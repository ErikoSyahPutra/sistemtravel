<x-guide-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-6">

        {{-- SECTION 1: WELCOME & STATS --}}
        {{-- Kita buat style card statistik senada dengan list pekerjaan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Welcome Card --}}
            <div class="md:col-span-3 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Halo, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-gray-500 text-sm mt-1">Selamat datang kembali. Pantau jadwal dan pekerjaan Anda di sini.</p>
                </div>
            </div>

            {{-- Stat 1: Aktif --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center hover:border-indigo-200 transition-colors">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pekerjaan Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                </div>
            </div>

            {{-- Stat 2: Selesai --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center hover:border-emerald-200 transition-colors">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Trip Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
            </div>

            {{-- Stat 3: Total Pax --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center hover:border-orange-200 transition-colors">
                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Tamu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pax'] }}</p>
                </div>
            </div>
        </div>

        {{-- SECTION 2: PEKERJAAN TERDEKAT / AKTIF --}}
        {{-- Menggunakan layout Card yang sama persis dengan Index --}}
        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Jadwal Terdekat</h3>
                        <p class="text-sm text-gray-500">Pekerjaan yang perlu perhatian Anda segera.</p>
                    </div>
                    @if($upcomingJob)
                    <a href="{{ route('guide.my-jobs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                        Lihat Semua
                    </a>
                    @endif
                </div>

                @if($upcomingJob)
                <div class="group relative bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-indigo-300 transition-all duration-300">

                    <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                        {{-- Thumbnail --}}
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-md">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0 pr-24">
                            <h4 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">
                                {{ $upcomingJob->booking->package->title ?? 'Judul Paket' }}
                            </h4>

                            <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm text-gray-500 mt-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700">{{ $upcomingJob->booking->user->name ?? 'User N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-indigo-600 font-bold">
                                        {{ \Carbon\Carbon::parse($upcomingJob->booking->date_start)->format('d F Y') }}
                                    </span>
                                    <span class="mx-1 text-gray-300">|</span>
                                    <span class="text-gray-500">{{ \Carbon\Carbon::parse($upcomingJob->booking->date_start)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="mt-4 md:mt-0 w-full md:w-auto">
                            <a href="{{ route('guide.my-jobs.show', $upcomingJob) }}"
                                class="inline-flex justify-center items-center w-full md:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow transition-all duration-200">
                                Lihat Detail
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-10 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada jadwal dalam waktu dekat.</p>
                    <p class="text-xs text-gray-400 mt-1">Nikmati waktu istirahat Anda!</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</x-guide-layout>