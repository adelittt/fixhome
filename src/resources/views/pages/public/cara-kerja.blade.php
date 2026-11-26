<x-layouts.public
    activeNav="cara-kerja"
    description="Pelajari cara memesan teknisi di FixHome, rincian biaya jarak dan komisi 5% yang transparan, serta simulator estimasi biaya."
    title="Cara Kerja & Transparansi Biaya — FixHome"
>
    <!-- Page Hero Header -->
    <section class="relative w-full bg-gradient-to-b from-[#F0FDF4] via-white to-white pt-28 pb-10 border-b border-[#E5E7EB]/60">
        <div class="max-w-[1140px] mx-auto px-gutter lg:px-margin">
            <div class="max-w-2xl">
                <span class="fh-hero-anim inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] font-label-md text-[12px] font-semibold" data-hero-step="1">
                    <span class="material-symbols-outlined text-[15px]">lock_open</span>
                    Alur Jelas &amp; Tanpa Biaya Tersembunyi
                </span>
                <h1 class="fh-hero-anim font-headline-xl text-[28px] sm:text-[36px] leading-[1.16] font-extrabold tracking-[-0.03em] text-[#111827] mt-3.5" data-hero-step="2">
                    Cara Kerja FixHome: <span class="text-[#16A34A]">Pesan, Diskusi, Beres</span>
                </h1>
                <p class="fh-hero-anim font-body-lg text-[14.5px] text-[#4B5563] mt-3" data-hero-step="3">
                    Dari pemilihan teknisi hingga pembayaran QRIS dan pelacakan langsung, seluruh proses tercatat rapi di dashboard Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- 3-Step Flow + Interactive Pricing Simulator -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin py-10" data-reveal>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left: 3 Steps -->
            <div class="lg:col-span-6 space-y-4">
                <div class="stitch-surface-card p-5 rounded-[20px] bg-white flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#DCFCE7] text-[#15803D] flex items-center justify-center font-extrabold text-[15px] shrink-0">1</div>
                    <div>
                        <h2 class="font-title-md text-[16px] font-bold text-[#111827]">Pilih Layanan &amp; Teknisi Terdekat</h2>
                        <p class="text-[13.5px] text-[#4B5563] mt-1">Pilih kategori kerusakan, bandingkan profil teknisi terverifikasi beserta tarif dasarnya, lalu tentukan jadwal kunjungan sesuai waktu Anda.</p>
                    </div>
                </div>

                <div class="stitch-surface-card p-5 rounded-[20px] bg-white flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#FEF9C3] text-[#854D0E] flex items-center justify-center font-extrabold text-[15px] shrink-0">2</div>
                    <div>
                        <h2 class="font-title-md text-[16px] font-bold text-[#111827]">Bayar Aman via QRIS &amp; Pantau Live</h2>
                        <p class="text-[13.5px] text-[#4B5563] mt-1">Selesaikan pembayaran dengan QRIS Midtrans yang otomatis terverifikasi. Pantau status teknisi (OTW &rarr; Dikerjakan) dan koordinasi lewat Live Chat.</p>
                    </div>
                </div>

                <div class="stitch-surface-card p-5 rounded-[20px] bg-white flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#16A34A] text-white flex items-center justify-center font-extrabold text-[15px] shrink-0">3</div>
                    <div>
                        <h2 class="font-title-md text-[16px] font-bold text-[#111827]">Pekerjaan Tuntas &amp; Beri Ulasan</h2>
                        <p class="text-[13.5px] text-[#4B5563] mt-1">Setelah perbaikan selesai, periksa hasil pekerjaan dan berikan rating serta ulasan jujur untuk mitra teknisi.</p>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Pricing & 95/5 Split Simulator -->
            <div class="lg:col-span-6">
                <div class="stitch-surface-card rounded-[24px] p-6 bg-white">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#16A34A]"></span>
                            <h2 class="font-headline-sm text-[17px] font-bold text-[#111827]">Simulator Estimasi Biaya</h2>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-[#F0FDF4] text-[#15803D] text-[11px] font-semibold">Transparan 95 / 5</span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#4B5563] mb-1.5" for="calc-service">Pilih Jenis Layanan</label>
                            <select class="w-full rounded-xl border border-[#D1D5DB] bg-white px-3.5 py-2.5 text-[13.5px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none" id="calc-service">
                                @foreach ($services as $svc)
                                    <option value="{{ $svc['base_price'] }}">{{ $svc['title'] }} ({{ $svc['price'] }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <span class="block text-[12px] font-semibold text-[#4B5563] mb-1.5">Jarak Lokasi ke Teknisi</span>
                            <div class="grid grid-cols-2 gap-2 p-1 rounded-xl bg-[#F3F4F6]">
                                <button class="calc-dist-btn is-active py-2 px-3 rounded-lg text-[12.5px] font-semibold transition-all" data-distance="near" type="button">
                                    &lt; 10 km (Gratis Rp0)
                                </button>
                                <button class="calc-dist-btn py-2 px-3 rounded-lg text-[12.5px] font-semibold transition-all" data-distance="far" type="button">
                                    &ge; 10 km (+Rp10.000)
                                </button>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-[#F8FAFC] border border-[#E5E7EB] p-4 space-y-2.5 text-[13px]">
                            <div class="flex items-center justify-between">
                                <span class="text-[#4B5563]">Tarif Dasar Layanan</span>
                                <span class="font-semibold text-[#111827]" id="calc-base">Rp75.000</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[#4B5563]">Biaya Jarak</span>
                                <span class="font-semibold text-[#111827]" id="calc-distance">Rp0</span>
                            </div>
                            <div class="pt-2.5 border-t border-[#E5E7EB] flex items-center justify-between text-[15px]">
                                <span class="font-bold text-[#111827]">Total Dibayar Pelanggan</span>
                                <span class="font-extrabold text-[#16A34A]" id="calc-total">Rp75.000</span>
                            </div>
                            <div class="pt-2 border-t border-dashed border-[#D1D5DB] flex items-center justify-between text-[12px] text-[#4B5563]">
                                <span>Hak Mitra Teknisi (95%)</span>
                                <span class="font-semibold text-[#15803D]" id="calc-tech">Rp71.250</span>
                            </div>
                            <div class="flex items-center justify-between text-[12px] text-[#4B5563]">
                                <span>Komisi Platform (5%)</span>
                                <span class="font-semibold text-[#111827]" id="calc-fee">Rp3.750</span>
                            </div>
                        </div>

                        <a class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13.5px] font-semibold shadow-sm active:scale-[0.98] transition-all" href="{{ route('public.teknisi') }}">
                            <span>Pilih Teknisi Sekarang</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3 Transparency Pillars -->
    <section class="fh-reveal w-full max-w-[1140px] mx-auto px-gutter lg:px-margin pb-8" data-reveal>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="stitch-surface-card p-5 rounded-[20px] bg-white">
                <div class="w-11 h-11 rounded-xl bg-[#DCFCE7] text-[#15803D] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[22px]">shield_person</span>
                </div>
                <h3 class="font-title-md text-[15.5px] font-bold text-[#111827]">Verifikasi Ketat</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Teknisi wajib lolos verifikasi identitas dan keahlian oleh Admin sebelum menerima pesanan pertama.</p>
            </div>
            <div class="stitch-surface-card p-5 rounded-[20px] bg-white">
                <div class="w-11 h-11 rounded-xl bg-[#FEF9C3] text-[#854D0E] flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[22px]">route</span>
                </div>
                <h3 class="font-title-md text-[15.5px] font-bold text-[#111827]">Biaya Jarak Flat &amp; Jelas</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Gratis Rp0 untuk jarak &lt; 10 km, dan flat Rp10.000 untuk jarak &ge; 10 km tanpa biaya tak terduga.</p>
            </div>
            <div class="stitch-surface-card p-5 rounded-[20px] bg-white">
                <div class="w-11 h-11 rounded-xl bg-[#16A34A] text-white flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                </div>
                <h3 class="font-title-md text-[15.5px] font-bold text-[#111827]">Invoice Digital Otomatis</h3>
                <p class="text-[13px] text-[#4B5563] mt-1">Setiap pembayaran lunas langsung menghasilkan invoice resmi yang dikirim otomatis ke Gmail Anda.</p>
            </div>
        </div>
    </section>
</x-layouts.public>
