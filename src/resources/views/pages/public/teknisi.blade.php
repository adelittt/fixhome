<x-layouts.public
    activeNav="teknisi"
    description="Jelajahi katalog teknisi perbaikan rumah terverifikasi FixHome yang siap kerja. Bandingkan keahlian, rating, dan tarif dasar secara transparan."
    title="Daftar Teknisi Terverifikasi — FixHome"
>
    <!-- Page Hero Header -->
    <section class="relative w-full bg-gradient-to-b from-[#F0FDF4] via-white to-white pt-28 pb-10 border-b border-[#E5E7EB]/60">
        <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
            <div class="max-w-2xl">
                <span class="fh-hero-anim inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-md text-[12px] font-semibold" data-hero-step="1">
                    <span class="material-symbols-outlined text-[15px]">engineering</span>
                    Mitra Teknisi Terverifikasi
                </span>
                <h1 class="fh-hero-anim font-headline-xl text-[28px] sm:text-[36px] leading-[1.16] font-extrabold tracking-[-0.03em] text-[#111827] mt-3.5" data-hero-step="2">
                    Temukan <span class="text-[#16A34A]">Teknisi Ahli</span> yang Siap Meluncur Hari Ini
                </h1>
                <p class="fh-hero-anim font-body-lg text-[14.5px] text-[#4B5563] mt-3" data-hero-step="3">
                    Setiap mitra teknisi telah melewati verifikasi KTP, uji kompetensi keahlian, dan disetujui langsung oleh tim Admin FixHome.
                </p>
            </div>

            <!-- Category Filter Chips -->
            <div class="fh-hero-anim mt-6 flex flex-wrap items-center gap-2" data-hero-step="4">
                <a class="px-3.5 py-1.5 rounded-full text-[12.5px] font-semibold transition-all {{ !$selectedCategory ? 'bg-[#16A34A] text-white shadow-sm' : 'bg-white border border-[#E5E7EB] text-[#4B5563] hover:border-[#16A34A] hover:text-[#15803D]' }}" href="{{ route('public.teknisi') }}">
                    Semua Keahlian
                </a>
                @foreach ($services as $svc)
                    @if ($svc['category'])
                        <a class="px-3.5 py-1.5 rounded-full text-[12.5px] font-semibold transition-all {{ $selectedCategory === $svc['category'] ? 'bg-[#16A34A] text-white shadow-sm' : 'bg-white border border-[#E5E7EB] text-[#4B5563] hover:border-[#16A34A] hover:text-[#15803D]' }}" href="{{ route('public.teknisi', ['category' => $svc['category']]) }}">
                            {{ $svc['category'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Technicians Grid -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-10" data-reveal>
        @if ($technicians->isEmpty())
            <div class="stitch-surface-card rounded-[22px] p-10 bg-white text-center">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[24px]">engineering</span>
                </div>
                <h2 class="font-headline-sm text-[18px] font-bold text-[#111827]">Belum ada teknisi untuk filter ini</h2>
                <p class="font-body-md text-[13.5px] text-[#4B5563] mt-1 mb-5">Coba tampilkan semua keahlian atau masuk ke akun Anda untuk mencari teknisi terdekat.</p>
                <a class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13px] font-semibold transition-all" href="{{ route('public.teknisi') }}">
                    Tampilkan Semua Teknisi
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($technicians as $tech)
                    @php
                        $skills = array_values(array_filter(array_map('trim', explode(',', (string) $tech->keahlian))));
                        $initials = collect(explode(' ', (string) $tech->nama_lengkap))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
                    @endphp
                    <div class="stitch-surface-card rounded-[20px] p-5 bg-white flex flex-col justify-between gap-4 transition-all hover:-translate-y-1">
                        <div>
                            <div class="flex items-start justify-between gap-2.5 mb-3.5">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center font-bold text-[16px] shrink-0">
                                        {{ $initials ?: 'T' }}
                                    </div>
                                    <div class="min-w-0">
                                        <h2 class="font-title-md text-[15.5px] font-bold text-[#111827] truncate">{{ $tech->nama_lengkap }}</h2>
                                        <span class="inline-flex items-center gap-1 text-[12px] text-[#4B5563]">
                                            <span class="material-symbols-outlined text-[15px] text-[#FACC15]" style="font-variation-settings: 'FILL' 1;">star</span>
                                            <strong class="text-[#111827]">{{ number_format((float) ($tech->rating ?: 4.9), 1) }}</strong>
                                            &middot; Terverifikasi
                                        </span>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[11px] font-semibold text-[#15803D] shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span> Siap
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-1.5">
                                @foreach (array_slice($skills ?: ['Teknisi Umum'], 0, 4) as $skill)
                                    <span class="px-2.5 py-1 rounded-full bg-[#F8FAFC] border border-[#E5E7EB] text-[11.5px] font-medium text-[#374151]">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-3 border-t border-[#E5E7EB]/70 flex items-center justify-between gap-2">
                            <div>
                                <span class="block text-[11px] text-[#6B7280]">Tarif dasar</span>
                                <span class="text-[16px] font-extrabold text-[#111827]">Rp{{ number_format((float) ($tech->tarif_dasar ?: 50000), 0, ',', '.') }}</span>
                            </div>
                            <a
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[12.5px] font-semibold shadow-sm active:scale-95 transition-all"
                                href="{{ Auth::check() && Auth::user()->role === 'customer' ? route('customer.technician-detail', $tech->id) : route('login') }}"
                            >
                                <span>Pesan</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Verification Standard Strip -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pb-8" data-reveal>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stitch-surface-card rounded-[18px] p-5 bg-white">
                <span class="material-symbols-outlined text-[#16A34A] text-[22px]">badge</span>
                <h3 class="font-title-sm font-bold text-[#111827] mt-2">Verifikasi Identitas KTP</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Data diri setiap mitra diverifikasi manual oleh Admin FixHome sebelum akun diaktifkan.</p>
            </div>
            <div class="stitch-surface-card rounded-[18px] p-5 bg-white">
                <span class="material-symbols-outlined text-[#16A34A] text-[22px]">workspace_premium</span>
                <h3 class="font-title-sm font-bold text-[#111827] mt-2">Standar Kompetensi &amp; Rating</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Setiap ulasan pelanggan memengaruhi rating teknisi secara transparan dan real-time.</p>
            </div>
            <div class="stitch-surface-card rounded-[18px] p-5 bg-white">
                <span class="material-symbols-outlined text-[#16A34A] text-[22px]">location_on</span>
                <h3 class="font-title-sm font-bold text-[#111827] mt-2">Pelacakan Posisi Langsung</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Pantau status kedatangan teknisi (OTW → Dikerjakan → Selesai) langsung di aplikasi.</p>
            </div>
        </div>
    </section>
</x-layouts.public>
