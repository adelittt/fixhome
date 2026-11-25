<x-layouts.public
    activeNav="jadi-mitra"
    description="Bergabunglah sebagai Mitra Teknisi FixHome. Nikmati 95% pendapatan bersih, komisi platform transparan 5%, jadwal kerja fleksibel, dan jangkauan pelanggan Jabodetabek."
    title="Jadi Mitra Teknisi — FixHome"
>
    <!-- Page Hero Header -->
    <section class="relative w-full bg-gradient-to-b from-[#F0FDF4] via-white to-white pt-28 pb-10 border-b border-[#E5E7EB]/60">
        <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7">
                    <span class="fh-hero-anim inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-md text-[12px] font-semibold" data-hero-step="1">
                        <span class="material-symbols-outlined text-[15px]">handshake</span>
                        Kemitraan Teknisi FixHome
                    </span>
                    <h1 class="fh-hero-anim font-headline-xl text-[28px] sm:text-[36px] leading-[1.16] font-extrabold tracking-[-0.03em] text-[#111827] mt-3.5" data-hero-step="2">
                        Punya Keahlian Pertukangan? <span class="text-[#16A34A]">Dapatkan Order Rutin</span> Setiap Hari
                    </h1>
                    <p class="fh-hero-anim font-body-lg text-[14.5px] text-[#4B5563] mt-3 max-w-xl" data-hero-step="3">
                        Bergabung dengan jaringan teknisi profesional FixHome. Atur jadwal kerja secara fleksibel dan nikmati pembagian hasil adil 95% untuk teknisi.
                    </p>
                    <div class="fh-hero-anim mt-6 flex flex-wrap items-center gap-3" data-hero-step="4">
                        <a class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13.5px] font-semibold shadow-[0_6px_18px_rgba(22,163,74,0.26)] active:scale-95 transition-all" href="{{ route('register') }}">
                            <span>Daftar Jadi Mitra Sekarang</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                        <a class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-white border border-[#D1D5DB] text-[#111827] text-[13.5px] font-semibold hover:border-[#16A34A] transition-all" href="{{ route('login') }}">
                            Sudah Punya Akun? Masuk
                        </a>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="lg:col-span-5">
                    <div class="fh-hero-anim stitch-surface-card rounded-[24px] p-6 bg-white space-y-4" data-hero-step="5">
                        <h2 class="font-headline-sm text-[17px] font-bold text-[#111827]">Keuntungan Mitra FixHome</h2>
                        <ul class="space-y-3 text-[13.5px] text-[#374151]">
                            <li class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[#16A34A] text-[19px] shrink-0">check_circle</span>
                                <span><strong>95% Pendapatan Bersih</strong> langsung masuk ke dompet mitra (komisi platform flat 5%).</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[#16A34A] text-[19px] shrink-0">check_circle</span>
                                <span><strong>Toggle Status Fleksibel</strong> — aktifkan mode <em>Siap</em> kapan pun Anda ingin menerima pesanan.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[#16A34A] text-[19px] shrink-0">check_circle</span>
                                <span><strong>Live Chat &amp; Peta Rute</strong> langsung ke lokasi pelanggan tanpa ribet.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[#16A34A] text-[19px] shrink-0">check_circle</span>
                                <span><strong>Pembayaran Non-Tunai Terjamin</strong> lewat QRIS sebelum pekerjaan dimulai.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements & Onboarding Steps -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-10" data-reveal>
        <div class="max-w-xl mb-6">
            <h2 class="font-headline-lg text-[24px] font-bold text-[#111827]">Alur Pendaftaran &amp; Verifikasi Mitra</h2>
            <p class="text-[13.5px] text-[#4B5563] mt-1">Proses cepat dan transparan — begitu disetujui Admin, akun Anda langsung tampil di katalog pelanggan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="stitch-surface-card rounded-[20px] p-5 bg-white">
                <span class="inline-flex w-9 h-9 rounded-full bg-[#DCFCE7] text-[#15803D] items-center justify-center font-extrabold text-[14px]">1</span>
                <h3 class="font-title-md text-[15.5px] font-bold text-[#111827] mt-3">Buat Akun Teknisi</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Daftar di halaman registrasi, pilih peran <strong>Mitra Teknisi</strong>, isi daftar keahlian dan tarif dasar Anda.</p>
            </div>
            <div class="stitch-surface-card rounded-[20px] p-5 bg-white">
                <span class="inline-flex w-9 h-9 rounded-full bg-[#FEF9C3] text-[#854D0E] items-center justify-center font-extrabold text-[14px]">2</span>
                <h3 class="font-title-md text-[15.5px] font-bold text-[#111827] mt-3">Verifikasi oleh Admin</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Tim Admin FixHome meninjau profil &amp; keahlian Anda untuk menjaga standar keamanan dan kualitas layanan.</p>
            </div>
            <div class="stitch-surface-card rounded-[20px] p-5 bg-white">
                <span class="inline-flex w-9 h-9 rounded-full bg-[#16A34A] text-white items-center justify-center font-extrabold text-[14px]">3</span>
                <h3 class="font-title-md text-[15.5px] font-bold text-[#111827] mt-3">Aktif &amp; Terima Order</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Setelah disetujui, status Anda otomatis menjadi <strong>Terverifikasi</strong> dan siap menerima pesanan di wilayah sekitar.</p>
            </div>
        </div>
    </section>

    <!-- Open Skill Categories -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pb-8" data-reveal>
        <div class="stitch-surface-card rounded-[24px] p-6 sm:p-8 bg-white">
            <h2 class="font-headline-sm text-[18px] font-bold text-[#111827]">Keahlian yang Sedang Dibutuhkan</h2>
            <p class="text-[13.5px] text-[#4B5563] mt-1">Kami membuka pendaftaran untuk seluruh bidang perbaikan dan perawatan rumah berikut:</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
                @foreach ($services as $svc)
                    <div class="group rounded-[18px] overflow-hidden bg-white border border-[#E5E7EB] hover:border-[#16A34A] transition-all">
                        <div class="h-32 overflow-hidden bg-[#F3F4F6]">
                            <img alt="{{ $svc['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" src="{{ asset($svc['image']) }}" />
                        </div>
                        <div class="p-3.5">
                            <p class="text-[14px] font-bold text-[#111827] truncate">{{ $svc['title'] }}</p>
                            <p class="text-[12px] text-[#4B5563] mt-0.5 line-clamp-2">{{ $svc['desc'] }}</p>
                            <p class="text-[12px] font-bold text-[#16A34A] mt-2">{{ $svc['price'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
