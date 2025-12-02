<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Booking & Penugasan Guide
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Detail Booking -->
            <div class="md:col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Detail Booking</h3>
                <p><strong>Paket Tur:</strong> {{ $booking->package->title ?? 'N/A' }}</p>
                <p><strong>Pelanggan:</strong> {{ $booking->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $booking->user->email ?? 'N/A' }}</p>
                <p><strong>Telepon:</strong> {{ $booking->user->customerProfile->phone ?? 'N/A' }}</p>
                <p><strong>Tanggal Tur:</strong> {{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($booking->date_end)->format('d M Y') }}</p>
                <p><strong>Jumlah Pax:</strong> {{ $booking->pax_count ?? 'N/A' }} orang</p>
            </div>

            <!-- Kolom Kanan: Form Assignment -->
            <div class="md:col-span-1 bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Tugaskan Guide</h3>

                {{-- Menampilkan pesan sukses/error --}}
                @if(session('success'))
                <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                {{-- Tampilkan guide yang sudah ditugaskan jika ada --}}
                @if($assignment = $booking->guideAssignments->first())
                <div class="mb-4 p-4 bg-gray-100 rounded-lg">
                    <p class="font-medium">Telah Ditugaskan Kepada:</p>
                    <p class="text-lg font-semibold">{{ $assignment->guide->user->name ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Status: <span class="font-medium text-green-600">{{ $assignment->status }}</span></p>

                    {{-- (Opsional) Form untuk membatalkan assignment --}}
                    <form action="{{ route('admin.guide-assignments.destroy', $assignment) }}" method="POST" class="mt-2" onsubmit="return confirm('Anda yakin ingin membatalkan penugasan guide ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:underline">Batalkan Penugasan</button>
                    </form>
                </div>
                @else
                {{-- Form untuk menugaskan guide --}}
                <form action="{{ route('admin.guide-assignments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div>
                        <label for="guide_id" class="block font-medium text-sm text-gray-700">Pilih Guide (Hanya yang Tersedia)</label>
                        <select name="guide_id" id="guide_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Guide --</option>
                            {{-- Loop dari $availableGuides yang dikirim controller --}}
                            @forelse($availableGuides as $guide)
                            <option value="{{ $guide->id }}">{{ $guide->user->name }} ({{ is_array($guide->languages) ? implode(', ', $guide->languages) : $guide->languages }})</option>
                            @empty
                            <option value="" disabled>Tidak ada guide yang tersedia saat ini.</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="notes" class="block font-medium text-sm text-gray-700">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tugaskan Sekarang
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>