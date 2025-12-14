<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $package->name }} - Detail Paket</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-blue-600">KitaTravel</a>

            <nav class="space-x-6 hidden md:flex">
                <a href="/" class="hover:text-blue-600">Beranda</a>
                <a href="{{ route('customer.destinations') }}" class="hover:text-blue-600 font-semibold text-blue-600">
                    Destinasi
                </a>
                <a href="{{ route('customer.booking') }}" class="hover:text-blue-600">Booking</a>
                <a href="#" class="hover:text-blue-600">Panduan</a>
                <a href="#" class="hover:text-blue-600">Kontak</a>
            </nav>

            <div class="hidden md:flex">
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>

                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Login
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <nav class="flex flex-col space-y-4 p-4">
                <a href="/" class="hover:text-blue-600">Beranda</a>
                <a href="{{ route('customer.destinations') }}" class="hover:text-blue-600 font-semibold text-blue-600">
                    Destinasi
                </a>
                <a href="{{ route('customer.booking') }}" class="hover:text-blue-600">Booking</a>
                <a href="#" class="hover:text-blue-600">Panduan</a>
                <a href="#" class="hover:text-blue-600">Kontak</a>

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 text-center bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Login
                    </a>
                @endauth

            </nav>
        </div>
    </header>

    <!-- HEADER GAMBAR -->
    @php
            $images = json_decode($package->images, true);
        @endphp

        <div class="w-full h-64 bg-gray-200 overflow-hidden">
            @if ($images && isset($images[0]))
                <img
                    src="{{ asset('storage/' . $images[0]) }}"
                    alt="{{ $package->name }}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500 text-lg">
                    No Image
                </div>
            @endif
        </div>

    <!-- CONTENT -->
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- KONTEN KIRI -->
        <div class="lg:col-span-2 space-y-6">

            <!-- JUDUL -->
            <h1 class="text-3xl font-bold text-gray-800">{{ $package->name }}</h1>

            <p class="text-gray-600 text-lg">
                Durasi: <span class="font-semibold">{{ $package->duration_days }} hari</span>
            </p>

            <!-- DESKRIPSI -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-xl font-semibold mb-3">Deskripsi Paket</h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ $package->description ?? 'Tidak ada deskripsi tersedia.' }}
                </p>
            </div>

            <!-- RATING -->
            @if ($package->rating)
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-xl font-semibold mb-3">Rating</h2>
                    <p class="text-yellow-500 font-bold text-xl">{{ $package->rating }} ⭐</p>
                </div>
            @endif

            <!-- ITINERARY -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Itinerary Perjalanan</h2>

                @php
                    $grouped = $package->itineraries->sortBy('day_number')->groupBy('day_number');
                @endphp

                @if ($grouped->isEmpty())
                    <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                        Belum ada itinerary untuk paket ini.
                    </div>
                @else
                    @foreach ($grouped as $day => $items)
                        <div class="mb-12 relative">

                            <!-- Sticky Day Header -->
                            <div class="sticky top-0 z-10 py-2 backdrop-blur border-b border-gray-200 mb-8">
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Hari {{ $day }}
                                </span>
                            </div>

                            <!-- Vertical Timeline Line -->
                            <div class="relative border-l-2 border-blue-100 ml-5 pl-8 space-y-10">

                                @foreach ($items->sortBy('start_time') as $item)
                                    <div class="relative group">

                                        <!-- Dot Marker -->
                                        <div
                                            class="absolute -left-11 top-1.5 h-4 w-4 rounded-full border-4 border-white bg-blue-300 group-hover:bg-blue-600 transition-shadow shadow-sm">
                                        </div>

                                        <div class="flex flex-col sm:flex-row gap-4">

                                            <!-- Waktu -->
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="inline-block px-3 py-1 bg-gray-100 rounded-md text-sm font-mono font-bold text-gray-700 border border-gray-200">
                                                    {{ $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('H:i') : '?' }}
                                                </span>
                                            </div>

                                            <!-- Card -->
                                            <div
                                                class="flex-1 bg-white border border-gray-100 p-5 rounded-xl shadow-sm hover:shadow-md transition-all">

                                                <h4 class="font-bold text-gray-800 mb-1">
                                                    {{ $item->title }}
                                                </h4>

                                                @if ($item->location)
                                                    <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                                                        <svg class="w-3 h-3 text-red-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ $item->location }}
                                                    </p>
                                                @endif

                                                <p class="text-gray-600 leading-relaxed">
                                                    {{ $item->description }}
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    @endforeach

                @endif
            </div>




        </div>

        <!-- KONTEN KANAN (CARD BOOKING) -->
        <div>
            <div class="bg-white p-6 rounded-xl shadow sticky top-24">

                <h3 class="text-2xl font-bold text-blue-600">
                    Rp{{ number_format($package->price, 0, ',', '.') }}
                    <span class="text-gray-600 text-sm font-normal"> / orang</span>
                </h3>

                <p class="text-gray-500 mt-2">
                    Durasi: {{ $package->duration_days }} hari
                </p>

                <a href="{{ route('customer.booking.create', $package) }}"
                    class="block w-full mt-5 bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 font-semibold">
                    Pesan Sekarang
                </a>

            </div>
        </div>

    </div>

</body>

</html>
