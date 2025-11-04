<x-customer-layout title="Dashboard Customer">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Selamat datang, {{ auth()->user()->name }}!</h2>
        <p>Jelajahi destinasi wisata dan kelola booking kamu di sini.</p>
    </div>

    <!-- Daftar Tour Package -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($tourPackages as $package)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @php
                    $images = json_decode($package->images, true);
                    $image = $images[0] ?? 'default.jpg';
                @endphp

                <img src="{{ asset('storage/' . $image) }}" alt="{{ $package->title }}" class="w-full h-48 object-cover">

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $package->title }}</h3>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $package->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-bold">
                            {{ $package->currency }} {{ number_format($package->price, 0, ',', '.') }}
                        </span>
                        <form action="{{ route('customer.tourpackages.buy', $package->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Buy
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 col-span-3">Belum ada paket tur yang tersedia.</p>
        @endforelse
    </div>
</x-customer-layout>
