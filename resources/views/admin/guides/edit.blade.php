<x-admin-layout>
    <x-slot name="title">Edit Guide</x-slot>

    <div class="">
        <form action="{{ route('admin.guides.update', $guide->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf
            @method('PUT')

            {{-- User Info (disabled) --}}
            <input type="hidden" name="user_id" value="{{ $guide->user_id }}">
            <div>
                <label class="block font-medium text-gray-700">Nama</label>
                <input type="text" value="{{ $guide->user->name }}"
                    class="w-full border-gray-300 rounded-md bg-gray-100" readonly>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Email</label>
                <input type="email" value="{{ $guide->user->email }}"
                    class="w-full border-gray-300 rounded-md bg-gray-100" readonly>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Nomor HP</label>
                <input type="text" value="{{ $guide->user->phone ?? '-' }}"
                    class="w-full border-gray-300 rounded-md bg-gray-100" readonly>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Foto Profil</label>
                @if ($guide->user->profile_photo)
                    <img src="{{ asset('storage/' . $guide->user->profile_photo) }}"
                        class="mt-2 w-16 h-16 rounded-full object-cover" alt="Foto Profil">
                @else
                    <div class="mt-2 w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center text-gray-700">
                        {{ strtoupper(substr($guide->user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Guide Info --}}
            <div>
                <label class="block font-medium text-gray-700">Bahasa</label>
                <input type="text" name="languages"
                    value="{{ old('languages', implode(',', $guide->languages ?? [])) }}"
                    class="w-full border-gray-300 rounded-md">
                <small class="text-gray-500">Pisahkan dengan koma, misal: English, Indonesian</small>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Bio</label>
                <textarea name="bio" class="w-full border-gray-300 rounded-md" rows="4">{{ old('bio', $guide->bio) }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Available</label>
                <select name="available" class="w-full border-gray-300 rounded-md">
                    <option value="1" @selected($guide->available)>Yes</option>
                    <option value="0" @selected(!$guide->available)>No</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Rating</label>
                <input type="number" step="0.1" min="0" max="5" name="rating_cache"
                    value="{{ old('rating_cache', $guide->rating_cache) }}" class="w-full border-gray-300 rounded-md">
            </div>

            <div class="pt-4 flex justify-end space-x-2">
                <a href="{{ route('admin.guides.index') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
            </div>
        </form>
    </div>
</x-admin-layout>
