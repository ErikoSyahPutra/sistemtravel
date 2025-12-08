<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations • KitaTravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <!-- NAVBAR -->
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

    <script>
        const btn = document.getElementById("mobileMenuBtn");
        const menu = document.getElementById("mobileMenu");
        btn.addEventListener("click", () => menu.classList.toggle("hidden"));
    </script>

    <!-- CONTENT -->
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Header & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-blue-700">Explore Destinations</h1>
                    <p class="text-gray-600 mt-2">Temukan berbagai destinasi menarik untuk perjalanan Anda.</p>
                </div>

                <form action="{{ route('customer.destinations') }}" method="GET"
                    class="mt-4 sm:mt-0 flex items-center w-full max-w-md">
                    <input type="text" name="search" placeholder="Cari destinasi..."
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Grid Destinations -->
            @if (isset($destinations) && $destinations->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($destinations as $destination)
                        <div
                            class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col">
                            <div class="relative h-48 bg-gray-100 overflow-hidden">
                                @if ($destination->cover_image)
                                    <img src="{{ asset('storage/' . $destination->cover_image) }}"
                                        alt="{{ $destination->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $destination->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $destination->location }}</p>
                                    <p class="text-gray-700 text-sm mt-3 line-clamp-3">
                                        {{ $destination->description ? Str::limit($destination->description, 120) : 'Tidak ada deskripsi tersedia.' }}
                                    </p>

                                    <!-- Info Paket -->
                                    @if ($destination->tourPackages && $destination->tourPackages->isNotEmpty())
                                        @php $paket = $destination->tourPackages->first(); @endphp
                                        <div class="mt-3 text-sm text-gray-600 space-y-1">
                                            <div><span class="font-semibold">Durasi:</span>
                                                {{ $paket->duration_days ?? '-' }} hari</div>
                                            <div><span class="font-semibold">Harga mulai dari:</span>
                                                Rp{{ number_format($paket->price ?? 0, 0, ',', '.') }}</div>
                                            @if ($paket->rating)
                                                <div><span class="font-semibold">Rating:</span> {{ $paket->rating }} ⭐
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Lihat Paket Button -->
                                <div class="mt-4">
                                    <a href="{{ route('packages.index', $destination) }}"
                                        class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                        Lihat Paket →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-10">Tidak ada destinasi yang ditemukan.</p>
            @endif

        </div>
    </div>

</body>

</html>
