@props([
    'title' => 'Masuk — FixHome',
    'noScroll' => false,
])
<!DOCTYPE html>
<html lang="id" class="{{ $noScroll ? 'h-dvh overflow-hidden' : 'h-full scroll-smooth' }} bg-[#F8FAFC]">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#16A34A" />
    <link href="{{ asset('images/fixhome-icon.png') }}" rel="icon" type="image/png" />
    <title>{{ $title }}</title>

    <!-- Fonts: Plus Jakarta Sans + Inter + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />

    @vite(['resources/css/landing.css'])
</head>
<body class="{{ $noScroll ? 'h-dvh overflow-hidden' : 'min-h-screen overflow-x-hidden' }} bg-[#F8FAFC] font-body-md text-[#111827] antialiased flex flex-col justify-between relative">

    <!-- Minimal Standalone Top Bar (Only Back to Home) -->
    <div class="w-full max-w-[960px] mx-auto px-4 sm:px-6 {{ $noScroll ? 'pt-4' : 'pt-5 sm:pt-7' }} flex items-center justify-between shrink-0">
        <a href="{{ route('splash') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-[#E5E7EB] text-[12.5px] font-semibold text-[#374151] hover:text-[#15803D] hover:border-[#16A34A] shadow-xs transition-all">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('splash') }}" class="inline-flex items-center lg:hidden">
            <img alt="FixHome" class="h-7 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
        </a>
    </div>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div id="flash-banner" class="max-w-[920px] mx-auto w-full px-4 sm:px-6 pt-4">
            <div class="rounded-xl bg-[#F0FDF4] border border-[#BBF7D0] text-[#15803D] text-xs font-semibold px-4 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#16A34A] text-[18px] shrink-0">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-banner').remove()" class="text-[#15803D]/70 hover:text-[#15803D] text-base font-bold px-1">&times;</button>
            </div>
        </div>
    @endif

    @if($errors->any() && !request()->routeIs('login'))
        <div id="error-banner" class="max-w-[920px] mx-auto w-full px-4 sm:px-6 pt-4">
            <div class="rounded-xl bg-[#FEF2F2] border border-[#FECACA] text-[#991B1B] text-xs font-semibold px-4 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#EF4444] text-[18px] shrink-0">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
                <button type="button" onclick="document.getElementById('error-banner').remove()" class="text-[#991B1B]/70 hover:text-[#991B1B] text-base font-bold px-1">&times;</button>
            </div>
        </div>
    @endif

    <!-- Standalone Centered Content -->
    <main class="flex-1 min-h-0 flex items-center justify-center w-full">
        {{ $slot }}
    </main>

    <!-- Minimal Standalone Copyright -->
    <div class="w-full text-center {{ $noScroll ? 'py-3' : 'py-5' }} px-4 text-[11.5px] text-[#9CA3AF] shrink-0">
        &copy; {{ date('Y') }} FixHome Indonesia &middot; Layanan Perbaikan Rumah Terverifikasi
    </div>

    @stack('scripts')
</body>
</html>
