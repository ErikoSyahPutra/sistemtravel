<x-admin-layout>
    <x-slot name="title">Tambah Destinasi</x-slot>

    <div>
        <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-gray-700">Nama Destinasi</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                    class="w-full border-gray-300 rounded-md">
                <small class="text-gray-500">Akan terisi otomatis berdasarkan nama</small>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    class="w-full border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image" class="w-full border-gray-300 rounded-md">
                <img id="preview" class="mt-3 hidden w-40 h-40 object-cover rounded-md shadow" alt="Preview">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Meta (opsional)</label>
                <textarea name="meta" rows="2" class="w-full border-gray-300 rounded-md">{{ old('meta') }}</textarea>
                <small class="text-gray-500">Bisa diisi dengan JSON atau teks tambahan.</small>
            </div>

            <div class="pt-4 flex justify-end space-x-2">
                <a href="{{ route('admin.destinations.index') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>

    {{-- Script otomatisasi --}}
    <script>
        // Otomatis generate slug dari nama
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        });

        // Preview gambar sebelum upload
        document.getElementById('cover_image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const file = e.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
                preview.src = '';
            }
        });
    </script>
</x-admin-layout>
