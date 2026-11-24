<!DOCTYPE html>
<html class="scroll-smooth" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Pesan teknisi perbaikan rumah terverifikasi untuk AC, listrik, pipa, atap, hingga pengecatan. Tarif dasar terbuka, biaya jarak Rp0 di bawah 10 km, dan garansi resmi 14 hari." name="description" />
    <meta content="#775537" name="theme-color" />
    <link href="{{ asset('images/fixhome-icon.png') }}" rel="icon" type="image/png" />
    <title>FixHome — Jasa Perbaikan Rumah Terverifikasi &amp; Bergaransi</title>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,300..500,0..1,0&display=swap" rel="stylesheet" />

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

    $services = [
        [
            'num' => '01',
            'title' => 'Perawatan & Cuci AC',
            'scope' => 'Cuci indoor/outdoor, isi freon R32/R410A, atasi AC menetes, bongkar pasang.',
            'price' => 'Rp65.000',
            'base_num' => 65000,
            'icon' => 'ac_unit',
            'url' => route('customer.technicians', ['category' => 'AC & Pendingin']),
        ],
        [
            'num' => '02',
            'title' => 'Perbaikan Pipa & Sanitasi',
            'scope' => 'Pipa bocor, saluran mampet, pasang toren air, kloset, dan pompa booster.',
            'price' => 'Rp75.000',
            'base_num' => 75000,
            'icon' => 'plumbing',
            'url' => route('customer.technicians', ['category' => 'Pipa & Saluran Air']),
        ],
        [
            'num' => '03',
            'title' => 'Instalasi & Reparasi Listrik',
            'scope' => 'Penanganan korsleting, tambah titik lampu/stopkontak, panel MCB, grounding.',
            'price' => 'Rp85.000',
            'base_num' => 85000,
            'icon' => 'electric_bolt',
            'url' => route('customer.technicians', ['category' => 'Instalasi Listrik']),
        ],
        [
            'num' => '04',
            'title' => 'Pengecatan & Dinding',
            'scope' => 'Cat interior kamar, fasad eksterior, waterproofing rembesan, perapian plamir.',
            'price' => 'Rp90.000',
            'base_num' => 90000,
            'icon' => 'format_paint',
            'url' => route('customer.technicians', ['category' => 'Pengecatan & Tembok']),
        ],
        [
            'num' => '05',
            'title' => 'Perbaikan Atap & Plafon',
            'scope' => 'Atap bocor, ganti genteng retak, tambal plafon gypsum, pembersihan talang.',
            'price' => 'Rp120.000',
            'base_num' => 120000,
            'icon' => 'roofing',
            'url' => route('customer.technicians', ['category' => 'Atap & Plafon Bocor']),
        ],
        [
            'num' => '06',
            'title' => 'Kebersihan & Deep Cleaning',
            'scope' => 'Kuras kerak toren air, vakum tungau kasur/sofa, pembersihan pasca renovasi.',
            'price' => 'Rp50.000',
            'base_num' => 50000,
            'icon' => 'cleaning_services',
            'url' => route('customer.technicians'),
        ],
    ];
@endphp
<body class="fh-editorial bg-[#F9F9F9] text-[#1A1C1C] antialiased min-h-screen flex flex-col">

    <a class="fh-skip" href="#konten-utama">Lewati ke konten utama</a>

    <!-- HEADER: quiet, architectural, restrained -->
    <header class="sticky top-0 z-50 bg-[#F9F9F9]/92 backdrop-blur-md border-b border-[#E7E0D8]">
        <div class="max-w-[1220px] mx-auto px-5 sm:px-8 h-[72px] flex items-center justify-between gap-6">
            <a aria-label="Beranda FixHome" class="inline-flex items-center min-h-[44px] shrink-0" href="{{ route('splash') }}">
                <img alt="FixHome" class="h-8 sm:h-9 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
            </a>

            <nav aria-label="Navigasi utama" class="hidden md:flex items-center gap-8">
                <a class="fh-link text-[14px] font-medium text-[#50453C] hover:text-[#1A1C1C] py-2" href="#layanan">Layanan</a>
                <a class="fh-link text-[14px] font-medium text-[#50453C] hover:text-[#1A1C1C] py-2" href="#cara-kerja">Cara Kerja</a>
                <a class="fh-link text-[14px] font-medium text-[#50453C] hover:text-[#1A1C1C] py-2" href="#tarif-garansi">Tarif &amp; Garansi</a>
                <a class="fh-link text-[14px] font-medium text-[#50453C] hover:text-[#1A1C1C] py-2" href="#mitra">Gabung Mitra</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a class="fh-btn-solid h-10 px-4 text-[14px]" href="{{ $dashboardUrl }}">Dashboard</a>
                    <a aria-label="Profil {{ Auth::user()->name }}" class="w-10 h-10 rounded-lg bg-[#5D3E22] text-[#FAE19C] text-[13px] font-bold inline-flex items-center justify-center shrink-0" href="{{ $dashboardUrl }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </a>
                @else
                    <a class="hidden sm:inline-flex items-center min-h-[44px] px-3 text-[14px] font-semibold text-[#5D3E22] hover:text-[#775537] transition-colors" href="{{ route('login') }}">
                        Masuk
                    </a>
                    <a class="fh-btn-solid h-10 px-4 sm:px-5 text-[14px]" href="{{ route('register') }}">
                        Daftar
                    </a>
                @endauth

                <button
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                    aria-label="Buka menu navigasi"
                    class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-[#DDD4CA] bg-white text-[#5D3E22]"
                    id="mobile-menu-toggle"
                    type="button"
                >
                    <span aria-hidden="true" class="material-symbols-outlined text-[22px]" id="mobile-menu-icon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden fixed inset-0 top-[72px] z-40 bg-[#F9F9F9] border-t border-[#E7E0D8] overflow-y-auto" id="mobile-menu">
            <div class="max-w-[1220px] mx-auto px-5 py-8 flex flex-col justify-between min-h-[calc(100svh-72px)]">
                <nav class="flex flex-col divide-y divide-[#EAE2DA]">
                    <a class="mobile-nav-link py-4 flex items-center justify-between fh-serif text-[24px] font-semibold text-[#1A1C1C]" href="#layanan">
                        <span>Layanan</span>
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px] text-[#775537]">arrow_forward</span>
                    </a>
                    <a class="mobile-nav-link py-4 flex items-center justify-between fh-serif text-[24px] font-semibold text-[#1A1C1C]" href="#cara-kerja">
                        <span>Cara Kerja</span>
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px] text-[#775537]">arrow_forward</span>
                    </a>
                    <a class="mobile-nav-link py-4 flex items-center justify-between fh-serif text-[24px] font-semibold text-[#1A1C1C]" href="#tarif-garansi">
                        <span>Tarif &amp; Garansi</span>
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px] text-[#775537]">arrow_forward</span>
                    </a>
                    <a class="mobile-nav-link py-4 flex items-center justify-between fh-serif text-[24px] font-semibold text-[#1A1C1C]" href="#mitra">
                        <span>Gabung Mitra</span>
                        <span aria-hidden="true" class="material-symbols-outlined text-[20px] text-[#775537]">arrow_forward</span>
                    </a>
                </nav>

                @guest
                    <div class="pt-8 flex flex-col gap-3">
                        <a class="fh-btn-solid w-full h-12 text-[15px]" href="{{ route('register') }}">Daftar Gratis</a>
                        <a class="fh-btn-outline w-full h-12 text-[15px]" href="{{ route('login') }}">Masuk ke Akun</a>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <main class="flex-1 w-full" id="konten-utama">

        <!-- 1. HERO: Architectural Full-Width Canvas honoring the FixHome illustration + Docked Booking Bar -->
        <section class="w-full pt-5 sm:pt-7 pb-16 lg:pb-24" id="beranda">
            <div class="max-w-[1220px] mx-auto px-5 sm:px-8">
                <!-- Framed Hero Artwork -->
                <div class="relative rounded-[24px] sm:rounded-[28px] overflow-hidden border border-[#E5DDD4] bg-[#F7F3ED]">
                    <!-- Crisp Hero Banner Image (no heavy milky veil, houses stay vibrant on left/right) -->
                    <div class="relative min-h-[380px] sm:min-h-[440px] lg:min-h-[500px] flex flex-col items-center justify-start pt-10 sm:pt-14 lg:pt-16 pb-28 sm:pb-32 px-5 sm:px-10 text-center">
                        <img
                            alt="Ilustrasi hunian dan peralatan perbaikan rumah FixHome"
                            class="absolute inset-0 w-full h-full object-cover object-bottom pointer-events-none select-none"
                            src="{{ asset('images/fixhome-hero-banner.jpg') }}"
                        />
                        <!-- Soft radial sky clarity behind headline ONLY, leaving houses crisp -->
                        <div aria-hidden="true" class="fh-hero-sky absolute inset-0 pointer-events-none"></div>

                        <div class="relative z-10 max-w-[660px] mx-auto">
                            <h1 class="fh-serif text-[34px] sm:text-[46px] lg:text-[54px] font-semibold text-[#5D3E22] leading-[1.09] tracking-[-0.025em]">
                                Perbaikan rumah yang rapi, jelas biayanya.
                            </h1>
                            <p class="mt-4 text-[15px] sm:text-[16.5px] text-[#50453C] leading-[1.65] max-w-[520px] mx-auto">
                                Pesan teknisi terverifikasi untuk AC, pipa, listrik, hingga atap. Konsultasi langsung via live chat dengan garansi resmi 14 hari.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Docked Search / Quick-Booking Bar (real product utility, overlapping cleanly) -->
                <div class="relative z-20 -mt-12 sm:-mt-10 max-w-[860px] mx-auto px-2 sm:px-0">
                    <form
                        action="{{ route('customer.technicians') }}"
                        class="bg-white rounded-2xl border border-[#DDD3C8] shadow-[0_14px_34px_rgba(93,62,34,0.09)] p-2 sm:p-2.5 flex flex-col md:flex-row items-stretch md:items-center gap-2"
                        id="hero-search-form"
                        method="GET"
                    >
                        <div class="flex-1 relative flex items-center px-3 py-1.5 rounded-xl hover:bg-[#F9F9F9] transition-colors">
                            <span aria-hidden="true" class="material-symbols-outlined text-[#775537] text-[21px] mr-3 shrink-0">home_repair_service</span>
                            <div class="flex-1 min-w-0">
                                <label class="block text-[11px] font-semibold uppercase tracking-[0.06em] text-[#4C6264]" for="hero-category-select">Jenis Layanan</label>
                                <select
                                    class="w-full bg-transparent text-[14.5px] font-semibold text-[#1A1C1C] focus:outline-none appearance-none cursor-pointer pr-6 mt-0.5"
                                    id="hero-category-select"
                                    name="category"
                                >
                                    <option selected="" value="">Semua keahlian teknisi</option>
                                    <option value="AC & Pendingin">Perawatan &amp; Cuci AC</option>
                                    <option value="Pipa & Saluran Air">Perbaikan Pipa &amp; Sanitasi</option>
                                    <option value="Instalasi Listrik">Instalasi &amp; Reparasi Listrik</option>
                                    <option value="Pengecatan & Tembok">Pengecatan &amp; Dinding</option>
                                    <option value="Atap & Plafon Bocor">Perbaikan Atap &amp; Plafon</option>
                                    <option value="">Kebersihan &amp; Deep Cleaning</option>
                                </select>
                            </div>
                            <span aria-hidden="true" class="material-symbols-outlined text-[#50453C] text-[20px] pointer-events-none">expand_more</span>
                        </div>

                        <div aria-hidden="true" class="hidden md:block w-px h-9 bg-[#EAE2DA]"></div>

                        <div class="flex items-center px-3 py-1.5 md:w-[240px] shrink-0">
                            <span aria-hidden="true" class="material-symbols-outlined text-[#4C6264] text-[20px] mr-3 shrink-0">near_me</span>
                            <div class="min-w-0">
                                <span class="block text-[11px] font-semibold uppercase tracking-[0.06em] text-[#4C6264]">Biaya Jarak</span>
                                <span class="block text-[13.5px] font-semibold text-[#1A1C1C] truncate mt-0.5">Rp0 di bawah 10 km</span>
                            </div>
                        </div>

                        <button class="fh-btn-solid h-12 px-6 text-[14.5px] shrink-0" type="submit">
                            <span>Cari Teknisi</span>
                            <span aria-hidden="true" class="material-symbols-outlined text-[18px] fh-arrow">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Quiet Quick-Access Category Links -->
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-[13px] text-[#50453C]">
                        <span class="text-[#82756B]">Sering dicari:</span>
                        <a class="fh-quick-link" href="{{ route('customer.technicians', ['category' => 'AC & Pendingin']) }}">Cuci AC</a>
                        <a class="fh-quick-link" href="{{ route('customer.technicians', ['category' => 'Pipa & Saluran Air']) }}">Pipa Bocor</a>
                        <a class="fh-quick-link" href="{{ route('customer.technicians', ['category' => 'Instalasi Listrik']) }}">Listrik &amp; MCB</a>
                        <a class="fh-quick-link" href="{{ route('customer.technicians', ['category' => 'Atap & Plafon Bocor']) }}">Atap Bocor</a>
                        <a class="fh-quick-link" href="{{ route('customer.technicians', ['category' => 'Pengecatan & Tembok']) }}">Cat Dinding</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. LAYANAN: Editorial Directory List (NOT a generic 3x2 card grid) -->
        <section class="w-full py-16 lg:py-24 bg-white border-y border-[#E7E0D8] scroll-mt-20" id="layanan">
            <div class="max-w-[1220px] mx-auto px-5 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Sticky Left Intro + Brand 3D House Illustration -->
                    <div class="lg:col-span-4 lg:sticky lg:top-28">
                        <p class="text-[12px] font-bold uppercase tracking-[0.1em] text-[#4C6264]">Daftar Layanan</p>
                        <h2 class="fh-serif mt-2.5 text-[30px] sm:text-[36px] font-semibold text-[#1A1C1C] leading-[1.15] tracking-[-0.02em]">
                            Enam bidang perbaikan, tarif dasar di depan.
                        </h2>
                        <p class="mt-3.5 text-[15px] text-[#50453C] leading-[1.7]">
                            Pilih kategori sesuai kendala rumah Anda. Seluruh mitra memiliki tarif dasar terbuka dan sertifikasi sesuai bidangnya.
                        </p>

                        <div class="mt-8 rounded-2xl overflow-hidden border border-[#EAE2DA] bg-[#FAF8F5] hidden lg:block">
                            <img
                                alt="Visual kategori perbaikan rumah FixHome"
                                class="w-full aspect-square object-contain p-5"
                                src="{{ asset('images/fixhome-hero-3d.jpg') }}"
                            />
                        </div>
                    </div>

                    <!-- Right Hairline Editorial Service Rows -->
                    <div class="lg:col-span-8">
                        <div class="border-t border-[#E5DDD5] divide-y divide-[#E5DDD5]">
                            @foreach ($services as $service)
                                <a
                                    class="fh-service-row group py-5 sm:py-6 px-3 -mx-3 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-[#F9F7F4] transition-colors"
                                    href="{{ $service['url'] }}"
                                >
                                    <div class="flex items-start gap-4 sm:gap-5 min-w-0">
                                        <span class="text-[12px] font-bold text-[#82756B] tabular-nums pt-1 w-6 shrink-0">{{ $service['num'] }}</span>
                                        <span aria-hidden="true" class="material-symbols-outlined text-[22px] text-[#775537] pt-0.5 shrink-0">{{ $service['icon'] }}</span>
                                        <div class="min-w-0">
                                            <h3 class="text-[17px] sm:text-[18px] font-bold text-[#1A1C1C] group-hover:text-[#5D3E22] transition-colors">
                                                {{ $service['title'] }}
                                            </h3>
                                            <p class="mt-1 text-[14px] text-[#50453C] leading-[1.6]">
                                                {{ $service['scope'] }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end gap-4 pl-10 sm:pl-4 shrink-0">
                                        <div class="text-left sm:text-right">
                                            <span class="block text-[11px] font-medium text-[#82756B]">Mulai dari</span>
                                            <span class="block text-[15px] font-bold text-[#5D3E22] tabular-nums">{{ $service['price'] }}</span>
                                        </div>
                                        <span class="w-9 h-9 rounded-full border border-[#DDD3C8] group-hover:border-[#775537] group-hover:bg-[#775537] group-hover:text-white text-[#5D3E22] inline-flex items-center justify-center transition-colors shrink-0">
                                            <span aria-hidden="true" class="material-symbols-outlined text-[18px] fh-arrow">arrow_forward</span>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-[13.5px] text-[#50453C]">
                            <p>Tarif dasar mencakup inspeksi dan jasa pengerjaan standar SNI. Suku cadang disepakati lewat live chat sebelum pengerjaan.</p>
                            <a class="inline-flex items-center gap-1.5 font-semibold text-[#775537] hover:text-[#5D3E22] shrink-0" href="{{ route('customer.technicians') }}">
                                <span>Semua teknisi</span>
                                <span aria-hidden="true" class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. CARA KERJA: Warm Sand Editorial Band with Top-Rule Columns (no boxed clutter) -->
        <section class="w-full py-16 lg:py-24 bg-[#F3ECE4] border-b border-[#E5DACD] scroll-mt-20" id="cara-kerja">
            <div class="max-w-[1220px] mx-auto px-5 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end mb-12 lg:mb-14">
                    <div class="lg:col-span-7">
                        <p class="text-[12px] font-bold uppercase tracking-[0.1em] text-[#775537]">Cara Kerja</p>
                        <h2 class="fh-serif mt-2.5 text-[30px] sm:text-[38px] font-semibold text-[#5D3E22] leading-[1.13] tracking-[-0.02em]">
                            Dari pesan sampai beres, semua tercatat rapi.
                        </h2>
                    </div>
                    <p class="lg:col-span-5 text-[15px] text-[#50453C] leading-[1.7]">
                        Tidak perlu menebak harga atau menunggu tanpa kabar. Setiap tahapan order terpantau langsung dari akun Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
                    <div class="pt-6 border-t-2 border-[#775537]">
                        <div class="flex items-center justify-between mb-4">
                            <span class="fh-serif text-[28px] font-semibold text-[#775537] leading-none">01</span>
                            <span class="text-[12px] font-semibold text-[#4C6264] bg-[#CCE4E6]/75 px-2.5 py-1 rounded-md">2 menit</span>
                        </div>
                        <h3 class="text-[18px] font-bold text-[#1A1C1C]">Pilih teknisi &amp; jadwal</h3>
                        <p class="mt-2.5 text-[14.5px] text-[#50453C] leading-[1.7]">
                            Atur titik lokasi rumah, bandingkan keahlian serta tarif dasar teknisi terdekat dalam radius 35 km, lalu tentukan jadwal kunjungan.
                        </p>
                    </div>

                    <div class="pt-6 border-t-2 border-[#4C6264]">
                        <div class="flex items-center justify-between mb-4">
                            <span class="fh-serif text-[28px] font-semibold text-[#4C6264] leading-none">02</span>
                            <span class="text-[12px] font-semibold text-[#5D3E22] bg-[#FAE19C]/80 px-2.5 py-1 rounded-md">Real-time</span>
                        </div>
                        <h3 class="text-[18px] font-bold text-[#1A1C1C]">Konsultasi &amp; pantau GPS</h3>
                        <p class="mt-2.5 text-[14.5px] text-[#50453C] leading-[1.7]">
                            Begitu pembayaran diverifikasi, ruang live chat dua arah dan pelacakan rute jalan teknisi menuju alamat Anda langsung terbuka.
                        </p>
                    </div>

                    <div class="pt-6 border-t-2 border-[#5D3E22]">
                        <div class="flex items-center justify-between mb-4">
                            <span class="fh-serif text-[28px] font-semibold text-[#5D3E22] leading-none">03</span>
                            <span class="text-[12px] font-semibold text-[#5D3E22] bg-white border border-[#DFD3C6] px-2.5 py-1 rounded-md">14 hari</span>
                        </div>
                        <h3 class="text-[18px] font-bold text-[#1A1C1C]">Selesai &amp; bergaransi resmi</h3>
                        <p class="mt-2.5 text-[14.5px] text-[#50453C] leading-[1.7]">
                            Setelah pengerjaan tuntas, beri penilaian untuk teknisi. Jika kendala serupa muncul dalam 14 hari, perbaikan ulang tidak dipungut biaya.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. TARIF, KOMISI & GARANSI: Spec Sheet + Interactive Distance Calculator (real FixHome business logic) -->
        <section class="w-full py-16 lg:py-24 bg-[#F9F9F9] border-b border-[#E7E0D8] scroll-mt-20" id="tarif-garansi">
            <div class="max-w-[1220px] mx-auto px-5 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Left: Architectural Spec List -->
                    <div class="lg:col-span-7">
                        <p class="text-[12px] font-bold uppercase tracking-[0.1em] text-[#4C6264]">Transparansi &amp; Standar</p>
                        <h2 class="fh-serif mt-2.5 text-[30px] sm:text-[38px] font-semibold text-[#1A1C1C] leading-[1.15] tracking-[-0.02em]">
                            Aturan biaya yang adil bagi pemilik rumah dan teknisi.
                        </h2>

                        <dl class="mt-9 border-t border-[#E5DDD5] divide-y divide-[#E5DDD5]">
                            <div class="py-5 grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-6">
                                <dt class="sm:col-span-4 text-[14.5px] font-bold text-[#5D3E22]">Verifikasi Mitra</dt>
                                <dd class="sm:col-span-8 text-[14.5px] text-[#50453C] leading-[1.65]">
                                    Setiap teknisi wajib lolos verifikasi KTP, SKCK, dan sertifikasi kompetensi lapangan oleh Admin FixHome sebelum aktif menerima pesanan.
                                </dd>
                            </div>
                            <div class="py-5 grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-6">
                                <dt class="sm:col-span-4 text-[14.5px] font-bold text-[#5D3E22]">Biaya Jarak Tetap</dt>
                                <dd class="sm:col-span-8 text-[14.5px] text-[#50453C] leading-[1.65]">
                                    Gratis (<strong class="text-[#1A1C1C]">Rp0</strong>) untuk jarak di bawah <strong class="text-[#1A1C1C]">10 km</strong>. Tarif flat <strong class="text-[#1A1C1C]">Rp10.000</strong> untuk jarak operasional 10–35 km.
                                </dd>
                            </div>
                            <div class="py-5 grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-6">
                                <dt class="sm:col-span-4 text-[14.5px] font-bold text-[#5D3E22]">Komisi Terbuka 5%</dt>
                                <dd class="sm:col-span-8 text-[14.5px] text-[#50453C] leading-[1.65]">
                                    <strong class="text-[#1A1C1C]">95%</strong> pembayaran langsung masuk ke dompet teknisi, sementara <strong class="text-[#1A1C1C]">5%</strong> menopang verifikasi mitra dan sistem garansi.
                                </dd>
                            </div>
                            <div class="py-5 grid grid-cols-1 sm:grid-cols-12 gap-2 sm:gap-6">
                                <dt class="sm:col-span-4 text-[14.5px] font-bold text-[#5D3E22]">Garansi 14 Hari</dt>
                                <dd class="sm:col-span-8 text-[14.5px] text-[#50453C] leading-[1.65]">
                                    Perbaikan ulang tanpa biaya tambahan bila masalah serupa terjadi kembali dalam 14 hari sejak pesanan ditandai selesai.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Right: Interactive Pricing Rule Simulator -->
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-2xl border border-[#DDD3C8] p-6 sm:p-7">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-[16px] font-bold text-[#1A1C1C]">Simulasi Rincian Biaya</h3>
                                <span class="text-[12px] font-semibold text-[#5D3E22] bg-[#FAE19C]/80 px-2.5 py-1 rounded-md">Garansi 14 Hari</span>
                            </div>
                            <p class="mt-1 text-[13px] text-[#50453C]">Uji perhitungan tarif dan komisi otomatis FixHome.</p>

                            <!-- Service selector -->
                            <div class="mt-5">
                                <label class="block text-[12px] font-semibold text-[#50453C] mb-1.5" for="calc-service">Layanan</label>
                                <div class="relative">
                                    <select class="w-full h-11 pl-3.5 pr-9 rounded-lg border border-[#DCD2C7] bg-[#F9F9F9] text-[14px] font-semibold text-[#1A1C1C] appearance-none cursor-pointer" id="calc-service">
                                        @foreach ($services as $svc)
                                            <option value="{{ $svc['base_num'] }}" {{ $loop->index === 1 ? 'selected' : '' }}>
                                                {{ $svc['title'] }} ({{ $svc['price'] }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span aria-hidden="true" class="material-symbols-outlined text-[#50453C] text-[19px] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">expand_more</span>
                                </div>
                            </div>

                            <!-- Distance toggle -->
                            <div class="mt-4">
                                <span class="block text-[12px] font-semibold text-[#50453C] mb-1.5">Jarak Teknisi ke Rumah</span>
                                <div class="grid grid-cols-2 gap-2 p-1 rounded-lg bg-[#F3EFEA] border border-[#E5DDD5]" role="group" aria-label="Pilih jarak teknisi">
                                    <button class="calc-dist-btn is-active h-9 rounded-md text-[13px] font-semibold transition-colors" data-distance="near" type="button">
                                        &lt; 10 km (Gratis)
                                    </button>
                                    <button class="calc-dist-btn h-9 rounded-md text-[13px] font-semibold transition-colors" data-distance="far" type="button">
                                        10–35 km (+Rp10rb)
                                    </button>
                                </div>
                            </div>

                            <!-- Breakdown -->
                            <dl class="mt-5 pt-4 border-t border-[#ECE4DC] space-y-2.5 text-[14px]">
                                <div class="flex items-center justify-between">
                                    <dt class="text-[#50453C]">Tarif dasar layanan</dt>
                                    <dd class="font-semibold text-[#1A1C1C] tabular-nums" id="calc-base">Rp75.000</dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-[#50453C]">Biaya jarak operasional</dt>
                                    <dd class="font-semibold text-[#4C6264] tabular-nums" id="calc-distance">Rp0</dd>
                                </div>
                                <div class="flex items-center justify-between pt-3 border-t border-[#ECE4DC]">
                                    <dt class="font-bold text-[#1A1C1C]">Total dibayar</dt>
                                    <dd class="text-[20px] font-extrabold text-[#5D3E22] tabular-nums" id="calc-total">Rp75.000</dd>
                                </div>
                            </dl>

                            <!-- Split bar -->
                            <div class="mt-4 p-3.5 rounded-xl bg-[#F9F7F4] border border-[#EAE2DA] text-[12.5px] text-[#50453C] flex items-center justify-between gap-2">
                                <span>Hak teknisi (95%): <strong class="text-[#1A1C1C] tabular-nums" id="calc-tech">Rp71.250</strong></span>
                                <span>Platform (5%): <strong class="text-[#5D3E22] tabular-nums" id="calc-fee">Rp3.750</strong></span>
                            </div>

                            <a class="fh-btn-solid mt-5 w-full h-11 text-[14px]" href="{{ $bookingCtaUrl }}">
                                <span>Jadwalkan Teknisi</span>
                                <span aria-hidden="true" class="material-symbols-outlined text-[18px] fh-arrow">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. CLOSING INVITATION -->
        <section class="w-full py-16 lg:py-20 bg-[#F9F9F9] scroll-mt-20" id="mitra">
            <div class="max-w-[1220px] mx-auto px-5 sm:px-8">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                    <div class="max-w-xl">
                        <p class="text-[12px] font-bold uppercase tracking-[0.1em] text-[#775537]">Mulai Sekarang</p>
                        <h2 class="fh-serif mt-2.5 text-[30px] sm:text-[40px] font-semibold text-[#1A1C1C] leading-[1.12] tracking-[-0.02em]">
                            Rumah butuh perbaikan hari ini, atau ingin bergabung sebagai teknisi?
                        </h2>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                        <a class="fh-btn-solid h-12 px-6 text-[14.5px]" href="{{ $bookingCtaUrl }}">
                            <span>Pesan Teknisi</span>
                            <span aria-hidden="true" class="material-symbols-outlined text-[18px] fh-arrow">arrow_forward</span>
                        </a>
                        <a class="fh-btn-outline h-12 px-6 text-[14.5px]" href="{{ route('register', ['role' => 'teknisi']) }}">
                            Daftar Jadi Teknisi
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER: Rich Espresso Brand Ground -->
    <footer class="w-full bg-[#5D3E22] text-[#EFE7DF]">
        <div class="max-w-[1220px] mx-auto px-5 sm:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-10 border-b border-white/15">
                <div class="lg:col-span-4">
                    <a aria-label="Beranda FixHome" class="inline-flex items-center rounded-xl bg-white px-3.5 py-2 w-fit" href="{{ route('splash') }}">
                        <img alt="FixHome" class="h-7 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </a>
                    <p class="mt-3 text-[14px] text-[#E4D9CE] leading-[1.65] max-w-xs">
                        Platform booking jasa perbaikan rumah terverifikasi dengan biaya transparan, live chat, pelacakan GPS, dan garansi resmi 14 hari.
                    </p>
                </div>

                <div class="lg:col-span-3 flex flex-col gap-2">
                    <h3 class="text-[12px] font-bold uppercase tracking-[0.08em] text-[#FAE19C] mb-1">Pelanggan</h3>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="{{ $bookingCtaUrl }}">Cari Teknisi</a>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="#layanan">Daftar Layanan</a>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="#cara-kerja">Cara Kerja</a>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="#tarif-garansi">Tarif &amp; Garansi</a>
                </div>

                <div class="lg:col-span-3 flex flex-col gap-2">
                    <h3 class="text-[12px] font-bold uppercase tracking-[0.08em] text-[#FAE19C] mb-1">Mitra Teknisi</h3>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="{{ route('register', ['role' => 'teknisi']) }}">Daftar Jadi Teknisi</a>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="#tarif-garansi">Verifikasi KTP &amp; SKCK</a>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="#tarif-garansi">Komisi 5% Transparan</a>
                </div>

                <div class="lg:col-span-2 flex flex-col gap-2">
                    <h3 class="text-[12px] font-bold uppercase tracking-[0.08em] text-[#FAE19C] mb-1">Akun</h3>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="{{ route('login') }}">Masuk</a>
                    <a class="text-[14px] text-[#E4D9CE] hover:text-white transition-colors w-fit py-1" href="{{ route('register') }}">Buat Akun</a>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-[13px] text-[#DACFC4]">
                <p>&copy; {{ date('Y') }} FixHome Indonesia. Layanan perbaikan rumah bergaransi.</p>
                <p class="text-[#FAE19C] font-medium">Garansi Resmi 14 Hari · Teknisi Terverifikasi</p>
            </div>
        </div>
    </footer>

</body>
</html>
