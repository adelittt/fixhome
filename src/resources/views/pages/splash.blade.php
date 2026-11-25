<!DOCTYPE html>
<html class="scroll-smooth bg-surface" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Pesan teknisi perbaikan rumah terverifikasi untuk AC, listrik, pipa, atap, hingga pengecatan. Biaya jelas, live chat, dan garansi resmi 14 hari." name="description" />
    <meta content="#16A34A" name="theme-color" />
    <link href="{{ asset('images/fixhome-icon.png') }}" rel="icon" type="image/png" />
    <title>FixHome - Layanan Perbaikan Rumah Terverifikasi &amp; Bergaransi</title>

    <!-- Fonts: Plus Jakarta Sans (Headings) + Inter (Body & UI) + Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />

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
            'title' => 'Perbaikan Pipa & Saluran Air',
            'category' => 'Pipa & Saluran Air',
            'icon' => 'plumbing',
            'price' => 'Mulai Rp75.000',
            'count' => '320+ Teknisi Siap',
            'desc' => 'Solusi tuntas pipa bocor, saluran mampet, instalasi toren, kloset, dan pompa booster otomatis.',
        ],
        [
            'title' => 'Instalasi Listrik',
            'category' => 'Instalasi Listrik',
            'icon' => 'electric_bolt',
            'price' => 'Mulai Rp85.000',
            'count' => '240+ Teknisi Siap',
            'desc' => 'Penanganan korsleting, pasang titik lampu baru, perapian panel MCB, dan grounding bersertifikasi.',
        ],
        [
            'title' => 'Perawatan AC & Pendingin',
            'category' => 'AC & Pendingin',
            'icon' => 'ac_unit',
            'price' => 'Mulai Rp65.000',
            'count' => '190+ Teknisi Siap',
            'desc' => 'Cuci unit indoor & outdoor, isi freon R32/R410A, perbaikan bocor air, dan pemindahan posisi AC.',
        ],
        [
            'title' => 'Perbaikan Atap & Plafon',
            'category' => 'Atap & Plafon Bocor',
            'icon' => 'roofing',
            'price' => 'Mulai Rp120.000',
            'count' => '180+ Teknisi Siap',
            'desc' => 'Pencegahan atap rembes bocor, ganti genteng retak, tambal plafon gypsum berjamur, & talang air.',
        ],
        [
            'title' => 'Pengecatan Rumah',
            'category' => 'Pengecatan & Tembok',
            'icon' => 'format_paint',
            'price' => 'Mulai Rp90.000',
            'count' => '210+ Teknisi Siap',
            'desc' => 'Pengecatan interior kamar, dinding eksterior fasad cuaca tropis, waterproofing, dan perbaikan plamir retak.',
        ],
        [
            'title' => 'Kebersihan & Deep Cleaning',
            'category' => null,
            'icon' => 'cleaning_services',
            'price' => 'Mulai Rp50.000',
            'count' => '150+ Teknisi Siap',
            'desc' => 'Pembersihan kerak toren air, sedot tungau kasur/sofa hidro-alergi, dan pembersihan menyeluruh pasca renovasi.',
        ],
    ];

    // Katalog teknisi siap kerja (read-only showcase, aman bila DB belum siap)
    try {
        $featuredTechnicians = \App\Models\Teknisi::ready()->orderByDesc('rating')->take(3)->get();
    } catch (\Throwable $e) {
        $featuredTechnicians = collect();
    }
@endphp
<body class="fh-plus bg-surface font-body-md text-on-surface antialiased min-h-screen flex flex-col overscroll-none" id="top">

    <div class="flex-1 flex flex-col pb-16 sm:pb-0">
        <!-- FLOATING PILL HEADER NAVIGATION (Dynamic Island Morph on Scroll) -->
        <header class="fh-header-anim fixed top-3 sm:top-4 left-0 right-0 z-50 px-3 sm:px-6 pointer-events-none" id="site-header">
            <div class="fh-header-pill pointer-events-auto h-14 max-w-[1140px] mx-auto px-4 sm:px-5 rounded-full bg-white/95 backdrop-blur-md border border-white/80 shadow-[0_6px_28px_rgba(17,24,39,0.08)] flex items-center justify-between gap-4 overflow-hidden" id="header-pill-bar">
                <!-- Brand Logo + Compact Active Indicator -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <a aria-label="Beranda FixHome" class="flex items-center shrink-0 group active:scale-[0.98] transition-transform" href="#beranda" data-nav-target="beranda">
                        <img alt="FixHome" class="fh-header-logo h-7 sm:h-[30px] w-auto object-contain group-hover:opacity-90 transition-all duration-300" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </a>
                    <span class="fh-compact-badge hidden md:inline-flex items-center gap-1.5 pl-2.5 border-l border-[#E5E7EB] text-[12px] font-semibold text-[#15803D] whitespace-nowrap" id="header-compact-badge">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] animate-pulse"></span>
                        <span id="header-compact-label">Beranda</span>
                    </span>
                </div>

                <!-- Center Navigation Links -->
                <nav aria-label="Navigasi utama" class="fh-header-collapsible hidden md:flex items-center gap-0.5 lg:gap-1 relative" id="desktop-nav">
                    <span aria-hidden="true" class="fh-nav-pill pointer-events-none absolute top-0 bottom-0 left-0 rounded-full bg-[#DCFCE7] z-0 opacity-0" id="nav-active-pill"></span>
                    <a class="fh-nav-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 text-[#15803D] font-semibold whitespace-nowrap" data-nav-target="beranda" href="#beranda" aria-current="page">Beranda</a>
                    <a class="fh-nav-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 text-[#4B5563] hover:text-[#111827] whitespace-nowrap" data-nav-target="layanan-populer" href="#layanan-populer">Layanan</a>
                    <a class="fh-nav-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 text-[#4B5563] hover:text-[#111827] whitespace-nowrap" data-nav-target="katalog-teknisi" href="#katalog-teknisi">Teknisi</a>
                    <a class="fh-nav-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 text-[#4B5563] hover:text-[#111827] whitespace-nowrap" data-nav-target="cara-kerja" href="#cara-kerja">Cara Kerja</a>
                    @guest
                        <a class="fh-nav-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 text-[#4B5563] hover:text-[#111827] whitespace-nowrap" data-nav-target="jadi-mitra" href="#jadi-mitra">Jadi Mitra</a>
                    @endguest
                    <a class="fh-nav-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 text-[#4B5563] hover:text-[#111827] whitespace-nowrap" data-nav-target="tentang-kami" href="#tentang-kami">Tentang Kami</a>
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a class="relative z-10 font-label-md text-label-md text-[#15803D] bg-[#F0FDF4] border border-[#BBF7D0] rounded-full px-3 py-1 hover:bg-[#DCFCE7] active:scale-95 transition-all whitespace-nowrap" href="{{ url('/admin') }}">Panel Admin</a>
                        @endif
                    @endauth
                </nav>

                <!-- Right Controls (Masuk & Daftar only) -->
                <div class="fh-header-collapsible flex items-center gap-2 shrink-0">
                    <div class="hidden sm:flex items-center gap-2">
                        @auth
                            <a class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-white border border-[#E5E7EB] shadow-sm text-xs font-semibold text-[#111827] hover:border-[#16A34A] active:scale-95 transition-all whitespace-nowrap" href="{{ $dashboardUrl }}">
                                <span class="w-6 h-6 rounded-full bg-[#16A34A] text-white flex items-center justify-center text-[11px] font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <span class="material-symbols-outlined text-[16px] text-[#4B5563]">dashboard</span>
                            </a>
                        @else
                            <a class="inline-flex items-center justify-center font-label-lg text-[13px] text-[#15803D] bg-white border border-[#E5E7EB] rounded-full px-4 py-1.5 hover:bg-[#F0FDF4] hover:border-[#16A34A] active:scale-95 transition-all whitespace-nowrap" href="{{ route('login') }}">
                                Masuk
                            </a>
                            <a class="inline-flex items-center justify-center font-label-lg text-[13px] text-white bg-[#16A34A] hover:bg-[#15803D] rounded-full px-4 py-1.5 shadow-[0_3px_10px_rgba(22,163,74,0.24)] active:scale-95 transition-all whitespace-nowrap" href="{{ route('register') }}">
                                Daftar
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile & Tablet Menu Trigger -->
                    <button
                        aria-controls="mobile-menu"
                        aria-expanded="false"
                        aria-label="Buka menu navigasi"
                        class="md:hidden w-9 h-9 rounded-full bg-white border border-[#E5E7EB] hover:border-[#16A34A] flex items-center justify-center text-[#111827] active:scale-95 transition-all"
                        id="mobile-menu-toggle"
                        type="button"
                    >
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px]" id="mobile-menu-icon">menu</span>
                    </button>
                </div>
            </div>

            <!-- Mobile & Tablet Dropdown Menu -->
            <div class="pointer-events-auto hidden md:hidden mt-2 max-w-[1140px] mx-auto rounded-2xl bg-white/95 backdrop-blur-md border border-[#E5E7EB] px-4 pt-3 pb-4 space-y-1.5 shadow-xl" id="mobile-menu">
                <a class="fh-nav-link block px-4 py-2.5 rounded-xl text-sm font-semibold transition-all active:scale-[0.99] bg-[#DCFCE7] text-[#15803D]" data-nav-target="beranda" href="#beranda" aria-current="page">Beranda</a>
                <a class="fh-nav-link block px-4 py-2.5 rounded-xl text-sm font-medium transition-all active:scale-[0.99] text-[#4B5563] hover:bg-[#F3F4F6] hover:text-[#111827]" data-nav-target="layanan-populer" href="#layanan-populer">Layanan</a>
                <a class="fh-nav-link block px-4 py-2.5 rounded-xl text-sm font-medium transition-all active:scale-[0.99] text-[#4B5563] hover:bg-[#F3F4F6] hover:text-[#111827]" data-nav-target="katalog-teknisi" href="#katalog-teknisi">Teknisi</a>
                <a class="fh-nav-link block px-4 py-2.5 rounded-xl text-sm font-medium transition-all active:scale-[0.99] text-[#4B5563] hover:bg-[#F3F4F6] hover:text-[#111827]" data-nav-target="cara-kerja" href="#cara-kerja">Cara Kerja</a>
                @guest
                    <a class="fh-nav-link block px-4 py-2.5 rounded-xl text-sm font-medium transition-all active:scale-[0.99] text-[#4B5563] hover:bg-[#F3F4F6] hover:text-[#111827]" data-nav-target="jadi-mitra" href="#jadi-mitra">Jadi Mitra</a>
                @endguest
                <a class="fh-nav-link block px-4 py-2.5 rounded-xl text-sm font-medium transition-all active:scale-[0.99] text-[#4B5563] hover:bg-[#F3F4F6] hover:text-[#111827]" data-nav-target="tentang-kami" href="#tentang-kami">Tentang Kami</a>
                @auth
                    <div class="pt-2">
                        <a class="block px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-[#16A34A] hover:bg-[#15803D] text-center active:scale-[0.98] transition-all" href="{{ $dashboardUrl }}">Buka Dashboard</a>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-2 pt-2 sm:hidden">
                        <a class="block px-4 py-2.5 rounded-full text-sm font-semibold text-[#15803D] bg-white border border-[#E5E7EB] text-center hover:bg-[#F0FDF4] active:scale-[0.98] transition-all" href="{{ route('login') }}">Masuk</a>
                        <a class="block px-4 py-2.5 rounded-full text-sm font-semibold text-white bg-[#16A34A] hover:bg-[#15803D] text-center active:scale-[0.98] transition-all" href="{{ route('register') }}">Daftar</a>
                    </div>
                @endauth
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 w-full bg-surface" id="konten-utama">
            <div class="flex flex-col w-full bg-surface text-on-surface min-h-screen relative overflow-x-clip">
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

                <!-- 2. SERVICE CATEGORIES SECTION -->
                <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-24" data-reveal id="layanan-populer">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-lg">
                        <div>
                            <div class="stitch-surface-card inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] text-secondary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                                <span>Keahlian Lengkap &amp; Terstandar</span>
                            </div>
                            <h2 class="font-headline-lg-mobile sm:font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">
                                Layanan Perbaikan Rumah Terpopuler
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                Pilih layanan yang Anda butuhkan, dikerjakan oleh tukang berpengalaman bersertifikasi.
                            </p>
                        </div>
                        <div class="flex items-center gap-space-sm self-start md:self-auto">
                            <a aria-label="Kembali ke atas" class="stitch-surface-card w-10 h-10 rounded-full bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] active:shadow-[inset_3px_3px_6px_#D2D2D2,inset_-3px_-3px_6px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="#beranda">
                                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                            </a>
                            <a aria-label="Lihat Katalog Teknisi" class="stitch-surface-card w-10 h-10 rounded-full bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] active:shadow-[inset_3px_3px_6px_#D2D2D2,inset_-3px_-3px_6px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="#katalog-teknisi">
                                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                            </a>
                        </div>
                    </div>

                    <!-- 6-Grid Tactile Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
                        @foreach ($services as $svc)
                            <a
                                class="stitch-surface-card service-card-item group cursor-pointer rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] hover:-translate-y-1 transition-all flex flex-col justify-between h-full"
                                href="{{ route('customer.technicians', array_filter(['category' => $svc['category']])) }}"
                            >
                                <div>
                                    <div class="flex items-center justify-between mb-space-md">
                                        <div class="w-11 h-11 rounded-xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC] group-hover:scale-105 transition-transform">
                                            <span class="material-symbols-outlined text-primary text-[22px]">{{ $svc['icon'] }}</span>
                                        </div>
                                        <span class="stitch-surface-inset px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                            {{ $svc['price'] }}
                                        </span>
                                    </div>
                                    <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">
                                        {{ $svc['title'] }}
                                    </h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant">
                                        {{ $svc['desc'] }}
                                    </p>
                                </div>
                                <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                                    <span class="font-label-sm text-label-sm text-secondary font-semibold">
                                        {{ $svc['count'] }}
                                    </span>
                                    <span class="stitch-surface-card w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <!-- 2B. KATALOG TEKNISI -->
                <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-24" data-reveal id="katalog-teknisi">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mb-space-lg">
                        <div>
                            <div class="stitch-surface-card inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] text-primary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                                <span class="material-symbols-outlined text-[15px]">engineering</span>
                                <span>Katalog Teknisi Terverifikasi</span>
                            </div>
                            <h2 class="font-headline-lg-mobile sm:font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">
                                Daftar Teknisi Siap Kerja
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                Pilih teknisi harian bersertifikasi, negosiasikan pekerjaan lewat live chat, dan pantau jadwal pengerjaan.
                            </p>
                        </div>

                        <!-- Tactile Filter Chips -->
                        <div class="flex items-center gap-space-xs overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
                            <a class="px-space-md py-1.5 rounded-full font-label-md text-label-md whitespace-nowrap transition-all bg-primary-container text-on-primary shadow-[inset_2px_2px_5px_rgba(0,0,0,0.32),0_4px_12px_rgba(119,85,55,0.22)] font-bold" href="{{ route('customer.technicians') }}">Semua</a>
                            @foreach ($services as $svc)
                                @if ($svc['category'])
                                    <a class="stitch-surface-card px-space-md py-1.5 rounded-full font-label-md text-label-md whitespace-nowrap transition-all bg-surface text-on-surface-variant shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] hover:text-primary" href="{{ route('customer.technicians', ['category' => $svc['category']]) }}">{{ $svc['category'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if ($featuredTechnicians->isEmpty())
                        <div class="stitch-surface-card rounded-[20px] p-space-xl bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-secondary-container flex items-center justify-center mb-space-md">
                                <span class="material-symbols-outlined text-primary text-[22px]">engineering</span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold font-butler">Teknisi Sedang Disiapkan</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1 mb-space-md">
                                Masuk ke akun Anda untuk melihat teknisi terdekat yang siap menerima pesanan.
                            </p>
                            <a class="inline-flex items-center gap-1.5 px-space-lg py-space-sm rounded-full bg-primary-container text-on-primary font-label-md text-label-md shadow-[0_6px_14px_rgba(119,85,55,0.25)] hover:opacity-95 transition" href="{{ $techniciansUrl }}">
                                <span class="material-symbols-outlined text-[16px]">search</span>
                                <span>Cari Teknisi Terdekat</span>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
                            @foreach ($featuredTechnicians as $tech)
                                @php
                                    $skills = array_values(array_filter(array_map('trim', explode(',', (string) $tech->keahlian))));
                                    $initials = collect(explode(' ', (string) $tech->nama_lengkap))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
                                @endphp
                                <div class="stitch-surface-card rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] flex flex-col justify-between gap-space-md transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8]">
                                    <div>
                                        <div class="flex items-start justify-between gap-space-sm mb-space-md">
                                            <div class="flex items-center gap-space-sm min-w-0">
                                                <div class="w-11 h-11 rounded-xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC] font-headline-sm text-headline-sm text-primary font-bold shrink-0">
                                                    {{ $initials ?: 'T' }}
                                                </div>
                                                <div class="min-w-0">
                                                    <h3 class="font-title-md text-title-md text-primary font-bold font-butler truncate">{{ $tech->nama_lengkap }}</h3>
                                                    <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant">
                                                        <span class="material-symbols-outlined text-[15px] text-tertiary" style="font-variation-settings: 'FILL' 1;">star</span>
                                                        {{ number_format((float) ($tech->rating ?: 4.9), 1) }} &middot; Terverifikasi
                                                    </span>
                                                </div>
                                            </div>
                                            <span class="stitch-surface-inset inline-flex items-center gap-1 px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-secondary shrink-0">
                                                <span class="w-2 h-2 rounded-full bg-[#3FAE6D]"></span> Siap
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-space-xs">
                                            @foreach (array_slice($skills ?: ['Teknisi Umum'], 0, 3) as $skill)
                                                <span class="px-space-sm py-1 rounded-full bg-secondary-container/60 font-label-sm text-label-sm text-primary">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-space-sm">
                                        <div>
                                            <span class="block font-label-sm text-label-sm text-on-surface-variant">Tarif dasar</span>
                                            <span class="font-headline-sm text-headline-sm text-primary font-bold">Rp{{ number_format((float) ($tech->tarif_dasar ?: 50000), 0, ',', '.') }}</span>
                                        </div>
                                        <a class="inline-flex items-center gap-1.5 px-space-lg py-space-sm rounded-full bg-primary-container text-on-primary font-label-md text-label-md shadow-[0_6px_14px_rgba(119,85,55,0.25)] hover:opacity-95 transition" href="{{ Auth::check() && Auth::user()->role === 'customer' ? route('customer.technician-detail', $tech->id) : route('login') }}">
                                            <span>Pesan</span>
                                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- 3. KEY FEATURE HIGHLIGHT SECTION (CARA KERJA & TRANSPARANSI BIAYA) -->
                <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-24" data-reveal id="cara-kerja">
                    <div class="stitch-surface-card rounded-[24px] p-space-lg lg:p-space-xl bg-surface shadow-[-10px_-10px_24px_#FFFFFF,10px_10px_24px_#C8C8C8] relative">
                        <div class="max-w-3xl mb-space-xl">
                            <div class="stitch-surface-card inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-2px_-2px_6px_#FFFFFF,2px_2px_6px_#D2D2D2] text-tertiary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                                <span class="material-symbols-outlined text-[16px]">lock_open</span>
                                <span>Transparansi Tanpa Keterikatan</span>
                            </div>
                            <h2 class="font-headline-lg-mobile sm:font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">
                                Cara Kerja FixHome: Pesan, Diskusi, Beres
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-2">
                                Teknisi Anda mendiagnosa kerusakan dan memberikan rincian biaya sebelum pekerjaan dimulai. Tidak ada biaya tersembunyi!
                            </p>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                            <!-- Left: 3 Process Steps -->
                            <div class="lg:col-span-6 flex flex-col gap-space-md">
                                <div class="stitch-surface-card p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] flex items-start gap-space-md group transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                                    <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center flex-shrink-0 font-headline-sm text-headline-sm text-primary font-bold shadow-[inset_2px_2px_4px_#B2CED0,inset_-2px_-2px_4px_#E6FAFC] group-hover:scale-110 transition-transform duration-300">1</div>
                                    <div>
                                        <h3 class="font-title-md text-title-md text-primary font-semibold font-butler">Pilih Teknisi &amp; Jadwal</h3>
                                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                            Pilih kategori jasa, bandingkan teknisi terdekat beserta tarif dasarnya, lalu tentukan jadwal kunjungan.
                                        </p>
                                    </div>
                                </div>

                                <div class="stitch-surface-card p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] flex items-start gap-space-md group transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                                    <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center flex-shrink-0 font-headline-sm text-headline-sm text-primary font-bold shadow-[inset_2px_2px_4px_#DCC582,inset_-2px_-2px_4px_#FFF9E6] group-hover:scale-110 transition-transform duration-300">2</div>
                                    <div>
                                        <h3 class="font-title-md text-title-md text-primary font-semibold font-butler">Diagnosa &amp; Live Chat</h3>
                                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                            Diskusikan kendala langsung di ruang obrolan, pantau posisi teknisi secara real-time saat menuju lokasi.
                                        </p>
                                    </div>
                                </div>

                                <div class="stitch-surface-card p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] flex items-start gap-space-md group transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                                    <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center flex-shrink-0 font-headline-sm text-headline-sm text-primary font-bold shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] group-hover:scale-110 transition-transform duration-300">3</div>
                                    <div>
                                        <h3 class="font-title-md text-title-md text-primary font-semibold font-butler">Bayar Aman &amp; Bergaransi</h3>
                                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                            Pembayaran tercatat jelas di dashboard Anda, dan setiap pekerjaan dilindungi garansi resmi 14 hari.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Live Cost Breakdown Box -->
                            <div class="lg:col-span-6">
                                <div class="stitch-surface-card p-space-lg rounded-[20px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col gap-space-md transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-tertiary-fixed"></span>
                                            <span class="font-headline-sm text-headline-sm text-primary font-bold">Rincian Biaya (Live)</span>
                                        </div>
                                        <span class="stitch-surface-inset font-label-sm text-label-sm text-on-surface-variant px-space-sm py-0.5 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF]">
                                            Tiket #FX-8902
                                        </span>
                                    </div>

                                    <!-- Recessed List Frame -->
                                    <div class="stitch-surface-inset p-space-md rounded-[18px] bg-surface shadow-[inset_4px_4px_8px_#D2D2D2,inset_-4px_-4px_8px_#FFFFFF] flex flex-col gap-space-sm">
                                        <div class="flex items-center justify-between pb-space-xs gap-2">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[18px] text-primary">circle</span>
                                                <span class="font-body-md text-body-md font-semibold text-on-surface">Jasa Perbaikan Pipa Bocor</span>
                                            </div>
                                            <span class="font-label-md text-label-md text-primary shrink-0">Rp75.000</span>
                                        </div>
                                        <div class="flex items-center justify-between pb-space-xs gap-2">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[18px] text-primary">circle</span>
                                                <span class="font-body-md text-body-md font-semibold text-on-surface">Biaya Jarak (&lt; 10 km)</span>
                                            </div>
                                            <span class="font-label-md text-label-md text-primary shrink-0">Rp0</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-2">
                                            <div class="flex items-center gap-space-xs">
                                                <span class="material-symbols-outlined text-[18px] text-primary">circle</span>
                                                <span class="font-body-md text-body-md font-semibold text-on-surface">Garansi Resmi 14 Hari</span>
                                            </div>
                                            <span class="font-label-md text-label-md text-primary shrink-0">Gratis</span>
                                        </div>
                                    </div>

                                    <!-- Total Calculation Bar -->
                                    <div class="flex items-center justify-between px-space-sm pt-space-xs">
                                        <span class="font-body-md text-body-md text-on-surface-variant font-medium">Total Estimasi Biaya:</span>
                                        <span class="font-headline-sm text-headline-sm text-primary font-bold">Rp75.000</span>
                                    </div>

                                    <!-- Two Equal-Weight Tactile Action Buttons -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md pt-space-xs">
                                        <a
                                            class="w-full py-3 px-6 rounded-full bg-tertiary-fixed text-primary font-label-lg text-label-lg font-bold shadow-[0_6px_14px_rgba(251,226,157,0.45),-4px_-4px_8px_#FFFFFF] hover:opacity-95 active:shadow-[inset_3px_3px_6px_#DCC582,inset_-3px_-3px_6px_#FFFFFF] transition-all flex items-center justify-center gap-2 active:scale-[0.98] hover:-translate-y-0.5"
                                            href="{{ $techniciansUrl }}"
                                        >
                                            <span class="material-symbols-outlined text-[20px]">engineering</span>
                                            <span>Cari Teknisi</span>
                                        </a>
                                        <a
                                            class="stitch-surface-card w-full py-3 px-6 rounded-full bg-surface text-primary font-label-lg text-label-lg font-bold shadow-[-6px_-6px_14px_#FFFFFF,6px_6px_14px_#D2D2D2] hover:shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] active:shadow-[inset_4px_4px_8px_#D2D2D2,inset_-4px_-4px_8px_#FFFFFF] transition-all flex items-center justify-center gap-2 active:scale-[0.98] hover:-translate-y-0.5"
                                            href="{{ Auth::check() ? $dashboardUrl : route('register') }}"
                                        >
                                            <span class="material-symbols-outlined text-[20px]">chat</span>
                                            <span>{{ Auth::check() ? 'Buka Dashboard' : 'Daftar Gratis' }}</span>
                                        </a>
                                    </div>

                                    <p class="font-body-sm text-body-sm text-on-surface-variant text-center italic mt-space-xs">
                                        *) Biaya jarak Rp0 untuk radius &lt; 10 km, flat Rp10.000 untuk jarak &ge; 10 km.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 4. TRUST & TRANSPARENCY SECTION -->
                <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-24" data-reveal id="transparansi">
                    <div class="text-center max-w-2xl mx-auto mb-space-xl">
                        <div class="stitch-surface-card inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] text-primary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span>Standar Integritas FixHome</span>
                        </div>
                        <h2 class="font-headline-lg-mobile sm:font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">
                            Transparan &amp; Tanpa Biaya Tersembunyi
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">
                            Sistem penetapan harga dan komisi yang adil bagi pelanggan dan teknisi.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                        <div class="stitch-surface-card p-space-lg rounded-[20px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col items-start group transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                            <div class="w-11 h-11 rounded-xl bg-secondary-container shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC] flex items-center justify-center text-primary mb-space-md group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-[26px]">shield_person</span>
                            </div>
                            <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-space-xs font-butler">Verifikasi Ketat</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Teknisi wajib melewati verifikasi identitas (KTP, sertifikasi, dan uji keahlian) oleh tim Admin FixHome sebelum menerima pesanan.
                            </p>
                        </div>

                        <div class="stitch-surface-card p-space-lg rounded-[20px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col items-start group transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                            <div class="w-11 h-11 rounded-xl bg-tertiary-fixed shadow-[inset_3px_3px_6px_#DCC582,inset_-3px_-3px_6px_#FFF9E6] flex items-center justify-center text-primary mb-space-md group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-[26px]">route</span>
                            </div>
                            <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-space-xs font-butler">Biaya Jarak Jelas &amp; Terukur</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Gratis Biaya Jarak (Rp0) untuk radius &lt; 10 km dari lokasi Anda ke teknisi. Biaya tetap flat hanya Rp10.000 untuk jarak operasional &ge; 10 km.
                            </p>
                        </div>

                        <div class="stitch-surface-card p-space-lg rounded-[20px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col items-start group transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                            <div class="w-11 h-11 rounded-xl bg-primary shadow-[inset_3px_3px_6px_rgba(0,0,0,0.35),inset_-3px_-3px_6px_rgba(255,255,255,0.2)] flex items-center justify-center text-on-primary mb-space-md group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-[26px]">receipt_long</span>
                            </div>
                            <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-space-xs font-butler">Komisi Terpisah &amp; Adil</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Pencatatan jelas tanpa markup gelap: hanya 5% komisi jasa teknisi untuk pemeliharaan sistem dan garansi resmi 14 hari.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 5. PARTNERSHIP CALLOUT BANNER -->
                <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pt-space-md pb-space-xl scroll-mt-24" data-reveal id="jadi-mitra">
                    <!-- Partnership Invitation Card -->
                    <div class="stitch-surface-card rounded-[24px] p-space-lg lg:p-space-xl bg-surface shadow-[-10px_-10px_22px_#FFFFFF,10px_10px_22px_#C8C8C8] flex flex-col md:flex-row items-center justify-between gap-space-lg">
                        <div class="max-w-xl text-center md:text-left">
                            <h3 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">
                                Punya Keahlian Pertukangan?
                            </h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                Bergabunglah dengan ekosistem perbaikan rumah FixHome dan jangkau ribuan pemilik rumah di sekitar Anda setiap hari.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-space-md w-full md:w-auto shrink-0">
                            <a
                                class="w-full sm:w-auto text-center px-space-xl py-space-sm rounded-full bg-primary-container text-on-primary font-label-lg text-label-lg shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF] hover:opacity-95 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.3)] transition-all hover:-translate-y-0.5 active:scale-[0.98]"
                                href="{{ route('register') }}"
                            >
                                Daftar Jadi Teknisi
                            </a>
                            <a
                                class="stitch-surface-card w-full sm:w-auto text-center px-space-xl py-space-sm rounded-full bg-surface text-primary font-label-lg text-label-lg font-semibold shadow-[-6px_-6px_14px_#FFFFFF,6px_6px_14px_#D2D2D2] active:shadow-[inset_4px_4px_8px_#D2D2D2,inset_-4px_-4px_8px_#FFFFFF] transition-all hover:-translate-y-0.5 active:scale-[0.98]"
                                href="{{ Auth::check() ? $dashboardUrl : route('login') }}"
                            >
                                {{ Auth::check() ? 'Buka Dashboard' : 'Masuk ke Akun' }}
                            </a>
                        </div>
                    </div>
                </section>

                <!-- 6. TENTANG KAMI -->
                <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-24" data-reveal id="tentang-kami">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                        <!-- Left: Story -->
                        <div class="lg:col-span-6 flex flex-col gap-space-md">
                            <div class="stitch-surface-card self-start inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] text-primary font-label-md text-label-md font-semibold font-lucy-rose">
                                <span class="material-symbols-outlined text-[16px]">diversity_3</span>
                                <span>Tentang Kami</span>
                            </div>
                            <h2 class="font-headline-lg-mobile sm:font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">
                                Membuat Perbaikan Rumah Lebih Mudah, Jelas, dan Tenang
                            </h2>
                            <p class="font-body-lg text-body-lg text-on-surface-variant">
                                FixHome lahir dari pengalaman sederhana: mencari tukang yang bisa dipercaya itu sulit, harganya sering tidak jelas, dan hasilnya tidak bergaransi. Kami membangun platform yang mempertemukan pemilik rumah dengan teknisi terverifikasi secara cepat dan transparan.
                            </p>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Setiap teknisi melewati verifikasi identitas dan keahlian, setiap biaya ditampilkan sebelum pekerjaan dimulai, dan setiap perbaikan dilindungi garansi resmi 14 hari. Di sisi lain, teknisi mendapatkan penghasilan yang adil dengan komisi platform hanya 5%.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md pt-space-xs">
                                <div class="stitch-surface-card p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]">
                                    <div class="flex items-center gap-space-xs mb-1">
                                        <span class="material-symbols-outlined text-[20px] text-primary">visibility</span>
                                        <h3 class="font-title-md text-title-md text-primary font-bold font-butler">Visi</h3>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface-variant">
                                        Menjadi platform perbaikan rumah paling tepercaya di Indonesia.
                                    </p>
                                </div>
                                <div class="stitch-surface-card p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]">
                                    <div class="flex items-center gap-space-xs mb-1">
                                        <span class="material-symbols-outlined text-[20px] text-primary">flag</span>
                                        <h3 class="font-title-md text-title-md text-primary font-bold font-butler">Misi</h3>
                                    </div>
                                    <p class="font-body-md text-body-md text-on-surface-variant">
                                        Menghadirkan layanan yang cepat, transparan, dan bergaransi bagi setiap rumah.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Values Card -->
                        <div class="lg:col-span-6">
                            <div class="stitch-surface-card rounded-[24px] p-space-lg lg:p-space-xl bg-surface shadow-[-10px_-10px_24px_#FFFFFF,10px_10px_24px_#C8C8C8] flex flex-col gap-space-md">
                                <div class="flex items-center gap-space-sm">
                                    <img alt="" aria-hidden="true" class="w-12 h-12 object-contain" src="{{ asset('images/fixhome-icon.png') }}" />
                                    <div>
                                        <span class="block font-headline-sm text-headline-sm text-primary font-bold font-recoleta">Nilai yang Kami Pegang</span>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Prinsip di balik setiap pesanan FixHome</span>
                                    </div>
                                </div>

                                <div class="stitch-surface-inset p-space-md rounded-[20px] bg-surface shadow-[inset_4px_4px_8px_#D2D2D2,inset_-4px_-4px_8px_#FFFFFF] flex flex-col gap-space-md">
                                    <div class="flex items-start gap-space-md">
                                        <div class="w-11 h-11 rounded-2xl bg-secondary-container flex items-center justify-center text-primary shrink-0 shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                            <span class="material-symbols-outlined text-[22px]">handshake</span>
                                        </div>
                                        <div>
                                            <h3 class="font-title-sm text-title-sm text-primary font-bold">Kepercayaan</h3>
                                            <p class="font-body-md text-body-md text-on-surface-variant">Hanya teknisi terverifikasi yang bisa menerima pesanan.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-space-md">
                                        <div class="w-11 h-11 rounded-2xl bg-tertiary-fixed flex items-center justify-center text-primary shrink-0 shadow-[inset_3px_3px_6px_#DCC582,inset_-3px_-3px_6px_#FFF9E6]">
                                            <span class="material-symbols-outlined text-[22px]">payments</span>
                                        </div>
                                        <div>
                                            <h3 class="font-title-sm text-title-sm text-primary font-bold">Transparansi</h3>
                                            <p class="font-body-md text-body-md text-on-surface-variant">Tarif dasar, biaya jarak, dan komisi tercatat terbuka.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-space-md">
                                        <div class="w-11 h-11 rounded-2xl bg-primary flex items-center justify-center text-on-primary shrink-0 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.35),inset_-3px_-3px_6px_rgba(255,255,255,0.2)]">
                                            <span class="material-symbols-outlined text-[22px]">workspace_premium</span>
                                        </div>
                                        <div>
                                            <h3 class="font-title-sm text-title-sm text-primary font-bold">Kualitas Bergaransi</h3>
                                            <p class="font-body-md text-body-md text-on-surface-variant">Hasil kerja dilindungi garansi resmi 14 hari.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-space-sm px-space-sm">
                                    <span class="inline-flex items-center gap-1 font-label-md text-label-md text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">location_on</span>
                                        Beroperasi di Jabodetabek
                                    </span>
                                    <a class="inline-flex items-center gap-1 font-label-lg text-label-lg text-primary-container font-bold hover:underline" href="{{ $techniciansUrl }}">
                                        Mulai Pesan
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <!-- GLOBAL FOOTER (Old Copper #775537) -->
        <footer class="w-full bg-primary-container text-inverse-on-surface pt-space-xl pb-space-lg mt-space-xl">
            <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-space-xl">
                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Pelanggan</h3>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ $techniciansUrl }}">Cari Teknisi</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#layanan-populer">Kategori Layanan</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#cara-kerja">Cara Pemesanan</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#transparansi">Perlindungan Garansi</a>
                    </div>

                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Teknisi</h3>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('register') }}">Daftar Menjadi Teknisi</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#transparansi">Standar Uji Kompetensi</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#transparansi">Komisi Transparan (5%)</a>
                    </div>

                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Akun</h3>
                        @auth
                            <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ $dashboardUrl }}">Dashboard Saya</a>
                        @else
                            <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('login') }}">Masuk</a>
                            <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('register') }}">Daftar Gratis</a>
                        @endauth
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#katalog-teknisi">Teknisi Siap Kerja</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="#tentang-kami">Tentang Kami</a>
                    </div>

                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Kontak &amp; Bantuan</h3>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs" href="#cara-kerja">
                            <span class="material-symbols-outlined text-[16px]">chat</span>
                            Live Chat di Aplikasi
                        </a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs" href="#transparansi">
                            <span class="material-symbols-outlined text-[16px]">support_agent</span>
                            Bantuan 24/7
                        </a>
                        <span class="font-body-sm text-body-sm text-tertiary-fixed/85 mt-1">Wilayah operasional: Jabodetabek</span>
                    </div>
                </div>

                <div class="pt-space-lg border-t border-white/15 flex flex-col md:flex-row items-center justify-between gap-space-md text-inverse-on-surface/75">
                    <p class="font-body-sm text-body-sm text-center md:text-left">&copy; {{ date('Y') }} FixHome Indonesia. Solusi Perbaikan Rumah Terpercaya.</p>
                    <div class="flex items-center gap-space-sm font-label-sm text-label-sm text-tertiary-fixed">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Garansi Resmi &amp; Teknisi Terverifikasi</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Bottom Navigation (Hidden on desktop, touch target >= 44px) -->
    <nav aria-label="Navigasi Bawah" class="sm:hidden fixed bottom-0 inset-x-0 z-40 px-2 py-1.5 bg-white/95 backdrop-blur-md border-t border-[#E5E7EB] shadow-[0_-4px_14px_rgba(17,24,39,0.06)]">
        <div class="grid grid-cols-4 gap-1.5 h-14">
            <a class="fh-bottom-link flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 bg-[#DCFCE7] text-[#15803D] font-bold" data-nav-target="beranda" href="#beranda">
                <span class="material-symbols-outlined text-[20px] mb-0.5">home</span>
                <span>Beranda</span>
            </a>
            <a class="fh-bottom-link flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 text-[#4B5563]" data-nav-target="layanan-populer" href="#layanan-populer">
                <span class="material-symbols-outlined text-[20px] mb-0.5">home_repair_service</span>
                <span>Layanan</span>
            </a>
            <a class="fh-bottom-link flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 text-[#4B5563]" data-nav-target="katalog-teknisi" href="#katalog-teknisi">
                <span class="material-symbols-outlined text-[20px] mb-0.5">engineering</span>
                <span>Teknisi</span>
            </a>
            @auth
                <a class="flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 text-[#4B5563]" href="{{ $dashboardUrl }}">
                    <span class="material-symbols-outlined text-[20px] mb-0.5">dashboard</span>
                    <span>Dasbor</span>
                </a>
            @else
                <a class="flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 text-[#4B5563]" href="{{ route('login') }}">
                    <span class="material-symbols-outlined text-[20px] mb-0.5">person</span>
                    <span>Masuk</span>
                </a>
            @endauth
        </div>
    </nav>
</body>
</html>
