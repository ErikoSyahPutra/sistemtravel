<x-admin-layout>
    <x-slot name="title">Data Tour Package</x-slot>

    <div class="py-6">
        {{-- Bagian atas: Search dan Tombol Tambah --}}
        <div class="flex items-center justify-between mb-4 gap-4">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('admin.tourpackages.index') }}"
                class="flex items-center w-full max-w-md gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama, email, nomor, atau role..."
                    class="border-gray-300 rounded-md w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Cari</button>
                @if (request('search'))
                    <a href="{{ route('admin.tourpackages.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">Reset</a>
                @endif
            </form>

            {{-- Tombol Tambah --}}
            <button onclick="window.location='{{ route('admin.tourpackages.create') }}'"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 whitespace-nowrap">
                Tambah Tour Package
            </button>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <table class="min-w-full text-sm text-gray-600">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Image</th>
                        <th class="px-4 py-2 text-left">Judul</th>
                        <th class="px-4 py-2 text-left">Destinasi</th>
                        <th class="px-4 py-2 text-left">Harga</th>
                        <th class="px-4 py-2 text-left">Durasi</th>
                        <th class="px-4 py-2 text-left">Kapasitas</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tourPackages as $index => $package)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($tourPackages->firstItem() - 1) }}</td>
                            <td class="px-4 py-2">
                                <img src="{{ asset('storage/' . $package->image) }}" alt="Sample Image"
                                    class=" border w-30 h-20 rounded-sm object-cover">
                            </td>
                            <td class="px-4 py-2">{{ $package->title }}</td>
                            <td class="px-4 py-2">{{ $package->destination->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                {{ strtoupper($package->currency) }} {{ number_format($package->price, 2) }}
                            </td>
                            <td class="px-4 py-2">{{ $package->duration_days }} hari</td>
                            <td class="px-4 py-2">{{ $package->capacity }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.tourpackages.edit', $package->id) }}"
                                    class="text-blue-500">Edit</a>
                                <form action="{{ route('admin.tourpackages.destroy', $package->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Yakin ingin menghapus paket ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">
                                Tidak ada data tour package ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $tourPackages->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
