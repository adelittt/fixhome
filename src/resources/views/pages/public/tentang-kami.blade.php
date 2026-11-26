<x-layouts.public
    activeNav="tentang-kami"
    description="Kenali FixHome — platform layanan perbaikan rumah terverifikasi dan transparan yang beroperasi di wilayah Jabodetabek."
    title="Tentang Kami — FixHome"
>
    <!-- Page Hero Header -->
    <section class="relative w-full bg-gradient-to-b from-[#F0FDF4] via-white to-white pt-28 pb-10 border-b border-[#E5E7EB]/60">
        <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
            <div class="max-w-2xl">
                <span class="fh-hero-anim inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-md text-[12px] font-semibold" data-hero-step="1">
                    <span class="material-symbols-outlined text-[15px]">diversity_3</span>
                    Tentang FixHome
                </span>
                <h1 class="fh-hero-anim font-headline-xl text-[28px] sm:text-[36px] leading-[1.16] font-extrabold tracking-[-0.03em] text-[#111827] mt-3.5" data-hero-step="2">
                    Membuat Perbaikan Rumah <span class="text-[#16A34A]">Lebih Mudah, Jelas, dan Tenang</span>
                </h1>
                <p class="fh-hero-anim font-body-lg text-[14.5px] text-[#4B5563] mt-3" data-hero-step="3">
                    FixHome lahir dari pengalaman sederhana: mencari tukang yang bisa dipercaya itu sulit, harganya sering tidak jelas, dan prosesnya sulit dipantau.
                </p>
            </div>
        </div>
    </section>

    <!-- Story + Vision/Mission + Values -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-10" data-reveal>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-6 space-y-5">
                <div class="space-y-3 text-[14px] leading-relaxed text-[#4B5563]">
                    <p>
                        Kami membangun platform digital yang mempertemukan pemilik rumah dengan teknisi pertukangan terverifikasi secara cepat, terukur, dan transparan — mulai dari perbaikan pipa bocor, instalasi listrik, perawatan AC, atap, pengecatan, hingga kebersihan menyeluruh.
                    </p>
                    <p>
                        Setiap mitra teknisi melewati proses verifikasi identitas dan keahlian oleh tim Admin FixHome. Di sisi lain, kami menjunjung keadilan bagi para teknisi dengan sistem komisi flat hanya 5% sehingga 95% nilai jasa diterima penuh oleh mitra.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="stitch-surface-card p-5 rounded-[20px] bg-white">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="material-symbols-outlined text-[20px] text-[#16A34A]">visibility</span>
                            <h2 class="font-title-md text-[15.5px] font-bold text-[#111827]">Visi</h2>
                        </div>
                        <p class="text-[13px] text-[#4B5563]">Menjadi platform layanan perbaikan dan perawatan rumah paling tepercaya di Indonesia.</p>
                    </div>
                    <div class="stitch-surface-card p-5 rounded-[20px] bg-white">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="material-symbols-outlined text-[20px] text-[#16A34A]">flag</span>
                            <h2 class="font-title-md text-[15.5px] font-bold text-[#111827]">Misi</h2>
                        </div>
                        <p class="text-[13px] text-[#4B5563]">Menghadirkan perbaikan yang cepat, transparan, dan terpercaya bagi setiap keluarga.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="stitch-surface-card rounded-[24px] p-6 bg-white space-y-5">
                    <div class="flex items-center gap-3">
                        <img alt="" aria-hidden="true" class="w-11 h-11 object-contain" src="{{ asset('images/fixhome-icon.png') }}" />
                        <div>
                            <h2 class="font-headline-sm text-[17px] font-bold text-[#111827]">Nilai yang Kami Pegang</h2>
                            <p class="text-[12px] text-[#6B7280]">Prinsip di balik setiap pesanan FixHome</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-[#F8FAFC] border border-[#E5E7EB] space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]">handshake</span>
                            </div>
                            <div>
                                <h3 class="text-[14px] font-bold text-[#111827]">Kepercayaan</h3>
                                <p class="text-[13px] text-[#4B5563]">Hanya teknisi yang telah lolos verifikasi identitas dan keahlian yang dapat menerima pesanan.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#FEF9C3] text-[#854D0E] flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]">payments</span>
                            </div>
                            <div>
                                <h3 class="text-[14px] font-bold text-[#111827]">Transparansi</h3>
                                <p class="text-[13px] text-[#4B5563]">Tarif dasar, biaya jarak, dan pembagian komisi 95/5 tercatat terbuka sejak awal pemesanan.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#16A34A] text-white flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]">workspace_premium</span>
                            </div>
                            <div>
                                <h3 class="text-[14px] font-bold text-[#111827]">Kualitas Terjaga</h3>
                                <p class="text-[13px] text-[#4B5563]">Setiap pengerjaan dinilai langsung lewat sistem rating dan ulasan pelanggan yang transparan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                        <span class="inline-flex items-center gap-1.5 text-[12.5px] font-medium text-[#4B5563]">
                            <span class="material-symbols-outlined text-[17px] text-[#16A34A]">location_on</span>
                            Wilayah Operasional: Jabodetabek &middot; Bantuan 24/7
                        </span>
                        <a class="fh-page-link inline-flex items-center gap-1 text-[13px] font-bold text-[#16A34A] hover:underline" href="{{ route('public.layanan') }}">
                            Lihat Semua Layanan
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Visual Gallery Strip -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pb-10" data-reveal>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="stitch-surface-card rounded-[20px] overflow-hidden bg-white">
                <img alt="Standar kerja teknisi FixHome" class="w-full h-40 object-cover" loading="lazy" src="{{ asset('images/fixhome-hero-bg.webp') }}" />
                <div class="p-4">
                    <h3 class="text-[14.5px] font-bold text-[#111827]">Pengerjaan Rapi &amp; Teliti</h3>
                    <p class="text-[12.5px] text-[#4B5563] mt-1">Setiap teknisi membawa peralatan kerja standar dan memastikan area rumah tetap bersih setelah selesai.</p>
                </div>
            </div>
            <div class="stitch-surface-card rounded-[20px] overflow-hidden bg-white">
                <img alt="Tim layanan kebersihan & perawatan rumah FixHome" class="w-full h-40 object-cover" loading="lazy" src="{{ asset('images/fixhome-hero-tactile.jpg') }}" />
                <div class="p-4">
                    <h3 class="text-[14.5px] font-bold text-[#111827]">Tim Ramah &amp; Terlatih</h3>
                    <p class="text-[12.5px] text-[#4B5563] mt-1">Komunikasi transparan sebelum dan selama pengerjaan agar pemilik rumah merasa aman dan nyaman.</p>
                </div>
            </div>
            <div class="stitch-surface-card rounded-[20px] overflow-hidden bg-white">
                <img alt="Perawatan AC & kelistrikan profesional" class="w-full h-40 object-cover" loading="lazy" src="{{ asset('images/services/ac-pendingin.jpg') }}" />
                <div class="p-4">
                    <h3 class="text-[14.5px] font-bold text-[#111827]">Transaksi Tercatat Rapi</h3>
                    <p class="text-[12.5px] text-[#4B5563] mt-1">Setiap pembayaran QRIS otomatis tercatat di sistem dengan invoice digital langsung ke Gmail Anda.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
