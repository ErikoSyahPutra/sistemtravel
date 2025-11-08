<x-guide-layout>
    <x-slot name="header">
        Ulasan Saya
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-semibold mb-4">Ulasan dari Pelanggan</h3>

            <div class="space-y-6">
                @forelse($reviews as $review)
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between">
                        {{-- Mengambil judul paket dari relasi 'package' --}}
                        <span class="text-sm font-medium text-indigo-600">
                            {{ $review->package->title ?? 'Tur Dihapus' }}
                        </span>
                        {{-- Menggunakan created_at karena controller menggunakan latest() --}}
                        <span class="text-xs text-gray-500">
                            {{ $review->created_at->format('d F Y') }}
                        </span>
                    </div>

                    {{-- Menampilkan Rating Bintang --}}
                    <div class="flex items-center my-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.96a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.446a1 1 0 00-.364 1.118l1.287 3.96c.3.921-.755 1.688-1.54 1.118l-3.368-2.446a1 1 0 00-1.176 0l-3.368 2.446c-.784.57-1.838-.197-1.54-1.118l1.287-3.96a1 1 0 00-.364-1.118L2.07 9.387c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.96z" />
                            </svg>
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-gray-700">({{ $review->rating }}/5)</span>
                    </div>

                    {{-- Menampilkan Komentar --}}
                    <p class="text-gray-700 italic">"{{ $review->comment }}"</p>

                    {{-- Mengambil nama customer dari relasi 'user' --}}
                    <p class="text-right text-sm text-gray-500 mt-2">
                        - {{ $review->user->name ?? 'Pelanggan Anonim' }}
                    </p>
                </div>
                @empty
                {{-- Pesan jika tidak ada ulasan --}}
                <p class="text-gray-500">Belum ada ulasan yang Anda terima.</p>
                @endforelse

                {{-- Link Paginasi --}}
                <div class="mt-4">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
    </div>
</x-guide-layout>