<!DOCTYPE html>
<html lang="id" class="h-full bg-surface scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="{{ asset('images/fixhome-icon.png') }}" rel="icon" type="image/png" />
    <title>{{ $title ?? 'FixHome' }} — Solusi Perbaikan Rumah Bergaransi</title>

    <!-- Fonts: Plus Jakarta Sans (Headings) + Inter (Body & UI) + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />

    <!-- Compiled FixHome Tailwind CSS (No CDN) -->
    @vite(['resources/css/landing.css'])

    <!-- Leaflet CSS & JS for Interactive Map (Pinned with SRI) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body class="min-h-screen bg-surface font-body-md text-on-surface antialiased flex flex-col justify-between relative overflow-x-hidden">

    <!-- DESKTOP FLOATING PILL NAVBAR (Harmonized with Multi-Page Public Header) -->
    <header class="hidden lg:block fixed top-4 left-0 right-0 z-50 px-6 pointer-events-none">
        <div class="pointer-events-auto max-w-[1140px] mx-auto h-14 px-5 rounded-full bg-white/95 backdrop-blur-md border border-white/80 shadow-[0_6px_28px_rgba(17,24,39,0.08)] flex items-center justify-between gap-4">

            <!-- Brand Logo -->
            <a aria-label="Beranda FixHome" href="{{ Auth::check() ? (Auth::user()->isAdmin() ? url('/admin') : (Auth::user()->isTeknisi() ? route('teknisi.dashboard') : route('customer.home'))) : route('splash') }}" class="flex items-center shrink-0 group">
                <img alt="FixHome" class="h-[30px] w-auto object-contain group-hover:opacity-90 transition-opacity" src="{{ asset('images/fixhome-logo-full.png') }}" />
            </a>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-1">
                @auth
                    @if(Auth::user()->role === 'teknisi')
                        <a href="{{ route('teknisi.dashboard') }}" class="font-body-md text-[13px] py-1.5 px-3.5 rounded-full transition-all {{ request()->routeIs('teknisi.dashboard') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6]' }}">
                            Dashboard Teknisi
                        </a>
                        <a href="{{ route('teknisi.wallet') }}" class="font-body-md text-[13px] py-1.5 px-3.5 rounded-full transition-all {{ request()->routeIs('teknisi.wallet') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6]' }}">
                            Dompet Pendapatan
                        </a>
                    @else
                        <a href="{{ route('customer.home') }}" class="font-body-md text-[13px] py-1.5 px-3.5 rounded-full transition-all {{ request()->routeIs('customer.home') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6]' }}">
                            Beranda
                        </a>
                        <a href="{{ route('customer.technicians') }}" class="font-body-md text-[13px] py-1.5 px-3.5 rounded-full transition-all {{ request()->routeIs('customer.technicians*') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6]' }}">
                            Cari Teknisi
                        </a>
                        <a href="{{ route('customer.orders') }}" class="font-body-md text-[13px] py-1.5 px-3.5 rounded-full transition-all {{ request()->routeIs('customer.orders') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6]' }}">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('customer.profile') }}" class="font-body-md text-[13px] py-1.5 px-3.5 rounded-full transition-all {{ request()->routeIs('customer.profile') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6]' }}">
                            Profil
                        </a>
                    @endif
                @else
                    <a href="{{ route('splash') }}" class="font-body-md text-[13px] text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] rounded-full transition-all py-1.5 px-3.5">Beranda</a>
                    <a href="{{ route('public.layanan') }}" class="font-body-md text-[13px] text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] rounded-full transition-all py-1.5 px-3.5">Layanan</a>
                    <a href="{{ route('public.teknisi') }}" class="font-body-md text-[13px] text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] rounded-full transition-all py-1.5 px-3.5">Teknisi</a>
                    <a href="{{ route('public.cara-kerja') }}" class="font-body-md text-[13px] text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] rounded-full transition-all py-1.5 px-3.5">Cara Kerja</a>
                    <a href="{{ route('public.jadi-mitra') }}" class="font-body-md text-[13px] text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] rounded-full transition-all py-1.5 px-3.5">Jadi Mitra</a>
                    <a href="{{ route('public.tentang-kami') }}" class="font-body-md text-[13px] text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] rounded-full transition-all py-1.5 px-3.5">Tentang Kami</a>
                @endauth
            </nav>

            <!-- Right Actions / Profile -->
            <div class="flex items-center gap-2.5">
                @auth
                    @if(Auth::user()->role === 'customer' && Auth::user()->customer)
                        <!-- Address Pill -->
                        <a href="{{ route('customer.set-address') }}" class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#F8FAFC] border border-[#E5E7EB] text-xs text-[#374151] hover:border-[#16A34A] transition-all max-w-[220px]" title="Ubah Alamat Rumah">
                            <span class="material-symbols-outlined text-[#16A34A] text-[15px] shrink-0">location_on</span>
                            <span class="truncate font-medium">{{ Auth::user()->customer->alamat_lengkap ?? 'Atur Alamat' }}</span>
                            <span class="text-[10px] font-bold text-[#15803D] bg-[#DCFCE7] px-1.5 py-0.5 rounded-full shrink-0">Ubah</span>
                        </a>
                    @endif

                    <div class="flex items-center gap-2.5 pl-2.5 border-l border-[#E5E7EB]">
                        <div class="text-right">
                            <span class="text-xs font-bold text-[#111827] block leading-tight">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-label-sm font-semibold text-[#15803D] uppercase tracking-wider">{{ Auth::user()->role }}</span>
                        </div>
                        <a href="{{ Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.profile') }}" class="w-8 h-8 rounded-full bg-[#16A34A] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-8 h-8 rounded-full bg-white border border-[#E5E7EB] flex items-center justify-center text-[#4B5563] hover:text-[#EF4444] hover:border-[#FCA5A5] transition-all" title="Keluar (Logout)">
                                <span class="material-symbols-outlined text-[16px]">logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center font-label-lg text-[13px] rounded-full px-4 py-1.5 transition-all {{ request()->routeIs('login') ? 'bg-[#DCFCE7] text-[#15803D] font-semibold' : 'text-[#15803D] bg-white border border-[#E5E7EB] hover:bg-[#F0FDF4] hover:border-[#16A34A]' }}">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center font-label-lg text-[13px] text-white bg-[#16A34A] hover:bg-[#15803D] rounded-full px-4 py-1.5 shadow-[0_3px_10px_rgba(22,163,74,0.24)] transition-all">
                        Daftar
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- MAIN RESPONSIVE CONTAINER -->
    <div class="w-full flex-1 flex flex-col justify-between relative z-10 lg:pt-20">

        <!-- Flash Alert Notifications -->
        @if(session('success'))
            <div id="flash-banner" class="max-w-md lg:max-w-4xl mx-auto w-full px-4 pt-4 z-40">
                <div class="neu-card-sm bg-secondary-container/90 text-on-secondary-fixed text-xs font-semibold px-5 py-3.5 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('flash-banner').remove()" class="text-on-secondary-container hover:text-primary text-base font-bold px-1">&times;</button>
                </div>
            </div>
        @endif

        @if($errors->any() && !request()->routeIs('login'))
            <div id="error-banner" class="max-w-md lg:max-w-4xl mx-auto w-full px-4 pt-4 z-40">
                <div class="neu-card-sm bg-error-container text-on-error-container text-xs font-semibold px-5 py-3.5 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-error text-[20px] shrink-0">error</span>
                        <span>{{ $errors->first() }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('error-banner').remove()" class="text-on-error-container/70 hover:text-on-error-container text-base font-bold px-1">&times;</button>
                </div>
            </div>
        @endif

        <!-- Slot Content -->
        <main class="flex-1 flex flex-col w-full">
            {{ $slot }}
        </main>

    </div>

    <!-- DESKTOP FOOTER (Clean, matching Multi-Page Public Footer) -->
    <footer class="hidden lg:block w-full bg-primary-container text-inverse-on-surface pt-space-xl pb-space-lg mt-space-xl relative z-10">
        <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
            <div class="grid grid-cols-4 gap-gutter mb-space-xl">
                <div class="flex flex-col gap-space-sm">
                    <div class="inline-flex items-center rounded-xl bg-surface px-3 py-1.5 mb-space-xs w-fit">
                        <img alt="FixHome" class="h-7 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </div>
                    <p class="font-body-sm text-body-sm text-inverse-on-surface/80 leading-relaxed">
                        Platform booking jasa perbaikan rumah terdekat dengan tarif terbuka, live chat, dan garansi resmi 14 hari.
                    </p>
                </div>

                <div class="flex flex-col gap-space-sm">
                    <h4 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Layanan Perbaikan</h4>
                    <a href="{{ route('public.layanan', ['kategori' => 'ac-pendingin']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Perawatan &amp; Cuci AC</a>
                    <a href="{{ route('public.layanan', ['kategori' => 'listrik']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Instalasi &amp; Reparasi Listrik</a>
                    <a href="{{ route('public.layanan', ['kategori' => 'pipa-air']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Perbaikan Pipa &amp; Sanitasi</a>
                    <a href="{{ route('public.layanan', ['kategori' => 'atap-plafon']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Perbaikan Atap &amp; Plafon</a>
                </div>

                <div class="flex flex-col gap-space-sm">
                    <h4 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Navigasi</h4>
                    <a href="{{ route('splash') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Beranda</a>
                    <a href="{{ route('public.layanan') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Layanan</a>
                    <a href="{{ route('public.teknisi') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Teknisi</a>
                    <a href="{{ route('public.cara-kerja') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Cara Kerja</a>
                    <a href="{{ route('public.tentang-kami') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Tentang Kami</a>
                </div>

                <div class="flex flex-col gap-space-sm">
                    <h4 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs">Kontak &amp; Bantuan</h4>
                    <a href="{{ route('public.cara-kerja') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-[16px]">chat</span>
                        <span>Live Chat di Aplikasi</span>
                    </a>
                    <a href="{{ route('public.tentang-kami') }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-[16px]">support_agent</span>
                        <span>Bantuan 24/7</span>
                    </a>
                    <span class="font-body-sm text-body-sm text-tertiary-fixed/85 mt-1">Wilayah operasional: Jabodetabek</span>
                </div>
            </div>

            <div class="pt-space-lg flex items-center justify-between text-inverse-on-surface/75 border-t border-inverse-on-surface/15">
                <p class="font-body-sm text-body-sm">&copy; {{ date('Y') }} FixHome Indonesia. Solusi Perbaikan Rumah Terpercaya.</p>
                <div class="flex items-center gap-space-sm font-label-sm text-label-sm text-tertiary-fixed">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Garansi Resmi &amp; Teknisi Terverifikasi</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
