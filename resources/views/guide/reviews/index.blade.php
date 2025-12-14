<x-guide-layout>
    <x-slot name="header">
        Ulasan Saya (Semua)
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-semibold mb-4">Daftar Ulasan</h3>

            <div class="space-y-6">
                @forelse($reviews as $review)
                <div class="border-b pb-4">
                    <div class="flex items-center justify-between">
                        {{-- Judul Paket --}}
                        <span class="text-sm font-medium text-indigo-600">
                            {{ $review->booking->package->title ?? 'Paket Tidak Ditemukan' }}
                        </span>
                        {{-- Tanggal --}}
                        <span class="text-xs text-gray-500">
                            {{ $review->created_at->format('d F Y') }}
                        </span>
                    </div>

                    {{-- Rating (Tampilkan Rating Paket jika Rating Guide kosong) --}}
                    <div class="flex items-center my-2">
                        @php
                        // Ambil rating guide, kalau kosong ambil rating paket
                        $ratingToShow = $review->rating_guide ?? $review->rating_package ?? 0;
                        $label = $review->rating_guide ? 'Guide' : 'Paket';
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="h-5 w-5 {{ $i <= $ratingToShow ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.96a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.446a1 1 0 00-.364 1.118l1.287 3.96c.3.921-.755 1.688-1.54 1.118l-3.368-2.446a1 1 0 00-1.176 0l-3.368 2.446c-.784.57-1.838-.197-1.54-1.118l1.287-3.96a1 1 0 00-.364-1.118L2.07 9.387c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.96z" />
                            </svg>
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-gray-700">
                                ({{ $ratingToShow }}/5 - {{ $label }})
                            </span>
                    </div>

                    {{-- Komentar --}}
                    <p class="text-gray-700 italic">
                        "{{ $review->comment_guide ?? $review->comment_package ?? 'Tidak ada komentar.' }}"
                    </p>

                    {{-- Nama Customer --}}
                    <p class="text-right text-sm text-gray-500 mt-2">
                        - {{ $review->user->name ?? 'Pelanggan' }}
                    </p>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Belum ada data ulasan di database.</p>
                @endforelse

                <div class="mt-4">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
    </div>
</x-guide-layout>