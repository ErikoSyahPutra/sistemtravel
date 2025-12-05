<x-guide-layout>
    <x-slot name="header">
        Pekerjaan Saya
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Header Section --}}
                    <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Penugasan</h3>
                            <p class="text-sm text-gray-500 mt-1">Kelola pekerjaan dan jadwal perjalanan Anda.</p>
                        </div>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold border border-indigo-100">
                            {{ $assignments->total() }} Pekerjaan Aktif
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($assignments as $assignment)
                        <div class="group relative bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-xl hover:border-indigo-200 transition-all duration-300">



                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">

                                {{-- Ikon / Thumbnail Paket --}}
                                <div class="flex-shrink-0">
                                    <div class="h-16 w-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform duration-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Informasi Utama --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors truncate">
                                        {{ $assignment->booking?->package?->title ?? 'Judul Paket Tidak Tersedia' }}
                                    </h4>

                                    <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm text-gray-500 mt-2">
                                        {{-- Nama Pelanggan --}}
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="font-medium text-gray-700">{{ $assignment->booking?->user?->name ?? 'User N/A' }}</span>
                                        </div>

                                        {{-- Tanggal Mulai --}}
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            @if($assignment->booking)
                                            <span>{{ \Carbon\Carbon::parse($assignment->booking->date_start)->format('d M Y') }}</span>
                                            @else
                                            <span class="text-red-400 italic">Tanggal Hilang</span>
                                            @endif
                                        </div>

                                        {{-- Jumlah Pax --}}
                                        @if($assignment->booking)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span>{{ $assignment->booking->pax_count }} Orang</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tombol Aksi (Single Button) --}}
                                <div class="mt-4 md:mt-0 w-full md:w-auto">
                                    @if($assignment->booking)
                                    <a href="{{ route('guide.my-jobs.show', $assignment) }}"
                                        class="inline-flex justify-center items-center w-full md:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Lihat Detail
                                        <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    @else
                                    <button disabled class="inline-flex justify-center items-center w-full md:w-auto px-5 py-2.5 bg-gray-100 text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">
                                        Data Tidak Tersedia
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center py-16 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50">
                            <div class="bg-white p-4 rounded-full shadow-sm mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada pekerjaan</h3>
                            <p class="mt-1 text-sm text-gray-500 max-w-sm text-center">Anda belum memiliki penugasan aktif saat ini. Tugas baru akan muncul di sini.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guide-layout>