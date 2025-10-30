<x-admin-layout>
    <x-slot name="title">Data User</x-slot>

    <div class="py-6">
        <div class="flex items-center justify-between mb-4 gap-4">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center w-full max-w-md gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama, email, nomor, atau role..."
                    class="border-gray-300 rounded-md w-full px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Cari</button>
                @if (request('search'))
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">Reset</a>
                @endif
            </form>

            {{-- Tombol Tambah --}}
            <button onclick="window.location='{{ route('admin.users.create') }}'"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 whitespace-nowrap">
                Tambah User
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <table class="min-w-full text-sm text-gray-600">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Foto</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Role</th>
                        <th class="px-4 py-2 text-left">No. HP</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-2">
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile"
                                    class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                            <td class="px-4 py-2">{{ $user->phone }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
