<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\TourPackage;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Menampilkan daftar booking user yang login
    public function index()
    {
        $bookings = Booking::with('tourPackage')
            ->where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
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
    public function store(Request $request)
    {
        $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'start_date' => 'required|date|after_or_equal:today',
            'pax' => 'required|integer|min:1',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:30',
        ]);

        $package = TourPackage::findOrFail($request->tour_package_id);

        // Hitung total harga
        $total_price = $package->price * $request->pax;

        // Hitung end_date berdasarkan durasi paket
        $start_date = Carbon::parse($request->start_date);
        $end_date = $start_date->copy()->addDays($package->duration - 1);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_package_id' => $package->id,
            'start_date' => $start_date->toDateString(),
            'end_date' => $end_date->toDateString(),
            'pax' => $request->pax,
            'total_price' => $total_price,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'status' => 'pending', // Status awal
        ]);

        // Alihkan ke halaman pembayaran
        return redirect()->route('customer.booking.pay', $booking);
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
