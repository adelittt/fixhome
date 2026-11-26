<x-layouts.public
    activeNav="layanan"
    description="Daftar lengkap layanan perbaikan rumah FixHome: pipa & saluran air, instalasi listrik, perawatan AC, atap & plafon, pengecatan, dan deep cleaning terverifikasi."
    title="Layanan Perbaikan Rumah — FixHome"
>
    <!-- Page Hero Header -->
    <section class="relative w-full bg-gradient-to-b from-[#F0FDF4] via-white to-white pt-28 pb-10 border-b border-[#E5E7EB]/60">
        <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
            <div class="max-w-2xl">
                <span class="fh-hero-anim inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-md text-[12px] font-semibold" data-hero-step="1">
                    <span class="material-symbols-outlined text-[15px]">home_repair_service</span>
                    Katalog Layanan Resmi FixHome
                </span>
                <h1 class="fh-hero-anim font-headline-xl text-[28px] sm:text-[36px] leading-[1.16] font-extrabold tracking-[-0.03em] text-[#111827] mt-3.5" data-hero-step="2">
                    Semua Kebutuhan <span class="text-[#16A34A]">Perbaikan Rumah</span> dalam Satu Platform
                </h1>
                <p class="fh-hero-anim font-body-lg text-[14.5px] text-[#4B5563] mt-3" data-hero-step="3">
                    Pilih layanan yang Anda perlukan. Setiap pengerjaan dilengkapi estimasi tarif dasar transparan dan diskusi langsung dengan teknisi terverifikasi.
                </p>
            </div>

            <!-- Quick Filter Pills -->
            <div class="fh-hero-anim mt-6 flex flex-wrap items-center gap-2" data-hero-step="4">
                <a class="px-3.5 py-1.5 rounded-full text-[12.5px] font-semibold transition-all {{ !$activeSlug ? 'bg-[#16A34A] text-white shadow-sm' : 'bg-white border border-[#E5E7EB] text-[#4B5563] hover:border-[#16A34A] hover:text-[#15803D]' }}" href="{{ route('public.layanan') }}">
                    Semua Layanan ({{ count($services) }})
                </a>
                @foreach ($services as $svc)
                    <a class="px-3.5 py-1.5 rounded-full text-[12.5px] font-semibold transition-all {{ $activeSlug === $svc['slug'] ? 'bg-[#16A34A] text-white shadow-sm' : 'bg-white border border-[#E5E7EB] text-[#4B5563] hover:border-[#16A34A] hover:text-[#15803D]' }}" href="{{ route('public.layanan', ['kategori' => $svc['slug']]) }}">
                        {{ $svc['title'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Detailed Service Cards with Photos -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-10" data-reveal>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $svc)
                @if (!$activeSlug || $activeSlug === $svc['slug'])
                    <article class="stitch-surface-card group rounded-[22px] overflow-hidden bg-white flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 {{ $activeSlug === $svc['slug'] ? 'md:col-span-2 lg:col-span-3 md:grid md:grid-cols-12' : '' }}">
                        <!-- Service Photo -->
                        <div class="relative overflow-hidden bg-[#F3F4F6] {{ $activeSlug === $svc['slug'] ? 'md:col-span-5 h-56 md:h-full' : 'w-full h-44' }}">
                            <img
                                alt="{{ $svc['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                                src="{{ asset($svc['image']) }}"
                            />
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-white/95 backdrop-blur-sm text-[11px] font-semibold text-[#15803D] shadow-sm">
                                {{ $svc['count'] }}
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 flex flex-col justify-between gap-4 {{ $activeSlug === $svc['slug'] ? 'md:col-span-7 sm:p-6' : 'flex-1' }}">
                            <div>
                                <div class="flex items-center gap-2 text-[11.5px] text-[#4B5563] mb-1.5">
                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <span class="material-symbols-outlined text-[14px] text-[#CA8A04]">schedule</span>
                                        {{ $svc['duration'] }}
                                    </span>
                                    <span>&middot;</span>
                                    <span class="inline-flex items-center gap-1 font-medium text-[#15803D]">
                                        <span class="material-symbols-outlined text-[14px]">verified_user</span>
                                        Teknisi Terverifikasi
                                    </span>
                                </div>

                                <h2 class="font-headline-sm text-[17px] font-bold text-[#111827]">{{ $svc['title'] }}</h2>
                                <p class="font-body-md text-[13px] leading-[1.55] text-[#4B5563] mt-1.5">{{ $svc['desc'] }}</p>

                                <!-- Scope of Work Checklist -->
                                <div class="mt-3.5 p-3.5 rounded-2xl bg-[#F8FAFC] border border-[#E5E7EB]/80">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280] mb-2">Cakupan Pekerjaan</p>
                                    <ul class="space-y-1.5">
                                        @foreach ($svc['includes'] as $item)
                                            <li class="flex items-start gap-2 text-[12.5px] text-[#374151]">
                                                <span class="material-symbols-outlined text-[15px] text-[#16A34A] shrink-0 mt-0.5">check_circle</span>
                                                <span>{{ $item }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-[#E5E7EB]/70 flex items-center justify-between gap-2">
                                <div>
                                    <span class="block text-[10.5px] text-[#6B7280]">Tarif dasar</span>
                                    <span class="text-[15px] font-extrabold text-[#16A34A]">{{ $svc['price'] }}</span>
                                </div>
                                <a
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[12.5px] font-semibold shadow-sm active:scale-95 transition-all"
                                    href="{{ route('customer.technicians', array_filter(['category' => $svc['category']])) }}"
                                >
                                    <span>Pesan</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pb-8" data-reveal>
        <div class="stitch-surface-card rounded-[24px] p-6 sm:p-8 bg-[#F0FDF4] border border-[#BBF7D0] flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-headline-md text-[20px] font-bold text-[#111827]">Masih ragu jenis kerusakan di rumah Anda?</h3>
                <p class="font-body-md text-[13.5px] text-[#4B5563] mt-1">Lihat daftar teknisi siap kerja dan konsultasikan langsung lewat fitur Live Chat sebelum pengerjaan dimulai.</p>
            </div>
            <div class="flex items-center gap-2.5 shrink-0">
                <a class="fh-page-link px-5 py-2.5 rounded-full bg-white border border-[#D1D5DB] text-[#111827] text-[13px] font-semibold hover:border-[#16A34A] transition-all" href="{{ route('public.cara-kerja') }}">Lihat Cara Kerja</a>
                <a class="fh-page-link px-5 py-2.5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13px] font-semibold shadow-sm transition-all" href="{{ route('public.teknisi') }}">Lihat Teknisi</a>
            </div>
        </div>
    </section>
</x-layouts.public>
