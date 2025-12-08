<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Menampilkan daftar ulasan untuk guide yang sedang login.
     */
    public function index(): View
    {
        // 1. Dapatkan profil guide dari user yang sedang login
        $guide = Auth::user()->guide;

        // 2. Jika guide tidak memiliki profil, kembalikan data kosong
        if (!$guide) {
            $reviews = collect();
            return view('guide.reviews.index', compact('reviews'));
        }

        $guideId = $guide->id;

        // 3. Ambil semua ulasan yang terhubung ke booking
        //    di mana guide ini ditugaskan (dan statusnya approved/confirmed)
        $reviews = Review::whereHas('booking.guideAssignments', function ($query) use ($guideId) {
            // --- PERBAIKAN DI SINI ---
            // Nama relasi di Model Booking adalah 'guideAssignments', bukan 'assignments'

            $query->where('guide_id', $guideId)
                ->where('status', 'confirmed'); // Sesuaikan status jika perlu, misal 'completed'
        })
            ->with([
                'user',     // Customer yang menulis ulasan
                'package'   // Muat relasi 'package' secara langsung
            ])
            ->latest() // Menggunakan 'created_at' (default)
            ->paginate(10);

        // 4. Kirim data ulasan ke view
        return view('guide.reviews.index', compact('reviews'));
    }
}
