<x-guide-layout>
    <x-slot name="header">Pekerjaan Saya</x-slot>

    @if(!$assignment->booking)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm animate-pulse">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-bold">Data Corrupt!</p>
                <p class="text-sm text-red-600">Data Booking asli telah dihapus. Beberapa informasi mungkin hilang.</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kiri: Detail Informasi --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Card Ringkasan --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full opacity-10 blur-xl"></div>

                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Detail Ringkas
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Mulai</p>
                        <p class="font-bold text-gray-800 text-lg mt-1">
                            {{ $assignment->booking ? \Carbon\Carbon::parse($assignment->booking->date_start)->format('d M') : '-' }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $assignment->booking ? \Carbon\Carbon::parse($assignment->booking->date_start)->format('Y') : '' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Selesai</p>
                        <p class="font-bold text-gray-800 text-lg mt-1">
                            {{ $assignment->booking ? \Carbon\Carbon::parse($assignment->booking->date_end)->format('d M') : '-' }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $assignment->booking ? \Carbon\Carbon::parse($assignment->booking->date_end)->format('Y') : '' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 col-span-2 md:col-span-1">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Lokasi</p>
                        <p class="font-bold text-gray-800 text-sm mt-2 line-clamp-2">
                            {{ $assignment->booking?->package?->destination?->name ?? 'Lokasi Umum' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Card Itinerary (Jadwal) --}}
            <div id="itinerary-section" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Jadwal Perjalanan
                    </h3>
                    <span class="text-xs font-medium px-2 py-1 bg-white border border-gray-200 rounded text-gray-500">
                        Zona Waktu Lokal
                    </span>
                </div>

                <div class="p-6">
                    @php
                    $package = $assignment->booking?->package;
                    $itineraries = $package?->itineraries;
                    if (($itineraries === null || $itineraries->isEmpty()) && $package) {
                    $itineraries = \App\Models\Itinerary::where('package_id', $package->id)->get();
                    }
                    $itineraries = $itineraries ?? collect();
                    $groupedItineraries = $itineraries->groupBy('day_number');
                    @endphp

                    <div class="space-y-10">
                        @forelse($groupedItineraries as $day => $activities)
                        <div class="relative">
                            {{-- Sticky Day Badge --}}
                            <div class="sticky top-0 z-10 py-2 bg-white/95 backdrop-blur-sm border-b border-gray-100 mb-6 w-full">
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-indigo-600 text-white shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Hari ke-{{ $day }}
                                </span>
                            </div>

                            {{-- Timeline Items --}}
                            <div class="relative pl-8 border-l-2 border-indigo-100 space-y-8 ml-3">
                                @foreach($activities->sortBy('start_time') as $activity)
                                <div class="relative group">
                                    {{-- Dot --}}
                                    <div class="absolute -left-[39px] top-1.5 h-5 w-5 rounded-full border-4 border-white bg-indigo-300 group-hover:bg-indigo-600 transition-colors shadow-sm"></div>

                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <div class="flex-shrink-0">
                                            <span class="inline-block px-3 py-1 bg-gray-100 rounded-md text-sm font-mono font-bold text-gray-700 border border-gray-200">
                                                {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="flex-1 bg-white border border-gray-100 p-4 rounded-xl shadow-sm group-hover:shadow-md group-hover:border-indigo-100 transition-all">
                                            <h5 class="font-bold text-gray-800 text-base mb-1">{{ $activity->title }}</h5>
                                            <p class="text-sm text-gray-600 leading-relaxed">{{ $activity->description }}</p>
                                            @if($activity->location)
                                            <div class="mt-3 flex items-center text-xs text-gray-500 font-medium bg-gray-50 px-2 py-1 rounded inline-block">
                                                <svg class="w-3 h-3 mr-1 text-red-500 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $activity->location }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-500 font-medium">Jadwal belum tersedia.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Card Pelanggan (Sticky) --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 sticky top-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Pelanggan</h4>

                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-3xl font-bold shadow-lg mb-4 ring-4 ring-indigo-50">
                        {{ substr($assignment->booking?->user?->name ?? '?', 0, 1) }}
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 line-clamp-1">
                        {{ $assignment->booking?->user?->name ?? 'User Terhapus' }}
                    </h3>
                    <p class="text-sm text-indigo-600 font-medium">Customer Utama</p>
                </div>

                <div class="space-y-4 border-t border-gray-100 pt-6">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 bg-white rounded-md shadow-sm mr-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs text-gray-400 mb-0.5">Email</p>
                            <p class="text-sm font-medium text-gray-700 truncate" title="{{ $assignment->booking?->user?->email ?? '-' }}">
                                {{ $assignment->booking?->user?->email ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 bg-white rounded-md shadow-sm mr-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">WhatsApp / Telepon</p>
                            <p class="text-sm font-medium text-gray-700">
                                {{ $assignment->booking?->user?->phone ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="p-2 bg-white rounded-md shadow-sm mr-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Jumlah Peserta</p>
                            <p class="text-sm font-medium text-gray-700">
                                {{ $assignment->booking->pax_count ?? 0 }} Orang
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">Catatan Admin</p>
                    <div class="bg-yellow-50 text-yellow-800 p-3 rounded-lg text-sm italic border border-yellow-100">
                        "{{ $assignment->notes ?? 'Tidak ada catatan khusus.' }}"
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</x-guide-layout>