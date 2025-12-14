<x-customer-layout title="Dashboard Customer">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            <!-- ================= SELAMAT DATANG ================= -->
            <section class="text-center bg-white shadow-md rounded-xl py-10 px-6">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-3">
                    Selamat Datang di <span class="text-blue-600">KitaTravel</span> ✈️
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Temukan berbagai destinasi terbaik untuk liburan impianmu.
                </p>
            </section>

            <!-- ================= DESTINASI POPULER ================= -->
            <section>
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

                                <!-- IMAGE (SAMA DENGAN PAGE DESTINATIONS) -->
                                <div class="relative h-44 bg-gray-100 overflow-hidden">
                                    @if ($destination->cover_image)
                                        <img src="{{ asset('storage/' . $destination->cover_image) }}"
                                            alt="{{ $destination->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400">
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                <!-- CONTENT -->
                                <div class="p-4">
                                    <h3 class="text-base font-semibold text-gray-800">
                                        {{ $destination->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($destination->description, 80) }}
                                    </p>
                                    <div class="mt-3 text-right">
                                        <a href="{{ route('packages.index', $destination) }}"
                                            class="text-sm text-blue-600 hover:underline font-semibold">
                                            Lihat Paket →
                                        </a>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-10">
                        Belum ada destinasi untuk ditampilkan.
                    </p>
                @endif
            </section>

            <!-- ================= REKOMENDASI ================= -->
            <section>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Untuk Kamu</h2>
                    <a href="{{ route('customer.destinations') }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        Jelajahi Semua →
                    </a>
                </div>

                @if (isset($destinations) && $destinations->count() >= 4)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($destinations->shuffle()->take(4) as $destination)
                            <div
                                class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">

                                <!-- IMAGE -->
                                <div class="relative h-44 bg-gray-100 overflow-hidden">
                                    @if ($destination->cover_image)
                                        <img src="{{ asset('storage/' . $destination->cover_image) }}"
                                            alt="{{ $destination->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400">
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3 class="text-base font-semibold text-gray-800">
                                        {{ $destination->name }}
                                    </h3>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-10">
                        Belum ada rekomendasi yang tersedia.
                    </p>
                @endif
            </section>

            <!-- ================= BOOKING SAYA ================= -->
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-5">Booking Saya</h2>

                @if (isset($bookings) && $bookings->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($bookings as $booking)
                            @php
                                $images = json_decode($booking->tourPackage->images ?? '[]', true);
                            @endphp

                            <a href="{{ route('customer.booking.show', $booking->id) }}"
                                class="block bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">

                                <!-- IMAGE (SAMA DENGAN PAGE PACKAGES) -->
                                <div class="relative h-44 bg-gray-100 overflow-hidden">
                                    @if ($images && isset($images[0]))
                                        <img src="{{ asset('storage/' . $images[0]) }}"
                                            alt="{{ $booking->tourPackage->title }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400">
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h3 class="text-base font-semibold text-gray-800">
                                        {{ $booking->tourPackage->title ?? 'Paket Tidak Tersedia' }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Rp{{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm mt-1">
                                        Status:
                                        <span
                                            class="font-semibold {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </p>
                                </div>

                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-10">
                        Belum ada booking untuk ditampilkan.
                    </p>
                @endif
            </section>

        </div>
    </div>
</x-customer-layout>
