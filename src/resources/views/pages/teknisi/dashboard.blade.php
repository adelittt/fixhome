<x-layouts.app title="Dashboard Mitra Teknisi - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-14">

        <div class="max-w-[1280px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg space-y-space-lg">

            <!-- Toast Notification -->
            <div id="dashboard-toast" class="fixed top-24 right-5 z-[60] transform translate-x-[120%] opacity-0 transition-all duration-300 pointer-events-none">
                <div class="bg-primary text-on-primary px-5 py-3.5 rounded-[22px] shadow-2xl flex items-center gap-3 border border-tertiary-fixed/40 max-w-sm">
                    <span id="toast-icon" class="text-xl">✅</span>
                    <div>
                        <h4 id="toast-title" class="text-xs font-bold text-tertiary-fixed">Pemberitahuan</h4>
                        <p id="toast-msg" class="text-[11px] text-inverse-on-surface/90 mt-0.5 leading-snug">Pesan status disini</p>
                    </div>
                </div>
            </div>

            @if (!$teknisi->isVerified())
                <div class="p-5 rounded-[22px] {{ $teknisi->isRejected() ? 'bg-red-50 border border-red-200 text-red-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }} flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-[24px] {{ $teknisi->isRejected() ? 'text-red-600' : 'text-amber-600' }} shrink-0 mt-0.5">
                            {{ $teknisi->isRejected() ? 'cancel' : 'hourglass_top' }}
                        </span>
                        <div>
                            <h3 class="text-sm font-bold">
                                {{ $teknisi->isRejected() ? 'Pendaftaran Mitra Teknisi Ditolak' : 'Menunggu Konfirmasi Verifikasi Admin' }}
                            </h3>
                            <p class="text-xs mt-0.5 leading-relaxed opacity-90">
                                @if ($teknisi->isRejected())
                                    Mohon maaf, pengajuan akun Mitra Teknisi Anda belum disetujui oleh Admin FixHome. Silakan hubungi tim admin untuk informasi lebih lanjut.
                                @else
                                    Data identitas dan keahlian Anda sedang ditinjau oleh Admin FixHome. Profil Anda belum tampil di pencarian customer sampai status diverifikasi.
                                @endif
                            </p>
                        </div>
                    </div>
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 self-start sm:self-center {{ $teknisi->isRejected() ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800' }}">
                        {{ $teknisi->isRejected() ? 'Ditolak' : 'Menunggu Verifikasi' }}
                    </span>
                </div>
            @endif

            <!-- Welcome Header Bar -->
            <div class="neu-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl neu-icon-primary font-extrabold text-2xl font-recoleta shrink-0">
                        {{ substr($teknisi->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-0.5 rounded-full neu-pill text-secondary font-label-sm font-semibold font-lucy-rose">
                                Portal Mitra Teknisi Resmi
                            </span>
                            <span class="text-xs text-outline font-mono">ID: #TK-{{ str_pad($teknisi->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta mt-1">{{ $teknisi->nama_lengkap }}</h1>
                        <p class="text-xs text-on-surface-variant font-medium">{{ $teknisi->keahlian }} &bull; Rating: ★ {{ number_format($teknisi->rating, 1) }} &bull; Tarif Mulai: Rp {{ number_format($teknisi->tarif_dasar, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if ($teknisi->isVerified())
                        <button type="button" id="toggle-ready-btn" onclick="toggleTeknisiStatus()"
                                class="px-5 py-3 rounded-full text-xs font-bold transition-all flex items-center gap-2.5 {{ $teknisi->isReady() ? 'bg-primary-container text-on-primary shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF]' : 'bg-surface text-on-surface-variant shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]' }}">
                            <span id="ready-ping-dot" class="w-2.5 h-2.5 rounded-full {{ $teknisi->isReady() ? 'bg-tertiary-fixed animate-ping' : 'bg-outline' }}"></span>
                            <span id="ready-btn-text">{{ $teknisi->isReady() ? 'Status: READY (Siap Order)' : 'Status: OFF (Istirahat)' }}</span>
                        </button>
                    @else
                        <span class="px-5 py-3 rounded-full text-xs font-bold flex items-center gap-2 {{ $teknisi->isRejected() ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800' }}">
                            <span class="w-2.5 h-2.5 rounded-full {{ $teknisi->isRejected() ? 'bg-red-600' : 'bg-amber-500 animate-pulse' }}"></span>
                            <span>{{ $teknisi->isRejected() ? 'Akun Ditolak' : 'Menunggu Konfirmasi Admin' }}</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- 3 METRIC CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">

                <!-- Card 1: Wallet 95% -->
                <div class="bg-primary-container text-on-primary rounded-[26px] p-6 shadow-[0_12px_26px_rgba(119,85,55,0.28),-6px_-6px_16px_#FFFFFF] space-y-3 flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full bg-tertiary-fixed/15 blur-2xl pointer-events-none"></div>
                    <div class="space-y-3 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-tertiary-fixed">Total Saldo Bersih (95% Mitra)</span>
                            <span class="text-[10px] bg-surface/20 px-2.5 py-0.5 rounded-full font-bold">95% / 5%</span>
                        </div>
                        <h2 id="total-pendapatan-val" class="font-headline-lg text-3xl font-bold tracking-tight font-butler">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                        <p class="text-[11px] text-inverse-on-surface/80 pt-2 border-t border-inverse-on-surface/15 leading-relaxed">
                            Sistem memotong 5% komisi platform secara otomatis di setiap pembayaran.
                        </p>
                    </div>
                    <a href="{{ route('teknisi.wallet') }}" class="relative z-10 mt-2 inline-flex items-center justify-between px-4 py-2.5 bg-surface/15 hover:bg-surface/25 rounded-full text-xs font-bold text-on-primary transition-all">
                        <span>Lihat Rincian &amp; Tarik Saldo</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <!-- Card 2: Status Kerja -->
                <div class="neu-card p-6 space-y-3">
                    <span class="text-xs font-bold text-outline uppercase tracking-wider block">Ketersediaan di Aplikasi</span>
                    <div class="flex items-center gap-2.5">
                        <span id="card-status-dot" class="w-3.5 h-3.5 rounded-full {{ $teknisi->isReady() ? 'bg-secondary' : 'bg-outline-variant' }}"></span>
                        <h3 id="card-status-title" class="font-headline-sm text-primary font-bold font-butler">
                            {{ $teknisi->isReady() ? 'READY (Terlihat)' : 'OFF (Tersembunyi)' }}
                        </h3>
                    </div>
                    <p id="card-status-desc" class="text-xs text-on-surface-variant leading-relaxed">
                        @if($teknisi->isReady())
                            Profil Anda aktif di hasil pencarian terdekat customer.
                        @else
                            Profil Anda disembunyikan dan koordinat GPS dimatikan.
                        @endif
                    </p>
                </div>

                <!-- Card 3: Kebijakan 5 Bulan -->
                <div class="neu-card p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-outline uppercase tracking-wider block">Kebijakan Inaktif</span>
                        <button type="button" onclick="openPolicyModal()" class="text-xs font-bold text-secondary hover:text-primary transition-colors">Info Jadwal</button>
                    </div>
                    <div class="flex items-center justify-between">
                        <h3 class="font-headline-sm font-bold font-butler {{ $teknisi->isOff() ? 'text-tertiary' : 'text-primary' }}">
                            {{ $inactiveDays }} Hari Off
                        </h3>
                        <span class="px-2.5 py-0.5 rounded-full neu-inset-sm text-[11px] font-semibold text-on-surface-variant">Batas: 150 Hari</span>
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Sistem FixHome mengirim pengingat otomatis pada hari 30, 60, 90, 120, dan 150 (BR-10).
                    </p>
                </div>

            </div>

            <!-- 2-Column: Active Jobs & Recent Completed -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">

                <!-- Left: Active Ongoing Jobs -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-headline-sm text-primary font-bold font-recoleta">Pesanan Aktif Perlu Pengerjaan</h2>
                        <span class="px-3.5 py-1 rounded-full bg-secondary-container text-primary text-xs font-bold">
                            <span id="active-orders-count">{{ $activeOrders->count() }}</span> Order Aktif
                        </span>
                    </div>

                    <div id="active-orders-container" class="space-y-4">
                        @forelse($activeOrders as $order)
                            <div id="order-card-{{ $order->id }}" class="order-card neu-card p-6 space-y-4 transition-all hover:-translate-y-0.5" data-total="{{ $order->total_biaya }}">
                                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40 text-xs">
                                    <span class="font-mono text-primary font-bold">#BK-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <span id="status-badge-{{ $order->id }}" class="px-3 py-1 rounded-full text-xs font-bold {{ $order->status_order === 'paid' ? 'bg-tertiary-fixed text-on-tertiary-fixed animate-pulse' : ($order->status_order === 'otw' ? 'bg-secondary-container text-primary animate-pulse' : ($order->status_order === 'working' ? 'bg-primary-fixed text-on-primary-fixed' : 'neu-inset-sm text-primary')) }}">
                                        {{ $order->status_order === 'paid' ? 'LUNAS (SIAP BERANGKAT)' : strtoupper($order->status_order) }}
                                    </span>
                                </div>

                                <div class="space-y-1.5">
                                    <h3 class="font-title-sm text-primary font-bold font-butler">{{ $order->customer->nama_lengkap }}</h3>
                                    <p class="text-xs text-on-surface-variant">📍 {{ $order->customer->alamat_lengkap }}</p>
                                    <div class="p-3.5 neu-inset text-xs text-on-surface mt-2 font-medium">
                                        "{{ $order->deskripsi_kerusakan }}"
                                    </div>
                                    <div class="flex flex-wrap items-center justify-between gap-2 text-xs pt-2">
                                        <span class="text-outline">Total Tarif Order:</span>
                                        <span class="font-bold text-primary">Rp {{ number_format($order->total_biaya, 0, ',', '.') }} (Hak 95%: Rp {{ number_format($order->total_biaya * 0.95, 0, ',', '.') }})</span>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-outline-variant/40 flex flex-col sm:flex-row items-center gap-3">
                                    <a href="{{ route('tracking.chat', $order->id) }}" class="w-full sm:w-auto px-4 py-2.5 neu-btn-secondary text-xs text-primary gap-1.5 shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">map</span>
                                        <span>GPS &amp; Chat</span>
                                    </a>

                                    <div class="flex-1 w-full grid grid-cols-3 gap-2">
                                        <button type="button" onclick="updateOrderStatus({{ $order->id }}, 'otw', this)" class="btn-step py-2.5 rounded-full text-xs font-bold transition-all {{ $order->status_order === 'paid' || $order->status_order === 'otw' ? 'bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(119,85,55,0.28)]' : 'bg-surface text-on-surface-variant shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]' }}">
                                            🛵 Meluncur
                                        </button>
                                        <button type="button" onclick="updateOrderStatus({{ $order->id }}, 'working', this)" class="btn-step py-2.5 rounded-full text-xs font-bold transition-all {{ $order->status_order === 'working' ? 'bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(119,85,55,0.28)]' : 'bg-surface text-on-surface-variant shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]' }}">
                                            🔧 Servis
                                        </button>
                                        <button type="button" onclick="updateOrderStatus({{ $order->id }}, 'completed', this)" class="btn-step py-2.5 rounded-full text-xs font-bold transition-all {{ $order->status_order === 'completed' ? 'bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(119,85,55,0.28)]' : 'bg-surface text-on-surface-variant shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]' }}">
                                            ✓ Selesai
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center neu-inset rounded-[26px]">
                                <span class="material-symbols-outlined text-outline text-4xl mb-2">task_alt</span>
                                <p class="text-xs text-on-surface-variant">Tidak ada pesanan aktif yang perlu dikerjakan saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right: Recent Completed Orders -->
                <div class="lg:col-span-5 space-y-4">
                    <h2 class="font-headline-sm text-primary font-bold font-recoleta">Riwayat Pesanan Selesai</h2>

                    <div id="completed-orders-list" class="neu-card p-5 space-y-3">
                        @forelse($recentOrders->where('status_order', 'completed') as $history)
                            <div class="p-4 neu-inset text-xs flex items-center justify-between gap-3">
                                <div>
                                    <h4 class="font-bold text-primary font-butler text-sm">{{ $history->customer->nama_lengkap }}</h4>
                                    <span class="text-[10px] text-outline">{{ \Carbon\Carbon::parse($history->jadwal)->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="font-bold text-secondary block">+ Rp {{ number_format($history->total_biaya * 0.95, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-outline font-semibold">95% Bersih</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-outline empty-msg">
                                Belum ada pesanan yang selesai.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <!-- Policy Modal -->
        <div id="policy-modal" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
            <div class="neu-card-lg max-w-lg w-full p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                    <h3 class="font-headline-sm text-primary font-bold font-recoleta">Kebijakan Inaktif 5 Bulan</h3>
                    <button type="button" onclick="closePolicyModal()" class="w-8 h-8 rounded-full neu-btn-secondary text-primary text-lg">&times;</button>
                </div>

                <div class="space-y-3 text-xs text-on-surface-variant leading-relaxed">
                    <p>Untuk memastikan ketersediaan teknisi berkualitas dan responsif, FixHome memberlakukan sistem kontrol keaktifan:</p>

                    <div class="space-y-2.5 pt-1">
                        <div class="p-3.5 neu-inset flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl neu-icon-teal font-bold text-xs shrink-0">30</span>
                            <div>
                                <span class="font-bold text-primary block">Hari ke-30: Pengingat Santai</span>
                                <span class="text-[11px]">Notifikasi motivasi untuk kembali aktif menerima servis.</span>
                            </div>
                        </div>

                        <div class="p-3.5 neu-inset flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl neu-icon-gold font-bold text-xs shrink-0">60-90</span>
                            <div>
                                <span class="font-bold text-primary block">Hari ke-60 &amp; 90: Peringatan Sedang</span>
                                <span class="text-[11px]">Notifikasi push dan email konfirmasi kendala.</span>
                            </div>
                        </div>

                        <div class="p-3.5 neu-inset flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-error-container text-on-error-container font-bold text-xs flex items-center justify-center shrink-0">150</span>
                            <div>
                                <span class="font-bold text-primary block">Hari ke-150 (5 Bulan): Penonaktifan Otomatis</span>
                                <span class="text-[11px]">Akun dinonaktifkan demi menjaga akurasi radius pencarian.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="closePolicyModal()" class="w-full neu-btn-primary py-3 text-xs">
                    Saya Mengerti
                </button>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        const csrfToken = @json(csrf_token());

        function showToast(title, message, icon = '✅') {
            const toast = document.getElementById('dashboard-toast');
            document.getElementById('toast-title').textContent = title;
            document.getElementById('toast-msg').textContent = message;
            document.getElementById('toast-icon').textContent = icon;

            toast.classList.remove('translate-x-[120%]', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-x-[120%]', 'opacity-0');
            }, 3500);
        }

        function toggleTeknisiStatus() {
            const btn = document.getElementById('toggle-ready-btn');
            const btnText = document.getElementById('ready-btn-text');
            const dot = document.getElementById('ready-ping-dot');
            const cardDot = document.getElementById('card-status-dot');
            const cardTitle = document.getElementById('card-status-title');
            const cardDesc = document.getElementById('card-status-desc');

            fetch('{{ route('teknisi.toggle-status') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(() => {
                if (btn.classList.contains('bg-primary-container')) {
                    btn.className = 'px-5 py-3 rounded-full text-xs font-bold transition-all flex items-center gap-2.5 bg-surface text-on-surface-variant shadow-[-4px_-4px_10px_#FFFFFF,4px_4px_10px_#D2D2D2]';
                    btnText.textContent = 'Status: OFF (Istirahat)';
                    dot.className = 'w-2.5 h-2.5 rounded-full bg-outline';
                    cardDot.className = 'w-3.5 h-3.5 rounded-full bg-outline-variant';
                    cardTitle.textContent = 'OFF (Tersembunyi)';
                    cardDesc.textContent = 'Profil Anda disembunyikan dan koordinat GPS dimatikan (BR-08).';
                    showToast('Status: OFF (Istirahat)', 'Anda kini tidak akan muncul dalam pencarian radius customer terdekat (BR-08).', '⏸️');
                } else {
                    btn.className = 'px-5 py-3 rounded-full text-xs font-bold transition-all flex items-center gap-2.5 bg-primary-container text-on-primary shadow-[0_8px_18px_rgba(119,85,55,0.28),-4px_-4px_10px_#FFFFFF]';
                    btnText.textContent = 'Status: READY (Siap Order)';
                    dot.className = 'w-2.5 h-2.5 rounded-full bg-tertiary-fixed animate-ping';
                    cardDot.className = 'w-3.5 h-3.5 rounded-full bg-secondary';
                    cardTitle.textContent = 'READY (Terlihat)';
                    cardDesc.textContent = 'Profil Anda aktif di hasil pencarian terdekat customer (BR-02 & BR-07).';
                    showToast('Status: READY (Siap Order)', 'Profil Anda aktif dan dapat menerima pesanan baru secara real-time (BR-07)!', '🎉');
                }
            })
            .catch(() => {
                showToast('Gagal', 'Terjadi kesalahan jaringan.', '⚠️');
            });
        }

        function updateOrderStatus(bookingId, status, buttonEl) {
            const formData = new FormData();
            formData.append('status_order', status);

            fetch(`/teknisi/order/${bookingId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(() => {
                const badge = document.getElementById(`status-badge-${bookingId}`);
                if (badge) {
                    badge.textContent = status.toUpperCase();
                    if (status === 'otw') {
                        badge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-secondary-container text-primary';
                        showToast('Status: OTW', 'Customer telah menerima notifikasi bahwa Anda sedang meluncur ke lokasi.', '🛵');
                    } else if (status === 'working') {
                        badge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-primary-fixed text-on-primary-fixed';
                        showToast('Status: Servis', 'Pengerjaan servis dimulai di lokasi customer.', '🔧');
                    } else if (status === 'completed') {
                        badge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-secondary-container text-primary';
                        showToast('Status: Selesai', 'Pekerjaan tuntas! Dana bersih 95% otomatis masuk ke saldo Anda (BR-04).', '💰');
                    }
                }

                const buttons = buttonEl.parentElement.querySelectorAll('.btn-step');
                buttons.forEach(b => {
                    b.className = 'btn-step py-2.5 rounded-full text-xs font-bold transition-all bg-surface text-on-surface-variant shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]';
                });
                buttonEl.className = 'btn-step py-2.5 rounded-full text-xs font-bold transition-all bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(119,85,55,0.28)]';
            })
            .catch(() => {
                showToast('Gagal', 'Gagal memperbarui status order.', '⚠️');
            });
        }

        function openPolicyModal() {
            document.getElementById('policy-modal').classList.remove('opacity-0', 'pointer-events-none');
        }

        function closePolicyModal() {
            document.getElementById('policy-modal').classList.add('opacity-0', 'pointer-events-none');
        }
    </script>
    @endpush
</x-layouts.app>
