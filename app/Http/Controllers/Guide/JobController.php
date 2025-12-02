<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\GuideAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobController extends Controller
{
    /**
     * Menampilkan daftar semua pekerjaan (assignments) yang
     * ditugaskan kepada guide yang sedang login.
     */
    public function index(Request $request): View
    {
        $guide = Auth::user()->guide;

        // Jika user login tapi belum punya profil guide
        if (!$guide) {
            return view('guide.my-jobs.index', ['assignments' => collect()]);
        }

        // Query dasar
        $assignmentsQuery = GuideAssignment::where('guide_id', $guide->id)
            // Filter: Hanya tampilkan assignment yang data booking-nya masih ada (valid)
            ->has('booking')
            ->with([
                'booking.package', // Agar judul paket muncul
                'booking.user'     // Agar nama customer muncul
            ])
            ->latest('created_at');

        // Filter status jika ada parameter ?status=... di URL
        if ($request->has('status') && $request->status != '') {
            $assignmentsQuery->where('status', $request->status);
        }

        $assignments = $assignmentsQuery->paginate(10);

        return view('guide.my-jobs.index', compact('assignments'));
    }

    public function show($id)
    {
        $currentGuideId = Auth::user()->guide->id;

        $assignment = GuideAssignment::with([
            'booking.user',                  // Data Pelanggan
            'booking.package.destination',   // Data Lokasi Paket
            'booking.package.itineraries',   // Data Itinerary
            'assignedBy'                     // Admin yang menugaskan
        ])->find($id);

        // 2. CEK APAKAH ASSIGNMENT DITEMUKAN?
        if (!$assignment) {
            return redirect()->route('guide.my-jobs.index')->with('error', 'Data pekerjaan tidak ditemukan.');
        }

        // 3. CEK OTORISASI (Pemilik Tugas)
        if ($assignment->guide_id !== $currentGuideId) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses pekerjaan ini.');
        }

        if (!$assignment->booking) {
            return redirect()->route('guide.my-jobs.index')
                ->with('error', 'Data Booking untuk pekerjaan ini tidak valid atau telah dihapus.');
        }

        // Kirim ke View
        return view('guide.my-jobs.show', compact('assignment'));
    }

    /**
     * Mengubah status ketersediaan guide.
     */
    public function toggleAvailability(Request $request): RedirectResponse
    {
        $guide = Auth::user()->guide;

        if ($guide) {
            $guide->available = !$guide->available;
            $guide->save();

            $status = $guide->available ? 'Tersedia' : 'Tidak Tersedia';
            return back()->with('success', 'Status ketersediaan Anda telah diperbarui menjadi: ' . $status);
        }

        return back()->with('error', 'Profil guide tidak ditemukan.');
    }
}
