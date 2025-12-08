<x-customer-layout title="Booking Saya">
    <div class="py-12 bg-gray-50 min-h-screen">

        <div class="max-w-7xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-blue-700">Booking Saya</h1>
                <p class="text-gray-600 mt-2">Pantau status booking dan detail perjalananmu di sini.</p>
            </div>

            <!-- Daftar Booking -->
            @if (isset($bookings) && $bookings->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

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

    </div>
</x-customer-layout>
