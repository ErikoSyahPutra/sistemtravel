<x-customer-layout title="Booking Saya">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-700">Booking Saya</h1>
                <p class="text-gray-600 mt-2">Pantau status booking dan detail perjalananmu di sini.</p>
            </div>

            <!-- Daftar Booking -->
            @if (isset($bookings) && $bookings->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($bookings as $booking)
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition flex flex-col sm:flex-row sm:justify-between items-start sm:items-center">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 text-lg">
                                    {{ optional($booking->tourPackage)->title ?? 'Paket tidak tersedia' }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ optional($booking->start_date) ? \Carbon\Carbon::parse($booking->start_date)->format('d M Y') : '-' }}
                                    –
                                    {{ optional($booking->end_date) ? \Carbon\Carbon::parse($booking->end_date)->format('d M Y') : '-' }}
                                    · Pax: {{ $booking->pax }}
                                </div>
                                @if ($booking->status)
                                    <div class="text-sm mt-1">
                                        Status:
                                        <span
                                            class="font-semibold text-{{ $booking->status == 'confirmed' ? 'green-600' : 'yellow-600' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 sm:mt-0 text-right">
                                <div class="text-gray-700 font-semibold text-lg">
                                    Rp{{ number_format($booking->total_amount, 0, ',', '.') }}
                                </div>
                                @if ($booking->status == 'pending')
                                    <a href="{{ route('customer.booking.pay', $booking->id) }}"
                                        class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                        Bayar Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-10">Belum ada booking untuk ditampilkan.</p>
            @endif

        </div>
    </div>
</x-customer-layout>
