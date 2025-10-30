<x-admin-layout>
    <x-slot name="title">Tambah Currency</x-slot>


    <div>
        <form action="{{ route('admin.currencies.store') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf

            <div>
                <label for="code" class="block font-medium text-gray-700">Kode (misal: USD)</label>
                <input type="text" name="code" id="code" value="{{ old('code') }}" required
                    class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('code')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block font-medium text-gray-700">Nama Mata Uang</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rate_to_base" class="block font-medium text-gray-700">Rate ke Base</label>
                <input type="number" step="0.0001" name="rate_to_base" id="rate_to_base"
                    value="{{ old('rate_to_base') }}" required
                    class="w-full border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('rate_to_base')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <a href="{{ route('admin.currencies.index') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
