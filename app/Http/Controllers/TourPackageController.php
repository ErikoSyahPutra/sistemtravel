<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Destination;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourPackageController extends Controller
{
    // 🔹 INDEX — daftar & search
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tourPackages = TourPackage::with('destination')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('destination', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.tourpackages.index', compact('tourPackages', 'search'));
    }

    // 🔹 CREATE — form tambah
    public function create()
    {
        $currencies = Currency::all();
        $destinations = Destination::all();
        return view('admin.tourpackages.create', compact('destinations', 'currencies'));
    }

    // 🔹 STORE — simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price_minor'    => 'required|numeric|min:0',
            'currency'       => 'required|string|max:10',
            'duration_days'  => 'required|integer|min:1',
            'capacity'       => 'required|integer|min:1',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Upload multiple images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('tour_packages', 'public');
            }
        }
        $validated['images'] = json_encode($imagePaths);

        TourPackage::create($validated);

        return redirect()->route('admin.tourpackages.index')->with('success', 'Tour Package berhasil ditambahkan!');
    }

    // 🔹 EDIT — form edit
    public function edit(TourPackage $tourpackage)
    {
        $destinations = Destination::all();
        $currencies = Currency::all(['id', 'code', 'name']);
        return view('admin.tourpackages.edit', compact('tourpackage', 'destinations', 'currencies'));
    }

    // 🔹 UPDATE — simpan perubahan
    public function update(Request $request, TourPackage $tourpackage)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price_minor'    => 'required|numeric|min:0',
            'currency'       => 'required|string|max:10',
            'duration_days'  => 'required|integer|min:1',
            'capacity'       => 'required|integer|min:1',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Tambah gambar baru tanpa hapus yang lama
        $oldImages = json_decode($tourpackage->images ?? '[]', true);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $oldImages[] = $image->store('tour_packages', 'public');
            }
        }

        $validated['images'] = json_encode($oldImages);

        $tourpackage->update($validated);

        return redirect()->route('admin.tourpackages.index')->with('success', 'Tour Package berhasil diperbarui!');
    }

    // 🔹 DESTROY — hapus paket tur
    public function destroy(TourPackage $tourpackage)
    {
        $images = json_decode($tourPackage->images ?? '[]', true);
        foreach ($images as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        $tourpackage->delete();
        return redirect()->route('admin.tourpackages.index')->with('success', 'Tour Package berhasil dihapus!');
    }
}
