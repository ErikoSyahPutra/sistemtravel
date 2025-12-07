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
                        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition flex flex-col sm:flex-row sm:justify-between items-start sm:items-center border border-gray-100">
                            
                            {{-- Bagian Kiri: Info Paket --}}
                            <div class="flex-1 w-full sm:w-auto mb-4 sm:mb-0">
                                <div class="font-bold text-gray-900 text-lg">
                                    {{ $booking->tourPackage->title ?? 'Paket tidak tersedia' }}
                                </div>
                                
                                <div class="text-sm text-gray-600 mt-1 flex flex-wrap items-center gap-2">
                                    {{-- FIX: Menggunakan date_start & date_end sesuai Controller --}}
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $booking->date_start ? \Carbon\Carbon::parse($booking->date_start)->format('d M Y') : '-' }}
                                        <span class="mx-1">–</span>
                                        {{ $booking->date_end ? \Carbon\Carbon::parse($booking->date_end)->format('d M Y') : '-' }}
                                    </span>
                                    
                                    <span class="hidden sm:inline text-gray-300">|</span>

                                    {{-- FIX: Menggunakan pax_count sesuai Controller --}}
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Pax: {{ $booking->pax_count }} Orang
                                    </span>
                                </div>

                                {{-- Status Badges --}}
                                <div class="mt-2 flex items-center gap-2">
                                    @php
                                        $statusClass = match($booking->status) {
                                            'confirmed' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        
                                        $paymentClass = match($booking->payment_status) {
                                            'paid' => 'text-green-600',
                                            'unpaid' => 'text-orange-600',
                                            'failed' => 'text-red-600',
                                            default => 'text-gray-500'
                                        };
                                    @endphp
                                    
                                    <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $statusClass }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <span class="text-xs font-medium {{ $paymentClass }} border-l pl-2 border-gray-300">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Bagian Kanan: Harga & Aksi --}}
                            <div class="text-right w-full sm:w-auto flex flex-row sm:flex-col justify-between items-center sm:items-end mt-4 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                                <div class="text-blue-700 font-bold text-xl mb-0 sm:mb-2">
                                    Rp{{ number_format($booking->total_price ?? $booking->total_amount, 0, ',', '.') }}
                                </div>

                                @if ($booking->status == 'pending' && $booking->payment_status == 'unpaid')
                                    {{-- Cek apakah ada Link Pembayaran di Metadata (Logic Controller) --}}
                                    @if(!empty($booking->meta) && isset(json_decode($booking->meta)->payment_url))
                                        <a href="{{ json_decode($booking->meta)->payment_url }}" target="_blank"
                                            class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-semibold text-sm shadow-md hover:shadow-lg">
                                            Lanjut Pembayaran
                                        </a>
                                    @else
                                        {{-- Fallback ke halaman detail pembayaran internal --}}
                                        <a href="{{ route('customer.payment.show', $booking->id) }}"
                                            class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-semibold text-sm shadow-md hover:shadow-lg">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                @else
                                    <button class="text-gray-400 text-sm font-medium cursor-default bg-gray-50 px-3 py-1 rounded">
                                        Detail
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-gray-500 font-medium text-lg">Belum ada booking untuk ditampilkan.</p>
                    <a href="/" class="mt-4 inline-block text-blue-600 font-semibold hover:underline">Cari Paket Wisata &rarr;</a>
                </div>
            @endif

        </div>
    </div>
</x-customer-layout>