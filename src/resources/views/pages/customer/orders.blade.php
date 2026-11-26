<x-layouts.app title="Riwayat & Status Pesanan - FixHome">
    <div class="flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="max-w-4xl mx-auto w-full px-gutter lg:px-margin pt-space-lg">

            <!-- Header Section -->
            <div class="neu-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-space-lg">
                <div>
                    <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta leading-tight">Aktivitas &amp; Riwayat Pesanan</h1>
                    <p class="font-body-sm text-on-surface-variant mt-0.5">Pantau status teknisi, chat langsung, dan riwayat perbaikan rumah Anda</p>
                </div>
                <a href="{{ route('customer.technicians') }}" class="neu-btn-primary px-5 py-3 text-xs gap-1.5 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Pesan Teknisi Baru</span>
                </a>
            </div>

            <!-- Interactive Filter Bar & Search -->
            <div class="space-y-4 mb-space-lg">
                <div class="neu-inset rounded-full flex items-center px-4 py-2.5">
                    <span class="material-symbols-outlined text-primary text-[20px] mr-2.5">search</span>
                    <input type="text" id="order-search" placeholder="Cari nama teknisi, keluhan, atau kode invoice #BK..."
                           class="w-full bg-transparent text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none">
                </div>

                <div class="flex items-center gap-2.5 overflow-x-auto pb-1 scrollbar-none text-xs">
                    <button type="button" onclick="filterStatus('all', this)" class="status-tab px-4 py-2 rounded-full font-bold transition-all bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(22,163,74,0.24)] shrink-0">
                        Semua (<span id="count-all">{{ $bookings->count() }}</span>)
                    </button>
                    <button type="button" onclick="filterStatus('active', this)" class="status-tab px-4 py-2 rounded-full font-semibold transition-all bg-surface text-on-surface-variant hover:text-primary shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] shrink-0">
                        Sedang Berjalan (<span id="count-active">{{ $bookings->whereIn('status_order', ['otw', 'working'])->count() }}</span>)
                    </button>
                    <button type="button" onclick="filterStatus('pending_payment', this)" class="status-tab px-4 py-2 rounded-full font-semibold transition-all bg-surface text-on-surface-variant hover:text-primary shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] shrink-0">
                        Menunggu Bayar (<span id="count-pending">{{ $bookings->where('status_order', 'pending_payment')->count() }}</span>)
                    </button>
                    <button type="button" onclick="filterStatus('completed', this)" class="status-tab px-4 py-2 rounded-full font-semibold transition-all bg-surface text-on-surface-variant hover:text-primary shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] shrink-0">
                        Selesai (<span id="count-completed">{{ $bookings->where('status_order', 'completed')->count() }}</span>)
                    </button>
                </div>
            </div>

            <!-- Orders List -->
            <div id="orders-list" class="space-y-4">
                @forelse($bookings as $booking)
                    <div class="order-item neu-card p-5 sm:p-6 space-y-4 transition-all hover:-translate-y-0.5"
                         data-status="{{ $booking->status_order }}"
                         data-search="#bk-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} {{ strtolower($booking->teknisi->nama_lengkap) }} {{ strtolower($booking->deskripsi_kerusakan) }}">

                        <!-- Top Meta Header -->
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-outline-variant/40 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-primary font-bold">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-outline-variant">&bull;</span>
                                <span class="text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->jadwal)->translatedFormat('d M Y, H:i') }} WIB</span>
                            </div>

                            @if($booking->status_order === 'completed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-secondary-container text-primary">
                                    ✓ Selesai
                                </span>
                            @elseif($booking->status_order === 'otw')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-tertiary-fixed text-on-tertiary-fixed flex items-center gap-1.5 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    <span>Teknisi OTW</span>
                                </span>
                            @elseif($booking->status_order === 'working')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-primary-fixed text-on-primary-fixed flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                    <span>Sedang Dikerjakan</span>
                                </span>
                            @elseif($booking->status_order === 'pending_payment')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-error-container text-on-error-container flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error animate-ping"></span>
                                    <span>Menunggu Pembayaran</span>
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold neu-inset-sm text-primary">{{ ucfirst($booking->status_order) }}</span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl neu-icon-primary font-extrabold text-xl font-recoleta shrink-0">
                                    {{ substr($booking->teknisi->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-title-sm text-primary font-bold font-butler">{{ $booking->teknisi->nama_lengkap }}</h3>
                                    <p class="text-xs text-secondary font-semibold">{{ $booking->teknisi->keahlian }} &bull; Rating ★ {{ number_format($booking->teknisi->rating, 1) }}</p>
                                    <div class="p-3 neu-inset text-xs text-on-surface-variant mt-2">
                                        <span class="font-bold text-primary">Keluhan:</span> {{ $booking->deskripsi_kerusakan }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-right shrink-0 pt-2 sm:pt-0">
                                <span class="text-[11px] text-outline block font-medium">Total Tarif:</span>
                                <span class="font-headline-sm text-primary font-bold font-butler">Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Card Footer Action -->
                        <div class="pt-3 border-t border-outline-variant/40 flex flex-col sm:flex-row items-center justify-end gap-2.5">
                            @if($booking->status_order === 'pending_payment')
                                <a href="{{ route('booking.payment', $booking->id) }}" class="w-full sm:w-auto px-6 py-2.5 neu-btn-primary text-xs gap-1.5">
                                    <span>Lanjutkan Pembayaran</span>
                                    <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                                </a>
                            @else
                                <a href="{{ route('tracking.chat', $booking->id) }}" class="w-full sm:w-auto px-5 py-2.5 neu-btn-secondary text-xs text-primary gap-1.5">
                                    <span class="material-symbols-outlined text-[17px] text-secondary">location_on</span>
                                    <span>Lacak GPS &amp; Chat Teknisi</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center neu-inset rounded-[28px]">
                        <div class="w-16 h-16 rounded-2xl neu-icon-teal mx-auto mb-3">
                            <span class="material-symbols-outlined text-[30px]">receipt_long</span>
                        </div>
                        <h3 class="font-title-md text-primary font-bold font-butler">Belum Ada Riwayat Pesanan</h3>
                        <p class="text-xs text-on-surface-variant mt-1">Mulai pesan teknisi perbaikan AC, pipa, listrik, atau atap bocor sekarang.</p>
                        <a href="{{ route('customer.technicians') }}" class="inline-flex mt-4 px-6 py-2.5 neu-btn-primary text-xs">
                            Cari Teknisi Terdekat
                        </a>
                    </div>
                @endforelse

                <div id="no-filter-match" class="hidden p-12 text-center neu-inset rounded-[28px]">
                    <p class="text-xs text-on-surface-variant">Tidak ada pesanan yang sesuai dengan filter atau pencarian Anda.</p>
                </div>
            </div>

        </div>

        <!-- Mobile Bottom Navigation -->
        <nav class="lg:hidden fixed bottom-0 inset-x-0 max-w-md mx-auto bg-surface/95 backdrop-blur-md shadow-[0_-6px_18px_rgba(0,0,0,0.08)] py-2.5 px-6 flex items-center justify-between z-30 rounded-t-3xl">
            <a href="{{ route('customer.home') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[22px]">home</span>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="{{ route('customer.orders') }}" class="flex flex-col items-center gap-0.5 text-primary-container">
                <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                <span class="text-[10px] font-bold">Pesanan</span>
            </a>
            <a href="{{ route('customer.technicians') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[22px]">search</span>
                <span class="text-[10px] font-medium">Cari Teknisi</span>
            </a>
            <a href="{{ route('customer.profile') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[22px]">person</span>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </nav>

    </div>

    @push('scripts')
    <script>
        let currentStatusFilter = 'all';
        let currentSearchQuery = '';

        const tabActiveClass = 'status-tab px-4 py-2 rounded-full font-bold transition-all bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(22,163,74,0.24)] shrink-0';
        const tabInactiveClass = 'status-tab px-4 py-2 rounded-full font-semibold transition-all bg-surface text-on-surface-variant hover:text-primary shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2] shrink-0';

        function applyFilters() {
            const items = document.querySelectorAll('.order-item');
            let visibleCount = 0;

            items.forEach(item => {
                const status = item.getAttribute('data-status');
                const searchData = item.getAttribute('data-search') || '';

                let matchesStatus = false;
                if (currentStatusFilter === 'all') {
                    matchesStatus = true;
                } else if (currentStatusFilter === 'active') {
                    matchesStatus = (status === 'otw' || status === 'working');
                } else {
                    matchesStatus = (status === currentStatusFilter);
                }

                const matchesSearch = currentSearchQuery === '' || searchData.includes(currentSearchQuery.toLowerCase());

                if (matchesStatus && matchesSearch) {
                    item.classList.remove('hidden');
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            const emptyEl = document.getElementById('no-filter-match');
            if (emptyEl) {
                if (visibleCount === 0 && items.length > 0) {
                    emptyEl.classList.remove('hidden');
                } else {
                    emptyEl.classList.add('hidden');
                }
            }
        }

        function filterStatus(status, btn) {
            currentStatusFilter = status;
            document.querySelectorAll('.status-tab').forEach(b => {
                b.className = tabInactiveClass;
            });
            btn.className = tabActiveClass;
            applyFilters();
        }

        document.getElementById('order-search').addEventListener('input', function(e) {
            currentSearchQuery = e.target.value.trim();
            applyFilters();
        });
    </script>
    @endpush
</x-layouts.app>
