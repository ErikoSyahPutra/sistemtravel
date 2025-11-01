<x-customer-layout title="Pembayaran Booking">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-blue-700">Selesaikan Pembayaran</h1>
                    <p class="text-gray-600 mt-1">Booking Anda <span class="font-semibold text-yellow-600">pending</span> menunggu pembayaran.</p>
                </div>

                <div class="mb-6 border-y py-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paket Tur:</span>
                        <span class="font-semibold text-gray-800">{{ $booking->tourPackage->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Pax:</span>
                        <span class="font-semibold text-gray-800">{{ $booking->pax }} orang</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t">
                        <span class="text-lg font-semibold text-gray-700">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-gray-500 text-sm mb-4">
                        Ini adalah halaman simulasi pembayaran. Klik tombol di bawah ini untuk mengonfirmasi (pura-pura) pembayaran.
                    </p>
                    
                    <form action="{{ route('customer.booking.process', $booking->id) }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full text-center bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition font-semibold text-lg"
                        >
                            Bayar Sekarang
                        </button>
                    </form>
                    
                    <a href="{{ route('customer.booking') }}" class="mt-4 inline-block text-sm text-gray-600 hover:text-blue-500">
                        Bayar Nanti (Kembali ke Daftar Booking)
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-customer-layout>