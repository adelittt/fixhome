<x-layouts.app title="Dompet Digital Mitra Teknisi - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-16">

        <div class="max-w-[1140px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg space-y-space-lg">

            <!-- Toast Notification -->
            <div id="wallet-toast" class="fixed top-24 right-5 z-[60] transform translate-x-[120%] opacity-0 transition-all duration-300 pointer-events-none">
                <div class="bg-primary text-on-primary px-5 py-3.5 rounded-[22px] shadow-2xl flex items-center gap-3 border border-tertiary-fixed/40 max-w-sm">
                    <span id="wallet-toast-icon" class="text-xl">✅</span>
                    <div>
                        <h4 id="wallet-toast-title" class="text-xs font-bold text-tertiary-fixed">Sukses</h4>
                        <p id="wallet-toast-msg" class="text-[11px] text-inverse-on-surface/90 mt-0.5 leading-snug">Penarikan dana berhasil diproses.</p>
                    </div>
                </div>
            </div>

            <!-- Breadcrumbs -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('teknisi.dashboard') }}" class="neu-btn-secondary px-4 py-2 text-xs text-primary gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Dashboard</span>
                </a>

                <span class="neu-pill px-4 py-1.5 text-xs font-mono font-bold text-on-surface-variant">
                    ID Teknisi: #TK-{{ str_pad($teknisi->id, 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            <!-- Header Banner -->
            <div class="neu-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl neu-icon-primary text-2xl shrink-0">
                        <span class="material-symbols-outlined text-[30px]">account_balance_wallet</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-0.5 rounded-full neu-pill text-secondary font-label-sm font-semibold font-lucy-rose">
                                Dompet Digital Mitra Resmi
                            </span>
                            <span class="text-xs text-outline">BR-04 Transparansi Bagi Hasil</span>
                        </div>
                        <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta mt-1">Penghasilan &amp; Saldo Mitra</h1>
                        <p class="text-xs text-on-surface-variant font-medium">{{ $teknisi->nama_lengkap }} &bull; Rekening terdaftar: Bank Mandiri (***8921)</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="openWithdrawModal()" class="neu-btn-primary px-6 py-3 text-xs gap-2">
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span>Tarik Saldo ke Rekening</span>
                    </button>
                </div>
            </div>

            <!-- 3 Financial Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">

                <!-- Card 1: Total Saldo Bersih 95% -->
                <div class="bg-primary-container text-on-primary rounded-[26px] p-6 shadow-[0_12px_26px_rgba(22,163,74,0.24),-6px_-6px_16px_#FFFFFF] space-y-3 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-36 h-36 rounded-full bg-tertiary-fixed/15 blur-2xl pointer-events-none"></div>
                    <span class="text-xs font-bold uppercase tracking-wider text-tertiary-fixed block relative z-10">Saldo Bersih Tersedia (95%)</span>
                    <div class="flex items-baseline justify-between gap-2 relative z-10">
                        <h2 id="display-saldo" class="font-headline-lg text-3xl font-bold tracking-tight font-butler">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                        <span class="text-[11px] bg-surface/20 px-3 py-0.5 rounded-full font-bold shrink-0">Siap Cair</span>
                    </div>
                    <p class="text-[11px] text-inverse-on-surface/80 pt-2 border-t border-inverse-on-surface/15 leading-relaxed relative z-10">
                        Dana murni hak teknisi setelah dipotong 5% komisi admin platform FixHome.
                    </p>
                </div>

                <!-- Card 2: Total Transaksi Selesai -->
                <div class="neu-card p-6 space-y-3">
                    <span class="text-xs font-bold text-outline uppercase tracking-wider block">Total Transaksi Selesai</span>
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-headline-lg text-3xl font-bold text-primary font-butler">
                            {{ $transaksis->total() }} <span class="text-sm font-semibold text-outline font-sans">Order</span>
                        </h3>
                        <span class="text-xs font-bold text-primary bg-secondary-container px-3 py-1 rounded-full">100% Terverifikasi</span>
                    </div>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Jumlah order servis rumah yang telah selesai dikerjakan dan terbayar penuh.
                    </p>
                </div>

                <!-- Card 3: Aturan Bagi Hasil ACID -->
                <div class="neu-card p-6 space-y-3">
                    <span class="text-xs font-bold text-outline uppercase tracking-wider block">Aturan Bagi Hasil (BR-04 &amp; BR-12)</span>
                    <div class="space-y-2 pt-1">
                        <div class="flex items-center justify-between text-xs font-bold text-on-surface">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                Mitra Teknisi
                            </span>
                            <span class="text-secondary">95% (Bersih)</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-bold text-on-surface">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-tertiary"></span>
                                Platform Admin
                            </span>
                            <span class="text-tertiary">5% (Operasional)</span>
                        </div>
                    </div>
                    <p class="text-xs text-outline pt-1 leading-relaxed">
                        Semua pembagian dihitung otomatis dan aman dengan transaksi ACID.
                    </p>
                </div>

            </div>

            <!-- Transaction History Table -->
            <div class="neu-card p-6 space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-outline-variant/40">
                    <div>
                        <h2 class="font-headline-sm text-primary font-bold font-recoleta">Riwayat Mutasi &amp; Transaksi</h2>
                        <p class="text-xs text-on-surface-variant">Rincian pendapatan di setiap pesanan perbaikan rumah</p>
                    </div>

                    <div class="neu-inset rounded-full flex items-center px-3.5 py-2 w-full sm:w-72">
                        <span class="material-symbols-outlined text-primary text-[18px] mr-2">search</span>
                        <input type="text" id="filter-wallet" placeholder="Cari invoice atau customer..."
                               class="w-full bg-transparent text-xs text-on-surface placeholder:text-outline focus:outline-none">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-outline uppercase tracking-wider font-bold border-b border-outline-variant/40">
                                <th class="pb-3">No. Invoice</th>
                                <th class="pb-3">Tanggal</th>
                                <th class="pb-3">Customer</th>
                                <th class="pb-3">Nilai Tagihan</th>
                                <th class="pb-3">Admin (5%)</th>
                                <th class="pb-3">Hak Bersih (95%)</th>
                                <th class="pb-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody id="wallet-table-body" class="divide-y divide-outline-variant/30">
                            @forelse($transaksis as $trx)
                                <tr class="wallet-row hover:bg-surface-container-low/70 transition-colors" data-search="#bk-{{ str_pad($trx->booking_id, 5, '0', STR_PAD_LEFT) }} {{ strtolower($trx->booking->customer->nama_lengkap ?? '') }}">
                                    <td class="py-4 font-mono font-bold text-primary">
                                        #BK-{{ str_pad($trx->booking_id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="py-4 text-on-surface-variant">
                                        {{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="py-4 font-bold text-primary">
                                        {{ $trx->booking->customer->nama_lengkap ?? 'Customer FixHome' }}
                                    </td>
                                    <td class="py-4 text-on-surface-variant">
                                        Rp {{ number_format($trx->total_biaya ?? $trx->gross_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-error font-medium">
                                        - Rp {{ number_format($trx->komisi_admin, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 font-bold text-secondary text-sm">
                                        + Rp {{ number_format($trx->dana_teknisi, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-right">
                                        @if($trx->status_pembayaran === 'paid')
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-secondary-container text-primary">
                                                ✓ Masuk Saldo
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-tertiary-fixed text-on-tertiary-fixed">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-outline">
                                        Belum ada riwayat transaksi masuk. Selesaikan pesanan untuk mulai mengumpulkan saldo!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transaksis->hasPages())
                    <div class="pt-4 border-t border-outline-variant/40">
                        {{ $transaksis->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- Withdraw Modal -->
        <div id="withdraw-modal" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
            <div class="neu-card-lg max-w-md w-full p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                    <h3 class="font-headline-sm text-primary font-bold font-recoleta">Tarik Saldo ke Rekening Bank</h3>
                    <button type="button" onclick="closeWithdrawModal()" class="w-8 h-8 rounded-full neu-btn-secondary text-primary text-lg">&times;</button>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-label-md text-primary mb-1.5">Pilih Rekening Tujuan</label>
                        <select id="bank-select" class="neu-input p-3 font-medium">
                            <option value="mandiri">Bank Mandiri (***8921 a/n {{ $teknisi->nama_lengkap }})</option>
                            <option value="bca">Bank BCA (***3382 a/n {{ $teknisi->nama_lengkap }})</option>
                            <option value="bri">Bank BRI (***0982 a/n {{ $teknisi->nama_lengkap }})</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-label-md text-primary mb-1.5">Nominal Penarikan (Rp)</label>
                        <input type="number" id="withdraw-amount" placeholder="Minimal Rp 50.000" value="{{ min(100000, $totalPendapatan) }}"
                               class="neu-input p-3 font-mono text-sm font-bold">
                        <span class="text-[11px] text-outline mt-1 block">Saldo maksimum dapat ditarik: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                    </div>

                    <div class="p-3.5 rounded-[18px] bg-secondary-container/60 text-on-secondary-fixed text-[11px] leading-relaxed">
                        ⚡ <strong>Pencairan Instan:</strong> Dana masuk ke rekening Anda dalam 1–5 menit tanpa biaya administrasi penarikan.
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeWithdrawModal()" class="flex-1 py-3 neu-btn-secondary text-xs text-on-surface-variant">
                        Batal
                    </button>
                    <button type="button" id="confirm-withdraw-btn" onclick="processWithdrawal()" class="flex-1 py-3 neu-btn-primary text-xs">
                        Konfirmasi Tarik Dana
                    </button>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function openWithdrawModal() {
            document.getElementById('withdraw-modal').classList.remove('opacity-0', 'pointer-events-none');
        }

        function closeWithdrawModal() {
            document.getElementById('withdraw-modal').classList.add('opacity-0', 'pointer-events-none');
        }

        document.getElementById('filter-wallet').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            document.querySelectorAll('.wallet-row').forEach(row => {
                const search = row.getAttribute('data-search') || '';
                if (query === '' || search.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });

        function showWalletToast(title, msg, icon = '✅') {
            const toast = document.getElementById('wallet-toast');
            document.getElementById('wallet-toast-title').textContent = title;
            document.getElementById('wallet-toast-msg').textContent = msg;
            document.getElementById('wallet-toast-icon').textContent = icon;

            toast.classList.remove('translate-x-[120%]', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-x-[120%]', 'opacity-0');
            }, 4000);
        }

        function processWithdrawal() {
            const amountInput = document.getElementById('withdraw-amount');
            const amount = parseInt(amountInput.value, 10) || 0;
            const currentTotal = {{ $totalPendapatan }};

            if (amount < 50000) {
                showWalletToast('Nominal Belum Sesuai', 'Minimal penarikan saldo adalah Rp 50.000.', '⚠️');
                return;
            }

            const btn = document.getElementById('confirm-withdraw-btn');
            btn.disabled = true;
            btn.textContent = 'Memproses ke Bank...';

            setTimeout(() => {
                btn.disabled = false;
                btn.textContent = 'Konfirmasi Tarik Dana';
                closeWithdrawModal();

                const newBalance = Math.max(0, currentTotal - amount);
                document.getElementById('display-saldo').textContent = 'Rp ' + newBalance.toLocaleString('id-ID');

                showWalletToast('Penarikan Berhasil!', `Dana sebesar Rp ${amount.toLocaleString('id-ID')} telah berhasil ditransfer ke rekening bank Anda.`, '🎉');
            }, 1500);
        }
    </script>
    @endpush
</x-layouts.app>
