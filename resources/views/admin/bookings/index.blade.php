<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Booking
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Pesan Sukses --}}
                    @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- (Opsional) Filter Navigasi --}}
                    <div class="mb-4 flex space-x-2">
                        <a href="{{ route('admin.bookings.index') }}" class="px-3 py-1 rounded-md text-sm font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Semua</a>
                        <a href="{{ route('admin.bookings.index', ['status' => 'unassigned']) }}" class="px-3 py-1 rounded-md text-sm font-medium {{ request('status') == 'unassigned' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Belum Ditugaskan</a>
                        <a href="{{ route('admin.bookings.index', ['status' => 'assigned']) }}" class="px-3 py-1 rounded-md text-sm font-medium {{ request('status') == 'assigned' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">Sudah Ditugaskan</a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket Tur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Guide</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->package->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($booking->date_start)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- Menggunakan relasi 'guideAssignments' dari model Booking --}}
                                    @if($assignment = $booking->guideAssignments->first())
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($assignment->status == 'confirmed') bg-green-100 text-green-800 @endif
                                                @if($assignment->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                                @if($assignment->status == 'rejected') bg-red-100 text-red-800 @endif
                                            ">
                                        Ditugaskan
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Belum Ditugaskan
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-900">Detail / Tugaskan Guide</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data booking.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>