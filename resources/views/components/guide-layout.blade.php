<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Guide Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-64 bg-gray-900 text-white flex flex-col overflow-y-auto">
        <div class="p-4 text-2xl font-bold border-b border-gray-800">
            Sistem Travel
        </div>
        <nav class="flex-1 p-4 space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('guide.dashboard') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('guide.dashboard') ? 'bg-gray-800' : '' }}">
                Dashboard
            </a>

            {{-- Pekerjaan Saya --}}
            <a href="{{ route('guide.my-jobs.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('guide.my-jobs.*') ? 'bg-gray-800' : '' }}">
                Pekerjaan Saya
            </a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded bg-red-600 hover:bg-red-700 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-64">
        <!-- Topbar -->
        {{-- Penyesuaian: Menggunakan left-64 dan right-0 agar header pas di sebelah sidebar tanpa scroll horizontal --}}
        <header class="fixed top-0 right-0 left-64 bg-white shadow px-6 py-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-semibold text-gray-800">
                {{-- Mendukung variabel $header (dari slot) atau $title --}}
                @if (isset($header))
                {{ $header }}
                @else
                {{ $title ?? 'Dashboard' }}
                @endif
            </h1>
            <div class="flex items-center space-x-3">
                <span class="text-gray-600">{{ auth()->user()->name }}</span>

                {{-- Logika Foto Profil: Cek kolom profile_photo jika ada, jika tidak pakai inisial --}}
                @if (isset(auth()->user()->profile_photo) && auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile"
                    class="w-8 h-8 rounded-full border border-gray-300 object-cover">
                @else
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-700 font-bold border border-gray-400">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 mt-16">
            {{ $slot }}
        </main>
    </div>
</body>

</html>