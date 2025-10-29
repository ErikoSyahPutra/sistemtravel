<x-admin-layout>
    <x-slot name="title">Tambah User</x-slot>

    <div class="">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md"
                    required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Role</label>
                <select name="role" class="w-full border-gray-300 rounded-md">
                    <option value="admin">Admin</option>
                    <option value="guide">Guide</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Foto Profil</label>
                <input type="file" name="profile_photo" class="w-full border-gray-300 rounded-md">
            </div>

            <div class="pt-4 flex justify-end space-x-2">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-admin-layout>
