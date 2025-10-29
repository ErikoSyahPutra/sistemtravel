<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\User;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    // Tampilkan semua guide
    public function index()
    {
        $guides = Guide::with('user')->paginate(10);
        return view('admin.guides.index', compact('guides'));
    }

    // Form tambah guide
    public function create()
    {
        // Ambil user dengan role guide yang belum punya guide
        $users = User::where('role', 'guide')
            ->whereDoesntHave('guide')
            ->get();

        return view('admin.guides.create', compact('users'));
    }

    // Simpan guide baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'languages'  => 'nullable|array',
            'bio'        => 'nullable|string|max:1000',
            'available'  => 'sometimes|boolean',
        ]);

        $validated['available'] = $request->has('available'); // checkbox handling
        $validated['rating_cache'] = 0; // default rating

        Guide::create($validated);

        return redirect()->route('admin.guides.index')->with('success', 'Guide berhasil ditambahkan!');
    }

    // Form edit guide
    public function edit(Guide $guide)
    {
        // Semua user guide, termasuk user yang sudah punya guide ini
        $users = User::where('role', 'guide')
            ->orWhere('id', $guide->user_id)
            ->get();

        return view('admin.guides.edit', compact('guide', 'users'));
    }

    // Update guide
    public function update(Request $request, Guide $guide)
    {
        $validated = $request->validate([
            'languages'   => 'nullable|string',
            'bio'         => 'nullable|string|max:1000',
            'available'   => 'sometimes|boolean',
            'rating_cache' => 'nullable|numeric|min:0|max:5',
        ]);

        $validated['available'] = $request->has('available');

        // ubah languages string menjadi array
        $validated['languages'] = !empty($validated['languages'])
            ? array_map('trim', explode(',', $validated['languages']))
            : [];

        $guide->update($validated);

        return redirect()->route('admin.guides.index')->with('success', 'Guide berhasil diperbarui!');
    }

    // Hapus guide
    public function destroy(Guide $guide)
    {
        $guide->delete();

        return redirect()->route('admin.guides.index')->with('success', 'Guide berhasil dihapus!');
    }
}
