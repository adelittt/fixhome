<x-layouts.app title="Beranda - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pt-space-md sm:pt-space-lg space-y-space-xl">

            <!-- Mobile Only Header Bar -->
            <div class="lg:hidden neu-card-sm px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img alt="FixHome" class="h-9 w-9 object-contain shrink-0" src="{{ asset('images/fixhome-icon.png') }}" />
                    <div>
                        <span class="text-[11px] font-label-sm font-semibold text-on-surface-variant block">Selamat Datang</span>
                        <h2 class="font-title-sm text-primary font-bold font-recoleta leading-tight">Halo, {{ Str::words($customer->nama_lengkap ?? Auth::user()->name, 2, '') }}</h2>
                    </div>
                </div>
                <a href="{{ route('customer.set-address') }}" class="w-10 h-10 rounded-full neu-icon-teal hover:scale-105 transition-transform" title="Ubah Alamat">
                    <span class="material-symbols-outlined text-[20px]">location_on</span>
                </a>
            </div>

            <!-- Active Order Banner (If Any) -->
            @if($activeBooking)
                <div class="rounded-[22px] bg-[#16A34A] text-white p-6 shadow-[0_10px_24px_rgba(22,163,74,0.22)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-tertiary-fixed/15 blur-2xl pointer-events-none"></div>
                    <div class="space-y-1.5 relative z-10">
                        <div class="flex items-center gap-2.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider bg-tertiary-fixed text-on-tertiary-fixed px-3 py-0.5 rounded-full">
                                Pesanan Aktif
                            </span>
                            <span class="text-xs font-semibold text-on-primary-container">
                                Status: {{ ucfirst($activeBooking->status_order) }}
                            </span>
                        </div>
                        <h3 class="font-headline-sm text-on-primary font-bold font-butler">{{ $activeBooking->teknisi->nama_lengkap }} &bull; {{ $activeBooking->teknisi->keahlian }}</h3>
                        <p class="text-xs text-inverse-on-surface/85 truncate max-w-xl">"{{ $activeBooking->deskripsi_kerusakan }}"</p>
                    </div>
                    <a href="{{ route('tracking.chat', $activeBooking->id) }}" class="relative z-10 px-5 py-3 bg-surface text-primary hover:opacity-95 rounded-full text-xs font-bold transition-all inline-flex items-center justify-center gap-2 shadow-md shrink-0">
                        <span class="material-symbols-outlined text-[18px]">map</span>
                        <span>Buka Peta GPS &amp; Chat</span>
                    </a>
                </div>
            @endif

            <!-- Hero Banner Section (Harmonized with Full-Bleed Technician Hero) -->
            <div class="relative overflow-hidden neu-card-lg p-6 sm:p-10 min-h-[260px] flex items-center">
                <div class="absolute inset-0 w-full h-full pointer-events-none">
                    <img alt="Teknisi FixHome" class="w-full h-full object-cover object-right" src="{{ asset('images/fixhome-hero-bg.webp') }}" />
                    <div class="absolute inset-0 fh-hero-veil"></div>
                </div>

                <div class="relative z-10 max-w-xl space-y-3.5">
                    <div class="inline-flex items-center px-3.5 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-sm text-[11.5px] font-semibold">
                        Radius Terdekat &amp; Transparansi 95% / 5%
                    </div>
                    <h1 class="font-headline-lg text-[24px] sm:text-[30px] font-extrabold leading-tight">
                        <span class="text-[#16A34A]">Butuh Teknisi Rumah?</span>
                        <span class="block text-[#111827]">Temukan yang Terdekat dari Rumah Anda.</span>
                    </h1>
                    <p class="font-body-md text-[13.5px] text-[#4B5563] leading-relaxed">
                        Layanan cepat perbaikan AC, instalasi listrik, perbaikan saluran air, hingga atap rumah dengan tarif transparan dan bergaransi 14 hari.
                    </p>

                    <!-- Clean Pill Search Bar -->
                    <form action="{{ route('customer.technicians') }}" method="GET" class="pt-1">
                        <div class="flex items-center gap-2 max-w-lg">
                            <div class="flex-1 bg-white/95 rounded-full border border-[#E5E7EB] shadow-sm flex items-center px-4 py-2.5 focus-within:border-[#16A34A] focus-within:ring-2 focus-within:ring-[#16A34A]/15">
                                <span class="material-symbols-outlined text-[#16A34A] text-[19px] mr-2">search</span>
                                <input type="text" name="search"
                                    class="w-full bg-transparent text-xs sm:text-sm text-[#111827] placeholder:text-[#6B7280] focus:outline-none"
                                    placeholder="Cari nama teknisi, AC, listrik, pipa...">
                            </div>
                            <button type="submit" class="neu-btn-primary px-6 py-2.5 text-xs shrink-0">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Section (Photo-Top Cards Matching Landing Page) -->
            <div class="space-y-4">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-sm font-semibold mb-1.5">
                            Keahlian Terstandar
                        </span>
                        <h2 class="font-headline-md text-[20px] text-[#111827] font-bold">Kategori Layanan Utama</h2>
                        <p class="font-body-sm text-[#4B5563]">Pilih kategori servis spesialis yang Anda perlukan</p>
                    </div>
                    <a href="{{ route('customer.technicians') }}" class="neu-btn-secondary px-4 py-2 text-xs text-[#15803D] shrink-0 gap-1">
                        <span>Lihat Semua</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                @php
                    $categoryPhotos = [
                        'Instalasi Listrik' => 'images/services/listrik.jpg',
                        'AC & Pendingin' => 'images/services/ac-pendingin.jpg',
                        'Pipa & Saluran Air' => 'images/services/pipa-air.jpg',
                        'Atap & Plafon Bocor' => 'images/services/atap-plafon.jpg',
                        'Pengecatan & Tembok' => 'images/services/pengecatan.jpg',
                        'Kunci & Pintu Rusak' => 'images/services/kebersihan.jpg',
                    ];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
                    @foreach($categories as $cat)
                        <a href="{{ route('customer.technicians', ['category' => $cat['tag']]) }}"
                           class="neu-card-sm overflow-hidden hover:-translate-y-1 transition-all flex flex-col group">
                            <div class="w-full h-24 overflow-hidden bg-[#F3F4F6]">
                                <img alt="{{ $cat['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" src="{{ asset($categoryPhotos[$cat['tag']] ?? 'images/services/pipa-air.jpg') }}" />
                            </div>
                            <div class="p-3 text-center">
                                <span class="font-title-sm text-xs font-bold text-[#111827] group-hover:text-[#16A34A] transition-colors leading-snug block">{{ $cat['name'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Nearby Technicians Section -->
            <div class="space-y-5 pt-2">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full neu-pill text-tertiary font-label-sm font-semibold mb-1.5 font-lucy-rose">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            <span>Teknisi Ready &amp; Terverifikasi</span>
                        </div>
                        <h2 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">Teknisi Terdekat (Siap Order)</h2>
                        <p class="font-body-sm text-on-surface-variant">Disaring otomatis berdasarkan radius jarak terdekat dari rumah Anda</p>
                    </div>
                    <a href="{{ route('customer.technicians') }}" class="neu-btn-secondary px-4 py-2 text-xs text-primary shrink-0 gap-1">
                        <span>Semua Teknisi</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
                    @forelse($technicians as $tek)
                        <div class="neu-card p-space-lg hover:-translate-y-1 transition-all flex flex-col justify-between group">
                            <div class="space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-14 h-14 rounded-2xl neu-icon-primary font-extrabold text-xl font-recoleta shrink-0">
                                            {{ substr($tek->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5">
                                                <h4 class="font-title-md text-base font-bold text-primary font-butler">{{ $tek->nama_lengkap }}</h4>
                                                <span class="w-2.5 h-2.5 rounded-full bg-secondary" title="Ready Siap Kerja"></span>
                                            </div>
                                            <span class="inline-block mt-0.5 text-xs font-semibold text-secondary">{{ $tek->keahlian }}</span>

                                            <div class="flex items-center gap-2 mt-1.5 text-xs text-on-surface-variant font-medium">
                                                <span class="text-tertiary font-bold">★ {{ number_format($tek->rating, 1) }}</span>
                                                <span>&bull;</span>
                                                <span class="inline-flex items-center gap-0.5 text-primary font-semibold">
                                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                                    {{ $tek->distance }} km
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <span class="text-[10px] text-outline block font-semibold">Tarif Mulai</span>
                                        <span class="px-2.5 py-1 rounded-full neu-inset-sm text-xs font-bold text-primary inline-block mt-0.5">Rp{{ number_format($tek->tarif_dasar, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-outline-variant/40 flex items-center justify-between gap-3">
                                <a href="{{ route('customer.technician-detail', $tek->id) }}" class="flex-1 py-2.5 neu-btn-secondary text-xs text-primary">
                                    Lihat Profil
                                </a>
                                <a href="{{ route('booking.form', $tek->id) }}" class="flex-1 py-2.5 neu-btn-primary text-xs">
                                    Booking Servis
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 p-10 text-center neu-inset rounded-[26px]">
                            <span class="material-symbols-outlined text-outline text-4xl mb-2">engineering</span>
                            <p class="text-xs text-on-surface-variant">Belum ada mitra teknisi berstatus Ready di radius ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Mobile Bottom Navigation -->
        <nav class="lg:hidden fixed bottom-0 inset-x-0 max-w-md mx-auto bg-surface/95 backdrop-blur-md shadow-[0_-6px_18px_rgba(0,0,0,0.08)] py-2.5 px-6 flex items-center justify-between z-30 rounded-t-3xl">
            <a href="{{ route('customer.home') }}" class="flex flex-col items-center gap-0.5 text-primary-container">
                <span class="material-symbols-outlined text-[22px]">home</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="{{ route('customer.orders') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                <span class="text-[10px] font-medium">Pesanan</span>
            </a>
            <a href="{{ route('customer.technicians') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[22px]">search</span>
                <span class="text-[10px] font-medium">Cari Teknisi</span>
            </a>
            <a href="{{ route('customer.profile') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[22px]">person</span>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </nav>

    </div>
</x-layouts.app>
