<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 p-4 border-l-4 border-emerald-500 shadow-sm flex items-center animate-fade-in-down">
                <svg class="h-5 w-5 text-emerald-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-6">

                    {{-- Header & Stats --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar Reservasi Masuk</h3>
                            <p class="text-sm text-gray-500 mt-1">Kelola data booking dan penugasan guide.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                Total: {{ $bookings->total() }}
                            </span>
                        </div>
                    </div>

                    {{-- Filter Tabs --}}
                    <div class="mb-6 border-b border-gray-100">
                        <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                            <a href="{{ route('admin.bookings.index') }}"
                                class="{{ !request('status') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Semua Booking
                            </a>
                            <a href="{{ route('admin.bookings.index', ['status' => 'unassigned']) }}"
                                class="{{ request('status') == 'unassigned' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center">
                                Belum Ditugaskan
                                @if(request('status') == 'unassigned')
                                <span class="ml-2 bg-indigo-100 text-indigo-600 py-0.5 px-2 rounded-full text-xs hidden sm:inline-block">{{ $bookings->total() }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.bookings.index', ['status' => 'assigned']) }}"
                                class="{{ request('status') == 'assigned' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Sudah Ditugaskan
                            </a>
                        </nav>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Pelanggan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Paket Wisata
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Jadwal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Status Guide
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    {{-- Kolom Pelanggan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                                    {{ substr($booking->user->name ?? '?', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $booking->user->name ?? 'N/A' }}</div>
                                                <div class="text-xs text-gray-500">{{ $booking->user->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Paket --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->package->title ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $booking->package->destination->name ?? 'Lokasi Umum' }}
                                        </div>
                                    </td>

                                    {{-- Kolom Tanggal --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-gray-800 flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }}
                                            </span>
                                            <span class="text-xs text-gray-500 ml-5">
                                                {{ $booking->pax_count ?? 0 }} Orang
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kolom Status Guide --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($assignment = $booking->guideAssignments->first())
                                        {{-- Status Badge Dinamis --}}
                                        @php
                                        $statusClass = match($assignment->status) {
                                        'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'assigned' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200'
                                        };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClass }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5"></span>
                                            {{ ucfirst($assignment->status) }}
                                        </span>
                                        <div class="text-[10px] text-gray-500 mt-1 ml-1">
                                            {{ $assignment->guide->user->name ?? 'Guide Terhapus' }}
                                        </div>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                            Belum Ditugaskan
                                        </span>
                                        @endif
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.bookings.show', $booking) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            Kelola
                                            <svg class="ml-1.5 -mr-0.5 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">Tidak ada data booking yang ditemukan.</p>
                                            <p class="text-xs text-gray-400 mt-1">Coba ubah filter atau tunggu pesanan masuk.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>