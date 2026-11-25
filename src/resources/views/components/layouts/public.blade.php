@props([
    'title' => 'FixHome - Layanan Perbaikan Rumah Terverifikasi & Bergaransi',
    'activeNav' => 'beranda',
    'description' => 'Pesan teknisi perbaikan rumah terverifikasi untuk AC, listrik, pipa, atap, hingga pengecatan. Biaya jelas, live chat, dan garansi resmi 14 hari.',
])
@php
    $dashboardUrl = Auth::check()
        ? (Auth::user()->role === 'admin'
            ? url('/admin')
            : (Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.home')))
        : route('login');
    $techniciansUrl = Auth::check() && Auth::user()->role === 'customer'
        ? route('customer.technicians')
        : (Auth::check() ? $dashboardUrl : route('login'));

    $navItems = [
        ['key' => 'beranda', 'label' => 'Beranda', 'href' => route('splash')],
        ['key' => 'layanan', 'label' => 'Layanan', 'href' => route('public.layanan')],
        ['key' => 'teknisi', 'label' => 'Teknisi', 'href' => route('public.teknisi')],
        ['key' => 'cara-kerja', 'label' => 'Cara Kerja', 'href' => route('public.cara-kerja')],
    ];
    if (! Auth::check()) {
        $navItems[] = ['key' => 'jadi-mitra', 'label' => 'Jadi Mitra', 'href' => route('public.jadi-mitra')];
    }
    $navItems[] = ['key' => 'tentang-kami', 'label' => 'Tentang Kami', 'href' => route('public.tentang-kami')];

    $activeLabel = collect($navItems)->firstWhere('key', $activeNav)['label'] ?? 'Beranda';
@endphp
<!DOCTYPE html>
<html class="scroll-smooth bg-surface" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="{{ $description }}" name="description" />
    <meta content="#16A34A" name="theme-color" />
    <link href="{{ asset('images/fixhome-icon.png') }}" rel="icon" type="image/png" />
    <title>{{ $title }}</title>

    <!-- Fonts: Plus Jakarta Sans (Headings) + Inter (Body & UI) + Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />

    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body class="fh-plus bg-surface font-body-md text-on-surface antialiased min-h-screen flex flex-col overscroll-none" data-active-page="{{ $activeNav }}" id="top">

    <div class="flex-1 flex flex-col pb-16 sm:pb-0">
        <!-- FLOATING PILL HEADER NAVIGATION (Dynamic Island Morph on Scroll) -->
        <header class="fh-header-anim fixed top-3 sm:top-4 left-0 right-0 z-50 px-3 sm:px-6 pointer-events-none" id="site-header">
            <div class="fh-header-pill pointer-events-auto h-14 max-w-[1140px] mx-auto px-4 sm:px-5 rounded-full bg-white/95 backdrop-blur-md border border-white/80 shadow-[0_6px_28px_rgba(17,24,39,0.08)] flex items-center justify-between gap-4 overflow-hidden" id="header-pill-bar">
                <!-- Brand Logo + Compact Active Indicator -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <a aria-label="Beranda FixHome" class="fh-page-link flex items-center shrink-0 group active:scale-[0.98] transition-transform" href="{{ route('splash') }}">
                        <img alt="FixHome" class="fh-header-logo h-7 sm:h-[30px] w-auto object-contain group-hover:opacity-90 transition-all duration-300" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </a>
                    <span class="fh-compact-badge hidden md:inline-flex items-center pl-2.5 border-l border-[#E5E7EB] text-[12px] font-semibold text-[#15803D] whitespace-nowrap" id="header-compact-badge">
                        <span class="leading-none" id="header-compact-label">{{ $activeLabel }}</span>
                    </span>
                </div>

                <!-- Center Navigation Links -->
                <nav aria-label="Navigasi utama" class="fh-header-collapsible hidden md:flex items-center gap-0.5 lg:gap-1 relative" id="desktop-nav">
                    <span aria-hidden="true" class="fh-nav-pill pointer-events-none absolute top-0 bottom-0 left-0 rounded-full bg-[#DCFCE7] z-0 opacity-0" id="nav-active-pill"></span>
                    @foreach ($navItems as $item)
                        @php $isCurrent = $activeNav === $item['key']; @endphp
                        <a
                            class="fh-nav-link fh-page-link relative z-10 font-body-md text-[13px] rounded-full px-3.5 py-1.5 transition-colors duration-200 active:scale-95 whitespace-nowrap {{ $isCurrent ? 'text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827]' }}"
                            data-nav-key="{{ $item['key'] }}"
                            href="{{ $item['href'] }}"
                            @if ($isCurrent) aria-current="page" @endif
                        >{{ $item['label'] }}</a>
                    @endforeach
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
                @foreach ($navItems as $item)
                    @php $isCurrent = $activeNav === $item['key']; @endphp
                    <a
                        class="fh-page-link block px-4 py-2.5 rounded-xl text-sm transition-all active:scale-[0.99] {{ $isCurrent ? 'font-semibold bg-[#DCFCE7] text-[#15803D]' : 'font-medium text-[#4B5563] hover:bg-[#F3F4F6] hover:text-[#111827]' }}"
                        href="{{ $item['href'] }}"
                        @if ($isCurrent) aria-current="page" @endif
                    >{{ $item['label'] }}</a>
                @endforeach
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

        <!-- PAGE CONTENT WITH SMOOTH PAGE TRANSITION -->
        <main class="fh-page-stage flex-1 w-full bg-surface" id="konten-utama">
            {{ $slot }}
        </main>

        <!-- GLOBAL FOOTER -->
        <footer class="w-full bg-primary-container text-inverse-on-surface pt-space-xl pb-space-lg mt-space-xl">
            <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-space-xl">
                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Pelanggan</h3>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('public.layanan') }}">Kategori Layanan</a>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('public.teknisi') }}">Daftar Teknisi</a>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('public.cara-kerja') }}">Cara Pemesanan &amp; Biaya</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ $techniciansUrl }}">Mulai Pesan Sekarang</a>
                    </div>

                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Mitra Teknisi</h3>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('public.jadi-mitra') }}">Gabung Jadi Mitra</a>
                        <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('register') }}">Daftar Akun Teknisi</a>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('public.cara-kerja') }}">Komisi Transparan (5%)</a>
                    </div>

                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Akun</h3>
                        @auth
                            <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ $dashboardUrl }}">Dashboard Saya</a>
                        @else
                            <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('login') }}">Masuk</a>
                            <a class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('register') }}">Daftar Gratis</a>
                        @endauth
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors" href="{{ route('public.tentang-kami') }}">Tentang Kami</a>
                    </div>

                    <div class="flex flex-col gap-space-sm">
                        <h3 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Kontak &amp; Bantuan</h3>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs" href="{{ route('public.cara-kerja') }}">
                            <span class="material-symbols-outlined text-[16px]">chat</span>
                            Live Chat di Aplikasi
                        </a>
                        <a class="fh-page-link font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs" href="{{ route('public.tentang-kami') }}">
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

    <!-- Mobile Bottom Navigation -->
    <nav aria-label="Navigasi Bawah" class="sm:hidden fixed bottom-0 inset-x-0 z-40 px-2 py-1.5 bg-white/95 backdrop-blur-md border-t border-[#E5E7EB] shadow-[0_-4px_14px_rgba(17,24,39,0.06)]">
        <div class="grid grid-cols-4 gap-1.5 h-14">
            <a class="fh-page-link flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 {{ $activeNav === 'beranda' ? 'bg-[#DCFCE7] text-[#15803D] font-bold' : 'text-[#4B5563]' }}" href="{{ route('splash') }}">
                <span class="material-symbols-outlined text-[20px] mb-0.5">home</span>
                <span>Beranda</span>
            </a>
            <a class="fh-page-link flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 {{ $activeNav === 'layanan' ? 'bg-[#DCFCE7] text-[#15803D] font-bold' : 'text-[#4B5563]' }}" href="{{ route('public.layanan') }}">
                <span class="material-symbols-outlined text-[20px] mb-0.5">home_repair_service</span>
                <span>Layanan</span>
            </a>
            <a class="fh-page-link flex flex-col items-center justify-center min-h-[44px] rounded-2xl text-xs transition-all active:scale-95 {{ $activeNav === 'teknisi' ? 'bg-[#DCFCE7] text-[#15803D] font-bold' : 'text-[#4B5563]' }}" href="{{ route('public.teknisi') }}">
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
