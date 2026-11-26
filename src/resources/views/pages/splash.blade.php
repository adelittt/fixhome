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
                    <!-- Two-Tone Display Headline -->
                    <h1 class="fh-hero-anim font-headline-xl text-[30px] sm:text-[40px] lg:text-[44px] leading-[1.14] font-extrabold tracking-[-0.03em]" data-hero-step="1">
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
                        <span class="inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-[#16A34A]">verified_user</span>
                            Estimasi Biaya Jelas
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. LAYANAN PERBAIKAN RUMAH TERPOPULER (Photo-Top Editorial Cards) -->
        <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl" data-reveal>
            <div class="text-center max-w-2xl mx-auto mb-8">
                <h2 class="font-headline-lg text-[26px] sm:text-[32px] leading-[1.18] font-extrabold tracking-[-0.02em]">
                    <span class="block text-[#16A34A]">Layanan Perbaikan Rumah</span>
                    <span class="block text-[#111827]">Terpopuler</span>
                </h2>
                <p class="font-body-md text-[13.5px] text-[#4B5563] mt-2">
                    Pilih layanan yang Anda butuhkan, dikerjakan oleh tukang berpengalaman bersertifikasi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($services as $svc)
                    <a
                        class="fh-page-link stitch-surface-card group cursor-pointer rounded-[20px] overflow-hidden bg-white hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full"
                        href="{{ route('public.layanan', ['kategori' => $svc['slug']]) }}"
                    >
                        <div>
                            <div class="relative w-full h-40 overflow-hidden bg-[#F3F4F6]">
                                <img
                                    alt="{{ $svc['title'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                    src="{{ asset($svc['image']) }}"
                                />
                            </div>
                            <div class="p-4 sm:p-5 pb-3">
                                <h3 class="font-title-md text-[15.5px] text-[#111827] font-bold">
                                    {{ $svc['title'] }}
                                </h3>
                                <p class="font-body-md text-[12.5px] leading-[1.55] text-[#4B5563] mt-1.5">
                                    {{ $svc['desc'] }}
                                </p>
                            </div>
                        </div>
                        <div class="px-4 sm:px-5 pb-4 pt-1 flex items-center justify-between">
                            <span class="text-[13px] text-[#16A34A] font-bold">{{ $svc['price'] }}</span>
                            <span class="w-8 h-8 rounded-full bg-[#F0FDF4] text-[#16A34A] group-hover:bg-[#16A34A] group-hover:text-white flex items-center justify-center transition-colors duration-200">
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-7 text-center">
                <a class="fh-page-link inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-white border border-[#E5E7EB] hover:border-[#16A34A] text-[13px] font-semibold text-[#15803D] shadow-sm transition-all" href="{{ route('public.layanan') }}">
                    <span>Lihat Detail Semua Layanan</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </section>

        <!-- 3. CUPLIKAN TEKNISI SIAP KERJA -->
        <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl" data-reveal>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-lg">
                <div>
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
                                        <img
                                            alt="{{ $tech->nama_lengkap }}"
                                            class="w-12 h-12 rounded-xl object-cover border border-[#E5E7EB] shrink-0"
                                            loading="lazy"
                                            src="{{ $tech->foto_url }}"
                                        />
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
