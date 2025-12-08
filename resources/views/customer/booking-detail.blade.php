<x-customer-layout title="Detail Booking">
    <div class="py-12 max-w-4xl mx-auto">

        <!-- ============================= -->
        <!--           DETAIL BOOKING      -->
        <!-- ============================= -->
        <h1 class="text-2xl font-bold text-blue-700 mb-6">Detail Booking</h1>

        <div class="bg-white p-6 rounded-lg shadow mb-10">

            <!-- Nama Paket -->
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $booking->tourPackage->title }}
            </h2>

            <!-- Tanggal -->
            <p class="text-gray-500 mt-2">
                {{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }} –
                {{ \Carbon\Carbon::parse($booking->date_end)->format('d M Y') }}
            </p>

            <!-- Pax -->
            <p class="mt-3">
                Pax: <strong>{{ $booking->pax_count }}</strong>
            </p>

            <!-- Total Price -->
            <p>
                Total Harga:
                <strong>Rp{{ number_format($booking->total_price, 0, ',', '.') }}</strong>
            </p>

            <!-- Status Pembayaran -->
            <p class="mt-2">
                Status:
                <span
                    class="font-semibold 
                    {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ ucfirst($booking->payment_status) }}
                </span>
            </p>

            <!-- Tombol Kembali -->
            <a href="{{ route('customer.booking') }}"
                class="inline-block mt-6 bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                Kembali
            </a>

            <!-- Tombol Bayar Sekarang -->
            @if ($booking->payment_status === 'pending')
                <a href="{{ route('customer.booking.pay', $booking->id) }}"
                    class="inline-block mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Bayar Sekarang
                </a>
            @endif

        </div>


        <!-- ============================= -->
        <!--        ITINERARY (TIMELINE)   -->
        <!-- ============================= -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Itinerary Perjalanan</h2>

            @php
                $itineraries = $booking->tourPackage->itineraries->sortBy('day_number')->groupBy('day_number');
            @endphp

            @if ($itineraries->isEmpty())

                <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                    Belum ada itinerary untuk paket ini.
                </div>
            @else
                {{-- LOOP PER HARI --}}
                @foreach ($itineraries as $day => $items)
                    <div class="mb-12 relative">

                        <!-- Sticky Day Header -->
                        <div class="sticky top-0 z-10 py-2 backdrop-blur border-b border-gray-200 mb-8">
                            <span
                                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Hari {{ $day }}
                            </span>
                        </div>

                        <!-- Timeline Vertical Line -->
                        <div class="relative border-l-2 border-blue-100 ml-5 pl-8 space-y-10">

                            {{-- LOOP ITEM ITINERARY --}}
                            @foreach ($items->sortBy('start_time') as $item)
                                <div class="relative group">

                                    <!-- Dot Marker -->
                                    <div
                                        class="absolute -left-11 top-1.5 h-4 w-4 rounded-full border-4 border-white bg-blue-300 group-hover:bg-blue-600 transition-shadow shadow-sm">
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-4">

                                        <!-- Waktu -->
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-block px-3 py-1 bg-gray-100 rounded-md text-sm font-mono font-bold text-gray-700 border border-gray-200">
                                                {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
                                            </span>
                                        </div>

                                        <!-- Card Itinerary -->
                                        <div
                                            class="flex-1 bg-white border border-gray-100 p-5 rounded-xl shadow-sm hover:shadow-md transition-all">

                                            <h4 class="font-bold text-gray-800 mb-1">
                                                {{ $item->title }}
                                            </h4>

                                            @if ($item->location)
                                                <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                                                    <svg class="w-3 h-3 text-red-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $item->location }}
                                                </p>
                                            @endif

                                            <p class="text-gray-600 leading-relaxed">
                                                {{ $item->description }}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-customer-layout>
