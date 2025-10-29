<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Guide</h2>
    </x-slot>

    <div class="py-6 max-w-lg">
        <form action="{{ route('admin.guides.store') }}" method="POST">
            @csrf

            <!-- User -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">User Email</label>
                <select name="user_id" class="w-full border px-3 py-2 rounded">
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->email }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border px-3 py-2 rounded">
                @error('phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bio -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Bio</label>
                <textarea name="bio" class="w-full border px-3 py-2 rounded">{{ old('bio') }}</textarea>
                @error('bio')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Languages -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Languages (comma separated)</label>
                <input type="text" name="languages"
                    value="{{ old('languages') ? implode(',', old('languages')) : '' }}"
                    class="w-full border px-3 py-2 rounded">
                @error('languages')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Available -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="available" class="form-checkbox"
                        {{ old('available') ? 'checked' : '' }}>
                    <span class="ml-2">Available</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.guides.index') }}" class="ml-2 text-gray-700">Batal</a>
        </form>
    </div>
</x-admin-layout>
