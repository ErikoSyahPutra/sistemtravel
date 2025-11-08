<x-customer-layout>
    <div class="flex items-center justify-center">
        <div class="bg-white p-8 rounded-2xl shadow-lg max-w-lg w-full text-center">
            <!-- Icon sukses -->
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-500" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4" />
                </svg>
            </div>

            <!-- Judul -->
            <h2 class="text-3xl font-semibold text-gray-800 mb-2">Pembayaran Berhasil!</h2>
            <p class="text-gray-600 mb-8">
                Terima kasih telah melakukan pembayaran. Pesanan Anda telah berhasil diproses dan sedang kami
                verifikasi.
            </p>

            @if ($booking)
                <!-- Kartu informasi transaksi -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm text-left p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        🧾 Detail Transaksi
                    </h3>

                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Kode Booking</span>
                            <span class="font-semibold text-gray-800">{{ $booking->booking_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Nama Paket</span>
                            <span class="text-gray-800">{{ $booking->tourPackage->title ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Jumlah Peserta</span>
                            <span class="text-gray-800">{{ $booking->pax_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Tanggal Berangkat</span>
                            <span
                                class="text-gray-800">{{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Tanggal Kembali</span>
                            <span
                                class="text-gray-800">{{ \Carbon\Carbon::parse($booking->date_end)->format('d M Y') }}</span>
                        </div>

                        <div class="border-t my-3"></div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Total Pembayaran</span>
                            <span class="font-bold text-green-600 text-lg">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Status Pembayaran</span>
                            <span
                                class="font-semibold {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-500' }}">
                                {{ strtoupper($booking->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-lg mb-8">
                    <p>Data transaksi tidak ditemukan. Silakan cek kembali di dashboard Anda.</p>
                </div>
            @endif

            <!-- Tombol kembali -->
            <a href="{{ route('customer.dashboard') }}"
                class="inline-block bg-blue-600 text-white font-medium px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-customer-layout>
