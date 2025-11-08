<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Guide Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-gray-800">
                Sistem Travel
            </div>
            <nav class="flex-1 p-4 space-y-2">
                {{-- Link navigasi HANYA untuk guide --}}
                <a href="{{ route('guide.dashboard') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('guide.dashboard') ? 'bg-gray-800' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('guide.my-jobs.index') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('guide.my-jobs.index') ? 'bg-gray-800' : '' }}">
                    Pekerjaan Saya
                </a>

                <a href="{{ route('guide.reviews.index') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('guide.reviews.index') ? 'bg-gray-800' : '' }}">
                    Ulasan Saya
                </a>

            </nav>
            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded bg-red-600 hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                {{-- Menggunakan slot $header --}}
                <h1 class="text-xl font-semibold">
                    @if (isset($header))
                    {{ $header }}
                    @else
                    Dashboard
                    @endif
                </h1>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>