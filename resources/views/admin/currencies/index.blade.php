<x-admin-layout>
    <x-slot name="title">Data Currency</x-slot>

    <div class="py-6">
        <div class="flex items-center justify-between mb-4 gap-4">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('admin.currencies.index') }}"
                class="flex items-center w-full max-w-md gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama atau lokasi..."
                    class="border-gray-300 rounded-md w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Cari</button>
                @if (request('search'))
                    <a href="{{ route('admin.currencies.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">Reset</a>
                @endif
            </form>

            {{-- Tombol Tambah --}}
            <button onclick="window.location='{{ route('admin.currencies.create') }}'"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 whitespace-nowrap">
                Tambah Currency
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-md rounded-md sm:rounded-lg p-6">
            @if (session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <table class="min-w-full text-sm text-gray-600">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Kode</th>
                        <th class="py-2 px-4 text-left">Nama</th>
                        <th class="py-2 px-4 text-left">Rate ke Base</th>
                        <th class="py-2 px-4 text-left">Diperbarui</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($currencies as $currency)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="py-2 px-4">{{ $currency->code }}</td>
                            <td class="py-2 px-4">{{ $currency->name }}</td>
                            <td class="py-2 px-4">{{ number_format($currency->rate_to_base, 2) }}</td>
                            <td class="py-2 px-4">
                                {{ $currency->fetched_at ? $currency->fetched_at->timezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB' : '-' }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('admin.currencies.edit', $currency->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin hapus currency ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $currencies->links() }}
            </div>
        </div>
    </div>

</x-admin-layout>
