<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

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
}
