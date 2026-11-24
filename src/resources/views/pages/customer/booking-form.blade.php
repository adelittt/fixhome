<x-layouts.app title="Formulir Pemesanan - FixHome Plus">
    <div class="w-full flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="max-w-[1280px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg">

            <!-- Back Link -->
            <div class="mb-space-lg flex items-center justify-between">
                <a href="{{ route('customer.technician-detail', $technician->id) }}" class="neu-btn-secondary px-4 py-2 text-xs text-primary gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Detail Teknisi</span>
                </a>
            </div>

            <!-- 2-Column Checkout Form -->
            <form id="booking-form" action="{{ route('booking.store') }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-space-lg items-start">
                @csrf
                <input type="hidden" name="teknisi_id" value="{{ $technician->id }}">

                <!-- Left Column -->
                <div class="lg:col-span-8 space-y-space-lg">

                    <!-- Technician Banner -->
                    <div class="neu-card p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl neu-icon-primary font-extrabold text-xl font-recoleta shrink-0">
                            {{ substr($technician->nama_lengkap, 0, 1) }}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <span class="text-[10px] font-bold text-secondary uppercase tracking-wider block font-lucy-rose">Teknisi Pilihan Anda</span>
                            <h2 class="font-title-md text-primary font-bold font-butler truncate">{{ $technician->nama_lengkap }}</h2>
                            <p class="text-xs text-on-surface-variant">{{ $technician->keahlian }} &bull; ★ {{ number_format($technician->rating, 1) }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="px-3 py-1 rounded-full neu-inset-sm text-xs font-bold text-primary">Rp {{ number_format($technician->tarif_dasar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Keluhan & Quick Chips -->
                    <div class="neu-card p-6 space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Detail Keluhan &amp; Masalah</h3>
                            <span class="text-xs text-outline">Pilih keluhan umum:</span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="setComplaint('AC menetes dan hembusan angin tidak dingin sejak 2 hari lalu.')" class="neu-pill px-3.5 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                ❄️ AC Bocor / Tidak Dingin
                            </button>
                            <button type="button" onclick="setComplaint('Korsleting listrik, saklar utama turun setiap menyalakan peralatan.')" class="neu-pill px-3.5 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                ⚡ Listrik Korslet / MCB Turun
                            </button>
                            <button type="button" onclick="setComplaint('Saluran pipa wastafel / pembuangan mampet air meluap.')" class="neu-pill px-3.5 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                🚿 Pipa / Saluran Mampet
                            </button>
                            <button type="button" onclick="setComplaint('Atap genteng bocor merembes ke plafon kamar saat hujan deras.')" class="neu-pill px-3.5 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                🏠 Atap / Plafon Bocor
                            </button>
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-primary mb-1.5">Deskripsi Masalah / Permintaan Servis</label>
                            <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan" rows="3" required
                                class="neu-input text-xs p-3.5"
                                placeholder="Jelaskan kondisi kerusakan yang terjadi secara jelas..."></textarea>
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-primary mb-1.5">Catatan Tambahan untuk Teknisi (Opsional)</label>
                            <input type="text" name="catatan_perbaikan"
                                class="neu-input text-xs px-4 py-3"
                                placeholder="Contoh: Rumah cat putih pagar hitam, tangga sudah disiapkan di teras">
                        </div>
                    </div>

                    <!-- Add-on Layanan Ekstra -->
                    <div class="neu-card p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Opsi Tambahan (Opsional)</h3>
                            <span class="px-3 py-0.5 rounded-full bg-secondary-container text-primary text-[11px] font-bold">Kalkulasi Otomatis</span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <label class="flex items-center justify-between p-4 rounded-[20px] neu-card-sm cursor-pointer transition-all hover:-translate-y-0.5">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="addon_outdoor" value="1" onchange="toggleAddon(25000, this.checked)" class="w-4 h-4 rounded accent-primary-container">
                                    <div>
                                        <span class="font-bold text-primary block font-butler text-sm">Pembersihan Unit Outdoor &amp; Filter Ekstra</span>
                                        <span class="text-[11px] text-on-surface-variant">Penyemprotan tekanan tinggi pada unit luar</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full neu-inset-sm font-bold text-primary shrink-0">+ Rp 25.000</span>
                            </label>

                            <label class="flex items-center justify-between p-4 rounded-[20px] neu-card-sm cursor-pointer transition-all hover:-translate-y-0.5">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="addon_freon" value="1" onchange="toggleAddon(50000, this.checked)" class="w-4 h-4 rounded accent-primary-container">
                                    <div>
                                        <span class="font-bold text-primary block font-butler text-sm">Pemeriksaan &amp; Pengisian Freon R32 / R410</span>
                                        <span class="text-[11px] text-on-surface-variant">Termasuk pengujian tekanan manifold gauge</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full neu-inset-sm font-bold text-primary shrink-0">+ Rp 50.000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Jadwal Kunjungan -->
                    <div class="neu-card p-6 space-y-4">
                        <h3 class="font-headline-sm text-primary font-bold font-recoleta">Jadwal Kunjungan Teknisi</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-label-md text-label-md text-primary mb-1.5">Pilih Hari / Tanggal</label>
                                <input type="date" name="jadwal_tanggal" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required
                                    class="neu-input text-xs px-4 py-3 font-medium">
                            </div>

                            <div>
                                <label class="block font-label-md text-label-md text-primary mb-1.5">Slot Jam Kedatangan</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(['09:00', '11:00', '13:30', '15:00', '16:30', '19:00'] as $idx => $slot)
                                        <label class="flex items-center justify-center p-2.5 rounded-full cursor-pointer transition-all neu-pill has-[:checked]:bg-primary-container has-[:checked]:text-on-primary text-xs font-bold text-on-surface-variant">
                                            <input type="radio" name="jadwal_jam" value="{{ $slot }}" {{ $idx === 1 ? 'checked' : '' }} class="sr-only">
                                            <span>{{ $slot }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengerjaan & Distance -->
                    <div class="neu-card p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Alamat Pengerjaan &amp; Jarak Rute</h3>
                            <a href="{{ route('customer.set-address') }}" class="text-xs font-bold text-secondary hover:text-primary transition-colors">Ubah Lokasi</a>
                        </div>

                        <div class="flex items-start gap-3 p-4 neu-inset text-xs">
                            <div class="w-9 h-9 rounded-xl neu-icon-teal shrink-0">
                                <span class="material-symbols-outlined text-[19px]">location_on</span>
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-primary block font-butler text-sm">{{ $customer->nama_lengkap }}</span>
                                <p class="text-on-surface-variant text-xs mt-0.5 leading-relaxed">{{ $customer->alamat_lengkap ?? 'Alamat belum diatur' }}</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-[18px] {{ $distance >= 10 ? 'bg-tertiary-fixed/70 text-on-tertiary-fixed' : 'bg-secondary-container/70 text-on-secondary-fixed' }} text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[20px] text-primary">route</span>
                                <div>
                                    <span class="font-bold block text-primary">Estimasi Jarak Tempuh: {{ number_format($distance, 1) }} km</span>
                                    <span class="text-[11px] opacity-85">
                                        {{ $distance >= 10 ? 'Setiap kelipatan 10 km dikenakan Rp 10.000 (total ' . floor($distance / 10) . 'x = Rp ' . number_format($biayaJarak, 0, ',', '.') . ')' : 'Jarak < 10 km: Bebas biaya tambahan jarak (Rp 0)' }}
                                    </span>
                                </div>
                            </div>
                            <span class="font-bold text-xs px-3 py-1 rounded-full bg-surface text-primary shadow-sm shrink-0">
                                {{ $biayaJarak > 0 ? '+ Rp ' . number_format($biayaJarak, 0, ',', '.') : 'Gratis Jarak' }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sticky Summary) -->
                <div class="lg:col-span-4 sticky top-24 space-y-4 mt-6 lg:mt-0">
                    <div class="neu-card-lg p-6 space-y-5">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-secondary-container"></span>
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Rincian Biaya Transparan</h3>
                        </div>

                        <div class="p-4 neu-inset space-y-3 text-xs">
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span>Tarif Dasar Kunjungan</span>
                                <span class="font-bold text-primary">Rp {{ number_format($technician->tarif_dasar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span>Biaya Jarak ({{ number_format($distance, 1) }} km)</span>
                                <span class="font-bold {{ $biayaJarak > 0 ? 'text-tertiary' : 'text-secondary' }}">
                                    {{ $biayaJarak > 0 ? '+ Rp ' . number_format($biayaJarak, 0, ',', '.') : 'Rp 0 (Gratis)' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span>Add-on Tambahan</span>
                                <span id="addon-display" class="font-bold text-secondary">+ Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between text-on-surface-variant">
                                <span>Komisi Platform (5%)</span>
                                <span class="font-semibold text-primary">Termasuk (BR-04)</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between px-1">
                            <span class="font-body-md text-on-surface-variant font-medium">Total Pembayaran</span>
                            <span id="total-display" class="font-headline-md text-primary font-bold font-butler">Rp {{ number_format($technician->tarif_dasar + $biayaJarak, 0, ',', '.') }}</span>
                        </div>

                        <div class="p-3.5 rounded-[18px] bg-surface-container-low text-[11px] text-on-surface-variant leading-relaxed space-y-1">
                            <div class="font-bold text-primary">🔒 Aturan Transparan (KF-07 &amp; KF-10):</div>
                            <div>&bull; 95% diteruskan ke mitra teknisi</div>
                            <div>&bull; 5% biaya operasional &amp; garansi resmi 14 hari</div>
                            <div>&bull; Biaya jarak: Rp 10.000 per kelipatan 10 km (&lt; 10 km Rp 0)</div>
                        </div>

                        <button type="submit" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                            <span>Lanjut ke Pembayaran</span>
                            <span class="material-symbols-outlined text-[19px]">arrow_forward</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const basePrice = {{ $technician->tarif_dasar }};
        const distanceFee = {{ $biayaJarak }};
        let addonTotal = 0;

        function setComplaint(text) {
            document.getElementById('deskripsi_kerusakan').value = text;
        }

        function toggleAddon(amount, isChecked) {
            if (isChecked) {
                addonTotal += amount;
            } else {
                addonTotal -= amount;
            }

            const total = basePrice + distanceFee + addonTotal;
            document.getElementById('addon-display').textContent = `+ Rp ${addonTotal.toLocaleString('id-ID')}`;
            document.getElementById('total-display').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }
    </script>
    @endpush
</x-layouts.app>
