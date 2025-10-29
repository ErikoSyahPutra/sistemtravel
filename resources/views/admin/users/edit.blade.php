<x-admin-layout>
    <x-slot name="title">Edit User</x-slot>

    <div class="">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Role</label>
                <select name="role" class="w-full border-gray-300 rounded-md">
                    <option value="admin" @selected($user->role == 'admin')>Admin</option>
                    <option value="guide" @selected($user->role == 'guide')>Guide</option>
                    <option value="customer" @selected($user->role == 'customer')>Customer</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Foto Profil</label>
                <input type="file" name="profile_photo" class="w-full border-gray-300 rounded-md">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                        class="mt-2 w-16 h-16 rounded-full object-cover" alt="Foto Profil">
                @endif
            </div>

            <div class="pt-4 flex justify-end space-x-2">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
            </div>
        </form>
    </div>
</x-admin-layout>
