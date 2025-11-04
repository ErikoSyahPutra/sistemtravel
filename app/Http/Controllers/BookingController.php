<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\TourPackage;
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
        $user = auth()->user();

        // Hitung total harga
        $total_price = $package->price * $request->pax;

        // Hitung date_end berdasarkan durasi paket
        $date_start = Carbon::parse($request->date_start);
        $date_end = $date_start->copy()->addDays($package->duration - 1);
        $expiredHours = (int) config('services.payment.expired_hours', 24);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'booking_number' => 'BOOK-' . strtoupper(Str::random(10)),
            'date_start' => $date_start->toDateString(),
            'date_end' => $date_end->toDateString(),
            'pax_count' => $request->pax,
            'total_price' => $total_price,
            'total_amount' => $total_price,
            'currency' => $package->currency ?? 'IDR',
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'payment_status' => 'pending',
            'expired_at' => Carbon::now()->addHours($expiredHours),
        ]);

        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id' => $booking->booking_number,
                'amount' => $booking->total_amount,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
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

                $booking->update([
                    'va_number' => $data['data']['va_number'] ?? null,
                    'payment_url' => $data['data']['payment_url'] ?? null,
                ]);

                return redirect($booking->payment_url ?? route('customer.dashboard'))
                    ->with('success', 'Pemesanan berhasil, lanjutkan pembayaran.');
            }

            return back()->with('error', 'Gagal membuat pembayaran.');
        } catch (\Exception $e) {
            Log::error('Error payment gateway: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }

        // // Alihkan ke halaman pembayaran
        // return redirect()->route('customer.booking.pay', $booking);
    }

    public function paymentCallback(Request $request)
    {
        Log::info('Callback diterima dari Doovera:', $request->all());

        // Ambil semua kemungkinan parameter dari callback
        $externalId = $request->input('external_id');
        $orderId = $request->input('order_id');
        $vaNumber = $request->input('va_number');
        $status = $request->input('status'); // success / failed / pending

        $lookupValue = $externalId ?? $orderId ?? $vaNumber;

        Log::info('Identifikasi booking dari callback:', [
            'external_id' => $externalId,
            'order_id' => $orderId,
            'va_number' => $vaNumber,
            'lookupValue' => $lookupValue
        ]);

        // Cari booking berdasarkan salah satu dari tiga kemungkinan
        $booking = Booking::where('booking_number', $externalId)
            ->orWhere('booking_number', $orderId)
            ->orWhere('va_number', $vaNumber)
            ->first();

        if (!$booking) {
            Log::warning("Booking tidak ditemukan untuk external_id={$externalId}, order_id={$orderId}, va_number={$vaNumber}");
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update status booking berdasarkan callback
        if (in_array($status, ['success', 'paid', 'completed'])) {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);
            Log::info("Booking {$booking->booking_number} berhasil diperbarui menjadi PAID.");
        } elseif (in_array($status, ['failed', 'cancelled'])) {
            $booking->update(['payment_status' => 'failed']);
            Log::info("Booking {$booking->booking_number} gagal atau dibatalkan.");
        }


        return redirect()->route('customer.payment.success');
    }




    public function paymentSuccess(Request $request)
    {
        $userId = auth()->id(); // user yang login
        $status = $request->get('status') ?? 'success';

        // Ambil booking terbaru user yang sudah paid
        $booking = Booking::with('tourPackage')
            ->where('user_id', $userId)
            ->where('payment_status', 'paid')
            ->latest('updated_at') // booking terakhir yang diupdate
            ->first();

        return view('customer.payment-success', compact('booking', 'status'));
    }

    /**
     * Menampilkan halaman pembayaran untuk booking.
     */
    public function showPayment(Booking $booking)
    {
        // Pastikan user hanya bisa melihat booking miliknya
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.payment', compact('booking'));
    }

    /**
     * Proses (simulasi) pembayaran untuk booking.
     */
    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Simulasi proses pembayaran: update status dan paid_at
        $booking->update([
            'status' => 'confirmed',
            'paid_at' => now(),
        ]);

        return redirect()->route('customer.booking')->with('success', 'Pembayaran berhasil. Booking terkonfirmasi.');
    }
}
