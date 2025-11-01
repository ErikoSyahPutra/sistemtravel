<x-customer-layout title="Destinations">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Header & Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-blue-700">Explore Destinations</h1>
                    <p class="text-gray-600 mt-2">Temukan berbagai destinasi menarik untuk perjalanan Anda.</p>
                </div>

                <form action="{{ route('customer.destinations') }}" method="GET" class="mt-4 sm:mt-0 flex items-center w-full max-w-md">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari destinasi..."
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <button 
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition"
                    >
                        Cari
                    </button>
                </form>
            </div>

            <!-- Grid Destinations -->
            @if(isset($destinations) && $destinations->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($destinations as $destination)
                        <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col">
                            <div class="relative h-48 bg-gray-100 overflow-hidden">
                                @if($destination->cover_image)
                                    <img src="{{ asset('storage/' . $destination->cover_image) }}" 
                                         alt="{{ $destination->name }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
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
                                    @if($destination->tourPackages && $destination->tourPackages->isNotEmpty())
                                        @php
                                            $paket = $destination->tourPackages->first();
                                        @endphp
                                        <div class="mt-3 text-sm text-gray-600 space-y-1">
                                            <div><span class="font-semibold">Durasi:</span> {{ $paket->duration ?? '-' }} hari</div>
                                            <div><span class="font-semibold">Harga mulai dari:</span> Rp{{ number_format($paket->price ?? 0, 0, ',', '.') }}</div>
                                            @if($paket->rating)
                                                <div><span class="font-semibold">Rating:</span> {{ $paket->rating }} ⭐</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Lihat Paket Button -->
                                <div class="mt-4">
                                    <a href="{{ route('customer.packages.index', $destination) }}"
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
</x-customer-layout>
