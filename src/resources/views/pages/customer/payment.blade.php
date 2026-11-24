<x-layouts.app title="Rincian Pembayaran - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="max-w-[1280px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg">

            <div class="mb-space-lg flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('customer.home') }}" class="neu-btn-secondary px-4 py-2 text-xs text-primary gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Beranda</span>
                </a>

                <div class="neu-pill px-4 py-2 text-xs font-bold text-on-surface-variant">
                    <span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span>
                    <span>Batas Pembayaran: <span id="payment-timer" class="font-mono text-primary font-extrabold">{{ str_pad($midtransExpiryHours ?? 2, 2, '0', STR_PAD_LEFT) }}:00:00</span></span>
                </div>
            </div>

            @if (session('info'))
                <div class="mb-space-md p-4 rounded-2xl bg-secondary-container/70 text-primary text-xs font-semibold flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] shrink-0">schedule</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-space-md p-4 rounded-2xl bg-red-100 text-red-800 text-xs font-semibold flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- 2-Column Checkout -->
            <form id="payment-form" action="{{ route('booking.process-payment', $booking->id) }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-space-lg items-start">
                @csrf

                <!-- Left Column -->
                <div class="lg:col-span-8 space-y-space-lg">

                    <!-- Order Detail Card -->
                    <div class="neu-card p-6 space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-outline-variant/40">
                            <div>
                                <span class="text-xs text-outline font-medium">Nomor Tagihan Pemesanan</span>
                                <h2 class="font-headline-sm text-primary font-bold font-butler mt-0.5">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h2>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-xs font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                <span>Menunggu Pembayaran</span>
                            </span>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl neu-icon-primary font-extrabold text-xl font-recoleta shrink-0">
                                {{ substr($booking->teknisi->nama_lengkap, 0, 1) }}
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-title-sm text-primary font-bold font-butler">{{ $booking->teknisi->nama_lengkap }}</h3>
                                    <span class="px-2.5 py-0.5 rounded-full bg-secondary-container text-primary text-[10px] font-bold">Teknisi Terverifikasi</span>
                                </div>
                                <p class="text-xs text-on-surface-variant">{{ $booking->teknisi->keahlian }} &bull; Rating ★ {{ number_format($booking->teknisi->rating, 1) }}</p>
                                <span class="text-xs text-secondary font-bold inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">calendar_month</span>
                                    <span>Waktu Kunjungan: {{ \Carbon\Carbon::parse($booking->jadwal)->translatedFormat('d F Y, H:i') }} WIB</span>
                                </span>
                            </div>
                        </div>

                        <div class="p-4 neu-inset text-xs text-on-surface-variant">
                            <span class="font-bold text-primary block mb-0.5">Keluhan Kerusakan:</span>
                            {{ $booking->deskripsi_kerusakan }}
                        </div>
                    </div>

                    <!-- Payment Method Selector -->
                    @if (!empty($midtransEnabled))
                        <div class="neu-card p-6 space-y-5">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div>
                                    <h3 class="font-headline-sm text-primary font-bold font-recoleta">Pembayaran Aman via Midtrans</h3>
                                    <p class="text-xs text-on-surface-variant mt-0.5">Pilih metode pembayaran langsung di halaman checkout Midtrans Snap.</p>
                                </div>
                                <span class="px-3 py-1 rounded-full {{ !empty($midtransIsProduction) ? 'bg-secondary-container text-primary' : 'bg-tertiary-fixed text-on-tertiary-fixed' }} text-[11px] font-bold">
                                    {{ !empty($midtransIsProduction) ? 'Midtrans Live' : 'Midtrans Sandbox' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                                <div class="p-4 rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]">
                                    <span class="font-bold text-xs text-primary bg-secondary-container px-2.5 py-0.5 rounded-full inline-block mb-2">Virtual Account</span>
                                    <div class="font-bold text-primary text-xs font-butler">BCA, BNI, BRI, Mandiri</div>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5">Verifikasi otomatis dari bank</p>
                                </div>
                                <div class="p-4 rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]">
                                    <span class="font-bold text-xs text-on-tertiary-fixed bg-tertiary-fixed px-2.5 py-0.5 rounded-full inline-block mb-2">QRIS &amp; E-Wallet</span>
                                    <div class="font-bold text-primary text-xs font-butler">QRIS, GoPay, ShopeePay</div>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5">Scan QR atau bayar instan</p>
                                </div>
                                <div class="p-4 rounded-[20px] bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]">
                                    <span class="font-bold text-xs text-on-primary bg-primary-container px-2.5 py-0.5 rounded-full inline-block mb-2">Tenggat {{ $midtransExpiryHours ?? 2 }} Jam</span>
                                    <div class="font-bold text-primary text-xs font-butler">Batas Waktu Jelas</div>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5">Berlaku {{ $midtransExpiryHours ?? 2 }} jam sejak klik bayar</p>
                                </div>
                            </div>

                            <div id="midtrans-error-box" class="hidden p-3.5 rounded-2xl bg-red-100 text-red-800 text-xs font-semibold"></div>

                            @if (empty($midtransIsProduction))
                                <div class="p-4 neu-inset text-xs text-on-surface-variant leading-relaxed">
                                    <span class="font-bold text-primary block mb-1">Mode Uji Coba (Sandbox):</span>
                                    Setelah memilih Virtual Account / QRIS di halaman Midtrans, Anda dapat menyimulasikan pembayaran lunas di
                                    <a href="https://simulator.sandbox.midtrans.com/" target="_blank" rel="noopener noreferrer" class="font-bold text-primary underline">Midtrans Payment Simulator</a>,
                                    lalu klik tombol <strong>Cek Status Pembayaran</strong>.
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="neu-card p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Pilih Metode Pembayaran</h3>
                            <span class="text-xs text-outline">Verifikasi Otomatis 24/7</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                            <!-- BCA VA -->
                            <label class="payment-method-card relative flex flex-col p-4 rounded-[20px] cursor-pointer transition-all bg-primary-container/10 ring-2 ring-primary-container shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]" data-target="bca-panel">
                                <input type="radio" name="payment_method" value="BCA Virtual Account" checked class="sr-only">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-xs text-primary bg-secondary-container px-2.5 py-0.5 rounded-full">BCA VA</span>
                                    <div class="w-5 h-5 rounded-full bg-primary-container text-on-primary flex items-center justify-center radio-check">
                                        <span class="material-symbols-outlined text-[13px]">check</span>
                                    </div>
                                </div>
                                <span class="font-bold text-primary text-xs font-butler">Virtual Account</span>
                                <span class="text-[10px] text-on-surface-variant mt-0.5">m-BCA / KlikBCA / ATM</span>
                            </label>

                            <!-- QRIS -->
                            <label class="payment-method-card relative flex flex-col p-4 rounded-[20px] cursor-pointer transition-all bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]" data-target="qris-panel">
                                <input type="radio" name="payment_method" value="QRIS / E-Wallet" class="sr-only">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-xs text-on-tertiary-fixed bg-tertiary-fixed px-2.5 py-0.5 rounded-full">QRIS</span>
                                    <div class="w-5 h-5 rounded-full border-2 border-outline-variant text-transparent flex items-center justify-center radio-check">
                                        <span class="material-symbols-outlined text-[13px]">check</span>
                                    </div>
                                </div>
                                <span class="font-bold text-primary text-xs font-butler">QRIS Standar</span>
                                <span class="text-[10px] text-on-surface-variant mt-0.5">GoPay, OVO, Dana, LinkAja</span>
                            </label>

                            <!-- Mandiri VA -->
                            <label class="payment-method-card relative flex flex-col p-4 rounded-[20px] cursor-pointer transition-all bg-surface shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]" data-target="mandiri-panel">
                                <input type="radio" name="payment_method" value="Mandiri Virtual Account" class="sr-only">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-xs text-on-primary-fixed bg-primary-fixed px-2.5 py-0.5 rounded-full">Mandiri</span>
                                    <div class="w-5 h-5 rounded-full border-2 border-outline-variant text-transparent flex items-center justify-center radio-check">
                                        <span class="material-symbols-outlined text-[13px]">check</span>
                                    </div>
                                </div>
                                <span class="font-bold text-primary text-xs font-butler">Mandiri VA</span>
                                <span class="text-[10px] text-on-surface-variant mt-0.5">Livin' by Mandiri</span>
                            </label>
                        </div>

                        <!-- Dynamic Content Panes -->
                        <div class="pt-4 border-t border-outline-variant/40">
                            <!-- BCA Panel -->
                            <div id="bca-panel" class="payment-panel space-y-4">
                                <div class="p-4 neu-inset flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Nomor BCA Virtual Account</span>
                                        <span id="bca-va-code" class="text-lg font-mono font-extrabold text-primary tracking-wider mt-1 block">8277 0812 {{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }} 99</span>
                                    </div>
                                    <button type="button" onclick="copyVA('bca-va-code', this)" class="neu-btn-secondary px-4 py-2 text-xs text-primary gap-1.5 shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                        <span class="copy-label">Salin No. VA</span>
                                    </button>
                                </div>

                                <div class="space-y-2 text-xs text-on-surface-variant">
                                    <div class="font-bold text-primary">Petunjuk Pembayaran BCA Mobile:</div>
                                    <ol class="list-decimal list-inside space-y-1 pl-1 leading-relaxed">
                                        <li>Buka aplikasi m-BCA dan pilih menu <strong class="text-primary">m-Transfer &gt; BCA Virtual Account</strong>.</li>
                                        <li>Masukkan nomor Virtual Account di atas dan klik <strong class="text-primary">Send</strong>.</li>
                                        <li>Periksa nama penerima <strong class="text-primary">FixHome: {{ $booking->teknisi->nama_lengkap }}</strong> dan nominal total.</li>
                                        <li>Masukkan PIN m-BCA Anda untuk menyelesaikan pembayaran.</li>
                                    </ol>
                                </div>
                            </div>

                            <!-- QRIS Panel -->
                            <div id="qris-panel" class="payment-panel hidden space-y-4">
                                <div class="p-6 neu-inset flex flex-col items-center text-center space-y-3">
                                    <div class="inline-block bg-surface-container-lowest p-4 rounded-2xl shadow-md">
                                        <div class="w-48 h-48 bg-surface-container-lowest flex flex-col items-center justify-center relative p-2 border-2 border-primary rounded-xl">
                                            <div class="absolute top-2 left-2 w-10 h-10 border-4 border-primary rounded-md"></div>
                                            <div class="absolute top-2 right-2 w-10 h-10 border-4 border-primary rounded-md"></div>
                                            <div class="absolute bottom-2 left-2 w-10 h-10 border-4 border-primary rounded-md"></div>
                                            <div class="grid grid-cols-6 gap-1 w-28 h-28 opacity-85">
                                                <div class="bg-primary"></div><div class="bg-transparent"></div><div class="bg-primary"></div><div class="bg-primary"></div><div class="bg-transparent"></div><div class="bg-primary"></div>
                                                <div class="bg-transparent"></div><div class="bg-primary"></div><div class="bg-transparent"></div><div class="bg-transparent"></div><div class="bg-primary"></div><div class="bg-transparent"></div>
                                                <div class="bg-primary"></div><div class="bg-primary"></div><div class="bg-primary-container flex items-center justify-center text-on-primary text-[8px] font-black col-span-2 row-span-2 rounded">FIX+</div><div class="bg-primary"></div><div class="bg-transparent"></div>
                                                <div class="bg-transparent"></div><div class="bg-transparent"></div><div class="bg-transparent"></div><div class="bg-primary"></div>
                                                <div class="bg-primary"></div><div class="bg-primary"></div><div class="bg-transparent"></div><div class="bg-primary"></div><div class="bg-primary"></div><div class="bg-primary"></div>
                                                <div class="bg-transparent"></div><div class="bg-primary"></div><div class="bg-primary"></div><div class="bg-transparent"></div><div class="bg-transparent"></div><div class="bg-primary"></div>
                                            </div>
                                            <span class="text-[9px] font-extrabold text-primary tracking-wider mt-2">NMID: ID102030405060</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-title-sm font-bold text-primary font-butler">PT SOLUSI FIXHOME INDONESIA</h4>
                                        <p class="text-xs text-on-surface-variant">Scan kode QR di atas menggunakan aplikasi e-wallet apa saja (GoPay, OVO, Dana, BCA, Livin)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Mandiri Panel -->
                            <div id="mandiri-panel" class="payment-panel hidden space-y-4">
                                <div class="p-4 neu-inset flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Nomor Mandiri Virtual Account</span>
                                        <span id="mandiri-va-code" class="text-lg font-mono font-extrabold text-primary tracking-wider mt-1 block">8960 8812 {{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }} 77</span>
                                    </div>
                                    <button type="button" onclick="copyVA('mandiri-va-code', this)" class="neu-btn-secondary px-4 py-2 text-xs text-primary gap-1.5 shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                        <span class="copy-label">Salin No. VA</span>
                                    </button>
                                </div>

                                <div class="space-y-2 text-xs text-on-surface-variant">
                                    <div class="font-bold text-primary">Petunjuk Pembayaran Livin' by Mandiri:</div>
                                    <ol class="list-decimal list-inside space-y-1 pl-1 leading-relaxed">
                                        <li>Buka aplikasi Livin' by Mandiri, pilih menu <strong class="text-primary">Bayar &gt; Virtual Account</strong>.</li>
                                        <li>Masukkan nomor Mandiri Virtual Account di atas.</li>
                                        <li>Konfirmasi tagihan dan selesaikan transaksi menggunakan PIN Anda.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        </div>
                    @endif

                    <!-- Business Rules Notice -->
                    <div class="p-4 rounded-[22px] bg-secondary-container/60 text-xs text-on-secondary-fixed leading-relaxed flex items-start gap-3 shadow-[inset_2px_2px_5px_#B2CED0,inset_-2px_-2px_5px_#E6FAFC]">
                        <span class="material-symbols-outlined text-primary text-[22px] shrink-0 mt-0.5">info</span>
                        <span>
                            <strong>Informasi Layanan:</strong> Kanal <strong>Chat dua arah</strong> dan fitur <strong>Pelacakan GPS</strong> posisi teknisi secara real-time akan langsung terbuka segera setelah pembayaran terverifikasi.
                        </span>
                    </div>

                </div>

                <!-- Right Column (Sticky Summary) -->
                <div class="lg:col-span-4 sticky top-24 space-y-4 mt-6 lg:mt-0">
                    <div class="neu-card-lg p-6 space-y-5">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-secondary-container"></span>
                            <h3 class="font-headline-sm text-primary font-bold font-recoleta">Rincian &amp; Transparansi Biaya</h3>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="p-4 neu-inset space-y-2.5">
                                <div class="flex items-center justify-between text-on-surface-variant">
                                    <span>Biaya Layanan Jasa</span>
                                    <span class="font-bold text-primary">Rp {{ number_format($booking->biaya_layanan > 0 ? $booking->biaya_layanan : ($booking->total_biaya - $booking->biaya_jarak), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant">
                                    <span>Biaya Jarak ({{ number_format($booking->jarak_km, 1) }} km)</span>
                                    <span class="font-bold {{ $booking->biaya_jarak > 0 ? 'text-tertiary' : 'text-secondary' }}">
                                        {{ $booking->biaya_jarak > 0 ? '+ Rp ' . number_format($booking->biaya_jarak, 0, ',', '.') : 'Rp 0 (Gratis)' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 rounded-[18px] bg-surface-container-low space-y-2">
                                <div class="text-[11px] font-bold text-primary uppercase tracking-wider">Skema Transparansi Biaya</div>
                                <div class="flex items-center justify-between text-on-surface-variant">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        <span>Hak Mitra Teknisi (95%)</span>
                                    </span>
                                    <span class="font-bold text-primary">Rp {{ number_format($split['dana_teknisi'], 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-on-surface-variant">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                        <span>Komisi Platform (5%)</span>
                                    </span>
                                    <span class="font-bold text-primary">Rp {{ number_format($split['komisi_admin'], 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="pt-2 flex items-center justify-between px-1">
                                <span class="font-body-md text-on-surface-variant font-medium">Total Tagihan</span>
                                <span class="font-headline-md text-primary font-bold font-butler">Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-[18px] bg-tertiary-fixed/40 text-[11px] text-on-tertiary-fixed leading-relaxed">
                            Pembayaran Anda tercatat aman dan transparan. Dana diteruskan ke teknisi setelah pekerjaan selesai.
                        </div>

                        @if (!empty($midtransEnabled))
                            <div class="space-y-2.5">
                                <button type="button" id="btn-midtrans-pay" onclick="startMidtransPayment()" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                                    <span class="material-symbols-outlined text-[20px]">payments</span>
                                    <span id="btn-midtrans-label">Bayar via Midtrans</span>
                                </button>

                                <a href="{{ route('booking.midtrans-status', $booking->id) }}" id="btn-check-status" class="w-full neu-btn-secondary py-2.5 px-5 text-xs text-primary gap-1.5 {{ $booking->transaksi ? 'inline-flex' : 'hidden' }} items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">refresh</span>
                                    <span>Cek Status Pembayaran</span>
                                </a>
                            </div>
                        @else
                            <button type="button" id="btn-pay-now" onclick="triggerInteractivePayment()" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                                <span class="material-symbols-outlined text-[20px]">verified</span>
                                <span>Bayar Sekarang (Simulasi)</span>
                            </button>
                        @endif
                    </div>
                </div>

            </form>
        </div>

        <!-- Interactive Processing Modal -->
        <div id="payment-modal" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
            <div class="neu-card-lg max-w-md w-full p-7 text-center space-y-6 transform scale-95 transition-transform duration-300" id="modal-box">

                <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
                    <div id="modal-spinner" class="w-20 h-20 border-4 border-secondary-container border-t-primary-container rounded-full animate-spin"></div>
                    <div id="modal-check" class="hidden absolute inset-0 bg-primary-container rounded-full items-center justify-center text-on-primary scale-0 transition-transform duration-500">
                        <span class="material-symbols-outlined text-[40px]">check</span>
                    </div>
                </div>

                <div>
                    <h3 id="modal-title" class="font-headline-sm text-primary font-bold font-recoleta">Memproses Pembayaran...</h3>
                    <p id="modal-subtitle" class="text-xs text-on-surface-variant mt-1">Menghubungkan ke gateway pembayaran FixHome</p>
                </div>

                <div class="neu-inset p-4 text-left space-y-2.5 text-xs text-on-surface-variant font-medium">
                    <div id="step-1" class="flex items-center gap-2.5 text-outline">
                        <span class="w-5 h-5 rounded-full border border-outline-variant flex items-center justify-center text-[10px] font-bold step-icon">1</span>
                        <span>Verifikasi dana Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</span>
                    </div>
                    <div id="step-2" class="flex items-center gap-2.5 text-outline">
                        <span class="w-5 h-5 rounded-full border border-outline-variant flex items-center justify-center text-[10px] font-bold step-icon">2</span>
                        <span>Alokasi ACID: 95% Teknisi &amp; 5% Platform (BR-04)</span>
                    </div>
                    <div id="step-3" class="flex items-center gap-2.5 text-outline">
                        <span class="w-5 h-5 rounded-full border border-outline-variant flex items-center justify-center text-[10px] font-bold step-icon">3</span>
                        <span>Buka akses Chat Dua Arah &amp; Pelacakan GPS (BR-03)</span>
                    </div>
                </div>

                <div class="text-[11px] text-outline italic">
                    Mohon tunggu beberapa detik, sistem otomatis mengalihkan Anda...
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    @if (!empty($midtransEnabled) && !empty($midtransClientKey))
        <script src="{{ $midtransSnapJsUrl }}" data-client-key="{{ $midtransClientKey }}"></script>
    @endif
    <script>
        const midtransSnapUrl = @json(route('booking.midtrans-snap', $booking->id));
        const midtransStatusUrl = @json(route('booking.midtrans-status', $booking->id));
        const hasMidtransClientKey = @json(!empty($midtransClientKey));
        const csrfToken = @json(csrf_token());

        async function startMidtransPayment() {
            const btn = document.getElementById('btn-midtrans-pay');
            const label = document.getElementById('btn-midtrans-label');
            const errBox = document.getElementById('midtrans-error-box');
            const checkBtn = document.getElementById('btn-check-status');

            if (errBox) {
                errBox.classList.add('hidden');
                errBox.textContent = '';
            }
            if (btn) btn.disabled = true;
            if (label) label.textContent = 'Menghubungkan ke Midtrans...';

            try {
                const res = await fetch(midtransSnapUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({}),
                });

                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || 'Gagal memulai pembayaran Midtrans.');
                }

                if (data.already_paid && data.redirect_url) {
                    window.location.href = data.redirect_url;
                    return;
                }

                if (checkBtn) {
                    checkBtn.classList.remove('hidden');
                    checkBtn.classList.add('inline-flex');
                }

                if (hasMidtransClientKey && window.snap && data.token) {
                    window.snap.pay(data.token, {
                        onSuccess: function () {
                            window.location.href = midtransStatusUrl;
                        },
                        onPending: function () {
                            window.location.href = midtransStatusUrl;
                        },
                        onError: function () {
                            if (errBox) {
                                errBox.textContent = 'Terjadi kesalahan pada pembayaran Midtrans. Silakan coba lagi.';
                                errBox.classList.remove('hidden');
                            }
                            if (btn) btn.disabled = false;
                            if (label) label.textContent = 'Bayar via Midtrans';
                        },
                        onClose: function () {
                            if (btn) btn.disabled = false;
                            if (label) label.textContent = 'Bayar via Midtrans';
                        },
                    });
                } else if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    throw new Error('Token pembayaran Midtrans tidak diterima.');
                }
            } catch (err) {
                if (errBox) {
                    errBox.textContent = err.message || 'Gagal menghubungi Midtrans.';
                    errBox.classList.remove('hidden');
                }
                if (btn) btn.disabled = false;
                if (label) label.textContent = 'Bayar via Midtrans';
            }
        }

        const methodCards = document.querySelectorAll('.payment-method-card');
        const panels = document.querySelectorAll('.payment-panel');

        methodCards.forEach(card => {
            card.addEventListener('click', () => {
                methodCards.forEach(c => {
                    c.classList.remove('bg-primary-container/10', 'ring-2', 'ring-primary-container');
                    c.classList.add('bg-surface');
                    const check = c.querySelector('.radio-check');
                    if (check) {
                        check.classList.remove('bg-primary-container', 'text-on-primary');
                        check.classList.add('border-2', 'border-outline-variant', 'text-transparent');
                    }
                });

                card.classList.remove('bg-surface');
                card.classList.add('bg-primary-container/10', 'ring-2', 'ring-primary-container');
                const activeCheck = card.querySelector('.radio-check');
                if (activeCheck) {
                    activeCheck.classList.remove('border-2', 'border-outline-variant', 'text-transparent');
                    activeCheck.classList.add('bg-primary-container', 'text-on-primary');
                }

                const targetId = card.getAttribute('data-target');
                panels.forEach(p => p.classList.add('hidden'));
                const activePanel = document.getElementById(targetId);
                if (activePanel) {
                    activePanel.classList.remove('hidden');
                }
            });
        });

        function copyVA(elementId, btn) {
            const text = document.getElementById(elementId).textContent.replace(/\s+/g, '');
            navigator.clipboard.writeText(text).then(() => {
                const label = btn.querySelector('.copy-label');
                const icon = btn.querySelector('.material-symbols-outlined');
                if (label) label.textContent = 'Tersalin!';
                if (icon) icon.textContent = 'check';
                setTimeout(() => {
                    if (label) label.textContent = 'Salin No. VA';
                    if (icon) icon.textContent = 'content_copy';
                }, 2000);
            });
        }

        let timeLeft = {{ max(2, (int) ($midtransExpiryHours ?? 2)) }} * 60 * 60;
        const timerEl = document.getElementById('payment-timer');
        setInterval(() => {
            if (timeLeft <= 0) return;
            timeLeft--;
            const hrs = Math.floor(timeLeft / 3600);
            const mins = Math.floor((timeLeft % 3600) / 60);
            const secs = timeLeft % 60;
            timerEl.textContent = `${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }, 1000);

        function triggerInteractivePayment() {
            const modal = document.getElementById('payment-modal');
            const modalBox = document.getElementById('modal-box');
            const spinner = document.getElementById('modal-spinner');
            const check = document.getElementById('modal-check');
            const title = document.getElementById('modal-title');
            const subtitle = document.getElementById('modal-subtitle');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');

            const s1 = document.getElementById('step-1');
            const s2 = document.getElementById('step-2');
            const s3 = document.getElementById('step-3');

            function markStepDone(el) {
                el.classList.remove('text-outline');
                el.classList.add('text-primary', 'font-bold');
                const icon = el.querySelector('.step-icon');
                if (icon) {
                    icon.classList.remove('border', 'border-outline-variant');
                    icon.classList.add('bg-primary-container', 'text-on-primary');
                    icon.textContent = '✓';
                }
            }

            setTimeout(() => {
                markStepDone(s1);
                subtitle.textContent = 'Memverifikasi dana masuk dari perbankan...';
            }, 600);

            setTimeout(() => {
                markStepDone(s2);
                subtitle.textContent = 'Mengalokasikan pembagian 95% & 5% sesuai BR-04...';
            }, 1400);

            setTimeout(() => {
                markStepDone(s3);
                subtitle.textContent = 'Membuka kanal chat dan mengaktifkan sinyal pelacak GPS...';
            }, 2100);

            setTimeout(() => {
                spinner.classList.add('hidden');
                check.classList.remove('hidden', 'scale-0');
                check.classList.add('scale-100', 'flex');

                title.textContent = 'Pembayaran Berhasil Diverifikasi!';
                subtitle.textContent = 'Mengarahkan ke layar Pelacakan GPS & Chat langsung...';

                setTimeout(() => {
                    document.getElementById('payment-form').submit();
                }, 1000);
            }, 2800);
        }
    </script>
    @endpush
</x-layouts.app>
