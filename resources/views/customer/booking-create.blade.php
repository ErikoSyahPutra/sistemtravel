<x-customer-layout title="Formulir Booking">
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-lg">

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-blue-700">Formulir Booking</h1>
                    <p class="text-gray-600 mt-1">Selesaikan detail pemesanan Anda.</p>
                </div>

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="mb-6 border-b pb-6">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $package->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $package->duration_days }} hari</p>
                    <div class="mt-2 text-xl font-bold text-blue-600">
                        <span id="display-base-price">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                        <span class="text-sm font-normal text-gray-500">/ orang</span>
                    </div>
                </div>

                <form action="{{ route('customer.booking.store', $package->id) }}" method="POST" class="space-y-4"
                    id="booking-form">
                    @csrf
                    <input type="hidden" name="tour_package_id" value="{{ $package->id }}">

                    <div>
                        <label for="date_start" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" id="date_start" name="date_start" min="{{ date('Y-m-d') }}"
                            value="{{ old('date_start') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <div id="availability-message" class="mt-2 text-sm font-medium hidden"></div>
                        
                        @error('date_start')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_end_display" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir</label>
                        <input type="text" id="date_end_display" name="date_end_display"
                            value="{{ old('date_end') ? \Carbon\Carbon::parse(old('date_end'))->isoFormat('DD MMM YYYY') : '' }}"
                            readonly class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg">
                    </div>

                    <div>
                        <label for="pax" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Orang (Pax)</label>
                        <input type="number" id="pax" name="pax" placeholder="Contoh: 2" min="1"
                            value="{{ old('pax', 1) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('pax')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kontak</label>
                        <input type="text" id="contact_name" name="contact_name"
                            value="{{ old('contact_name', auth()->user()->name ?? '') }}"
                            placeholder="Nama yang dapat dihubungi" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('contact_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="tel" id="contact_phone" name="contact_phone"
                            value="{{ old('contact_phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('contact_phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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
                        <div class="text-xs text-gray-500 mt-2">Tanggal berakhir dihitung otomatis berdasarkan tanggal mulai dan durasi paket.</div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="submit-btn"
                            class="w-full text-center bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-lg disabled:opacity-50 disabled:cursor-not-allowed">
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
            // Harga dasar dari DB
            let currentPrice = {{ (int) $package->price }};
            const defaultPrice = {{ (int) $package->price }};
            const packageId = {{ $package->id }};
            const checkRoute = "{{ route('customer.booking.check') }}";
            const csrfToken = "{{ csrf_token() }}";

            const startEl = document.getElementById('date_start');
            const paxEl = document.getElementById('pax');
            const endHiddenEl = document.getElementById('date_end');
            const endDisplayEl = document.getElementById('date_end_display');
            const totalEl = document.getElementById('total_price');
            const totalDisplay = document.getElementById('total-display');
            const priceDisplay = document.getElementById('price-per-person');
            const mainPriceDisplay = document.getElementById('display-base-price');
            const availMsgEl = document.getElementById('availability-message');
            const submitBtn = document.getElementById('submit-btn');

            function formatRupiah(num) {
                return num.toLocaleString('id-ID');
            }

            function formatReadable(d) {
                return d.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function computeTotal() {
                const pax = Math.max(1, parseInt(paxEl.value || 1));
                const total = pax * currentPrice;
                totalEl.value = total;
                totalDisplay.textContent = formatRupiah(total);
                
                // Update tampilan harga per orang jika berubah
                priceDisplay.textContent = formatRupiah(currentPrice);
                mainPriceDisplay.textContent = 'Rp' + formatRupiah(currentPrice);
            }

            function updateEndDate() {
                if (startEl.value) {
                    const s = new Date(startEl.value);
                    const end = new Date(s);
                    end.setDate(s.getDate() + Math.max(0, duration - 1));
                    endDisplayEl.value = formatReadable(end);
                } else {
                    endDisplayEl.value = '';
                }
            }

            async function checkAvailability() {
                const date = startEl.value;
                const pax = parseInt(paxEl.value || 1);

                if (!date) {
                    availMsgEl.classList.add('hidden');
                    // Reset harga ke default jika tanggal kosong
                    currentPrice = defaultPrice;
                    computeTotal();
                    return;
                }

                availMsgEl.classList.remove('hidden', 'text-green-600', 'text-red-600');
                availMsgEl.classList.add('text-gray-500');
                availMsgEl.textContent = 'Mengecek ketersediaan...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch(checkRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            package_id: packageId,
                            date: date,
                            pax: pax
                        })
                    });

                    const data = await response.json();

                    availMsgEl.classList.remove('text-gray-500');

                    if (data.status === 'available') {
                        availMsgEl.classList.add('text-green-600');
                        availMsgEl.classList.remove('text-red-600');
                        availMsgEl.innerHTML = `✅ ${data.message} (Sisa: ${data.remaining} pax)`;
                        
                        // Cek apakah ada harga override dari backend
                        if (data.price_override) {
                            currentPrice = data.price_override;
                            availMsgEl.innerHTML += ` <span class="text-blue-600 font-bold ml-2">(Harga Khusus Tanggal Ini!)</span>`;
                        } else {
                            currentPrice = defaultPrice;
                        }
                        
                        computeTotal();
                        submitBtn.disabled = false;
                    } else {
                        availMsgEl.classList.add('text-red-600');
                        availMsgEl.classList.remove('text-green-600');
                        availMsgEl.innerHTML = `❌ ${data.message}`;
                        submitBtn.disabled = true;
                    }

                } catch (error) {
                    console.error('Error checking availability:', error);
                    availMsgEl.textContent = 'Gagal mengecek ketersediaan. Silakan coba lagi.';
                    availMsgEl.classList.add('text-red-600');
                }
            }

            // Init
            computeTotal();
            updateEndDate();

            startEl.addEventListener('change', () => {
                updateEndDate();
                checkAvailability();
            });

            paxEl.addEventListener('input', () => {
                computeTotal();
                checkAvailability();
            });

        })();
    </script>
</x-customer-layout>
```

---

### Step 3: Pendaftaran Route (Sama seperti sebelumnya, hanya memastikan)

Pastikan di `routes/web.php` Anda sudah ada route ini di dalam grup customer:

```php
Route::post('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check');