<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuideAssignment;
use App\Models\Booking;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GuideAssignmentController extends Controller
{
    /**
     * Menyimpan penugasan guide baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'guide_id'   => 'required|exists:guides,id',
            'notes'      => 'nullable|string|max:255',
        ]);

        $existingAssignment = GuideAssignment::where('booking_id', $request->booking_id)
            ->whereIn('status', ['pending', 'confirmed', 'assigned'])
            ->exists();

        if ($existingAssignment) {
            return back()->with('error', 'Gagal: Booking ini sudah memiliki guide yang aktif ditugaskan.');
        }

        // 3. Simpan Assignment Baru
        GuideAssignment::create([
            'booking_id'  => $request->booking_id,
            'guide_id'    => $request->guide_id,
            'status'      => 'assigned',
            'assigned_by'  => auth()->id(),
            'notes'       => $request->notes,
        ]);
        $guide = Guide::find($request->guide_id);
        $guide->update(['available' => false]);
        return back()->with('success', 'Berhasil menugaskan guide untuk booking ini.');
    }

    /**
     * Menghapus atau membatalkan penugasan guide.
     */
    public function destroy($id): RedirectResponse
    {
        $assignment = GuideAssignment::findOrFail($id);

        if ($assignment->status === 'completed') {
            return back()->with('error', 'Tidak dapat membatalkan tugas yang sudah selesai.');
        }

        $assignment->delete();

        return back()->with('success', 'Penugasan guide berhasil dibatalkan.');
    }
}
