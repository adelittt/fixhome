<x-layouts.app title="Beranda - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="w-full max-w-[1280px] mx-auto px-gutter lg:px-margin pt-space-md sm:pt-space-lg space-y-space-xl">

            <!-- Mobile Only Header Bar -->
            <div class="lg:hidden neu-card-sm px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img alt="FixHome Logo" class="h-8 w-8 rounded-lg object-contain mix-blend-multiply" src="{{ asset('images/fixhome-logo.jpg') }}" />
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
                <div class="rounded-[28px] bg-primary-container text-on-primary p-6 shadow-[0_12px_28px_rgba(119,85,55,0.28),-6px_-6px_16px_#FFFFFF] flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden">
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

            <!-- Hero Banner Section (Harmonized with Landing Page) -->
            <div class="relative overflow-hidden neu-card-lg p-6 sm:p-10 min-h-[260px] flex items-center">
                <div class="absolute inset-0 w-full h-full pointer-events-none">
                    <img alt="FixHome Banner" class="w-full h-full object-cover" src="{{ asset('images/fixhome-hero-banner.jpg') }}" />
                    <div class="absolute inset-0 hero-banner-overlay"></div>
                    <div aria-hidden="true" class="hero-shimmer-overlay pointer-events-none"></div>
                </div>

                <div class="relative z-10 max-w-2xl space-y-4">
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-surface/95 backdrop-blur-md shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] text-secondary font-label-sm font-semibold font-lucy-rose">
                        <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                        <span>Radius Terdekat &amp; Transparansi 95% / 5%</span>
                    </div>
                    <h1 class="font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-extrabold font-recoleta leading-tight hero-headline-shadow">
                        Butuh Teknisi Rumah? Temukan yang Terdekat dari Rumah Anda.
                    </h1>
                    <p class="font-body-md text-body-md text-on-surface-variant font-medium leading-relaxed">
                        Layanan cepat perbaikan AC, instalasi listrik, perbaikan saluran air, hingga atap rumah dengan tarif transparan dan bergaransi 14 hari.
                    </p>

                    <!-- Tactile Search Bar -->
                    <form action="{{ route('customer.technicians') }}" method="GET" class="pt-1">
                        <div class="neu-card-sm p-2 rounded-full flex items-center gap-2 max-w-xl">
                            <div class="flex-1 neu-inset rounded-full flex items-center px-4 py-2.5">
                                <span class="material-symbols-outlined text-primary text-[20px] mr-2">search</span>
                                <input type="text" name="search"
                                    class="w-full bg-transparent text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none"
                                    placeholder="Cari nama teknisi, AC, listrik, pipa...">
                            </div>
                            <button type="submit" class="neu-btn-primary px-6 py-2.5 text-xs shrink-0">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="space-y-4">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full neu-pill text-secondary font-label-sm font-semibold mb-1.5 font-lucy-rose">
                            <span>Keahlian Terstandar</span>
                        </div>
                        <h2 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">Kategori Layanan Utama</h2>
                        <p class="font-body-sm text-on-surface-variant">Pilih kategori servis spesialis yang Anda perlukan</p>
                    </div>
                    <a href="{{ route('customer.technicians') }}" class="neu-btn-secondary px-4 py-2 text-xs text-primary shrink-0 gap-1">
                        <span>Lihat Semua</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                @php
                    $materialIcons = [
                        'zap' => 'electric_bolt',
                        'wind' => 'ac_unit',
                        'droplet' => 'plumbing',
                        'home' => 'roofing',
                        'paint-bucket' => 'format_paint',
                        'key' => 'cleaning_services',
                    ];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-space-md">
                    @foreach($categories as $cat)
                        <a href="{{ route('customer.technicians', ['category' => $cat['tag']]) }}"
                           class="neu-card-sm p-4 hover:-translate-y-1 transition-all flex flex-col items-center text-center group">
                            <div class="w-14 h-14 rounded-2xl neu-icon-teal mb-3 group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-[26px]">{{ $materialIcons[$cat['icon']] ?? 'home_repair_service' }}</span>
                            </div>
                            <span class="font-title-sm text-xs font-bold text-primary font-butler leading-snug">{{ $cat['name'] }}</span>
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
                        <p class="font-body-sm text-on-surface-variant">Disaring otomatis berdasarkan radius jarak terdekat dari rumah Anda (BR-02)</p>
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
