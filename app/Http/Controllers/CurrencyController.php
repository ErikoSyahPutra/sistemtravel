<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $currencies = Currency::when($search, function ($query, $search) {
            $query->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");
        })
            ->orderBy('code')
            ->paginate(10);

        return view('admin.currencies.index', compact('currencies', 'search'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code',
            'name' => 'required|string|max:100',
            'rate_to_base' => 'required|numeric|min:0',
            'fetched_at' => 'nullable|date',
        ]);

        Currency::create([
            'code' => $request->code,
            'name' => $request->name,
            'rate_to_base' => $request->rate_to_base,
            'fetched_at' => $request->fetched_at ?? now(), // default sekarang jika kosong
        ]);

        return redirect()->route('admin.currencies.index')->with('success', 'Currency berhasil ditambahkan!');
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:100',
            'rate_to_base' => 'required|numeric|min:0',
            'fetched_at' => 'nullable|date',
        ]);

        $currency->update([
            'code' => $request->code,
            'name' => $request->name,
            'rate_to_base' => $request->rate_to_base,
            'fetched_at' => $request->fetched_at ?? now(), // jika kosong, diisi tanggal sekarang
        ]);

        return redirect()->route('admin.currencies.index')->with('success', 'Currency berhasil diperbarui!');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect()->route('admin.currencies.index')->with('success', 'Currency berhasil dihapus!');
    }
}
