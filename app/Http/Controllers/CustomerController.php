<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
