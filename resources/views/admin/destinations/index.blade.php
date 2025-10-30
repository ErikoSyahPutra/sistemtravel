<x-admin-layout>
    <x-slot name="title">Destination Management</x-slot>

    <div class="py-6">
        <div class="flex items-center justify-between mb-4 gap-4">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('admin.destinations.index') }}"
                class="flex items-center w-full max-w-md gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama atau lokasi..."
                    class="border-gray-300 rounded-md w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Cari</button>
                @if (request('search'))
                    <a href="{{ route('admin.destinations.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">Reset</a>
                @endif
            </form>

            {{-- Tombol Tambah --}}
            <button onclick="window.location='{{ route('admin.destinations.create') }}'"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 whitespace-nowrap">
                Tambah Destination
            </button>
        </div>


        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if (session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <table class="min-w-full text-sm text-gray-600">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Slug</th>
                        <th class="px-4 py-2 text-left">Lokasi</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($destinations as $destination)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($destinations->currentPage() - 1) * $destinations->perPage() }}
                            </td>
                            <td class="px-4 py-2">{{ $destination->name }}</td>
                            <td class="px-4 py-2">{{ $destination->slug }}</td>
                            <td class="px-4 py-2">{{ $destination->location }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.destinations.edit', $destination->id) }}"
                                    class="text-blue-500">Edit</a>
                                <form action="{{ route('admin.destinations.destroy', $destination->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2"
                                        onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $destinations->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
