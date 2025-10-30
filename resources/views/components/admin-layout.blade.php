<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-800">
            Sistem Travel
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800' : '' }}">
                Management User
            </a>
            <a href="{{ route('admin.guides.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.guides.*') ? 'bg-gray-800' : '' }}">
                Management Guide
            </a>
            <a href="{{ route('admin.destinations.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.destinations.*') ? 'bg-gray-800' : '' }}">
                Management Destination
            </a>
            <a href="{{ route('admin.currencies.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.currencies.*') ? 'bg-gray-800' : '' }}">
                Currency Management
            </a>
            <a href="{{ route('admin.tourpackages.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800 {{ request()->routeIs('admin.tourpackages.*') ? 'bg-gray-800' : '' }}">
                Tour Package Management
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
    <div class="flex-1 flex flex-col ml-64">
        <!-- Topbar -->
        <header class="fixed top-0 left-0 w-screen ml-64 bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">{{ $title ?? 'Dashboard' }}</h1>
            <div class="flex items-center space-x-3">
                <span class="text-gray-600">{{ auth()->user()->name }}</span>
                @if (auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile"
                        class="w-8 h-8 rounded-full border border-gray-300">
                @else
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-700">
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
