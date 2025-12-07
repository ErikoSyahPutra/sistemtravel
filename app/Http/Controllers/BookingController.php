<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\PackageAvailability;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    // Menampilkan daftar booking user yang login
    public function index()
    {
        $bookings = Booking::with('tourPackage')
            ->where('user_id', Auth::id())
            ->orderBy('date_start', 'desc')
            ->get();

        return view('customer.booking', compact('bookings'));
    }

    /**
     * Menampilkan form untuk membuat booking baru.
     */
    public function create(TourPackage $tourPackage)
    {
        return view('customer.booking-create', [
            'package' => $tourPackage
        ]);
    }

    /**
     * AJAX Method: Cek Ketersediaan Tanggal & Harga Dinamis
     */
    public function checkAvailability(Request $request)
    {
        try {
            $request->validate([
                'package_id' => 'required|exists:tour_packages,id',
                'date' => 'required|date|after_or_equal:today',
                'pax' => 'required|integer|min:1'
            ]);

            $package = TourPackage::findOrFail($request->package_id);
            $checkDate = $request->date;

            // 1. Ambil Kapasitas
            $dailyQuota = $package->capacity; 
            if (!$dailyQuota || $dailyQuota <= 0) {
                $dailyQuota = 50; 
            }

            // 2. Hitung Pax Terpakai (REVISI LOGIC DURASI)
            // Kita cari booking yang "menutupi" tanggal yang dicek.
            // Logic: Booking dianggap memakan kuota di $checkDate jika:
            // date_start <= $checkDate DAN date_end >= $checkDate
            $bookedPax = Booking::where('package_id', $package->id)
                ->where(function ($query) use ($checkDate) {
                    $query->where('date_start', '<=', $checkDate)
                          ->where('date_end', '>=', $checkDate);
                })
                ->whereIn('status', ['pending', 'confirmed', 'paid'])
                ->sum('pax_count');

            $remaining = $dailyQuota - $bookedPax;
            
            // Cek apakah sisa kuota cukup untuk jumlah pax yang diminta
            $isAvailable = $remaining >= $request->pax;

            // Opsional: Jika paket yang mau dibooking durasinya > 1 hari, 
            // idealnya kita juga loop cek hari-hari berikutnya, tapi untuk AJAX check tanggal awal,
            // ini biasanya sudah cukup untuk validasi dasar. (Validasi ketat ada di method store)

            return response()->json([
                'status' => $isAvailable ? 'available' : 'unavailable',
                'message' => $isAvailable ? 'Tersedia' : 'Kuota Penuh',
                'remaining' => $remaining,
                'debug_info' => [
                    'capacity_db' => $package->capacity,
                    'used' => $bookedPax,
                    'check_date' => $checkDate
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'System Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Menyimpan booking baru ke database.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'date_start' => 'required|date|after_or_equal:today',
            'pax' => 'required|integer|min:1',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:30',
        ]);

        $package = TourPackage::find($id);
        if (!$package) {
            return back()->with('error', 'Paket tidak ditemukan.');
        }

        $duration = $package->duration_days ?? $package->duration ?? 1;
        $startDate = Carbon::parse($request->date_start);
        
        // --- VALIDASI KETERSEDIAAN KETAT (LOOP PER HARI) ---
        // Kita harus memastikan SETIAP HARI selama durasi tour masih ada kuota.
        // Jika durasi 3 hari, maka hari ke-1, ke-2, dan ke-3 harus dicek.
        
        $dailyQuota = $package->capacity;
        if (!$dailyQuota || $dailyQuota <= 0) $dailyQuota = 50;

        for ($i = 0; $i < $duration; $i++) {
            $currentCheckDate = $startDate->copy()->addDays($i)->format('Y-m-d');

            // Hitung penggunaan kuota pada hari $currentCheckDate
            $bookedPaxOnDay = Booking::where('package_id', $package->id)
                ->where(function ($query) use ($currentCheckDate) {
                    $query->where('date_start', '<=', $currentCheckDate)
                          ->where('date_end', '>=', $currentCheckDate);
                })
                ->whereNotIn('payment_status', ['failed', 'cancelled', 'expired'])
                ->sum('pax_count');

            $remainingOnDay = $dailyQuota - $bookedPaxOnDay;

            if ($request->pax > $remainingOnDay) {
                return back()->withInput()->with('error', "Maaf, kuota penuh pada tanggal {$currentCheckDate}. Sisa kursi: {$remainingOnDay}.");
            }
        }
        
        // --- END VALIDASI ---

        // Hitung harga (Cek override price berdasarkan tanggal start)
        $dateCheckStr = $startDate->format('Y-m-d');
        try {
            $availability = PackageAvailability::where('package_id', $package->id)
                ->where('date_start', '<=', $dateCheckStr)
                ->where('date_end', '>=', $dateCheckStr)
                ->first();
        } catch (\Exception $e) { $availability = null; }

        $user = auth()->user();

        $unitPrice = $package->price;
        if ($availability && $availability->price_override_minor) {
            $unitPrice = $availability->price_override_minor;
        }

        $total_price_val = $unitPrice * $request->pax;

        // Hitung date_end
        $date_end = $startDate->copy()->addDays($duration - 1);
        
        $expiredHours = (int) config('services.payment.expired_hours', 24);
        $expiredAt = Carbon::now()->addHours($expiredHours);
        
        $bookingNumber = 'BOOK-' . strtoupper(Str::random(10));

        $metaData = [
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'expired_at' => $expiredAt->toDateTimeString(),
            'va_number' => null,
            'payment_url' => null,
            'description' => 'Pembayaran paket ' . $package->title
        ];

        // Simpan Booking
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->package_id = $package->id;
        $booking->booking_number = $bookingNumber;
        $booking->date_start = $startDate->toDateString();
        $booking->date_end = $date_end->toDateString();
        $booking->pax_count = $request->pax;
        $booking->total_price = $total_price_val; 
        $booking->total_amount = $total_price_val; 
        $booking->currency = $package->currency ?? 'IDR'; 
        $booking->status = 'pending';
        $booking->payment_status = 'unpaid';
        $booking->meta = json_encode($metaData);
        
        $booking->save(); 

        try {
            // Integrasi Payment Gateway
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id' => $bookingNumber,
                'amount' => $total_price_val,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? $request->contact_phone,
                'description' => 'Pembayaran paket ' . $package->title,
                'expired_duration' => $expiredHours,
                'callback_url' => route('customer.payment.callback'),
                'redirect_url' => route('customer.payment.success'),
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => auth()->id(),
                ]
            ]);

            Log::info('Response dari payment gateway:', ['body' => $response->body()]);

            if ($response->successful()) {
                $data = $response->json();
                
                $metaData['va_number'] = $data['data']['va_number'] ?? null;
                $metaData['payment_url'] = $data['data']['payment_url'] ?? null;
                
                $booking->meta = json_encode($metaData);
                $booking->save();

                return redirect($metaData['payment_url'] ?? route('customer.dashboard'))
                    ->with('success', 'Pemesanan berhasil, lanjutkan pembayaran.');
            }

            return back()->with('error', 'Gagal membuat pembayaran.');
        } catch (\Exception $e) {
            Log::error('Error payment gateway: ' . $e->getMessage());
            return redirect()->route('customer.booking')->with('warning', 'Booking tersimpan tapi gagal memproses pembayaran otomatis. Silakan hubungi admin.');
        }
    }

    public function paymentCallback(Request $request)
    {
        Log::info('Callback diterima dari Doovera:', $request->all());

        $externalId = $request->input('external_id');
        $status = $request->input('status');

        $booking = Booking::where('booking_number', $externalId)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if (in_array($status, ['success', 'paid', 'completed'])) {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'paid_at' => now()
            ]);
        } elseif (in_array($status, ['failed', 'cancelled'])) {
            $booking->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'Callback processed']);
    }

    public function paymentSuccess(Request $request)
    {
        $userId = auth()->id();
        $status = $request->get('status') ?? 'success';

        $booking = Booking::with('tourPackage')
            ->where('user_id', $userId)
            ->where('payment_status', 'paid')
            ->latest('updated_at')
            ->first();

        return view('customer.payment-success', compact('booking', 'status'));
    }

    public function showPayment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        return view('customer.payment', compact('booking'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'confirmed',
            'paid_at' => now(), 
        ]);

        return redirect()->route('customer.booking')->with('success', 'Pembayaran berhasil. Booking terkonfirmasi.');
    }
}