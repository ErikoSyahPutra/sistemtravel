<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua booking.
     */
    public function index(Request $request): View
    {
        // Eager load relasi yang dibutuhkan di tabel index
        $query = Booking::with([
            'user',              // Customer
            'package',           // Tour Package
            'guideAssignments'   // Status assignment
        ])->latest('created_at');

        // Filter: Belum Ditugaskan
        if ($request->get('status') === 'unassigned') {
            $query->where(function ($q) {
                $q->whereDoesntHave('guideAssignments')
                    ->orWhereHas('guideAssignments', function ($subQ) {
                        $subQ->where('status', 'rejected');
                    });
            });
        }

        // Filter: Sudah Ditugaskan
        if ($request->get('status') === 'assigned') {
            $query->whereHas('guideAssignments', function ($q) {
                $q->whereIn('status', ['assigned']);
            });
        }

        $bookings = $query->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan detail booking & form assignment.
     */
    public function show(Booking $booking): View
    {
        $booking->load([
            'user',                          // Data user (customer)
            'package',                       // Info paket
            'guideAssignments.guide.user'    // Info guide yang sedang bertugas (jika ada)
        ]);

        // 2. Ambil daftar guide yang 'available' untuk dropdown form
        $availableGuides = Guide::with('user')
            ->where('available', true)
            ->get();

        return view('admin.bookings.show', compact('booking', 'availableGuides'));
    }

    /**
     * (Opsional) Update status manual
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate(['status' => 'required|string']);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
