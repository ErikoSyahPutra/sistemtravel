<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Destination;

class CustomerController extends Controller
{
    // Dashboard customer
    public function index()
    {
        // Menampilkan 8 destinasi populer untuk dashboard
        $destinations = Destination::orderBy('created_at', 'desc')->take(8)->get();
        return view('customer.dashboard', compact('destinations'));
    }

    // Semua destinasi (tanpa pagination)
    public function destinations(Request $request)
    {
        $query = Destination::query();

        // Jika ada pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        // Ambil semua destinasi tanpa pagination
        $destinations = $query->orderBy('created_at', 'desc')->get();

        return view('customer.destinations', compact('destinations'));
    }

    // Method baru untuk menampilkan paket tur berdasarkan destinasi
    public function showPackages(Destination $destination)
    {
        // Load paket tur yang terkait dengan destinasi ini
        $destination->load('tourPackages');

        return view('customer.packages', compact('destination'));
    }

    public function confirm(TourPackage $tourpackage)
    {
        if (!$tourpackage) {
            return redirect()->route('customer.dashboard')->with('error', 'Paket tidak ditemukan.');
        }

        return view('customer.confirm', compact('package'));
    }
}
