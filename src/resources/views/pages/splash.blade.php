@php
    $services = \App\Http\Controllers\PublicPageController::serviceCatalog();
    try {
        $featuredTechnicians = \App\Models\Teknisi::ready()->orderByDesc('rating')->take(3)->get();
    } catch (\Throwable $e) {
        $featuredTechnicians = collect();
    }
    $dashboardUrl = Auth::check()
        ? (Auth::user()->role === 'admin'
            ? url('/admin')
            : (Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.home')))
        : route('login');
@endphp

<x-layouts.public activeNav="beranda">
    <div class="flex flex-col w-full bg-surface text-on-surface relative overflow-x-clip">
        <!-- 1. FULL-BLEED PHOTOGRAPHIC HERO SECTION -->
        <section class="relative w-full min-h-[580px] sm:min-h-[640px] lg:min-h-[680px] lg:h-[92vh] lg:max-h-[820px] flex items-center overflow-hidden scroll-mt-0" id="beranda">
            <!-- Full-Bleed Technician Background -->
            <img
                alt="Teknisi FixHome sedang melakukan perbaikan rumah"
                class="fh-hero-bg absolute inset-0 w-full h-full object-cover object-[74%_center] sm:object-right select-none pointer-events-none"
                fetchpriority="high"
                loading="eager"
                src="{{ asset('images/fixhome-hero-bg.webp') }}"
            />
            <!-- Airy Left-to-Right Luminous White Veil -->
            <div aria-hidden="true" class="fh-hero-veil absolute inset-0 pointer-events-none"></div>
            <!-- Soft Seamless Bottom Fade to White Canvas -->
            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-white via-white/45 to-transparent pointer-events-none"></div>

            <!-- Hero Foreground Content -->
            <div class="relative z-10 w-full max-w-[1140px] mx-auto px-5 sm:px-8 pt-24 sm:pt-28 pb-14">
                <div class="max-w-[540px] flex flex-col items-start">
                    <!-- Pill Eyebrow -->
                    <div class="fh-hero-anim inline-flex items-center px-3.5 py-1 rounded-full bg-[#DCFCE7]/95 text-[#15803D] font-label-md text-[12px] font-semibold tracking-tight" data-hero-step="1">
                        Solusi Perbaikan Rumah Anda
                    </div>

                    <!-- Two-Tone Display Headline -->
                    <h1 class="fh-hero-anim font-headline-xl text-[30px] sm:text-[40px] lg:text-[44px] leading-[1.14] font-extrabold tracking-[-0.03em] mt-4" data-hero-step="2">
                        <span class="block text-[#16A34A]">Perbaikan Rumah Tuntas,</span>
                        <span class="block text-[#111827]">Material Tepat Tanpa Ribet</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="fh-hero-anim font-body-lg text-[14.5px] sm:text-[15.5px] leading-[1.6] text-[#4B5563] mt-3.5 max-w-[470px]" data-hero-step="3">
                        Pesan teknisi terverifikasi, pilih material berkualitas, dan nikmati perbaikan rumah dengan lebih mudah.
                    </p>

                    <!-- Inline Pill Category Search Bar -->
                    <form action="{{ route('customer.technicians') }}" class="fh-hero-anim mt-6 w-full flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5" data-hero-step="4" method="GET">
                        <div class="relative flex-1 flex items-center bg-white/95 backdrop-blur-sm rounded-full px-4 py-2.5 border border-[#E5E7EB]/90 shadow-[0_6px_22px_rgba(17,24,39,0.07)] focus-within:border-[#16A34A] focus-within:ring-2 focus-within:ring-[#16A34A]/15 transition-all">
                            <span class="material-symbols-outlined text-[#16A34A] text-[20px] mr-2.5 shrink-0">home</span>
                            <select
                                aria-label="Pilih Kategori Jasa"
                                class="w-full bg-transparent border-0 focus:ring-0 font-body-md text-[13.5px] text-[#374151] focus:outline-none appearance-none cursor-pointer pr-6 py-0.5"
                                name="category"
                            >
                                <option value="">Pilih Kategori Jasa</option>
                                @foreach ($services as $svc)
                                    @if ($svc['category'])
                                        <option value="{{ $svc['category'] }}">{{ $svc['title'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3.5 text-[#6B7280] text-[18px] pointer-events-none">expand_more</span>
                        </div>

                        <button
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white font-label-lg text-[13.5px] font-semibold shadow-[0_8px_20px_rgba(22,163,74,0.28)] hover:shadow-[0_10px_24px_rgba(22,163,74,0.34)] active:scale-[0.97] transition-all shrink-0"
                            type="submit"
                        >
                            <span class="material-symbols-outlined text-[18px]">search</span>
                            <span>Cari Teknisi</span>
                        </button>
                    </form>

                    <!-- Minimalist Trust Row -->
                    <div class="fh-hero-anim mt-5 flex flex-wrap items-center gap-y-2 text-[#374151] font-label-md text-[12px] font-medium" data-hero-step="5">
                        <span class="inline-flex items-center gap-1.5 pr-3 sm:pr-4">
                            <span class="material-symbols-outlined text-[16px] text-[#16A34A]">verified_user</span>
                            Estimasi Biaya Jelas
                        </span>
                        <span aria-hidden="true" class="hidden sm:inline-block h-3.5 w-px bg-[#D1D5DB]"></span>
                        <span class="inline-flex items-center gap-1.5 px-0 sm:px-4 pr-3">
                            <span class="material-symbols-outlined text-[16px] text-[#16A34A]">shield</span>
                            Garansi 14 Hari
                        </span>
                        <span aria-hidden="true" class="hidden sm:inline-block h-3.5 w-px bg-[#D1D5DB]"></span>
                        <span class="inline-flex items-center gap-1.5 sm:pl-4">
                            <span class="material-symbols-outlined text-[16px] text-[#16A34A]">groups</span>
                            1.200+ Teknisi Siap
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. RINGKASAN LAYANAN POPULER -->
        <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl" data-reveal>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-lg">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[#15803D] text-[11.5px] font-semibold mb-2">
                        Keahlian Lengkap &amp; Terstandar
                    </span>
                    <h2 class="font-headline-lg text-[24px] font-bold text-[#111827]">
                        Layanan Perbaikan Rumah Terpopuler
                    </h2>
                    <p class="font-body-md text-[13.5px] text-[#4B5563] mt-1">
                        Pilih layanan untuk melihat rincian pekerjaan, durasi, dan estimasi tarif dasar.
                    </p>
                </div>
                <a class="fh-page-link inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white border border-[#E5E7EB] hover:border-[#16A34A] text-[13px] font-semibold text-[#15803D] self-start md:self-auto transition-all" href="{{ route('public.layanan') }}">
                    <span>Lihat Detail Semua Layanan</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
                @foreach ($services as $svc)
                    <a
                        class="fh-page-link stitch-surface-card group cursor-pointer rounded-[20px] p-5 bg-white hover:-translate-y-1 transition-all flex flex-col justify-between h-full"
                        href="{{ route('public.layanan', ['kategori' => $svc['slug']]) }}"
                    >
                        <div>
                            <div class="flex items-center justify-between mb-3.5">
                                <div class="w-11 h-11 rounded-xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-[22px]">{{ $svc['icon'] }}</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-[#F8FAFC] border border-[#E5E7EB] text-[11px] font-semibold text-[#15803D]">
                                    {{ $svc['price'] }}
                                </span>
                            </div>
                            <h3 class="font-title-md text-[15.5px] text-[#111827] font-bold mb-1">
                                {{ $svc['title'] }}
                            </h3>
                            <p class="font-body-md text-[13px] text-[#4B5563]">
                                {{ $svc['desc'] }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-[#E5E7EB]/60 flex items-center justify-between">
                            <span class="text-[11.5px] text-[#15803D] font-semibold">{{ $svc['count'] }}</span>
                            <span class="inline-flex items-center gap-1 text-[12px] font-semibold text-[#111827] group-hover:text-[#16A34A] transition-colors">
                                Detail <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 3. CUPLIKAN TEKNISI SIAP KERJA -->
        <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl" data-reveal>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-lg">
                <div>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[#15803D] text-[11.5px] font-semibold mb-2">
                        <span class="material-symbols-outlined text-[14px]">engineering</span>
                        Katalog Teknisi Terverifikasi
                    </span>
                    <h2 class="font-headline-lg text-[24px] font-bold text-[#111827]">
                        Teknisi Siap Meluncur Hari Ini
                    </h2>
                </div>
                <a class="fh-page-link inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white border border-[#E5E7EB] hover:border-[#16A34A] text-[13px] font-semibold text-[#15803D] self-start md:self-auto transition-all" href="{{ route('public.teknisi') }}">
                    <span>Lihat Semua Teknisi</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            @if ($featuredTechnicians->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                    @foreach ($featuredTechnicians as $tech)
                        @php
                            $skills = array_values(array_filter(array_map('trim', explode(',', (string) $tech->keahlian))));
                            $initials = collect(explode(' ', (string) $tech->nama_lengkap))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
                        @endphp
                        <div class="stitch-surface-card rounded-[20px] p-5 bg-white flex flex-col justify-between gap-4 hover:-translate-y-1 transition-all">
                            <div>
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-11 h-11 rounded-xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center font-bold text-[15px] shrink-0">
                                            {{ $initials ?: 'T' }}
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="text-[15px] font-bold text-[#111827] truncate">{{ $tech->nama_lengkap }}</h3>
                                            <span class="inline-flex items-center gap-1 text-[11.5px] text-[#4B5563]">
                                                <span class="material-symbols-outlined text-[14px] text-[#FACC15]" style="font-variation-settings: 'FILL' 1;">star</span>
                                                {{ number_format((float) ($tech->rating ?: 4.9), 1) }} &middot; Terverifikasi
                                            </span>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#F0FDF4] text-[11px] font-semibold text-[#15803D] shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span> Siap
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach (array_slice($skills ?: ['Teknisi Umum'], 0, 3) as $skill)
                                        <span class="px-2.5 py-0.5 rounded-full bg-[#F8FAFC] border border-[#E5E7EB] text-[11px] text-[#374151]">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="pt-3 border-t border-[#E5E7EB]/60 flex items-center justify-between">
                                <div>
                                    <span class="block text-[10.5px] text-[#6B7280]">Tarif dasar</span>
                                    <span class="text-[15px] font-extrabold text-[#111827]">Rp{{ number_format((float) ($tech->tarif_dasar ?: 50000), 0, ',', '.') }}</span>
                                </div>
                                <a class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[12px] font-semibold transition-all" href="{{ Auth::check() && Auth::user()->role === 'customer' ? route('customer.technician-detail', $tech->id) : route('login') }}">
                                    Pesan <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- 4. PARTNERSHIP CALLOUT -->
        <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pt-4 pb-8" data-reveal>
            <div class="stitch-surface-card rounded-[24px] p-6 sm:p-8 bg-white flex flex-col md:flex-row items-center justify-between gap-5">
                <div class="max-w-xl text-center md:text-left">
                    <h2 class="font-headline-md text-[20px] text-[#111827] font-bold">
                        Punya Keahlian Pertukangan? Gabung Jadi Mitra FixHome
                    </h2>
                    <p class="font-body-md text-[13.5px] text-[#4B5563] mt-1">
                        Jangkau ribuan pemilik rumah di sekitar Anda dengan komisi transparan hanya 5% dan jadwal kerja fleksibel.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-2.5 w-full md:w-auto shrink-0">
                    <a class="fh-page-link w-full sm:w-auto text-center px-5 py-2.5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13px] font-semibold shadow-sm active:scale-95 transition-all" href="{{ route('public.jadi-mitra') }}">
                        Pelajari Kemitraan
                    </a>
                    <a class="fh-page-link w-full sm:w-auto text-center px-5 py-2.5 rounded-full bg-white border border-[#D1D5DB] hover:border-[#16A34A] text-[#111827] text-[13px] font-semibold active:scale-95 transition-all" href="{{ route('public.cara-kerja') }}">
                        Simulasi Biaya
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.public>
