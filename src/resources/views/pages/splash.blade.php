<!DOCTYPE html>
<html class="scroll-smooth" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Pesan teknisi perbaikan rumah terverifikasi untuk AC, listrik, pipa, atap, hingga pengecatan. Tarif dasar terbuka, biaya jarak jelas, pelacakan GPS, dan garansi pengerjaan 14 hari." name="description" />
    <meta content="#0F766E" name="theme-color" />
    <link href="{{ asset('images/fixhome-icon.png') }}" rel="icon" type="image/png" />
    <title>FixHome — Layanan Perbaikan Rumah Terverifikasi &amp; Bergaransi</title>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
@php
    $dashboardUrl = Auth::check()
        ? (Auth::user()->role === 'admin'
            ? url('/admin')
            : (Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.home')))
        : route('login');

    $techniciansUrl = Auth::check() && Auth::user()->role === 'customer'
        ? route('customer.technicians')
        : (Auth::check() ? $dashboardUrl : route('login'));

    $services = [
        [
            'title' => 'Perawatan & Cuci AC',
            'category' => 'AC & Pendingin',
            'price' => 'Mulai Rp65.000',
            'desc' => 'Cuci unit indoor & outdoor, tambah freon R32/R410A, atasi AC menetes, dan bongkar pasang.',
            'icon' => 'ac',
        ],
        [
            'title' => 'Perbaikan Pipa & Sanitasi',
            'category' => 'Pipa & Saluran Air',
            'price' => 'Mulai Rp75.000',
            'desc' => 'Atasi pipa bocor, saluran mampet, pemasangan toren air, kloset, dan pompa pendorong.',
            'icon' => 'pipe',
        ],
        [
            'title' => 'Instalasi & Reparasi Listrik',
            'category' => 'Instalasi Listrik',
            'price' => 'Mulai Rp85.000',
            'desc' => 'Penanganan korsleting, tambah titik lampu atau stopkontak, panel MCB, dan grounding.',
            'icon' => 'electric',
        ],
        [
            'title' => 'Pengecatan & Dinding',
            'category' => 'Pengecatan & Tembok',
            'price' => 'Mulai Rp90.000',
            'desc' => 'Cat interior kamar, fasad eksterior, lapisan anti bocor, dan perapian plamir retak.',
            'icon' => 'paint',
        ],
        [
            'title' => 'Perbaikan Atap & Plafon',
            'category' => 'Atap & Plafon Bocor',
            'price' => 'Mulai Rp120.000',
            'desc' => 'Penanganan atap rembes, ganti genteng pecah, perbaikan plafon gypsum, dan talang air.',
            'icon' => 'roof',
        ],
        [
            'title' => 'Kebersihan & Deep Cleaning',
            'category' => null,
            'price' => 'Mulai Rp50.000',
            'desc' => 'Kuras kerak toren air, pembersihan tungau kasur atau sofa, serta bersih pasca renovasi.',
            'icon' => 'clean',
        ],
    ];

    try {
        $featuredTechnicians = \App\Models\Teknisi::ready()->orderByDesc('rating')->take(3)->get();
    } catch (\Throwable $e) {
        $featuredTechnicians = collect();
    }
@endphp
<body class="fh-clean bg-[#F8FAFC] text-[#1F2937] antialiased min-h-screen flex flex-col" id="top">

    <a class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:rounded-lg focus:bg-[#164E63] focus:text-white focus:text-sm focus:font-semibold" href="#konten-utama">
        Lewati ke konten utama
    </a>

    <!-- NAVBAR: Minimalist, crisp white surface with subtle slate border -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-[#E2E8F0]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-6">
            <!-- Brand Logo -->
            <a aria-label="Beranda FixHome" class="inline-flex items-center gap-2.5 shrink-0" href="#top">
                <span class="w-9 h-9 rounded-lg bg-[#0F766E] text-white inline-flex items-center justify-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 10.5 12 3l9 7.5" />
                        <path d="M5 9.5V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5" />
                        <path d="M14.7 13.3a2.5 2.5 0 0 1-3.4 3.4l-2.3 2.3" />
                        <circle cx="13.5" cy="14.5" r="1" />
                    </svg>
                </span>
                <span class="text-lg font-bold tracking-tight text-[#164E63]">
                    FixHome<span class="text-[#0F766E]">+</span>
                </span>
            </a>

            <!-- Center Navigation -->
            <nav aria-label="Navigasi utama" class="hidden md:flex items-center gap-7">
                <a class="fh-nav-link text-sm font-medium text-[#0F766E]" href="#top">Beranda</a>
                <a class="fh-nav-link text-sm font-medium text-[#64748B] hover:text-[#1F2937] transition-colors" href="#layanan">Layanan</a>
                <a class="fh-nav-link text-sm font-medium text-[#64748B] hover:text-[#1F2937] transition-colors" href="#cara-kerja">Cara Kerja</a>
                <a class="fh-nav-link text-sm font-medium text-[#64748B] hover:text-[#1F2937] transition-colors" href="#keunggulan">Keunggulan</a>
                <a class="fh-nav-link text-sm font-medium text-[#64748B] hover:text-[#1F2937] transition-colors" href="#tentang-kami">Tentang Kami</a>
            </nav>

            <!-- Right Auth Actions -->
            <div class="flex items-center gap-2.5">
                @auth
                    <a class="inline-flex items-center justify-center h-9 px-4 rounded-lg bg-[#0F766E] hover:bg-[#115E59] text-white text-sm font-semibold transition-colors" href="{{ $dashboardUrl }}">
                        Dashboard
                    </a>
                    <a aria-label="Profil {{ Auth::user()->name }}" class="hidden sm:inline-flex items-center justify-center w-9 h-9 rounded-lg bg-[#164E63] text-white text-xs font-semibold" href="{{ $dashboardUrl }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </a>
                @else
                    <a class="hidden sm:inline-flex items-center justify-center h-9 px-4 rounded-lg bg-white border border-[#E2E8F0] hover:border-[#CBD5E1] hover:bg-[#F8FAFC] text-sm font-semibold text-[#1F2937] transition-colors" href="{{ route('login') }}">
                        Masuk
                    </a>
                    <a class="inline-flex items-center justify-center h-9 px-4 rounded-lg bg-[#0F766E] hover:bg-[#115E59] text-white text-sm font-semibold transition-colors" href="{{ route('register') }}">
                        Daftar
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                    aria-label="Buka menu navigasi"
                    class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-[#E2E8F0] bg-white text-[#1F2937]"
                    id="mobile-menu-toggle"
                    type="button"
                >
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" id="mobile-menu-svg-open" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="4" x2="20" y1="6" y2="6" />
                        <line x1="4" x2="20" y1="12" y2="12" />
                        <line x1="4" x2="20" y1="18" y2="18" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div class="hidden md:hidden bg-white border-t border-[#E2E8F0]" id="mobile-menu">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1">
                <a class="px-3 py-2.5 rounded-lg text-sm font-medium text-[#1F2937] hover:bg-[#F8FAFC]" href="#top">Beranda</a>
                <a class="px-3 py-2.5 rounded-lg text-sm font-medium text-[#1F2937] hover:bg-[#F8FAFC]" href="#layanan">Layanan</a>
                <a class="px-3 py-2.5 rounded-lg text-sm font-medium text-[#1F2937] hover:bg-[#F8FAFC]" href="#cara-kerja">Cara Kerja</a>
                <a class="px-3 py-2.5 rounded-lg text-sm font-medium text-[#1F2937] hover:bg-[#F8FAFC]" href="#keunggulan">Keunggulan</a>
                <a class="px-3 py-2.5 rounded-lg text-sm font-medium text-[#1F2937] hover:bg-[#F8FAFC]" href="#tentang-kami">Tentang Kami</a>
                <div class="pt-3 mt-2 border-t border-[#E2E8F0] grid grid-cols-2 gap-2.5">
                    @auth
                        <a class="col-span-2 inline-flex items-center justify-center h-10 rounded-lg bg-[#0F766E] text-white text-sm font-semibold" href="{{ $dashboardUrl }}">Buka Dashboard</a>
                    @else
                        <a class="inline-flex items-center justify-center h-10 rounded-lg bg-white border border-[#E2E8F0] text-sm font-semibold text-[#1F2937]" href="{{ route('login') }}">Masuk</a>
                        <a class="inline-flex items-center justify-center h-10 rounded-lg bg-[#0F766E] text-white text-sm font-semibold" href="{{ route('register') }}">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full" id="konten-utama">

        <!-- 1. HERO SECTION: Two-column editorial layout, white background, zero blobs/floating cards -->
        <section class="w-full bg-white border-b border-[#E2E8F0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                    <!-- Left Column: Copy, Clean Search Form & Verifiable Trust Indicators -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="space-y-4">
                            <h1 class="text-3xl sm:text-4xl lg:text-[46px] font-bold tracking-tight text-[#164E63] leading-[1.14]">
                                Perbaikan Rumah, Jadi Lebih Mudah.
                            </h1>
                            <p class="text-base sm:text-[17px] text-[#64748B] leading-relaxed max-w-xl">
                                Pesan teknisi terverifikasi untuk AC, listrik, pipa, atap, hingga pengecatan. Tarif dasar terbuka, biaya jarak jelas, dan dilindungi garansi pengerjaan 14 hari.
                            </p>
                        </div>

                        <!-- Clean Category Search Form (Preserves existing customer.technicians route) -->
                        <form action="{{ route('customer.technicians') }}" class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 sm:p-4 space-y-3" method="GET">
                            <label class="block text-xs font-semibold text-[#1F2937]" for="hero-category">
                                Pilih kategori perbaikan
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2.5">
                                <div class="relative flex-1">
                                    <select
                                        class="w-full h-11 pl-3.5 pr-10 rounded-lg bg-white border border-[#E2E8F0] text-sm font-medium text-[#1F2937] focus:outline-none focus:border-[#0F766E] focus:ring-2 focus:ring-[#0F766E]/15 appearance-none cursor-pointer"
                                        id="hero-category"
                                        name="category"
                                    >
                                        <option value="">Semua kategori layanan</option>
                                        @foreach ($services as $svc)
                                            @if ($svc['category'])
                                                <option value="{{ $svc['category'] }}">{{ $svc['title'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <svg aria-hidden="true" class="w-4 h-4 text-[#64748B] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </div>
                                <button
                                    class="h-11 px-6 rounded-lg bg-[#0F766E] hover:bg-[#115E59] text-white text-sm font-semibold inline-flex items-center justify-center gap-2 transition-colors shrink-0"
                                    type="submit"
                                >
                                    <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <span>Cari Teknisi</span>
                                </button>
                            </div>
                        </form>

                        <!-- Verifiable Trust Indicators (No fabricated numbers) -->
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2.5 pt-1 text-sm text-[#64748B]">
                            <span class="inline-flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-[#DCFCE7] text-[#16A34A] inline-flex items-center justify-center shrink-0">
                                    <svg aria-hidden="true" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                </span>
                                <span class="font-medium text-[#1F2937]">Teknisi Terverifikasi</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                <svg aria-hidden="true" class="w-4 h-4 text-[#0F766E] shrink-0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                                <span>Garansi 14 Hari</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                <svg aria-hidden="true" class="w-4 h-4 text-[#0F766E] shrink-0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                                <span>Biaya jarak Rp0 (&lt; 10 km)</span>
                            </span>
                        </div>
                    </div>

                    <!-- Right Column: Natural, realistic home-service technician photo (no overlays or floating cards) -->
                    <div class="lg:col-span-6">
                        <div class="rounded-2xl overflow-hidden border border-[#E2E8F0] bg-[#F8FAFC]">
                            <img
                                alt="Teknisi perbaikan rumah FixHome siap membantu dengan peralatan lengkap"
                                class="w-full aspect-[4/3] object-cover object-top block"
                                loading="eager"
                                src="{{ asset('images/fixhome-hero-technician.jpg') }}"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. SERVICE CATEGORIES -->
        <section class="w-full bg-[#F8FAFC] py-16 lg:py-20 border-b border-[#E2E8F0] scroll-mt-16" id="layanan">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                    <div class="max-w-2xl">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#164E63]">
                            Layanan untuk Kebutuhan Rumah Anda
                        </h2>
                        <p class="mt-2 text-sm sm:text-base text-[#64748B]">
                            Pilih jenis pekerjaan yang dibutuhkan dan bandingkan tarif dasar teknisi di sekitar lokasi Anda.
                        </p>
                    </div>
                    <a class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#0F766E] hover:text-[#115E59] shrink-0" href="{{ $techniciansUrl }}">
                        <span>Lihat semua teknisi</span>
                        <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($services as $svc)
                        <a
                            class="group bg-white border border-[#E2E8F0] hover:border-[#0F766E]/50 rounded-xl p-6 flex flex-col justify-between transition-colors"
                            href="{{ route('customer.technicians', array_filter(['category' => $svc['category']])) }}"
                        >
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <span class="w-10 h-10 rounded-lg bg-[#CCFBF1]/70 text-[#0F766E] inline-flex items-center justify-center shrink-0">
                                        @if ($svc['icon'] === 'ac')
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                                                <path d="M2 12h20" /><path d="M12 2v20" /><path d="m20 16-4-4 4-4" /><path d="m4 8 4 4-4 4" /><path d="m16 4-4 4-4-4" /><path d="m8 20 4-4 4 4" />
                                            </svg>
                                        @elseif ($svc['icon'] === 'pipe')
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                            </svg>
                                        @elseif ($svc['icon'] === 'electric')
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                                            </svg>
                                        @elseif ($svc['icon'] === 'paint')
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                                                <rect height="6" rx="1" width="16" x="2" y="2" /><path d="M10 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" /><rect height="6" rx="1" width="4" x="8" y="16" />
                                            </svg>
                                        @elseif ($svc['icon'] === 'roof')
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /><polyline points="9 22 9 12 15 12 15 22" />
                                            </svg>
                                        @else
                                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" viewBox="0 0 24 24">
                                                <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="text-xs font-semibold text-[#164E63] tabular-nums">
                                        {{ $svc['price'] }}
                                    </span>
                                </div>
                                <h3 class="text-base font-semibold text-[#1F2937] group-hover:text-[#0F766E] transition-colors">
                                    {{ $svc['title'] }}
                                </h3>
                                <p class="mt-1.5 text-sm text-[#64748B] leading-relaxed">
                                    {{ $svc['desc'] }}
                                </p>
                            </div>
                            <div class="mt-5 pt-4 border-t border-[#F1F5F9] flex items-center justify-between text-sm font-medium text-[#0F766E]">
                                <span>Cari teknisi</span>
                                <svg aria-hidden="true" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M5 12h14" /><path d="m12 5 7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if ($featuredTechnicians->isNotEmpty())
                    <!-- Real Ready Technicians from Database (No fabricated numbers) -->
                    <div class="mt-14 pt-12 border-t border-[#E2E8F0]">
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-[#164E63]">Teknisi Siap Menerima Pesanan</h3>
                                <p class="text-sm text-[#64748B] mt-1">Teknisi aktif yang tersedia di sistem FixHome saat ini.</p>
                            </div>
                            <a class="text-sm font-semibold text-[#0F766E] hover:text-[#115E59]" href="{{ $techniciansUrl }}">Lihat daftar lengkap</a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            @foreach ($featuredTechnicians as $tech)
                                @php
                                    $skills = array_values(array_filter(array_map('trim', explode(',', (string) $tech->keahlian))));
                                    $initials = collect(explode(' ', (string) $tech->nama_lengkap))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
                                @endphp
                                <div class="bg-white border border-[#E2E8F0] rounded-xl p-5 flex flex-col justify-between gap-4">
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <span class="w-10 h-10 rounded-lg bg-[#164E63] text-white text-sm font-semibold inline-flex items-center justify-center shrink-0">
                                                    {{ $initials ?: 'T' }}
                                                </span>
                                                <div class="min-w-0">
                                                    <h4 class="text-sm font-semibold text-[#1F2937] truncate">{{ $tech->nama_lengkap }}</h4>
                                                    @if ((float) $tech->rating > 0)
                                                        <div class="inline-flex items-center gap-1 text-xs text-[#64748B] mt-0.5">
                                                            <svg aria-hidden="true" class="w-3.5 h-3.5 text-[#F59E0B] fill-[#F59E0B]" viewBox="0 0 24 24">
                                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                            </svg>
                                                            <span class="font-semibold text-[#1F2937]">{{ number_format((float) $tech->rating, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-[#DCFCE7] text-[#16A34A] text-xs font-semibold shrink-0">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                                                Terverifikasi
                                            </span>
                                        </div>

                                        <p class="text-xs text-[#64748B] line-clamp-2">
                                            {{ implode(' · ', array_slice($skills ?: ['Teknisi Umum'], 0, 3)) }}
                                        </p>
                                    </div>

                                    <div class="pt-3 border-t border-[#F1F5F9] flex items-center justify-between gap-3">
                                        <div>
                                            <span class="block text-[11px] text-[#64748B]">Tarif dasar</span>
                                            <span class="text-sm font-bold text-[#1F2937] tabular-nums">Rp{{ number_format((float) ($tech->tarif_dasar ?: 50000), 0, ',', '.') }}</span>
                                        </div>
                                        <a class="inline-flex items-center justify-center h-9 px-4 rounded-lg bg-[#0F766E] hover:bg-[#115E59] text-white text-xs font-semibold transition-colors" href="{{ Auth::check() && Auth::user()->role === 'customer' ? route('customer.technician-detail', $tech->id) : route('login') }}">
                                            Pesan
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- 3. HOW IT WORKS: Clean 3-step horizontal flow without heavy cards -->
        <section class="w-full bg-white py-16 lg:py-20 border-b border-[#E2E8F0] scroll-mt-16" id="cara-kerja">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#164E63]">
                        Cara Kerja FixHome
                    </h2>
                    <p class="mt-2 text-sm sm:text-base text-[#64748B]">
                        Alur pemesanan ringkas dari pemilihan layanan hingga pekerjaan selesai dan bergaransi.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    <div class="space-y-3 border-t-2 border-[#0F766E] pt-5">
                        <span class="text-xs font-bold tracking-wider text-[#0F766E]">LANGKAH 01</span>
                        <h3 class="text-lg font-semibold text-[#1F2937]">Pilih layanan</h3>
                        <p class="text-sm text-[#64748B] leading-relaxed">
                            Pilih kategori perbaikan dan temukan teknisi terverifikasi terdekat lengkap dengan estimasi tarif dasarnya.
                        </p>
                    </div>

                    <div class="space-y-3 border-t-2 border-[#E2E8F0] pt-5">
                        <span class="text-xs font-bold tracking-wider text-[#0F766E]">LANGKAH 02</span>
                        <h3 class="text-lg font-semibold text-[#1F2937]">Atur jadwal &amp; bayar</h3>
                        <p class="text-sm text-[#64748B] leading-relaxed">
                            Tentukan hari serta jam kunjungan, lalu selesaikan pembayaran QRIS dengan rincian biaya yang transparan.
                        </p>
                    </div>

                    <div class="space-y-3 border-t-2 border-[#E2E8F0] pt-5">
                        <span class="text-xs font-bold tracking-wider text-[#0F766E]">LANGKAH 03</span>
                        <h3 class="text-lg font-semibold text-[#1F2937]">Teknisi datang &amp; selesai</h3>
                        <p class="text-sm text-[#64748B] leading-relaxed">
                            Pantau kedatangan teknisi lewat pelacakan GPS, koordinasi via live chat, dan nikmati garansi pengerjaan 14 hari.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. WHY FIXHOME: Asymmetric 2-column layout (NOT another card grid) -->
        <section class="w-full bg-white py-16 lg:py-20 border-b border-[#E2E8F0] scroll-mt-16" id="keunggulan">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Left Column: Positioning + Concrete Cost Rules Table -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="space-y-3">
                            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#164E63]">
                                Kenapa Memilih FixHome?
                            </h2>
                            <p class="text-sm sm:text-base text-[#64748B] leading-relaxed">
                                Setiap pemesanan dirancang agar pemilik rumah dan teknisi sama-sama mendapatkan kepastian biaya, jadwal, dan kualitas pengerjaan.
                            </p>
                        </div>

                        <!-- Structured Transparency Box -->
                        <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-5 space-y-3.5">
                            <h3 class="text-sm font-semibold text-[#164E63]">Ringkasan Ketentuan Layanan</h3>
                            <dl class="divide-y divide-[#E2E8F0] text-sm">
                                <div class="py-2.5 flex items-center justify-between gap-4">
                                    <dt class="text-[#64748B]">Biaya jarak (&lt; 10 km)</dt>
                                    <dd class="font-semibold text-[#16A34A]">Rp0 (Gratis)</dd>
                                </div>
                                <div class="py-2.5 flex items-center justify-between gap-4">
                                    <dt class="text-[#64748B]">Biaya jarak (&ge; 10 km)</dt>
                                    <dd class="font-semibold text-[#1F2937]">Flat Rp10.000</dd>
                                </div>
                                <div class="py-2.5 flex items-center justify-between gap-4">
                                    <dt class="text-[#64748B]">Garansi pengerjaan</dt>
                                    <dd class="font-semibold text-[#1F2937]">14 hari resmi</dd>
                                </div>
                                <div class="pt-2.5 flex items-center justify-between gap-4">
                                    <dt class="text-[#64748B]">Komisi platform</dt>
                                    <dd class="font-semibold text-[#1F2937]">5% (95% hak teknisi)</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Right Column: Clean 2-column feature list with subtle dividers -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-8">
                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-lg bg-[#DCFCE7] text-[#16A34A] inline-flex items-center justify-center shrink-0 mt-0.5">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" /><path d="m9 12 2 2 4-4" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#1F2937]">Teknisi Terverifikasi</h3>
                                <p class="mt-1 text-sm text-[#64748B] leading-relaxed">Identitas dan keahlian teknisi diperiksa tim admin sebelum dapat menerima pesanan.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-lg bg-[#CCFBF1]/70 text-[#0F766E] inline-flex items-center justify-center shrink-0 mt-0.5">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z" /><path d="M8 7h8" /><path d="M8 11h8" /><path d="M8 15h5" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#1F2937]">Transparansi Biaya</h3>
                                <p class="mt-1 text-sm text-[#64748B] leading-relaxed">Tarif dasar, biaya jarak, dan pembagian 95% / 5% ditampilkan jelas sebelum Anda membayar.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-lg bg-[#DBEAFE] text-[#2563EB] inline-flex items-center justify-center shrink-0 mt-0.5">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <polygon points="3 11 22 2 13 21 11 13 3 11" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#1F2937]">Pelacakan Pesanan &amp; GPS</h3>
                                <p class="mt-1 text-sm text-[#64748B] leading-relaxed">Pantau status pesanan dan lokasi teknisi secara real-time saat menuju rumah Anda.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-lg bg-[#CCFBF1]/70 text-[#0F766E] inline-flex items-center justify-center shrink-0 mt-0.5">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#1F2937]">Live Chat Langsung</h3>
                                <p class="mt-1 text-sm text-[#64748B] leading-relaxed">Diskusikan keluhan dan konfirmasi jadwal langsung dengan teknisi di dalam aplikasi.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-lg bg-[#CCFBF1]/70 text-[#0F766E] inline-flex items-center justify-center shrink-0 mt-0.5">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <rect height="5" rx="1" width="5" x="3" y="3" /><rect height="5" rx="1" width="5" x="16" y="3" /><rect height="5" rx="1" width="5" x="3" y="16" /><path d="M21 16h-3a2 2 0 0 0-2 2v3" /><path d="M21 21v.01" /><path d="M12 7v3a2 2 0 0 1-2 2H7" /><path d="M3 12h.01" /><path d="M12 3h.01" /><path d="M12 16v.01" /><path d="M16 12h1" /><path d="M21 12v.01" /><path d="M12 21v-1" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#1F2937]">Pembayaran QRIS Terverifikasi</h3>
                                <p class="mt-1 text-sm text-[#64748B] leading-relaxed">Pembayaran diproses melalui Midtrans dengan tenggat 2 jam dan verifikasi status otomatis.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-lg bg-[#DCFCE7] text-[#16A34A] inline-flex items-center justify-center shrink-0 mt-0.5">
                                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="8" r="6" /><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#1F2937]">Garansi Pengerjaan 14 Hari</h3>
                                <p class="mt-1 text-sm text-[#64748B] leading-relaxed">Setiap pekerjaan yang diselesaikan melalui FixHome dilindungi garansi resmi selama 14 hari.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. ABOUT US: Quiet, honest editorial section -->
        <section class="w-full bg-[#F8FAFC] py-16 lg:py-20 border-b border-[#E2E8F0] scroll-mt-16" id="tentang-kami">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                    <div class="lg:col-span-5">
                        <span class="text-xs font-semibold uppercase tracking-wider text-[#0F766E]">Tentang Kami</span>
                        <h2 class="mt-2 text-2xl sm:text-3xl font-bold tracking-tight text-[#164E63]">
                            Menghubungkan Pemilik Rumah dengan Teknisi Andal
                        </h2>
                    </div>
                    <div class="lg:col-span-7 space-y-4 text-sm sm:text-base text-[#64748B] leading-relaxed">
                        <p>
                            FixHome dibangun untuk menyelesaikan masalah sehari-hari saat merawat rumah: sulitnya mencari teknisi yang terpercaya, biaya yang sering tidak pasti, dan tidak adanya jaminan setelah pekerjaan selesai.
                        </p>
                        <p>
                            Melalui sistem pemesanan berbasis lokasi di wilayah operasional Jabodetabek, kami memastikan pemilik rumah memperoleh estimasi biaya yang terbuka sejak awal, sekaligus memberi ruang kerja yang adil bagi teknisi lokal dengan skema bagi hasil 95% untuk teknisi dan 5% untuk operasional platform.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. CTA SECTION: Solid Dark Navy surface, single standout Deep Teal primary CTA -->
        <section class="w-full bg-white py-16 lg:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-[#164E63] rounded-2xl px-6 py-10 sm:px-10 sm:py-12 lg:px-14 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                    <div class="max-w-xl space-y-2.5">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                            Ada yang Perlu Diperbaiki di Rumah?
                        </h2>
                        <p class="text-sm sm:text-base text-[#CBD5E1] leading-relaxed">
                            Temukan teknisi terverifikasi terdekat atau bergabung sebagai mitra teknisi FixHome.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                        <a class="inline-flex items-center justify-center h-11 px-6 rounded-lg bg-[#0F766E] hover:bg-[#115E59] text-white text-sm font-semibold transition-colors" href="{{ $techniciansUrl }}">
                            Cari Teknisi
                        </a>
                        <a class="inline-flex items-center justify-center h-11 px-6 rounded-lg bg-transparent border border-white/30 hover:bg-white/10 text-white text-sm font-semibold transition-colors" href="{{ route('register', ['role' => 'teknisi']) }}">
                            Daftar Jadi Teknisi
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER: Clean Dark Navy -->
    <footer class="w-full bg-[#164E63] text-[#CBD5E1] border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-14">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 pb-10 border-b border-white/10">
                <div class="space-y-3">
                    <a class="inline-flex items-center gap-2.5" href="#top">
                        <span class="w-8 h-8 rounded-lg bg-[#0F766E] text-white inline-flex items-center justify-center">
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 10.5 12 3l9 7.5" />
                                <path d="M5 9.5V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5" />
                            </svg>
                        </span>
                        <span class="text-base font-bold tracking-tight text-white">FixHome<span class="text-[#CCFBF1]">+</span></span>
                    </a>
                    <p class="text-sm text-[#94A3B8] leading-relaxed">
                        Platform pemesanan jasa perbaikan rumah terverifikasi dengan biaya terbuka dan garansi pengerjaan 14 hari.
                    </p>
                </div>

                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-white">Pelanggan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a class="hover:text-white transition-colors" href="{{ $techniciansUrl }}">Cari Teknisi</a></li>
                        <li><a class="hover:text-white transition-colors" href="#layanan">Kategori Layanan</a></li>
                        <li><a class="hover:text-white transition-colors" href="#cara-kerja">Cara Pemesanan</a></li>
                        <li><a class="hover:text-white transition-colors" href="#keunggulan">Garansi 14 Hari</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-white">Teknisi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a class="hover:text-white transition-colors" href="{{ route('register', ['role' => 'teknisi']) }}">Daftar Jadi Teknisi</a></li>
                        <li><a class="hover:text-white transition-colors" href="#keunggulan">Skema Bagi Hasil 95% / 5%</a></li>
                        <li><a class="hover:text-white transition-colors" href="{{ route('login') }}">Masuk ke Dashboard</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-white">Bantuan &amp; Informasi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a class="hover:text-white transition-colors" href="#tentang-kami">Tentang Kami</a></li>
                        <li><a class="hover:text-white transition-colors" href="#cara-kerja">Live Chat di Aplikasi</a></li>
                        <li class="text-[#94A3B8]">Wilayah operasional: Jabodetabek</li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-[#94A3B8]">
                <p>&copy; {{ date('Y') }} FixHome Indonesia. Hak cipta dilindungi.</p>
                <p>Teknisi Terverifikasi &middot; Garansi Resmi 14 Hari</p>
            </div>
        </div>
    </footer>
</body>
</html>
