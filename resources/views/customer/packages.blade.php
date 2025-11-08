<x-customer-layout :title="'Paket Tur di ' . $destination->name">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-700">Paket Tur: {{ $destination->name }}</h1>
                <p class="text-gray-600 mt-2">Pilih paket perjalanan yang paling sesuai untuk Anda.</p>
            </div>

            @if (isset($destination->tourPackages) && $destination->tourPackages->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($destination->tourPackages as $package)
                        <div
                            class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col">
                            <div class="relative h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                (Gambar Paket)
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $package->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $package->duration_days }} hari</p>
                                    <p class="text-gray-700 text-sm mt-3 line-clamp-3">
                                        {{ $package->description ? Str::limit($package->description, 120) : 'Tidak ada deskripsi tersedia.' }}
                                    </p>
                                    <div class="mt-3 text-xl font-bold text-blue-600">
                                        Rp{{ number_format($package->price ?? 0, 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/ orang</span>
                                    </div>
                                    @if ($package->rating)
                                        <div class="text-sm mt-1"><span class="font-semibold">Rating:</span>
                                            {{ $package->rating }} ⭐</div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('customer.booking.create', $package) }}"
                                        class="block w-full text-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-10">Belum ada paket tur yang tersedia untuk destinasi ini.</p>
            @endif

        </div>
    </div>
</x-customer-layout>
