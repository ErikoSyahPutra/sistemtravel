<x-customer-layout title="Dashboard Customer">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Section Selamat Datang -->
            <section class="text-center bg-white shadow-md rounded-xl py-10 px-6">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-3">
                    Selamat Datang di <span class="text-blue-600">KitaTravel</span> ✈️
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Temukan berbagai destinasi terbaik untuk liburan impianmu.
                    Jelajahi tempat-tempat menarik di seluruh penjuru negeri dengan mudah dan cepat!
                </p>
            </section>

            <!-- Search Bar -->
            <div class="flex justify-center">
                <form action="{{ route('customer.destinations') }}" method="GET"
                    class="flex items-center w-full max-w-md">
                    <input type="text" name="search" placeholder="Cari destinasi..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Destinasi Populer --}}
            <div id="destinasi" class="mb-14">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-2xl font-bold text-gray-800">Destinasi Populer</h2>
                    <a href="{{ route('customer.destinations') }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Lihat Semua →
                    </a>
                </div>

                @if (isset($destinations) && $destinations->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($destinations->take(8) as $destination)
                            <div
                                class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                                <div class="relative h-44 bg-gray-100 overflow-hidden">
                                    @if ($destination->image_url)
                                        <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">No
                                            Image</div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3 class="text-base font-semibold text-gray-800">{{ $destination->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($destination->description, 80) }}
                                    </p>
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('customer.destinations', $destination->id) }}"
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

            {{-- Rekomendasi Untuk Kamu --}}
            <div class="mb-14">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Untuk Kamu</h2>
                    <a href="{{ route('customer.destinations') }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Jelajahi Semua →
                    </a>
                </div>

                @if (isset($destinations) && $destinations->count() > 4)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($destinations->shuffle()->take(4) as $destination)
                            <div
                                class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                                <div class="relative h-44 bg-gray-100 overflow-hidden">
                                    @if ($destination->image_url)
                                        <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">No
                                            Image</div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3 class="text-base font-semibold text-gray-800">{{ $destination->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($destination->description, 80) }}
                                    </p>
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('customer.destinations', $destination->id) }}"
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

            {{-- Booking Saya --}}
            @if (isset($bookings) && $bookings->isNotEmpty())
                <div class="mt-10">
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
</x-customer-layout>
