<x-admin-layout>
    <x-slot name="title">Create Tour Package</x-slot>

    <div>
        <form action="{{ route('admin.tourpackages.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-gray-700">Nama Paket</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-md"
                    required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md" required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Harga</label>
                <input type="number" name="price" min="0" value="{{ old('price') }}"
                    class="w-full border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="currency" class="block text-sm font-medium text-gray-700">Mata Uang</label>
                <select name="currency" id="currency" class="w-full border-gray-300 rounded-md" required>
                    <option value="">-- Pilih Mata Uang --</option>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->code }}"
                            {{ old('currency') == $currency->code ? 'selected' : '' }}>
                            {{ $currency->name }} ({{ $currency->code }})
                        </option>
                    @endforeach
                </select>
            </div>


            <div>
                <label class="block font-medium text-gray-700">Destinasi</label>
                <select name="destination_id" class="w-full border-gray-300 rounded-md" required>
                    <option value="">-- Pilih Destinasi --</option>
                    @foreach ($destinations as $destination)
                        <option value="{{ $destination->id }}"
                            {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                            {{ $destination->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Durasi (hari)</label>
                <input type="number" name="duration_days" min="1" value="{{ old('duration_days') }}"
                    class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Kapasitas</label>
                <input type="number" name="capacity" min="1" value="{{ old('capacity') }}"
                    class="w-full border-gray-300 rounded-md" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Gambar</label>
                <input type="file" name="image" class="w-full border-gray-300 rounded-md">
            </div>

            <div class="pt-4 flex justify-end space-x-2">
                <a href="{{ route('admin.tourpackages.index') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
