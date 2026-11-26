<x-layouts.app title="{{ $technician->nama_lengkap }} - Detail Teknisi">
    <div class="w-full flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="max-w-[1140px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg">

            <!-- Back Navigation -->
            <div class="mb-space-lg flex items-center justify-between">
                <a href="{{ route('customer.technicians') }}" class="neu-btn-secondary px-4 py-2 text-xs text-primary gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Daftar Teknisi</span>
                </a>
            </div>

            <!-- 2-Column Layout -->
            <div class="lg:grid lg:grid-cols-12 lg:gap-space-lg items-start">

                <!-- Left Column -->
                <div class="lg:col-span-8 space-y-space-lg">

                    <!-- Profile Card -->
                    <div class="neu-card p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
                        <div class="relative shrink-0">
                            <img
                                alt="{{ $technician->nama_lengkap }}"
                                class="w-24 h-24 rounded-3xl object-cover border-2 border-white shadow-md"
                                src="{{ $technician->foto_url }}"
                            />
                            <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-secondary-container border-2 border-surface flex items-center justify-center shadow text-primary" title="Ready Siap Kerja">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </span>
                        </div>

                        <div class="flex-1 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div class="flex items-center gap-2 justify-center sm:justify-start flex-wrap">
                                    <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">{{ $technician->nama_lengkap }}</h1>
                                    <span class="inline-flex items-center gap-1 px-3 py-0.5 bg-secondary-container text-primary rounded-full text-[11px] font-bold" title="Identitas KTP & Kompetensi Terverifikasi Admin">
                                        <span class="material-symbols-outlined text-[14px] text-tertiary">verified</span>
                                        <span>Terverifikasi</span>
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-3.5 py-1 neu-inset-sm text-xs font-bold text-primary">
                                    {{ $technician->keahlian }}
                                </span>
                            </div>

                            @if($technician->sertifikasi)
                                <div class="text-xs text-on-surface-variant neu-inset p-3 flex items-center gap-2 justify-center sm:justify-start">
                                    <span class="material-symbols-outlined text-tertiary text-[18px] shrink-0">workspace_premium</span>
                                    <span><strong class="text-primary">Sertifikasi:</strong> {{ $technician->sertifikasi }}</span>
                                </div>
                            @endif

                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 text-xs text-on-surface-variant">
                                <span class="flex items-center gap-1 font-bold text-tertiary">
                                    ★ {{ number_format($technician->rating, 1) }}
                                </span>
                                <span>&bull;</span>
                                <span class="font-medium">({{ $technician->ulasans->count() }} ulasan kepuasan)</span>
                                <span>&bull;</span>
                                <span class="font-bold {{ ($technician->distance ?? 0) >= 10 ? 'text-tertiary' : 'text-secondary' }}">
                                    📍 {{ number_format($technician->distance ?? 1.2, 1) }} km dari lokasi Anda
                                    ({{ ($technician->biaya_jarak ?? 0) > 0 ? '+Rp ' . number_format($technician->biaya_jarak, 0, ',', '.') . ' (kelipatan 10km)' : 'Bebas biaya jarak' }})
                                </span>
                            </div>

                            <!-- 3 Metric Boxes -->
                            <div class="grid grid-cols-3 gap-3 pt-2">
                                <div class="p-3 neu-card-sm flex flex-col items-center">
                                    <span class="font-title-sm font-bold text-primary font-butler">5+ Tahun</span>
                                    <span class="text-[10px] text-on-surface-variant mt-0.5">Pengalaman</span>
                                </div>
                                <div class="p-3 neu-card-sm flex flex-col items-center">
                                    <span class="font-title-sm font-bold text-secondary font-butler">140+ Servis</span>
                                    <span class="text-[10px] text-on-surface-variant mt-0.5">Pengerjaan</span>
                                </div>
                                <div class="p-3 neu-card-sm flex flex-col items-center">
                                    <span class="font-title-sm font-bold text-tertiary font-butler">100%</span>
                                    <span class="text-[10px] text-on-surface-variant mt-0.5">Kepuasan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Portfolio Section -->
                    <div class="neu-card p-6 sm:p-8 space-y-4">
                        <h3 class="font-headline-sm text-primary font-bold font-recoleta">Dokumentasi Portofolio Pengerjaan</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="p-5 rounded-[22px] neu-icon-teal flex flex-col items-center text-center gap-1.5">
                                <span class="material-symbols-outlined text-[28px] text-primary">ac_unit</span>
                                <span class="font-title-sm text-xs font-bold text-primary font-butler">Servis &amp; Cuci AC</span>
                                <span class="text-[11px] text-on-secondary-container">Hasil Bersih &amp; Dingin</span>
                            </div>
                            <div class="p-5 rounded-[22px] neu-icon-gold flex flex-col items-center text-center gap-1.5">
                                <span class="material-symbols-outlined text-[28px] text-primary">electric_bolt</span>
                                <span class="font-title-sm text-xs font-bold text-primary font-butler">Isi Freon &amp; Cek Arus</span>
                                <span class="text-[11px] text-on-tertiary-fixed-variant">Tekanan Terukur</span>
                            </div>
                            <div class="p-5 rounded-[22px] neu-inset flex flex-col items-center text-center gap-1.5">
                                <span class="material-symbols-outlined text-[28px] text-primary">build</span>
                                <span class="font-title-sm text-xs font-bold text-primary font-butler">Ganti Kapasitor</span>
                                <span class="text-[11px] text-on-surface-variant">Sparepart Original</span>
                            </div>
                        </div>
                    </div>

                    <!-- About Technician Section -->
                    <div class="neu-card p-6 sm:p-8 space-y-3">
                        <h3 class="font-headline-sm text-primary font-bold font-recoleta">Tentang Teknisi</h3>
                        <p class="font-body-md text-on-surface-variant leading-relaxed">
                            Mitra teknisi terverifikasi platform FixHome dengan spesialisasi <strong class="text-primary">{{ $technician->keahlian }}</strong>. Menyediakan pemeriksaan komprehensif dan pengerjaan rapi standar SNI. Peralatan servis lengkap dan siap dipanggil sesuai jadwal.
                        </p>
                        <div class="flex flex-wrap items-center gap-2 pt-2 text-xs">
                            <span class="neu-pill px-3.5 py-1.5 text-primary font-semibold">✓ Peralatan Lengkap</span>
                            <span class="neu-pill px-3.5 py-1.5 text-primary font-semibold">✓ Protokol Rapi &amp; Bersih</span>
                        </div>
                    </div>

                    <!-- Customer Reviews -->
                    <div class="neu-card p-6 sm:p-8 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Ulasan Pelanggan</h3>
                            <span class="px-3 py-1 rounded-full neu-inset-sm text-xs font-bold text-tertiary">★ {{ number_format($technician->rating, 1) }} / 5.0</span>
                        </div>

                        <div class="space-y-3">
                            @forelse($technician->ulasans->take(3) as $review)
                                <div class="p-4 neu-inset text-xs space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-primary font-butler">{{ $review->customer->nama_lengkap ?? 'Pelanggan' }}</span>
                                        <span class="text-tertiary font-bold">★ {{ $review->rating }}</span>
                                    </div>
                                    <p class="text-on-surface-variant">{{ $review->komentar ?? 'Pengerjaan sangat rapi dan tepat waktu!' }}</p>
                                </div>
                            @empty
                                <div class="p-4 neu-inset text-xs text-on-surface-variant">
                                    "Teknisi sangat profesional, datang tepat waktu dan pekerjaan langsung tuntas rapi!"
                                    <span class="block text-[10px] text-outline mt-1">- Budi R., Kebayoran Baru</span>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Right Sticky Booking Card -->
                <div class="lg:col-span-4 sticky top-24 space-y-4 mt-6 lg:mt-0">
                    <div class="neu-card-lg p-6 space-y-5">
                        <div class="space-y-3 text-xs">
                            <div>
                                <span class="text-[11px] font-label-sm uppercase tracking-wider text-on-surface-variant block font-semibold">Estimasi Tarif Kunjungan</span>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="font-headline-lg text-2xl font-bold text-primary font-butler">Rp {{ number_format($technician->tarif_dasar, 0, ',', '.') }}</span>
                                    <span class="text-xs text-outline font-medium">/ kunjungan</span>
                                </div>
                            </div>

                            <div class="p-4 neu-inset space-y-2.5">
                                <div class="flex items-center justify-between text-on-surface-variant">
                                    <span>Jarak ke Rumah:</span>
                                    <span class="font-bold text-primary">{{ number_format($technician->distance ?? 1.2, 1) }} km</span>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant">
                                    <span>Biaya Tambahan Jarak:</span>
                                    <span class="font-bold {{ ($technician->biaya_jarak ?? 0) > 0 ? 'text-tertiary' : 'text-secondary' }}">
                                        {{ ($technician->biaya_jarak ?? 0) > 0 ? '+ Rp ' . number_format($technician->biaya_jarak, 0, ',', '.') : 'Rp 0 (Radius < 10 km)' }}
                                    </span>
                                </div>
                                <div class="pt-2.5 border-t border-outline-variant/40 flex items-center justify-between font-bold text-primary">
                                    <span>Estimasi Awal:</span>
                                    <span class="text-base font-butler">Rp {{ number_format($technician->tarif_dasar + ($technician->biaya_jarak ?? 0), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 rounded-[18px] bg-secondary-container/60 text-xs text-on-secondary-fixed space-y-1.5 shadow-[inset_2px_2px_5px_#B2CED0,inset_-2px_-2px_5px_#E6FAFC]">
                            <span class="font-bold block text-primary">Keuntungan Pesan di FixHome:</span>
                            <p class="text-[11px] leading-relaxed">
                                &bull; Pelacakan GPS teknisi langsung<br>
                                &bull; Chat langsung setelah pembayaran<br>
                                &bull; Skema transparan: 95% teknisi, 5% platform
                            </p>
                        </div>

                        @if($isOutOfRange ?? false)
                            <div class="p-4 rounded-[18px] bg-error-container text-xs text-on-error-container space-y-1">
                                <span class="font-bold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px]">warning</span>
                                    <span>Di Luar Jangkauan Layanan (&gt; 35 km)</span>
                                </span>
                                <p class="text-[11px] leading-relaxed">
                                    Jarak lokasi Anda ({{ number_format($technician->distance, 1) }} km) melebihi batas jangkauan operasional maksimal (35 km).
                                </p>
                            </div>

                            <button disabled class="w-full py-3.5 px-6 rounded-full bg-surface-container-highest text-outline font-bold cursor-not-allowed text-xs">
                                Di Luar Jangkauan (Maks 35 km)
                            </button>
                        @else
                            <a href="{{ route('booking.form', $technician->id) }}" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                                <span>Pesan Sekarang / Booking</span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
