<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GuideAssignment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $guide = Auth::user()->guide;

        // Jika user login tapi belum punya profil guide
        if (!$guide) {
            return view('guide.dashboard', [
                'stats' => ['active' => 0, 'completed' => 0, 'pax' => 0],
                'upcomingJob' => null,
                'recentJobs' => collect()
            ]);
        }

        // 1. Statistik
        // Pekerjaan Aktif: Booking yang belum selesai (date_end >= hari ini)
        $activeCount = GuideAssignment::where('guide_id', $guide->id)
            ->whereHas('booking', function ($q) {
                $q->where('date_end', '>=', now());
            })->count();

        // Pekerjaan Selesai: Booking yang sudah lewat (date_end < hari ini)
        $completedCount = GuideAssignment::where('guide_id', $guide->id)
            ->whereHas('booking', function ($q) {
                $q->where('date_end', '<', now());
            })->count();

        // Total Tamu (Pax) yang pernah dihandle (dari booking yang selesai/aktif)
        $totalPax = GuideAssignment::where('guide_id', $guide->id)
            ->has('booking')
            ->with('booking')
            ->get()
            ->sum(function ($assignment) {
                return $assignment->booking->pax_count ?? 0;
            });

        // 2. Pekerjaan Terdekat (Next Trip)
        // Kita join manual sedikit untuk sorting berdasarkan tanggal booking
        $upcomingJob = GuideAssignment::where('guide_id', $guide->id)
            ->whereHas('booking', function ($q) {
                $q->where('date_start', '>=', now()); // Hanya yang belum mulai atau mulai hari ini
            })
            ->join('bookings', 'guide_assignments.booking_id', '=', 'bookings.id')
            ->orderBy('bookings.date_start', 'asc') // Urutkan dari yang terdekat
            ->select('guide_assignments.*') // Ambil kolom assignment saja agar tidak bentrok
            ->with(['booking.package', 'booking.user'])
            ->first();

        // 3. List Pekerjaan Terbaru (Baru ditambahkan)
        $recentJobs = GuideAssignment::where('guide_id', $guide->id)
            ->has('booking')
            ->with(['booking.package'])
            ->latest('created_at')
            ->limit(3)
            ->get();

        return view('guide.dashboard', [
            'stats' => [
                'active' => $activeCount,
                'completed' => $completedCount,
                'pax' => $totalPax
            ],
            'upcomingJob' => $upcomingJob,
            'recentJobs' => $recentJobs,
            'guide' => $guide // Untuk akses status availability
        ]);
    }
}
