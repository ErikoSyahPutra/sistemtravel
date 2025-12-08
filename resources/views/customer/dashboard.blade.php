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

            <!-- Daftar Booking -->
            @if (isset($bookings) && $bookings->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-5">Booking Saya</h2>
                    @foreach ($bookings as $booking)
                        <a href="{{ route('customer.booking.show', $booking->id) }}"
                            class="block bg-white rounded-xl border shadow-sm hover:shadow-lg transition overflow-hidden">

                            <!-- Gambar Paket -->
                            <div class="relative h-44 bg-gray-100 overflow-hidden">
                                @if ($booking->tourPackage && $booking->tourPackage->image_url)
                                    <img src="{{ $booking->tourPackage->image_url }}"
                                        alt="{{ $booking->tourPackage->title }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <!-- Konten -->
                            <div class="p-4">

                                <!-- Judul Paket -->
                                <h3 class="text-base font-semibold text-gray-800">
                                    {{ $booking->tourPackage->title ?? 'Paket Tidak Tersedia' }}
                                </h3>

                                <!-- Tanggal -->
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }} –
                                    {{ \Carbon\Carbon::parse($booking->date_end)->format('d M Y') }}
                                </p>

                                <!-- Pax -->
                                <p class="text-sm text-gray-500">
                                    Pax: <span class="font-semibold">{{ $booking->pax_count }}</span>
                                </p>

                                <!-- Total Harga -->
                                <p class="mt-2 text-gray-800 font-semibold">
                                    Rp{{ number_format($booking->total_amount, 0, ',', '.') }}
                                </p>

                                <!-- Status -->
                                <p class="text-sm mt-1">
                                    Status:
                                    <span
                                        class="font-semibold 
                                        {{ $booking->payment_status == 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </p>

                                <!-- Tombol Bayar -->
                                @if ($booking->payment_status === 'pending')
                                    <div class="mt-4">
                                        <button
                                            onclick="window.location='{{ route('customer.booking.pay', $booking->id) }}'"
                                            class="block w-full text-center text-sm bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                            Bayar Sekarang
                                        </button>

                                    </div>
                                @endif

                            </div>

                        </a>
                    @endforeach

                </div>
            @else
                <p class="text-gray-600 text-center py-10">
                    Belum ada booking untuk ditampilkan.
                </p>
            @endif


        </div>
</x-customer-layout>
