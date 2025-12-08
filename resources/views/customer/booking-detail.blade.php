<x-customer-layout title="Detail Booking">
    <div class="py-12 max-w-4xl mx-auto">

        <!-- Judul -->
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

            <!-- Status -->
            <p class="mt-2">
                Status:
                <span
                    class="font-semibold 
                    {{ $booking->payment_status == 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ ucfirst($booking->payment_status) }}
                </span>
            </p>

            <!-- Tombol Kembali -->
            <a href="{{ route('customer.booking') }}"
                class="inline-block mt-6 bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                Kembali
            </a>

        </div>


        <!-- ============================= -->
        <!--          ITINERARY           -->
        <!-- ============================= -->
        <h2 class="text-xl font-bold text-gray-800 mb-4">Itinerary Perjalanan</h2>

        @php
            $itineraries = $booking->tourPackage->itineraries->sortBy('day_number')->groupBy('day_number');
        @endphp

        @if ($itineraries->isEmpty())

            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                Belum ada itinerary untuk paket ini.
            </div>
        @else
            @foreach ($itineraries as $day => $items)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-blue-600 mb-3">Hari {{ $day }}</h3>

                    <div class="space-y-4">
                        @foreach ($items as $item)
                            <div class="bg-white p-4 rounded-lg shadow">

                                <h4 class="font-semibold text-gray-800">{{ $item->title }}</h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $item->start_time }} - {{ $item->end_time }}
                                </p>

                                @if ($item->location)
                                    <p class="text-sm text-gray-600 mt-1">
                                        📍 {{ $item->location }}
                                    </p>
                                @endif

                                <p class="text-gray-700 mt-2">{{ $item->description }}</p>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

        @endif

    </div>
</x-customer-layout>
