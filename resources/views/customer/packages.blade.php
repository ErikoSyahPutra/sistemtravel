<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Tur - {{ $destination->name }}</title>
    @vite('resources/css/app.css')
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
        const menuBtn = document.getElementById("menuBtn");
        const mobileMenu = document.getElementById("mobileMenu");

        menuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>

    <!-- CONTENT SECTION -->
    <div class="py-12 max-w-7xl mx-auto px-6">

        <h1 class="text-3xl font-bold text-blue-700">Paket Tur: {{ $destination->name }}</h1>
        <p class="text-gray-600 mt-2">Pilih paket perjalanan yang paling sesuai untuk Anda.</p>

        <div class="mt-8">
            @if ($destination->tourPackages && $destination->tourPackages->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($destination->tourPackages as $package)
                        <div
                            class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col">

                            <div class="relative h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                (Gambar Paket)
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $package->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $package->duration_days }} hari</p>

                                    <p class="text-gray-700 text-sm mt-3 line-clamp-3">
                                        {{ $package->description ? Str::limit($package->description, 120) : 'Tidak ada deskripsi tersedia.' }}
                                    </p>

                                    <div class="mt-3 text-xl font-bold text-blue-600">
                                        Rp{{ number_format($package->price, 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/ orang</span>
                                    </div>

                                    @if ($package->rating)
                                        <div class="text-sm mt-1">
                                            <span class="font-semibold">Rating:</span> {{ $package->rating }} ⭐
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('customer.package.detail', $package) }}"
                                        class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <p class="text-gray-600 text-center py-10">Belum ada paket tur yang tersedia untuk destinasi ini.</p>
            @endif
        </div>

    </div>

</body>

</html>
