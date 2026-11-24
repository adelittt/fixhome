<!DOCTYPE html>
<html lang="id" class="h-full bg-surface scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{ $title ?? 'FixHome' }} — Solusi Perbaikan Rumah Bergaransi</title>

    <!-- Google Fonts matching FixHome Landing Page -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@100..900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Fraunces:ital,opsz,wght@0,9..144,400..800;1,9..144,400..800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet" />

    <!-- Compiled FixHome Tailwind CSS (No CDN) -->
    @vite(['resources/css/landing.css'])

    <!-- Leaflet CSS & JS for Interactive Map (Pinned with SRI) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body class="min-h-screen bg-surface font-body-md text-on-surface antialiased flex flex-col justify-between relative overflow-x-hidden">

    <!-- Ambient Decorative Light Wells (matching Landing Page) -->
    <div class="pointer-events-none fixed inset-x-0 top-0 max-w-[1280px] mx-auto overflow-hidden h-96 z-0">
        <div class="absolute -top-32 -left-20 w-96 h-96 rounded-full bg-secondary-container/35 blur-3xl"></div>
        <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-tertiary-fixed/25 blur-3xl"></div>
    </div>

    <!-- DESKTOP TOP NAVBAR -->
    <header class="hidden lg:block sticky top-0 z-50 bg-surface/90 backdrop-blur-md px-gutter lg:px-margin">
        <div class="max-w-[1280px] mx-auto h-20 flex items-center justify-between gap-gutter">

            <!-- Brand Logo -->
            <a href="{{ Auth::check() ? (Auth::user()->isAdmin() ? url('/admin') : (Auth::user()->isTeknisi() ? route('teknisi.dashboard') : route('customer.home'))) : route('splash') }}" class="flex items-center gap-space-md group">
                <img alt="FixHome Logo" class="h-9 w-9 rounded-lg object-contain mix-blend-multiply group-hover:scale-105 transition-transform" src="{{ asset('images/fixhome-logo.jpg') }}" />
                <div>
                    <span class="font-headline-sm text-headline-sm text-primary-container tracking-tight font-recoleta block leading-none">FixHome</span>
                    <span class="text-[10px] text-on-surface-variant font-label-sm tracking-wide block mt-0.5">Solusi Perbaikan Rumah</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-space-lg">
                @auth
                    @if(Auth::user()->role === 'teknisi')
                        <a href="{{ route('teknisi.dashboard') }}" class="font-body-md text-body-md py-space-xs px-space-sm transition-colors {{ request()->routeIs('teknisi.dashboard') ? 'text-primary-container font-bold' : 'text-on-surface-variant hover:text-primary' }}">
                            Dashboard Teknisi
                        </a>
                        <a href="{{ route('teknisi.wallet') }}" class="font-body-md text-body-md py-space-xs px-space-sm transition-colors {{ request()->routeIs('teknisi.wallet') ? 'text-primary-container font-bold' : 'text-on-surface-variant hover:text-primary' }}">
                            Dompet Pendapatan (95%)
                        </a>
                    @else
                        <a href="{{ route('customer.home') }}" class="font-body-md text-body-md py-space-xs px-space-sm transition-colors {{ request()->routeIs('customer.home') ? 'text-primary-container font-bold' : 'text-on-surface-variant hover:text-primary' }}">
                            Beranda
                        </a>
                        <a href="{{ route('customer.technicians') }}" class="font-body-md text-body-md py-space-xs px-space-sm transition-colors {{ request()->routeIs('customer.technicians*') ? 'text-primary-container font-bold' : 'text-on-surface-variant hover:text-primary' }}">
                            Cari Teknisi
                        </a>
                        <a href="{{ route('customer.orders') }}" class="font-body-md text-body-md py-space-xs px-space-sm transition-colors {{ request()->routeIs('customer.orders') ? 'text-primary-container font-bold' : 'text-on-surface-variant hover:text-primary' }}">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('customer.profile') }}" class="font-body-md text-body-md py-space-xs px-space-sm transition-colors {{ request()->routeIs('customer.profile') ? 'text-primary-container font-bold' : 'text-on-surface-variant hover:text-primary' }}">
                            Profil
                        </a>
                    @endif
                @else
                    <a href="{{ route('splash') }}" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors py-space-xs px-space-sm">Beranda</a>
                    <a href="{{ route('splash') }}#layanan" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors py-space-xs px-space-sm">Layanan</a>
                    <a href="{{ route('splash') }}#cara-kerja" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors py-space-xs px-space-sm">Cara Kerja</a>
                    <a href="{{ route('splash') }}#keunggulan" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors py-space-xs px-space-sm">Keunggulan</a>
                @endauth
            </nav>

            <!-- Right Actions / Profile -->
            <div class="flex items-center gap-space-md">
                @auth
                    @if(Auth::user()->role === 'customer' && Auth::user()->customer)
                        <!-- Address Pill (BR-01) -->
                        <a href="{{ route('customer.set-address') }}" class="neu-inset-sm flex items-center gap-2 px-3.5 py-1.5 text-xs text-on-surface hover:text-primary transition-all max-w-[260px]" title="Ubah Alamat Rumah">
                            <span class="material-symbols-outlined text-primary text-[16px] shrink-0">location_on</span>
                            <span class="truncate font-medium">{{ Auth::user()->customer->alamat_lengkap ?? 'Atur Alamat' }}</span>
                            <span class="text-[10px] font-bold text-primary bg-secondary-container px-2 py-0.5 rounded-full shrink-0">Ubah</span>
                        </a>
                    @endif

                    <div class="flex items-center gap-3 pl-3 border-l border-outline-variant/50">
                        <div class="text-right">
                            <span class="text-xs font-bold text-primary block leading-tight">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-label-sm font-semibold text-secondary uppercase tracking-wider">{{ Auth::user()->role }}</span>
                        </div>
                        <a href="{{ Auth::user()->role === 'teknisi' ? route('teknisi.dashboard') : route('customer.profile') }}" class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-9 h-9 rounded-full neu-btn-secondary text-on-surface-variant hover:text-error" title="Keluar (Logout)">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="neu-btn-secondary px-space-lg py-space-sm text-label-lg text-primary-container">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="neu-btn-primary px-space-lg py-space-sm text-label-lg">
                        Daftar
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- MAIN RESPONSIVE CONTAINER -->
    <div class="w-full flex-1 flex flex-col justify-between relative z-10">

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

    <!-- DESKTOP FOOTER (Matching Landing Page) -->
    <footer class="hidden lg:block w-full bg-primary-container text-inverse-on-surface pt-space-xl pb-space-lg mt-space-xl relative z-10">
        <div class="max-w-[1280px] mx-auto px-gutter lg:px-margin">
            <div class="grid grid-cols-4 gap-gutter mb-space-xl">
                <div class="flex flex-col gap-space-sm">
                    <div class="flex items-center gap-2.5 mb-space-xs">
                        <img alt="FixHome Logo" class="h-8 w-8 rounded-lg object-contain bg-surface p-0.5" src="{{ asset('images/fixhome-logo.jpg') }}" />
                        <span class="font-title-md text-title-md text-tertiary-fixed font-semibold font-recoleta">FixHome</span>
                    </div>
                    <p class="font-body-sm text-body-sm text-inverse-on-surface/80 leading-relaxed">
                        Platform booking jasa perbaikan rumah berbasis radius geospasial terdekat dengan skema bagi hasil transparan: 95% teknisi &amp; 5% operasional platform.
                    </p>
                </div>

                <div class="flex flex-col gap-space-sm">
                    <h4 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Layanan Perbaikan</h4>
                    <a href="{{ route('customer.technicians', ['category' => 'AC & Pendingin']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Perawatan &amp; Cuci AC</a>
                    <a href="{{ route('customer.technicians', ['category' => 'Instalasi Listrik']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Instalasi &amp; Reparasi Listrik</a>
                    <a href="{{ route('customer.technicians', ['category' => 'Pipa & Saluran Air']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Perbaikan Pipa &amp; Sanitasi</a>
                    <a href="{{ route('customer.technicians', ['category' => 'Atap & Plafon Bocor']) }}" class="font-body-sm text-body-sm text-inverse-on-surface/80 hover:text-inverse-on-surface transition-colors">Perbaikan Atap &amp; Plafon</a>
                </div>

                <div class="flex flex-col gap-space-sm">
                    <h4 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Garansi &amp; Mutu</h4>
                    <span class="font-body-sm text-body-sm text-inverse-on-surface/80"><strong class="text-tertiary-fixed">BR-01:</strong> Wajib Pin Alamat Utama</span>
                    <span class="font-body-sm text-body-sm text-inverse-on-surface/80"><strong class="text-tertiary-fixed">BR-02:</strong> Filter Radius Teknisi Ready</span>
                    <span class="font-body-sm text-body-sm text-inverse-on-surface/80"><strong class="text-tertiary-fixed">BR-03:</strong> Chat Terbuka Pasca Bayar</span>
                    <span class="font-body-sm text-body-sm text-inverse-on-surface/80"><strong class="text-tertiary-fixed">BR-04:</strong> Bagi Hasil 95% / 5% Otomatis</span>
                </div>

                <div class="flex flex-col gap-space-sm">
                    <h4 class="font-title-md text-title-md text-tertiary-fixed font-semibold mb-space-xs font-recoleta">Akses Cepat Demo</h4>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('quick-login', 'customer@fixhome.com') }}" class="px-3.5 py-2 bg-surface/15 hover:bg-surface/25 text-inverse-on-surface rounded-full text-xs font-semibold transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-[15px] text-tertiary-fixed">person</span>
                            <span>Masuk Sebagai Customer</span>
                        </a>
                        <a href="{{ route('quick-login', 'budi.teknisi@fixhome.com') }}" class="px-3.5 py-2 bg-surface/15 hover:bg-surface/25 text-inverse-on-surface rounded-full text-xs font-semibold transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-[15px] text-tertiary-fixed">engineering</span>
                            <span>Masuk Sebagai Teknisi</span>
                        </a>
                        <a href="{{ route('quick-login', 'admin@fixhome.com') }}" class="px-3.5 py-2 bg-surface/15 hover:bg-surface/25 text-inverse-on-surface rounded-full text-xs font-semibold transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-[15px] text-tertiary-fixed">admin_panel_settings</span>
                            <span>Admin Panel (Filament)</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-space-lg flex items-center justify-between text-inverse-on-surface/75 border-t border-inverse-on-surface/15">
                <p class="font-body-sm text-body-sm">&copy; 2025 FixHome Indonesia. Layanan Booking Jasa Perbaikan Rumah Bergaransi.</p>
                <div class="flex items-center gap-space-sm font-label-sm text-label-sm text-tertiary-fixed">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Garansi Resmi &amp; Teknisi Terverifikasi</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Quick Demo Switcher Bar (Harmonized Warm Espresso Theme) -->
    <div class="w-full bg-primary text-inverse-on-surface py-2.5 px-4 text-xs flex flex-wrap items-center justify-between gap-2 z-40 border-t border-inverse-on-surface/10 relative">
        <span class="text-on-primary-container font-medium flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[15px] text-tertiary-fixed">bolt</span>
            <span>Beralih Cepat (Quick Demo):</span>
        </span>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('quick-login', 'customer@fixhome.com') }}" class="px-3 py-1 bg-secondary-container text-on-secondary-fixed hover:opacity-90 rounded-full text-[11px] font-bold transition-all">Customer</a>
            <a href="{{ route('quick-login', 'baru@fixhome.com') }}" class="px-3 py-1 bg-tertiary-fixed text-on-tertiary-fixed hover:opacity-90 rounded-full text-[11px] font-bold transition-all">Customer Baru (BR-01)</a>
            <a href="{{ route('quick-login', 'budi.teknisi@fixhome.com') }}" class="px-3 py-1 bg-primary-fixed text-on-primary-fixed hover:opacity-90 rounded-full text-[11px] font-bold transition-all">Teknisi Mitra</a>
            <a href="{{ route('quick-login', 'admin@fixhome.com') }}" class="px-3 py-1 bg-surface/15 hover:bg-surface/25 text-inverse-on-surface rounded-full text-[11px] font-bold transition-all border border-inverse-on-surface/20">Admin Panel</a>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
