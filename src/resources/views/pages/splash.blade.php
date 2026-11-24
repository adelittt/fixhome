<!DOCTYPE html>
<html class="bg-surface scroll-smooth" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_standard" name="shell-type" />
    <title>FixHome — Platform Booking Jasa Perbaikan Rumah #1 di Indonesia</title>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@100..900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Fraunces:ital,opsz,wght@0,9..144,400..800;1,9..144,400..800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
@php
    $dashboardUrl = Auth::check()
        ? (Auth::user()->role === 'admin'
            ? url('/admin')
            : (Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.home')))
        : route('login');
    $bookingCtaUrl = Auth::check()
        ? (Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.technicians'))
        : route('login');
@endphp
<body class="bg-surface font-body-md text-on-surface antialiased min-h-screen">
    <header class="fixed top-0 left-0 right-0 z-50 bg-surface/90 backdrop-blur-md px-gutter lg:px-margin border-b border-outline-variant/25">
        <div class="h-20 max-w-[1280px] mx-auto flex items-center justify-between gap-gutter">
            <a class="flex items-center gap-2.5" data-path="beranda" href="{{ route('splash') }}">
                <img alt="FixHome Logo" class="h-9 w-9 rounded-lg object-contain mix-blend-multiply" src="{{ asset('images/fixhome-logo.jpg') }}" />
                <div class="flex flex-col leading-tight">
                    <span class="font-headline-sm text-headline-sm text-primary-container tracking-tight font-recoleta leading-none">FixHome</span>
                    <span class="text-[10px] font-medium text-on-surface-variant tracking-tight mt-0.5">Solusi Perbaikan Rumah</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-space-lg" data-active-classes="text-primary-container font-semibold">
                <a class="font-body-md text-body-md text-primary-container font-semibold hover:text-primary transition-colors py-space-xs px-space-sm" data-path="beranda" href="#beranda">Beranda</a>
                <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors py-space-xs px-space-sm" data-path="layanan" href="#layanan">Layanan</a>
                <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors py-space-xs px-space-sm" data-path="cara-kerja" href="#cara-kerja">Cara Kerja</a>
                <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors py-space-xs px-space-sm" data-path="keunggulan" href="#keunggulan">Keunggulan</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a class="inline-flex items-center justify-center font-label-lg text-label-lg text-on-primary bg-primary-container rounded-full px-space-lg py-space-sm shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF] hover:opacity-95 transition-all" href="{{ $dashboardUrl }}">
                        Dashboard
                    </a>
                    <a aria-label="Profil Pengguna" class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-on-primary font-label-md text-label-md" href="{{ $dashboardUrl }}" title="{{ Auth::user()->name }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </a>
                @else
                    <a class="hidden sm:inline-flex items-center justify-center font-label-lg text-label-lg text-primary-container bg-surface rounded-full px-6 py-2.5 shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] hover:shadow-[-2px_-2px_6px_#FFFFFF,2px_2px_6px_#D2D2D2] transition-all" data-path="masuk" href="{{ route('login') }}">Masuk</a>
                    <a class="inline-flex items-center justify-center font-label-lg text-label-lg text-on-primary bg-primary-container rounded-full px-6 py-2.5 shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF] hover:opacity-95 transition-all" data-path="daftar" href="{{ route('register') }}">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-surface">
        <div class="flex flex-col w-full">
            <!-- Top Decorative Ambient Light Wells -->
            <div class="relative w-full max-w-[1280px] mx-auto px-gutter lg:px-margin overflow-hidden pointer-events-none">
                <div class="absolute -top-32 -left-20 w-96 h-96 rounded-full bg-secondary-container/40 blur-3xl"></div>
                <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-tertiary-fixed/30 blur-3xl"></div>
            </div>

            <!-- 1. HERO SECTION -->
            <section class="w-full max-w-[1280px] mx-auto px-gutter lg:px-margin pt-space-lg lg:pt-space-xl pb-space-xl scroll-mt-20" id="beranda">
                <div class="w-full relative rounded-[32px] overflow-hidden shadow-[-10px_-10px_24px_#FFFFFF,10px_10px_24px_#C8C8C8] min-h-[460px] md:min-h-[520px] flex items-center justify-center p-space-lg md:p-space-xl py-16 md:py-24">
                    <!-- Landscape Banner Background -->
                    <div class="absolute inset-0 w-full h-full pointer-events-none">
                        <img alt="FixHome Landscape Banner" class="w-full h-full object-cover opacity-85" src="{{ asset('images/fixhome-hero-banner.jpg') }}" />
                        <div class="absolute inset-0 bg-gradient-to-b from-surface/75 via-surface/60 to-surface/55 backdrop-blur-[0.5px]"></div>
                        <div aria-hidden="true" class="hero-shimmer-overlay pointer-events-none"></div>
                    </div>

                    <!-- Centered Content -->
                    <div class="relative z-10 w-full max-w-3xl mx-auto flex flex-col items-center text-center gap-5">
                        <!-- Headline & Subheadline -->
                        <div class="flex flex-col items-center gap-3">
                            <h1 class="font-headline-xl text-headline-xl-mobile sm:text-headline-xl md:text-[46px] md:leading-[54px] text-primary font-extrabold tracking-tight font-recoleta text-center hero-headline-shadow">
                                Perbaikan Rumah Tuntas,<br class="hidden sm:inline" /> Material Tepat Tanpa Ribet
                            </h1>
                            <p class="font-body-md sm:font-body-lg text-body-md sm:text-body-lg text-on-surface-variant text-center max-w-xl font-medium leading-relaxed">
                                Pesan teknisi terverifikasi, konsultasikan kendala lewat live chat, dan nikmati perbaikan berkualitas bergaransi resmi 14 hari.
                            </p>
                        </div>

                        <!-- Compact Inline Category + CTA Row -->
                        <form action="{{ route('customer.technicians') }}" class="flex flex-col sm:flex-row items-center justify-center gap-3.5 w-full sm:w-auto mt-2" id="hero-search-form" method="GET">
                            <!-- Espresso Pill Category Dropdown -->
                            <div class="w-full sm:w-auto min-w-[235px] relative flex items-center px-5 py-3 rounded-full bg-primary-container text-on-primary shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF] hover:opacity-95 transition-all">
                                <span class="material-symbols-outlined text-on-primary text-[19px] mr-2.5 shrink-0">work</span>
                                <select aria-label="Pilih Kategori Jasa" class="w-full bg-transparent font-label-lg text-label-lg text-on-primary focus:outline-none appearance-none cursor-pointer pr-7" id="hero-category-select" name="category">
                                    <option class="bg-surface text-on-surface" selected="" value="">Pilih Kategori Jasa</option>
                                    <option class="bg-surface text-on-surface" value="Pipa & Saluran Air">Perbaikan Pipa &amp; Sanitasi</option>
                                    <option class="bg-surface text-on-surface" value="Instalasi Listrik">Instalasi &amp; Reparasi Listrik</option>
                                    <option class="bg-surface text-on-surface" value="AC & Pendingin">Perawatan &amp; Cuci AC</option>
                                    <option class="bg-surface text-on-surface" value="Atap & Plafon Bocor">Perbaikan Atap &amp; Plafon</option>
                                    <option class="bg-surface text-on-surface" value="Pengecatan & Tembok">Pengecatan Dinding</option>
                                    <option class="bg-surface text-on-surface" value="">Deep Cleaning &amp; Toren</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 text-on-primary text-[19px] pointer-events-none">expand_more</span>
                            </div>

                            <!-- Espresso Pill Primary CTA -->
                            <button class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-full bg-primary-container text-on-primary font-label-lg text-label-lg shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF] hover:opacity-95 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.35)] transition-all active:scale-[0.98]" type="submit">
                                <span>Cari Teknisi Terdekat</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- 2. SERVICE CATEGORIES SECTION -->
            <section class="w-full max-w-[1280px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-20" id="layanan">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-lg">
                    <div>
                        <div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] text-secondary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                            <span>Keahlian Lengkap &amp; Terstandar</span>
                        </div>
                        <h2 class="font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">Layanan Perbaikan Rumah Terpopuler</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Pilih layanan yang Anda butuhkan, dikerjakan oleh tukang berpengalaman bersertifikasi.</p>
                    </div>
                    <div class="flex items-center gap-space-sm self-start md:self-auto">
                        <button aria-label="Geser Kiri" class="w-10 h-10 rounded-full bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] active:shadow-[inset_3px_3px_6px_#D2D2D2,inset_-3px_-3px_6px_#FFFFFF] flex items-center justify-center text-primary transition-all" id="service-prev-btn" type="button">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </button>
                        <button aria-label="Geser Kanan" class="w-10 h-10 rounded-full bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] active:shadow-[inset_3px_3px_6px_#D2D2D2,inset_-3px_-3px_6px_#FFFFFF] flex items-center justify-center text-primary transition-all" id="service-next-btn" type="button">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </button>
                    </div>
                </div>

                <!-- 6-Grid Tactile Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg" id="service-cards-container">
                    <!-- Card 1: Pipa & Sanitasi -->
                    <div class="service-card-item group rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] transition-all flex flex-col justify-between h-full" data-categories="populer mendesak">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                    <span class="material-symbols-outlined text-primary text-[28px]">plumbing</span>
                                </div>
                                <span class="px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                    Mulai Rp75.000
                                </span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">Perbaikan Pipa &amp; Sanitasi</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Solusi tuntas pipa bocor, saluran mampet, instalasi toren, kloset, dan pompa booster otomatis.</p>
                        </div>
                        <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">320+ Teknisi Siap</span>
                            <a aria-label="Pilih Perbaikan Pipa & Sanitasi" class="w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="{{ route('customer.technicians', ['category' => 'Pipa & Saluran Air']) }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Listrik -->
                    <div class="service-card-item group rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] transition-all flex flex-col justify-between h-full" data-categories="mendesak">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                    <span class="material-symbols-outlined text-primary text-[28px]">electric_bolt</span>
                                </div>
                                <span class="px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                    Mulai Rp85.000
                                </span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">Instalasi &amp; Reparasi Listrik</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Penanganan korsleting, pasang titik lampu baru, perapian panel MCB, dan grounding bersertifikasi.</p>
                        </div>
                        <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">240+ Teknisi Siap</span>
                            <a aria-label="Pilih Instalasi & Reparasi Listrik" class="w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="{{ route('customer.technicians', ['category' => 'Instalasi Listrik']) }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Cuci AC -->
                    <div class="service-card-item group rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] transition-all flex flex-col justify-between h-full" data-categories="populer rutin">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                    <span class="material-symbols-outlined text-primary text-[28px]">ac_unit</span>
                                </div>
                                <span class="px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                    Mulai Rp65.000
                                </span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">Perawatan &amp; Cuci AC</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Cuci unit indoor &amp; outdoor, isi freon R32/R410A, perbaikan bocor air, dan pemindahan posisi AC.</p>
                        </div>
                        <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">190+ Teknisi Siap</span>
                            <a aria-label="Pilih Perawatan & Cuci AC" class="w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="{{ route('customer.technicians', ['category' => 'AC & Pendingin']) }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 4: Atap & Plafon -->
                    <div class="service-card-item group rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] transition-all flex flex-col justify-between h-full" data-categories="mendesak">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                    <span class="material-symbols-outlined text-primary text-[28px]">roofing</span>
                                </div>
                                <span class="px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                    Mulai Rp120.000
                                </span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">Perbaikan Atap &amp; Plafon</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Pencegahan atap rembes bocor, ganti genteng retak, tambal plafon gypsum berjamur, &amp; talang air.</p>
                        </div>
                        <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">180+ Teknisi Siap</span>
                            <a aria-label="Pilih Perbaikan Atap & Plafon" class="w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="{{ route('customer.technicians', ['category' => 'Atap & Plafon Bocor']) }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 5: Pengecatan Dinding -->
                    <div class="service-card-item group rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] transition-all flex flex-col justify-between h-full" data-categories="rutin">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                    <span class="material-symbols-outlined text-primary text-[28px]">format_paint</span>
                                </div>
                                <span class="px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                    Mulai Rp90.000
                                </span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">Pengecatan Dinding</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Pengecatan interior kamar, dinding eksterior fasad cuaca tropis, waterproofing, dan perbaikan plamir retak.</p>
                        </div>
                        <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">210+ Teknisi Siap</span>
                            <a aria-label="Pilih Pengecatan Dinding" class="w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="{{ route('customer.technicians', ['category' => 'Pengecatan & Tembok']) }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 6: Kebersihan & Deep Cleaning -->
                    <div class="service-card-item group rounded-[24px] p-space-lg bg-surface shadow-[-6px_-6px_16px_#FFFFFF,6px_6px_16px_#D2D2D2] hover:shadow-[-8px_-8px_20px_#FFFFFF,8px_8px_20px_#C8C8C8] transition-all flex flex-col justify-between h-full" data-categories="populer rutin">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC]">
                                    <span class="material-symbols-outlined text-primary text-[28px]">cleaning_services</span>
                                </div>
                                <span class="px-space-sm py-1 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] font-label-sm text-label-sm font-semibold text-primary">
                                    Mulai Rp50.000
                                </span>
                            </div>
                            <h3 class="font-title-md text-title-md text-primary font-bold mb-space-xs font-butler">Kebersihan &amp; Deep Cleaning</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Pembersihan kerak toren air, sedot tungau kasur/sofa hidro-alergi, dan pembersihan menyeluruh pasca renovasi.</p>
                        </div>
                        <div class="mt-space-lg pt-space-sm flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-secondary font-semibold">150+ Teknisi Siap</span>
                            <a aria-label="Pilih Kebersihan & Deep Cleaning" class="w-10 h-10 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] group-hover:shadow-[inset_2px_2px_5px_#D2D2D2,inset_-2px_-2px_5px_#FFFFFF] flex items-center justify-center text-primary transition-all" href="{{ route('customer.technicians') }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. KEY FEATURE HIGHLIGHT SECTION (CARA KERJA) -->
            <section class="w-full max-w-[1280px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-20" id="cara-kerja">
                <div class="rounded-[32px] p-space-lg lg:p-space-xl bg-surface shadow-[-10px_-10px_24px_#FFFFFF,10px_10px_24px_#C8C8C8] relative">
                    <div class="max-w-3xl mb-space-xl">
                        <div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-2px_-2px_6px_#FFFFFF,2px_2px_6px_#D2D2D2] text-tertiary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span>Proses Standar &amp; Terpercaya</span>
                        </div>
                        <h2 class="font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">Langkah Mudah Perbaikan Rumah Bergaransi</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">Dari diagnosa awal hingga pekerjaan tuntas, seluruh proses dirancang transparan, aman, dan tanpa biaya terselubung.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                        <div class="lg:col-span-6 flex flex-col gap-space-md">
                            <div class="p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] flex items-start gap-space-md group transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                                <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center flex-shrink-0 font-headline-sm text-headline-sm text-primary font-bold shadow-[inset_2px_2px_4px_#B2CED0,inset_-2px_-2px_4px_#E6FAFC] group-hover:scale-110 transition-transform duration-300">1</div>
                                <div>
                                    <h3 class="font-title-md text-title-md text-primary font-semibold font-butler">Konsultasi &amp; Diagnosa Masalah</h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Diskusikan kendala kerusakan Anda secara langsung via live chat dan dapatkan estimasi awal yang jelas dan akurat.</p>
                                </div>
                            </div>

                            <div class="p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] flex items-start gap-space-md group transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                                <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center flex-shrink-0 font-headline-sm text-headline-sm text-primary font-bold shadow-[inset_2px_2px_4px_#DCC582,inset_-2px_-2px_4px_#FFF9E6] group-hover:scale-110 transition-transform duration-300">2</div>
                                <div>
                                    <h3 class="font-title-md text-title-md text-primary font-semibold font-butler">Teknisi Datang &amp; Kerjakan</h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Mitra teknisi bersertifikasi tiba tepat waktu sesuai jadwal dengan peralatan lengkap untuk menyelesaikan pekerjaan.</p>
                                </div>
                            </div>

                            <div class="p-space-md rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2] flex items-start gap-space-md group transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center flex-shrink-0 font-headline-sm text-headline-sm text-primary font-bold shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF] group-hover:scale-110 transition-transform duration-300">3</div>
                                <div>
                                    <h3 class="font-title-md text-title-md text-primary font-semibold font-butler">Garansi 14 Hari &amp; Pembayaran Aman</h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Pembayaran hanya diteruskan ke teknisi setelah Anda puas dan pekerjaan terbukti tuntas tanpa kendala lanjutan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-6">
                            <div class="p-space-lg rounded-[26px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col gap-space-md transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-secondary-container"></span>
                                        <span class="font-headline-sm text-headline-sm text-primary font-bold">Ringkasan Layanan Kerja</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant px-space-xs py-0.5 rounded-full bg-surface shadow-[inset_2px_2px_4px_#D2D2D2,inset_-2px_-2px_4px_#FFFFFF]">Tiket #FX-8902</span>
                                </div>

                                <div class="p-space-md rounded-[18px] bg-surface shadow-[inset_4px_4px_8px_#D2D2D2,inset_-4px_-4px_8px_#FFFFFF] flex flex-col gap-space-sm">
                                    <div class="flex items-center justify-between pb-space-xs">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                            <span class="font-body-md text-body-md font-semibold text-on-surface">Inspeksi &amp; Pengecekan Sistem</span>
                                        </div>
                                        <span class="font-label-md text-label-md text-primary">Termasuk</span>
                                    </div>
                                    <div class="flex items-center justify-between pb-space-xs">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-[18px] text-tertiary">check_circle</span>
                                            <span class="font-body-md text-body-md font-semibold text-on-surface">Jasa Pengerjaan Standar SNI</span>
                                        </div>
                                        <span class="font-label-md text-label-md text-primary">Rp75.000</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="material-symbols-outlined text-[18px] text-tertiary">verified_user</span>
                                            <span class="font-body-md text-body-md font-semibold text-on-surface">Sertifikat Garansi 14 Hari</span>
                                        </div>
                                        <span class="font-label-md text-label-md text-primary">Gratis (Rp0)</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between px-space-sm pt-space-xs">
                                    <span class="font-body-md text-body-md text-on-surface-variant font-medium">Total Biaya Jasa:</span>
                                    <span class="font-headline-sm text-headline-sm text-primary font-bold">Rp75.000</span>
                                </div>

                                <div class="pt-space-xs">
                                    <a class="w-full py-3 px-6 rounded-full bg-primary-container text-on-primary font-headline-sm text-headline-sm font-bold shadow-[0_6px_14px_rgba(119,85,55,0.28),-4px_-4px_8px_#FFFFFF] hover:opacity-95 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.35)] transition-all flex items-center justify-center gap-2 active:scale-[0.98] hover:-translate-y-0.5" href="{{ $bookingCtaUrl }}">
                                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                                        <span>Pesan Jadwal Teknisi</span>
                                    </a>
                                </div>

                                <p class="font-body-sm text-body-sm text-on-surface-variant text-center italic mt-space-xs">
                                    *) Garansi 14 hari perbaikan ulang tanpa biaya tambahan jika masalah serupa muncul kembali.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. TRUST & TRANSPARENCY SECTION (KEUNGGULAN) -->
            <section class="w-full max-w-[1280px] mx-auto px-gutter lg:px-margin py-space-xl scroll-mt-20" id="keunggulan">
                <div class="text-center max-w-2xl mx-auto mb-space-xl">
                    <div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-surface shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#DCDCDC] text-primary font-label-md text-label-md font-semibold mb-space-xs font-lucy-rose">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Standar Integritas FixHome</span>
                    </div>
                    <h2 class="font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">Transparan &amp; Tanpa Biaya Tersembunyi</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-2">
                        Sistem penetapan harga dan komisi yang adil bagi pelanggan dan mitra teknisi.
                    </p>
                </div>

                <!-- 3 Raised Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                    <!-- Info Card 1 -->
                    <div class="p-space-lg rounded-[26px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col items-start group transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                        <div class="w-14 h-14 rounded-2xl bg-secondary-container shadow-[inset_3px_3px_6px_#B2CED0,inset_-3px_-3px_6px_#E6FAFC] flex items-center justify-center text-primary mb-space-md group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[26px]">shield_person</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-space-xs font-butler">Verifikasi Ketat</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Mitra Teknisi wajib melewati verifikasi identitas (KTP, SKCK, dan uji keahlian lapangan langsung) oleh tim Admin FixHome sebelum menerima pesanan.
                        </p>
                    </div>

                    <!-- Info Card 2 -->
                    <div class="p-space-lg rounded-[26px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col items-start group transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                        <div class="w-14 h-14 rounded-2xl bg-tertiary-fixed shadow-[inset_3px_3px_6px_#DCC582,inset_-3px_-3px_6px_#FFF9E6] flex items-center justify-center text-primary mb-space-md group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[26px]">route</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-space-xs font-butler">Biaya Jarak Jelas &amp; Terukur</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Gratis Biaya Jarak (Rp0) untuk radius &lt; 10 km dari lokasi Anda ke teknisi. Biaya tetap flat hanya Rp10.000 untuk jarak operasional &ge; 10 km.
                        </p>
                    </div>

                    <!-- Info Card 3 -->
                    <div class="p-space-lg rounded-[26px] bg-surface shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2] flex flex-col items-start group transition-all duration-300 ease-out hover:-translate-y-1.5 hover:shadow-[-12px_-12px_26px_#FFFFFF,12px_12px_26px_#C8C8C8]">
                        <div class="w-14 h-14 rounded-2xl bg-primary shadow-[inset_3px_3px_6px_rgba(0,0,0,0.35),inset_-3px_-3px_6px_rgba(255,255,255,0.2)] flex items-center justify-center text-on-primary mb-space-md group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[26px]">receipt_long</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-space-xs font-butler">Komisi Terpisah &amp; Adil</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Pencatatan jelas tanpa markup gelap: hanya 5% komisi jasa teknisi untuk pemeliharaan sistem verifikasi dan operasional garansi resmi 14 hari.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 5. STATS & CALLOUT BANNER (JADI MITRA) -->
            <section class="w-full max-w-[1280px] mx-auto px-gutter lg:px-margin pt-space-md pb-space-xl scroll-mt-20" id="jadi-mitra">
                <!-- 4 Stats Capsules -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md mb-space-xl">
                    <div class="p-space-md rounded-[20px] bg-surface shadow-[-5px_-5px_12px_#FFFFFF,5px_5px_12px_#D2D2D2] text-center transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                        <span class="font-headline-lg text-headline-lg text-primary font-bold block font-butler">15.000+</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Perbaikan Sukses</span>
                    </div>
                    <div class="p-space-md rounded-[20px] bg-surface shadow-[-5px_-5px_12px_#FFFFFF,5px_5px_12px_#D2D2D2] text-center transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                        <span class="font-headline-lg text-headline-lg text-secondary font-bold block font-butler">98.4%</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Kepuasan Pelanggan</span>
                    </div>
                    <div class="p-space-md rounded-[20px] bg-surface shadow-[-5px_-5px_12px_#FFFFFF,5px_5px_12px_#D2D2D2] text-center transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                        <span class="font-headline-lg text-headline-lg text-tertiary font-bold block font-butler">35+ Kota</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Wilayah Jangkauan</span>
                    </div>
                    <div class="p-space-md rounded-[20px] bg-surface shadow-[-5px_-5px_12px_#FFFFFF,5px_5px_12px_#D2D2D2] text-center transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-[-8px_-8px_18px_#FFFFFF,8px_8px_18px_#D2D2D2]">
                        <span class="font-headline-lg text-headline-lg text-primary font-bold block font-butler">1.200+</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Teknisi Tersertifikasi</span>
                    </div>
                </div>

                <!-- Partnership Invitation Card -->
                <div class="rounded-[32px] p-space-lg lg:p-space-xl bg-surface shadow-[-10px_-10px_22px_#FFFFFF,10px_10px_22px_#C8C8C8] flex flex-col md:flex-row items-center justify-between gap-space-lg">
                    <div class="max-w-xl text-center md:text-left">
                        <h3 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">Rumah Rusak atau Mau Bergabung Sebagai Teknisi?</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Dapatkan teknisi berpengalaman hari ini juga atau kembangkan karir pertukangan Anda bersama ekosistem FixHome.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-space-md w-full md:w-auto">
                        <a class="w-full sm:w-auto text-center px-space-xl py-space-sm rounded-full bg-primary-container text-on-primary font-label-lg text-label-lg shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF] hover:opacity-95 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.3)] transition-all hover:-translate-y-0.5 active:scale-[0.98]" href="{{ $bookingCtaUrl }}">
                            Pesan Teknisi Sekarang
                        </a>
                        <a class="w-full sm:w-auto text-center px-space-xl py-space-sm rounded-full bg-surface text-primary font-label-lg text-label-lg font-semibold shadow-[-6px_-6px_14px_#FFFFFF,6px_6px_14px_#D2D2D2] active:shadow-[inset_4px_4px_8px_#D2D2D2,inset_-4px_-4px_8px_#FFFFFF] transition-all hover:-translate-y-0.5 active:scale-[0.98]" href="{{ route('register', ['role' => 'teknisi']) }}">
                            Daftar Jadi Teknisi
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="w-full bg-primary-container text-inverse-on-surface pt-space-xl pb-space-lg mt-space-xl">
        <div class="max-w-[1280px] mx-auto px-gutter lg:px-margin">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-space-xl">
                <div class="flex flex-col gap-space-sm">
                    <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Pelanggan</h3>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="layanan" href="{{ $bookingCtaUrl }}">Cari Teknisi</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="layanan" href="#layanan">Kategori Layanan</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="cara-kerja" href="#cara-kerja">Cara Pemesanan</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors font-recoleta" data-path="beranda" href="#keunggulan">Perlindungan Garansi</a>
                </div>
                <div class="flex flex-col gap-space-sm">
                    <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Teknisi</h3>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="jadi-mitra" href="{{ route('register', ['role' => 'teknisi']) }}">Daftar Menjadi Teknisi</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="jadi-mitra" href="#keunggulan">Standar Uji Kompetensi</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="jadi-mitra" href="#keunggulan">Komisi Transparan</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="jadi-mitra" href="#cara-kerja">Pedoman Keselamatan</a>
                </div>
                <div class="flex flex-col gap-space-sm">
                    <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Garansi &amp; Mutu</h3>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="garansi" href="#cara-kerja">Klaim Garansi 14 Hari</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="verifikasi" href="#keunggulan">Verifikasi Identitas &amp; SKCK</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="asuransi" href="#keunggulan">Asuransi Pengerjaan</a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" data-path="kebijakan" href="#keunggulan">Ketentuan Layanan</a>
                </div>
                <div class="flex flex-col gap-space-sm">
                    <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Kontak &amp; Bantuan</h3>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs" data-path="bantuan" href="{{ route('login') }}">
                        <span class="material-symbols-outlined text-[16px]">chat</span>Live Chat WhatsApp
                    </a>
                    <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs" data-path="bantuan" href="{{ route('login') }}">
                        <span class="material-symbols-outlined text-[16px]">support_agent</span>Bantuan 24/7
                    </a>
                </div>
            </div>

            <div class="pt-space-lg flex flex-col md:flex-row items-center justify-between gap-space-md text-inverse-on-surface/70 border-t border-inverse-on-surface/15">
                <p class="font-body-sm text-body-sm text-center md:text-left">&copy; 2025 FixHome Indonesia. Layanan Booking Jasa Perbaikan Rumah Bergaransi.</p>
                <div class="flex items-center gap-space-sm font-label-sm text-label-sm text-tertiary-fixed">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Garansi Resmi &amp; Teknisi Terverifikasi</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
