<x-guide-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pekerjaan #{{ $assignment->booking->booking_number ?? $assignment->id }}
            </h2>
            <a href="{{ route('guide.my-jobs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- INFORMASI UTAMA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-bold text-indigo-600 mb-2">Informasi Paket</h3>
                            <p class="text-xl font-bold text-indigo-600">{{ $assignment->booking->package->title ?? 'N/A' }}</p>
                            <p class="text-gray-500">{{ $assignment->booking->package->destination->name ?? 'Lokasi Umum' }}</p>

                            <div class="mt-4 space-y-2">
                                <p><span class="font-semibold">Mulai:</span> {{ \Carbon\Carbon::parse($assignment->booking->date_start ?? '')->format('d F Y') }}</p>
                                <p><span class="font-semibold">Selesai:</span> {{ \Carbon\Carbon::parse($assignment->booking->date_end ?? '')->format('d F Y') }}</p>
                                <p><span class="font-semibold">Jumlah Tamu:</span> {{ $assignment->booking->pax_count ?? 'N/A' }} Orang</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-bold text-gray-700 mb-2">Data Pelanggan</h3>
                            <div class="flex items-center mb-4">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                                    {{ substr($assignment->booking->user->name ?? '', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold">{{ $assignment->booking->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $assignment->booking->user->email ?? 'N/A' }}</p>
                                    {{-- Tampilkan no hp jika ada --}}
                                    <p class="text-sm text-gray-500">{{ $assignment->booking->user->phone ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <p class="text-sm font-semibold text-gray-500">Catatan dari Admin:</p>
                                <p class="italic text-gray-700">{{ $assignment->notes ?? 'Tidak ada catatan khusus.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN ITINERARY (JADWAL) --}}
            {{-- ID ini penting agar tombol "Lihat Jadwal" di halaman index bisa scroll kesini --}}
            <div id="itinerary-section" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Jadwal Perjalanan (Itinerary)
                    </h3>

                    <div class="space-y-8">
                        @php
                        // PERBAIKAN:
                        // 1. Ambil itineraries dengan aman (?->).
                        // 2. Jika null, ganti dengan collect() kosong agar tidak error saat di-groupBy.
                        $itineraries = $assignment->booking?->package?->itineraries ?? collect();
                        $groupedItineraries = $itineraries->groupBy('day_number');
                        @endphp

                        @forelse($groupedItineraries as $day => $activities)
                        <div class="relative pl-8 border-l-2 border-indigo-200 ml-2">
                            {{-- Badge Hari --}}
                            <div class="absolute -left-3 top-0 bg-indigo-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow-sm">
                                {{ $day }}
                            </div>

                            <h4 class="font-bold text-lg text-gray-800 mb-4 ml-2">Hari ke-{{ $day }}</h4>

                            <div class="space-y-4">
                                @foreach($activities->sortBy('start_time') as $activity)
                                <div class="bg-gray-50 p-4 rounded-lg hover:shadow-md transition duration-200 border border-gray-100">
                                    <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4">
                                        <div class="flex-1">
                                            <h5 class="font-bold text-indigo-700 text-md">{{ $activity->title }}</h5>
                                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $activity->description }}</p>
                                            @if($activity->location)
                                            <p class="text-xs text-gray-500 mt-2 flex items-center font-medium">
                                                <svg class="w-3 h-3 mr-1 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $activity->location }}
                                            </p>
                                            @endif
                                        </div>
                                        <div class="text-left sm:text-right min-w-[80px]">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Belum ada jadwal perjalanan (itinerary) untuk paket ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guide-layout>