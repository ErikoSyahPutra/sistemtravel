<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Booking') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 p-4 border-l-4 border-emerald-500 shadow-sm flex items-center">
                <svg class="h-5 w-5 text-emerald-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500 shadow-sm flex items-center">
                <svg class="h-5 w-5 text-red-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: Detail Informasi --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Card 1: Informasi Paket Tur --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Informasi Booking
                            </h3>
                            <span class="px-3 py-1 bg-white border border-gray-200 rounded text-xs font-mono text-gray-500">
                                {{ $booking->booking_number ?? 'NO-REF' }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ $booking->package->title ?? 'Nama Paket Tidak Tersedia' }}</h4>
                            <p class="text-gray-500 mb-6 flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $booking->package->destination->name ?? 'Lokasi Umum' }}
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                                <div>
                                    <p class="text-xs text-indigo-400 uppercase font-bold tracking-wider mb-1">Tanggal Mulai</p>
                                    <p class="text-gray-900 font-semibold">
                                        {{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-400 uppercase font-bold tracking-wider mb-1">Tanggal Selesai</p>
                                    <p class="text-gray-900 font-semibold">
                                        {{ \Carbon\Carbon::parse($booking->date_end)->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-400 uppercase font-bold tracking-wider mb-1">Jumlah Peserta</p>
                                    <p class="text-gray-900 font-semibold flex items-center">
                                        {{ $booking->pax_count ?? 0 }}
                                        <span class="text-sm font-normal text-indigo-600 ml-1">Orang</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Data Pelanggan --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data Pelanggan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold shadow-md mr-5 flex-shrink-0">
                                    {{ substr($booking->user->name ?? '?', 0, 1) }}
                                </div>
                                <div class="space-y-1 flex-1">
                                    <h4 class="text-xl font-bold text-gray-900">{{ $booking->user->name ?? 'User Tidak Dikenal' }}</h4>

                                    <div class="flex flex-col sm:flex-row sm:items-center gap-y-2 gap-x-6 text-sm text-gray-600 mt-2">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $booking->user->email ?? '-' }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $booking->user->customerProfile->phone ?? $booking->user->phone ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN: Form Penugasan --}}
                <div class="lg:col-span-1">

                    @if($assignment = $booking->guideAssignments->first())
                    {{-- STATE: SUDAH DITUGASKAN --}}
                    <div class="bg-white shadow-lg rounded-xl border border-green-100 overflow-hidden relative">
                        <div class="absolute top-0 w-full h-1 bg-green-500"></div>

                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800">Status Penugasan</h3>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 uppercase tracking-wide">
                                    {{ $assignment->status }}
                                </span>
                            </div>

                            <div class="bg-green-50 rounded-xl p-4 border border-green-100 mb-6">
                                <p class="text-xs font-bold text-green-600 uppercase mb-2">Guide Bertugas</p>
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-green-700 font-bold shadow-sm mr-3 border border-green-100">
                                        {{ substr($assignment->guide->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $assignment->guide->user->name ?? 'Nama Guide' }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $assignment->guide->id ?? '-' }}</p>
                                    </div>
                                </div>

                                @if($assignment->notes)
                                <div class="mt-3 pt-3 border-t border-green-200/50">
                                    <p class="text-xs text-green-800 italic">"{{ $assignment->notes }}"</p>
                                </div>
                                @endif
                            </div>

                            <div class="text-center">
                                <form action="{{ route('admin.guide-assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Anda yakin ingin membatalkan penugasan guide ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-red-300 rounded-lg font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Batalkan Penugasan
                                    </button>
                                </form>
                                <p class="text-xs text-gray-400 mt-2">Membatalkan akan membuat guide tersedia kembali.</p>
                            </div>
                        </div>
                    </div>

                    @else
                    {{-- STATE: BELUM DITUGASKAN (FORM) --}}
                    <div class="bg-white shadow-lg rounded-xl border border-indigo-100 overflow-hidden relative">
                        <div class="absolute top-0 w-full h-1 bg-indigo-500"></div>

                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Tugaskan Guide</h3>
                                    <p class="text-xs text-gray-500">Pilih guide untuk perjalanan ini.</p>
                                </div>
                            </div>

                            <form action="{{ route('admin.guide-assignments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                <div class="space-y-4">
                                    <div>
                                        <label for="guide_id" class="block font-medium text-sm text-gray-700 mb-1">Pilih Guide Tersedia</label>
                                        <div class="relative">
                                            <select name="guide_id" id="guide_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                                <option value="">-- Pilih Guide --</option>
                                                @forelse($availableGuides as $guide)
                                                <option value="{{ $guide->id }}">
                                                    {{ $guide->user->name }}
                                                    ({{ is_array($guide->languages) ? implode(', ', $guide->languages) : ($guide->languages ?? 'Umum') }})
                                                </option>
                                                @empty
                                                <option value="" disabled>Tidak ada guide tersedia</option>
                                                @endforelse
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @if($availableGuides->isEmpty())
                                        <p class="text-xs text-red-500 mt-1">*Semua guide sedang bertugas/tidak aktif.</p>
                                        @endif
                                    </div>

                                    <div>
                                        <label for="notes" class="block font-medium text-sm text-gray-700 mb-1">Catatan Khusus (Opsional)</label>
                                        <textarea name="notes" id="notes" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: Jemput di lobi utara...">{{ old('notes') }}</textarea>
                                    </div>

                                    <div class="pt-2">
                                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" {{ $availableGuides->isEmpty() ? 'disabled' : '' }}>
                                            Tugaskan Sekarang
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>