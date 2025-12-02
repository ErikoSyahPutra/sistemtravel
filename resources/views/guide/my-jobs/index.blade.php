<x-guide-layout>
    <x-slot name="header">
        Pekerjaan Saya
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-semibold mb-4">Daftar Pekerjaan yang Ditugaskan</h3>

            {{-- Menampilkan pesan sukses --}}
            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="space-y-4">
                @forelse($assignments as $assignment)
                <div class="border rounded-lg p-4 flex flex-col sm:flex-row justify-between sm:items-center">
                    <div>
                        {{-- Data Paket diambil dari relasi Package --}}
                        <p class="text-xl font-bold text-indigo-600">{{ $assignment->booking->package->title ?? 'N/A' }}</p>

                        <p class="text-sm text-gray-600">
                            Pelanggan: <strong>{{ $assignment->booking->user->name ?? 'N/A' }}</strong>
                        </p>
                        <p class="text-sm text-gray-600">
                            {{-- Tanggal Mulai --}}
                            Tanggal Mulai: <strong>{{ \Carbon\Carbon::parse($assignment->booking->date_start)->format('d F Y') }}</strong>
                        </p>
                    </div>

                    <div class="mt-4 sm:mt-0 flex space-x-2">
                        {{-- Tombol 1: Detail Pekerjaan --}}
                        <a href="{{ route('guide.my-jobs.show', $assignment) }}" class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-500">Anda belum memiliki pekerjaan yang ditugaskan.</p>
                @endforelse

                <div class="mt-4">
                    {{ $assignments->links() }}
                </div>
            </div>

        </div>
    </div>
</x-guide-layout>