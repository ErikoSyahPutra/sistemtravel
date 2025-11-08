<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\GuideAssignment;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobController extends Controller
{
    /**
     * Menampilkan daftar semua pekerjaan (assignments) yang
     * ditugaskan kepada guide yang sedang login.
     * Ini adalah halaman "Pekerjaan Saya".
     */
    public function index(Request $request): View
    {
        // 1. Dapatkan profil guide dari user yang sedang login
        $guide = Auth::user()->guide;

        // 2. Jika tidak ada profil guide, kembalikan view with data kosong
        if (!$guide) {
            return view('guide.my-jobs.index', ['assignments' => collect()]);
        }

        // 3. Ambil semua assignment untuk guide ini
        // Asumsi admin menugaskan dengan status 'confirmed' atau 'pending_guide_confirmation'
        $assignmentsQuery = GuideAssignment::where('guide_id', $guide->id)
            ->with([
                'booking.package', // Memuat relasi package() dari model Booking
                'booking.user'     // Memuat relasi user() (customer) dari model Booking
            ])
            ->latest('created_at'); // Tampilkan yang terbaru ditugaskan

        // Filter berdasarkan status (misal: 'upcoming', 'completed')
        if ($request->has('status') && $request->status != '') {
            $assignmentsQuery->where('status', $request->status);
        }

        $assignments = $assignmentsQuery->paginate(10);

        // Arahkan ke view 'guide.my-jobs.index'
        // Jika $assignments kosong, Blade @forelse akan menampilkan
        // "belum ada pekerjaan yang diberikan"
        return view('guide.my-jobs.index', compact('assignments'));
    }

    /**
     * Menampilkan detail dari satu pekerjaan (assignment).
     * Termasuk detail booking, customer, dan itinerary.
     */
    public function show(GuideAssignment $assignment): View
    {
        // 1. OTORISASI: Pastikan guide yang login adalah guide yang
        // ditugaskan untuk assignment ini.
        $guideId = Auth::user()->guide->id;
        abort_if($assignment->guide_id !== $guideId, 403, 'Anda tidak memiliki izin untuk mengakses pekerjaan ini.');

        // 2. Muat semua relasi yang dibutuhkan untuk halaman detail
        $assignment->load([
            'booking.package.destination', // booking->package()->destination()
            'booking.user',                // booking->user() (customer)
            'booking.itineraries',         // booking->itineraries()
            'assignedBy'                   // assignedBy() (admin user)
        ]);

        // 3. Kirim data ke view
        return view('guide.my-jobs.show', compact('assignment'));
    }

    /**
     * Mengubah status ketersediaan guide.
     * Ini adalah fitur PENTING untuk alur kerja ini.
     */
    public function toggleAvailability(Request $request): RedirectResponse
    {
        $guide = Auth::user()->guide;

        if ($guide) {
            // Balik nilai boolean (true jadi false, false jadi true)
            $guide->available = !$guide->available;
            $guide->save();

            $status = $guide->available ? 'Tersedia' : 'Tidak Tersedia';
            return back()->with('success', 'Status ketersediaan Anda telah diperbarui menjadi: ' . $status);
        }

        return back()->with('error', 'Profil guide tidak ditemukan.');
    }
}
