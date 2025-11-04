<x-customer-layout title="Formulir Booking">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-lg">

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-blue-700">Formulir Booking</h1>
                    <p class="text-gray-600 mt-1">Selesaikan detail pemesanan Anda.</p>
                </div>

                <div class="mb-6 border-b pb-6">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $package->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $package->duration_days }} hari</p>
                    <div class="mt-2 text-xl font-bold text-blue-600">
                        Rp{{ number_format($package->price, 0, ',', '.') }}
                        <span class="text-sm font-normal text-gray-500">/ orang</span>
                    </div>
                </div>

                <form action="{{ route('customer.booking.store', $package->id) }}" method="POST" class="space-y-4"
                    id="booking-form">
                    @csrf
                    <input type="hidden" name="tour_package_id" value="{{ $package->id }}">

                    <div>
                        <label for="date_start" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Mulai</label>
                        <input type="date" id="date_start" name="date_start" min="{{ date('Y-m-d') }}"
                            value="{{ old('date_start') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('date_start')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visible end date (readonly) -->
                    <div>
                        <label for="date_end_display" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Berakhir</label>
                        <input type="text" id="date_end_display" name="date_end_display"
                            value="{{ old('date_end') ? \Carbon\Carbon::parse(old('date_end'))->isoFormat('DD MMM YYYY') : '' }}"
                            readonly class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg">
                    </div>

                    <div>
                        <label for="pax" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Orang
                            (Pax)</label>
                        <input type="number" id="pax" name="pax" placeholder="Contoh: 2" min="1"
                            value="{{ old('pax', 1) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('pax')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                            Kontak</label>
                        <input type="text" id="contact_name" name="contact_name"
                            value="{{ old('contact_name', auth()->user()->name ?? '') }}"
                            placeholder="Nama yang dapat dihubungi" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('contact_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">No.
                            Telepon</label>
                        <input type="tel" id="contact_phone" name="contact_phone"
                            value="{{ old('contact_phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('contact_phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hidden fields calculated client-side -->
                    <input type="hidden" id="date_end" name="date_end" value="{{ old('date_end') }}">
                    <input type="hidden" id="total_price" name="total_price" value="{{ old('total_price') }}">

                    <div class="bg-gray-50 p-4 rounded-md border border-gray-100">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600">Durasi</div>
                            <div class="text-sm font-semibold text-gray-800">{{ $package->duration_days }} hari</div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="text-sm text-gray-600">Harga / orang</div>
                            <div class="text-sm font-semibold text-blue-600">Rp<span
                                    id="price-per-person">{{ number_format($package->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="text-sm text-gray-600">Total</div>
                            <div class="text-lg font-bold text-gray-800">Rp<span id="total-display">0</span></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">Tanggal berakhir dihitung otomatis berdasarkan tanggal
                            mulai dan durasi paket.</div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full text-center bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                            Lanjut ke Pembayaran
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        (function() {
            const duration = {{ (int) $package->duration_days }};
            const price = {{ (int) $package->price }};
            const startEl = document.getElementById('date_start');
            const paxEl = document.getElementById('pax');
            const endHiddenEl = document.getElementById('date_end');
            const endDisplayEl = document.getElementById('date_end_display');
            const totalEl = document.getElementById('total_price');
            const totalDisplay = document.getElementById('total-display');

            function formatRupiah(num) {
                return num.toLocaleString('id-ID');
            }

            function formatISO(d) {
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }

            function formatReadable(d) {
                return d.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function compute() {
                const pax = Math.max(1, parseInt(paxEl.value || 1));
                const total = pax * price;
                totalEl.value = total;
                totalDisplay.textContent = formatRupiah(total);

                if (startEl.value) {
                    // Use UTC midnight to avoid timezone offset issues
                    const s = new Date(startEl.value + 'T00:00:00');
                    const end = new Date(s);
                    end.setDate(s.getDate() + Math.max(0, duration - 1));
                    endHiddenEl.value = formatISO(end);
                    endDisplayEl.value = formatReadable(end);
                } else {
                    endHiddenEl.value = '';
                    endDisplayEl.value = '';
                }
            }

            // init (also handle existing old values)
            compute();

            // events
            startEl.addEventListener('change', compute);
            paxEl.addEventListener('input', compute);

            // ensure compute before submit
            document.getElementById('booking-form').addEventListener('submit', function() {
                compute();
            });
        })();
    </script>
</x-customer-layout>
