<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitaTravel - Landing Page</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <!-- ================= NAVBAR ================= -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="text-2xl font-bold text-blue-600">KitaTravel</a>

            <!-- Navigation -->
            <nav class="space-x-6 hidden md:flex">
                <a href="/" class="hover:text-blue-600 font-semibold text-blue-600">Beranda</a>
                <a href="{{ route('destinations') }}" class="hover:text-blue-600">Destinasi</a>
                <a href="{{ route('customer.booking') }}" class="hover:text-blue-600">Booking</a>
                <a href="#" class="hover:text-blue-600">Panduan</a>
                <a href="#" class="hover:text-blue-600">Kontak</a>
            </nav>

            <!-- Login Button -->
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
                <a href="{{ route('destinations') }}" class="hover:text-blue-600">Destinasi</a>
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

    <script>
        const btn = document.getElementById("mobileMenuBtn");
        const menu = document.getElementById("mobileMenu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>


    <!-- OFFSET NAVBAR -->
    <div class="pt-24"></div>


    <!-- ================= HERO SECTION ================= -->
    <section class="text-center bg-white shadow-md rounded-xl py-10 px-6 max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">
            Selamat Datang di <span class="text-blue-600">KitaTravel</span> ✈️
        </h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Temukan berbagai destinasi terbaik untuk liburan impianmu.
            Jelajahi tempat-tempat menarik di seluruh penjuru negeri dengan mudah dan cepat!
        </p>
    </section>

    <!-- ================= SEARCH BAR ================= -->
    <div class="flex justify-center mt-10">
        <form action="{{ route('destinations') }}" method="GET" class="flex items-center w-full max-w-md">
            <input type="text" name="search" placeholder="Cari destinasi..." value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                Cari
            </button>
        </form>
    </div>


    <div class="max-w-7xl mx-auto mt-16 space-y-16">

        <!-- ================= DESTINASI POPULER ================= -->
        <div id="destinasi">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-gray-800">Destinasi Populer</h2>
                <a href="{{ route('destinations') }}"
                    class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    Lihat Semua →
                </a>
            </div>

            @if (isset($destinations) && $destinations->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($destinations->take(8) as $destination)
                        <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                            <div class="relative h-44 bg-gray-100 overflow-hidden">
                                @if ($destination->image_url)
                                    <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-base font-semibold text-gray-800">{{ $destination->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit($destination->description, 80) }}
                                </p>
                                <div class="mt-3 text-right">
                                    <a href="{{ route('destinations', $destination->id) }}"
                                        class="text-sm text-blue-600 hover:underline font-semibold">
                                        Lihat Paket →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-10">Belum ada destinasi untuk ditampilkan.</p>
            @endif
        </div>


        <!-- ================= REKOMENDASI ================= -->
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Untuk Kamu</h2>
                <a href="{{ route('destinations') }}"
                    class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    Jelajahi Semua →
                </a>
            </div>

            @if (isset($destinations) && $destinations->count() > 4)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($destinations->shuffle()->take(4) as $destination)
                        <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                            <div class="relative h-44 bg-gray-100 overflow-hidden">
                                @if ($destination->image_url)
                                    <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="text-base font-semibold text-gray-800">{{ $destination->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit($destination->description, 80) }}
                                </p>
                                <div class="mt-3 text-right">
                                    <a href="{{ route('destinations', $destination->id) }}"
                                        class="text-sm text-blue-600 hover:underline font-semibold">
                                        Lihat Paket →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-10">Belum ada rekomendasi yang tersedia saat ini.</p>
            @endif
        </div>


        <!-- ================= BOOKING SAYA ================= -->
        @if (isset($bookings) && $bookings->isNotEmpty())
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-5">Booking Saya</h2>
                <div class="space-y-3">
                    @foreach ($bookings as $booking)
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition">
                            <div>
                                <div class="font-semibold text-gray-800">
                                    {{ optional($booking->tourPackage)->name ?? 'Paket tidak tersedia' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ optional($booking->start_date) ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') : '-' }}
                                    –
                                    {{ optional($booking->end_date) ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}
                                    · Pax: {{ $booking->pax }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-700 font-semibold">
                                    Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <br><br>

</body>

</html>
