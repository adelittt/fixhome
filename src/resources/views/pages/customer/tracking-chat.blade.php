<x-layouts.app title="Pelacakan & Chat - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-10">

        <div class="max-w-[1280px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg flex-1 flex flex-col space-y-5">

            <!-- Toast Notification Container -->
            <div id="live-toast" class="fixed top-24 right-5 z-[60] transform translate-x-[120%] opacity-0 transition-all duration-300 pointer-events-none">
                <div class="bg-primary text-on-primary px-5 py-4 rounded-[22px] shadow-2xl flex items-center gap-3.5 border border-tertiary-fixed/40 max-w-md">
                    <span id="live-toast-icon" class="text-2xl shrink-0">🛵</span>
                    <div>
                        <h4 id="live-toast-title" class="text-xs font-bold text-tertiary-fixed">Pemberitahuan Status</h4>
                        <p id="live-toast-msg" class="text-[11px] text-inverse-on-surface/90 mt-0.5 leading-snug">Pesan notifikasi real-time...</p>
                    </div>
                </div>
            </div>

            <!-- Top App Bar -->
            <div class="neu-card px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ $isTeknisi ? route('teknisi.dashboard') : route('customer.home') }}" class="w-10 h-10 rounded-full neu-btn-secondary text-primary shrink-0">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    </a>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="font-title-md text-primary font-bold font-recoleta leading-tight">
                                {{ $isTeknisi ? 'Customer: ' . $booking->customer->nama_lengkap : 'Teknisi: ' . $booking->teknisi->nama_lengkap }}
                            </h1>
                            <span id="badge-status" class="px-3 py-0.5 rounded-full text-[10px] font-bold transition-all {{ $booking->status_order === 'otw' ? 'bg-secondary-container text-primary animate-pulse' : ($booking->status_order === 'working' ? 'bg-primary-fixed text-on-primary-fixed' : ($booking->status_order === 'completed' ? 'bg-secondary-container text-primary' : 'bg-tertiary-fixed text-on-tertiary-fixed animate-bounce')) }}">
                                {{ $booking->status_order === 'paid' ? 'MENUNGGU TEKNISI BERANGKAT' : strtoupper($booking->status_order) }}
                            </span>
                        </div>
                        <span class="text-xs text-on-surface-variant mt-0.5 block">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} &bull; {{ $booking->teknisi->keahlian }}</span>
                    </div>
                </div>

                <!-- Controls -->
                <div class="flex flex-wrap items-center gap-2">
                    @if($isTeknisi)
                        <div class="flex flex-wrap items-center gap-1.5 neu-inset p-1.5 rounded-full">
                            <span class="text-[11px] font-bold text-primary px-2.5 hidden md:inline">Panel Teknisi:</span>
                            <button type="button" id="btn-tek-otw" onclick="teknisiSetStatus('otw')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ $booking->status_order === 'paid' ? 'bg-primary-container text-on-primary shadow animate-pulse' : ($booking->status_order === 'otw' ? 'bg-primary-container text-on-primary' : 'bg-surface text-on-surface-variant') }}">
                                🛵 Berangkat (OTW)
                            </button>
                            <button type="button" id="btn-tek-working" onclick="teknisiSetStatus('working')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ $booking->status_order === 'working' ? 'bg-primary-container text-on-primary shadow' : 'bg-surface text-on-surface-variant' }}">
                                🔧 Mulai Servis
                            </button>
                            <button type="button" id="btn-tek-completed" onclick="teknisiSetStatus('completed')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ $booking->status_order === 'completed' ? 'bg-primary text-on-primary' : 'bg-surface text-on-surface-variant' }}">
                                ✓ Selesai
                            </button>
                        </div>
                    @else
                        <div id="customer-action-box" class="flex items-center gap-2">
                            <button type="button" onclick="simulateTeknisiBerangkat()" class="neu-pill px-3.5 py-2 text-[11px] font-bold text-primary hover:-translate-y-0.5 transition-all" title="Klik ini jika ingin menguji saat teknisi menekan tombol OTW">
                                <span>⚡ Uji Teknisi Tekan OTW</span>
                            </button>
                        </div>
                    @endif

                    <!-- Mobile View Switcher -->
                    <div class="lg:hidden p-1 neu-inset rounded-full flex items-center gap-1">
                        <button type="button" id="tab-gps" onclick="switchMobileView('gps')" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-primary-container text-on-primary">
                            Peta GPS
                        </button>
                        <button type="button" id="tab-chat" onclick="switchMobileView('chat')" class="px-3.5 py-1.5 rounded-full text-xs font-semibold text-on-surface-variant hover:text-primary transition-all">
                            Chat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Split Screen: Map + Live Chat -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-stretch">

                <!-- LEFT: LIVE GPS MAP -->
                <div id="col-gps" class="lg:col-span-7 flex flex-col neu-card-lg overflow-hidden h-[560px] lg:h-[640px] relative">

                    <div id="map-tracking" class="w-full flex-1 min-h-[320px] z-0"></div>

                    <!-- Live Indicator Pill -->
                    <div class="absolute top-4 left-4 z-20 bg-surface/95 backdrop-blur-md px-3.5 py-1.5 rounded-full shadow-lg flex items-center gap-2 text-xs font-bold">
                        <span id="gps-pulse-dot" class="w-2.5 h-2.5 rounded-full {{ in_array($booking->status_order, ['otw', 'working']) ? 'bg-secondary animate-ping' : 'bg-tertiary' }}"></span>
                        <span id="gps-status-text" class="text-primary">
                            {{ $booking->status_order === 'paid' ? 'Menunggu Keberangkatan Teknisi' : 'Pelacakan Live GPS' }}
                        </span>
                    </div>

                    <!-- Speed Pill -->
                    <div class="absolute top-4 right-4 z-20 bg-surface/95 backdrop-blur-md px-3.5 py-1.5 rounded-full shadow-lg flex items-center gap-1.5 text-xs font-bold text-on-surface-variant">
                        <span>Kecepatan: <strong id="speed-display" class="text-primary">{{ $booking->status_order === 'otw' ? '32 km/jam' : '0 km/jam' }}</strong></span>
                    </div>

                    <!-- Road Navigation Banner (Google Maps Style) -->
                    <div id="nav-instruction-pill" class="hidden absolute bottom-[245px] sm:bottom-[235px] left-4 right-4 z-20 pointer-events-none flex justify-center">
                        <div class="bg-primary text-on-primary px-4 py-2 rounded-full shadow-xl flex items-center gap-2 text-xs font-semibold max-w-md border border-tertiary-fixed/30">
                            <span id="nav-turn-icon" class="material-symbols-outlined text-[18px] text-tertiary-fixed shrink-0">navigation</span>
                            <span id="nav-road-text" class="truncate">Menghitung rute jalan terbaik...</span>
                        </div>
                    </div>

                    <!-- Waiting Banner -->
                    <div id="waiting-otw-banner" class="{{ $booking->status_order === 'paid' ? '' : 'hidden' }} absolute inset-x-4 top-16 z-20 bg-tertiary-fixed/95 backdrop-blur-md p-4 rounded-[20px] shadow-lg text-on-tertiary-fixed flex items-start gap-3 transition-all">
                        <span class="text-2xl shrink-0">⏳</span>
                        <div>
                            <h4 class="font-bold text-xs text-primary">Teknisi Sedang Bersiap di Pangkalan/Bengkel</h4>
                            <p class="text-[11px] opacity-90 mt-0.5 leading-relaxed">
                                {{ $booking->teknisi->nama_lengkap }} sedang menyiapkan peralatan kerja. Segera setelah teknisi menekan tombol <strong>"Berangkat (OTW)"</strong>, pergerakan GPS akan aktif secara live.
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Info Panel -->
                    <div class="p-5 bg-surface space-y-4 z-10 border-t border-outline-variant/40">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-outline block">Estimasi Waktu Tiba (ETA)</span>
                                <h3 id="eta-display" class="font-headline-sm text-primary font-bold font-butler">
                                    {{ $booking->status_order === 'paid' ? 'Menunggu Teknisi Berangkat' : ($booking->status_order === 'otw' ? '11 Menit 30 Detik' : 'Tiba di Lokasi') }}
                                </h3>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-outline block">Sisa Jarak</span>
                                <span id="distance-display" class="text-sm font-bold text-secondary">
                                    {{ $booking->status_order === 'paid' ? '1.8 km (Standby)' : ($booking->status_order === 'otw' ? '1.8 km' : '0 km') }}
                                </span>
                            </div>
                        </div>

                        <!-- Stepper Progress -->
                        <div class="grid grid-cols-4 gap-2 text-center text-[11px] font-bold pt-3 border-t border-outline-variant/40">
                            <div class="flex flex-col items-center gap-1 text-primary">
                                <div class="w-7 h-7 rounded-full bg-primary-container text-on-primary flex items-center justify-center text-xs shadow">✓</div>
                                <span>Lunas</span>
                            </div>
                            <div id="step-otw" class="flex flex-col items-center gap-1 {{ in_array($booking->status_order, ['otw', 'working', 'completed']) ? 'text-primary' : 'text-outline' }} transition-colors">
                                <div class="w-7 h-7 rounded-full {{ in_array($booking->status_order, ['otw', 'working', 'completed']) ? 'bg-primary-container text-on-primary' : 'neu-inset-sm text-outline' }} flex items-center justify-center text-xs">2</div>
                                <span>Meluncur</span>
                            </div>
                            <div id="step-working" class="flex flex-col items-center gap-1 {{ in_array($booking->status_order, ['working', 'completed']) ? 'text-primary' : 'text-outline' }} transition-colors">
                                <div class="w-7 h-7 rounded-full {{ in_array($booking->status_order, ['working', 'completed']) ? 'bg-primary-container text-on-primary' : 'neu-inset-sm text-outline' }} flex items-center justify-center text-xs">3</div>
                                <span>Perbaikan</span>
                            </div>
                            <div id="step-completed" class="flex flex-col items-center gap-1 {{ $booking->status_order === 'completed' ? 'text-primary' : 'text-outline' }} transition-colors">
                                <div class="w-7 h-7 rounded-full {{ $booking->status_order === 'completed' ? 'bg-primary-container text-on-primary' : 'neu-inset-sm text-outline' }} flex items-center justify-center text-xs">4</div>
                                <span>Selesai</span>
                            </div>
                        </div>

                        <!-- Alamat Tujuan -->
                        <div class="p-3.5 neu-inset text-xs flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-9 h-9 rounded-xl neu-icon-teal shrink-0">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                </div>
                                <div class="overflow-hidden">
                                    <span class="font-bold text-primary block truncate">Tujuan: Rumah Customer</span>
                                    <p class="text-xs text-on-surface-variant truncate">{{ $booking->customer->alamat_lengkap }}</p>
                                </div>
                            </div>
                            @if($isCustomer && $booking->status_order !== 'completed')
                                <button type="button" onclick="openReviewModal()" class="neu-btn-primary px-4 py-2 text-xs shrink-0">
                                    Konfirmasi Selesai
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- RIGHT: LIVE TWO-WAY SYNC CHAT -->
                <div id="col-chat" class="hidden lg:flex lg:col-span-5 flex-col neu-card-lg overflow-hidden h-[560px] lg:h-[640px]">

                    <!-- Chat Header -->
                    <div class="p-4 bg-surface border-b border-outline-variant/40 flex items-center justify-between shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl neu-icon-primary font-bold text-sm font-recoleta">
                                {{ substr($isTeknisi ? $booking->customer->nama_lengkap : $booking->teknisi->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <span class="font-title-sm text-sm font-bold text-primary font-butler block">
                                    {{ $isTeknisi ? $booking->customer->nama_lengkap : $booking->teknisi->nama_lengkap }}
                                </span>
                                <span class="text-[10px] text-secondary font-semibold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-ping"></span> Online &bull; Terhubung
                                </span>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-secondary-container text-primary rounded-full text-[10px] font-bold">
                            Chat Aktif
                        </span>
                    </div>

                    <!-- Messages Bubble Container -->
                    <div id="chat-messages" class="chat-scroll flex-1 min-h-0 overflow-y-auto p-4 space-y-3 text-xs bg-surface-container-low/60">
                        <div class="text-center my-2">
                            <span class="px-3.5 py-1 bg-secondary-container/80 text-primary rounded-full text-[10px] font-semibold">
                                Kanal Chat Dua Arah Aktif
                            </span>
                        </div>

                        <div id="messages-list" class="space-y-3">
                            @forelse($booking->chatMessages as $msg)
                                @php $isMe = $msg->sender_id === Auth::id(); @endphp
                                <div class="chat-bubble-item flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}" data-id="{{ $msg->id }}">
                                    <span class="text-[9px] text-outline mb-0.5 px-1">{{ $msg->sender->name }}</span>
                                    <div class="p-3 rounded-2xl max-w-[85%] {{ $isMe ? 'bg-primary-container text-on-primary rounded-tr-none shadow-sm' : 'bg-surface text-on-surface rounded-tl-none shadow-[-3px_-3px_6px_#FFFFFF,3px_3px_6px_#D2D2D2]' }}">
                                        {{ $msg->pesan }}
                                    </div>
                                    <span class="text-[9px] text-outline mt-0.5 px-1">{{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            @empty
                                <div class="text-center text-outline text-xs py-10" id="empty-notice">
                                    Belum ada obrolan. Ketik pesan untuk mulai berkoordinasi langsung!
                                </div>
                            @endforelse
                        </div>

                        <div id="typing-indicator" class="hidden flex items-center gap-1.5 p-3 rounded-2xl bg-surface w-fit text-on-surface-variant shadow-sm">
                            <span class="text-[11px] font-medium">{{ $isTeknisi ? $booking->customer->nama_lengkap : $booking->teknisi->nama_lengkap }} sedang mengetik</span>
                            <span class="flex gap-0.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-outline animate-bounce"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-outline animate-bounce [animation-delay:0.2s]"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-outline animate-bounce [animation-delay:0.4s]"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Quick Replies -->
                    <div class="p-2.5 border-t border-outline-variant/40 bg-surface flex items-center gap-2 overflow-x-auto hide-scrollbar text-[11px] shrink-0">
                        @if($isTeknisi)
                            <button type="button" onclick="sendQuickReply('Halo kak, saya sedang bersiap dan segera meluncur.')" class="neu-pill px-3 py-1 text-on-surface-variant hover:text-primary shrink-0 font-medium">
                                🛵 Segera meluncur
                            </button>
                            <button type="button" onclick="sendQuickReply('Sudah dekat perempatan jalan utama ya kak.')" class="neu-pill px-3 py-1 text-on-surface-variant hover:text-primary shrink-0 font-medium">
                                📍 Sudah dekat
                            </button>
                            <button type="button" onclick="sendQuickReply('Saya sudah sampai di depan rumah kak.')" class="neu-pill px-3 py-1 text-on-surface-variant hover:text-primary shrink-0 font-medium">
                                🏠 Sudah di depan
                            </button>
                        @else
                            <button type="button" onclick="sendQuickReply('Halo pak, posisi sudah di mana ya?')" class="neu-pill px-3 py-1 text-on-surface-variant hover:text-primary shrink-0 font-medium">
                                📍 Posisi di mana?
                            </button>
                            <button type="button" onclick="sendQuickReply('Pagar rumah sudah saya buka ya pak.')" class="neu-pill px-3 py-1 text-on-surface-variant hover:text-primary shrink-0 font-medium">
                                🚪 Pagar terbuka
                            </button>
                            <button type="button" onclick="sendQuickReply('Tangga lipat sudah disiapkan di teras.')" class="neu-pill px-3 py-1 text-on-surface-variant hover:text-primary shrink-0 font-medium">
                                🪜 Tangga siap
                            </button>
                        @endif
                    </div>

                    <!-- Live AJAX Chat Form -->
                    <form id="chat-form" onsubmit="handleChatSubmit(event)" class="p-3 bg-surface border-t border-outline-variant/40 flex items-center gap-2.5 shrink-0">
                        @csrf
                        <input type="text" id="chat-input" name="pesan" required autocomplete="off"
                            class="flex-1 neu-input rounded-full px-4 py-3 text-xs"
                            placeholder="{{ $isTeknisi ? 'Ketik pesan ke Customer...' : 'Ketik pesan ke Teknisi...' }}">

                        <button type="submit" id="btn-send" class="w-11 h-11 rounded-full neu-btn-primary shrink-0">
                            <span class="material-symbols-outlined text-[20px]">send</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- REVIEW MODAL (Hanya untuk Customer) -->
        @if($isCustomer)
        <div id="review-modal" class="{{ ($booking->status_order === 'completed' && !$booking->ulasan) ? '' : 'hidden' }} fixed inset-0 z-50 bg-primary/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="neu-card-lg w-full max-w-md p-6 sm:p-8 space-y-5">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl neu-icon-gold mx-auto mb-3">
                        <span class="material-symbols-outlined text-[28px]">celebration</span>
                    </div>
                    <h3 class="font-headline-sm text-primary font-bold font-recoleta">Pekerjaan Selesai!</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Beri rating bintang dan ulasan kepuasan untuk teknisi Anda (UC-12)</p>
                </div>

                <form id="review-form" onsubmit="handleReviewSubmit(event)" class="space-y-4">
                    @csrf
                    <input type="hidden" name="rating" id="review-rating-input" value="5">

                    <div class="flex flex-col items-center gap-1.5">
                        <div class="flex items-center justify-center gap-2 text-4xl text-tertiary select-none cursor-pointer">
                            <span class="star-btn hover:scale-125 transition-transform" data-val="1" onclick="setRating(1)">★</span>
                            <span class="star-btn hover:scale-125 transition-transform" data-val="2" onclick="setRating(2)">★</span>
                            <span class="star-btn hover:scale-125 transition-transform" data-val="3" onclick="setRating(3)">★</span>
                            <span class="star-btn hover:scale-125 transition-transform" data-val="4" onclick="setRating(4)">★</span>
                            <span class="star-btn hover:scale-125 transition-transform" data-val="5" onclick="setRating(5)">★</span>
                        </div>
                        <span id="rating-label" class="text-xs font-bold text-primary">5 Bintang - Sangat Puas! ⭐</span>
                    </div>

                    <div>
                        <textarea id="review-comment" name="komentar" rows="3" class="neu-input text-xs p-3.5"
                            placeholder="Bagaimana hasil servis teknisi? Tulis ulasan singkat..."></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" onclick="closeReviewModal()" class="w-1/3 py-3 neu-btn-secondary text-xs text-on-surface-variant">
                            Nanti
                        </button>
                        <button type="submit" id="btn-submit-review" class="flex-1 neu-btn-primary py-3 text-xs gap-1.5">
                            <span>Kirim Ulasan &amp; Selesai</span>
                            <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>

    @push('scripts')
    <script>
        const bookingId = {{ $booking->id }};
        const currentUserId = {{ Auth::id() }};
        const currentUserName = @json(Auth::user()->name);
        const technicianName = @json($booking->teknisi->nama_lengkap);
        const isTeknisi = {{ $isTeknisi ? 'true' : 'false' }};
        const isCustomer = {{ $isCustomer ? 'true' : 'false' }};
        const csrfToken = @json(csrf_token());

        let currentOrderStatus = @json($booking->status_order);
        let map, tekMarker, routeCasingLine, remainingRouteLine, traveledRouteLine;
        let routeCoords = [];
        let routeCumDist = [];
        let routeSteps = [];
        let totalRouteMeters = 1800;
        let totalRouteSeconds = 420;
        let animProgress = 0;
        let animInterval = null;
        let knownMessageIds = new Set();

        const custLat = {{ $booking->customer->latitude ?? -6.2155 }};
        const custLng = {{ $booking->customer->longitude ?? 106.8205 }};
        const startTekLat = {{ $booking->latestPelacakan?->current_lat ?? $booking->teknisi->latitude ?? -6.2240 }};
        const startTekLng = {{ $booking->latestPelacakan?->current_lng ?? $booking->teknisi->longitude ?? 106.8260 }};

        document.querySelectorAll('.chat-bubble-item').forEach(el => {
            const id = el.getAttribute('data-id');
            if (id) knownMessageIds.add(parseInt(id, 10));
        });

        function playChimeSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(587.33, ctx.currentTime);
                osc.frequency.setValueAtTime(880, ctx.currentTime + 0.15);
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.6);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.6);
            } catch (e) {}
        }

        function showLiveToast(title, message, icon = '🛵') {
            const toast = document.getElementById('live-toast');
            document.getElementById('live-toast-title').textContent = title;
            document.getElementById('live-toast-msg').textContent = message;
            document.getElementById('live-toast-icon').textContent = icon;

            toast.classList.remove('translate-x-[120%]', 'opacity-0');
            playChimeSound();

            setTimeout(() => {
                toast.classList.add('translate-x-[120%]', 'opacity-0');
            }, 5000);
        }

        function switchMobileView(tab) {
            const gpsTab = document.getElementById('tab-gps');
            const chatTab = document.getElementById('tab-chat');
            const gpsCol = document.getElementById('col-gps');
            const chatCol = document.getElementById('col-chat');

            const activeBtn = 'px-3.5 py-1.5 rounded-full text-xs font-bold transition-all bg-primary-container text-on-primary';
            const inactiveBtn = 'px-3.5 py-1.5 rounded-full text-xs font-semibold text-on-surface-variant hover:text-primary transition-all';

            if (tab === 'gps') {
                gpsTab.className = activeBtn;
                chatTab.className = inactiveBtn;
                gpsCol.classList.remove('hidden');
                chatCol.classList.add('hidden');
            } else {
                chatTab.className = activeBtn;
                gpsTab.className = inactiveBtn;
                chatCol.classList.remove('hidden');
                gpsCol.classList.add('hidden');
                scrollToBottom();
            }
        }

        function openReviewModal() {
            if (!isCustomer) return;
            const modal = document.getElementById('review-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeReviewModal() {
            const modal = document.getElementById('review-modal');
            if (modal) modal.classList.add('hidden');
        }

        function scrollToBottom() {
            const box = document.getElementById('chat-messages');
            box.scrollTop = box.scrollHeight;
        }

        async function handleChatSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            if (!message) return;

            input.value = '';

            try {
                const response = await fetch(`/chat/${bookingId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ pesan: message })
                });

                const data = await response.json();
                if (data.status === 'success' && data.message) {
                    knownMessageIds.add(data.message.id);
                    appendChatMessage(currentUserName, data.message.pesan, true, data.message.id);
                }
            } catch (err) {
                appendChatMessage(currentUserName, message, true);
            }
        }

        function sendQuickReply(text) {
            document.getElementById('chat-input').value = text;
            document.getElementById('chat-form').dispatchEvent(new Event('submit'));
        }

        function appendChatMessage(senderName, text, isMe, msgId = null) {
            const list = document.getElementById('messages-list');
            const emptyNotice = document.getElementById('empty-notice');
            if (emptyNotice) emptyNotice.remove();

            const timeNow = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            const div = document.createElement('div');
            div.className = `chat-bubble-item flex flex-col ${isMe ? 'items-end' : 'items-start'}`;
            if (msgId) div.setAttribute('data-id', String(msgId));

            const senderSpan = document.createElement('span');
            senderSpan.className = 'text-[9px] text-outline mb-0.5 px-1';
            senderSpan.textContent = senderName;

            const bubble = document.createElement('div');
            bubble.className = `p-3 rounded-2xl max-w-[85%] ${isMe ? 'bg-primary-container text-on-primary rounded-tr-none shadow-sm' : 'bg-surface text-on-surface rounded-tl-none shadow-[-3px_-3px_6px_#FFFFFF,3px_3px_6px_#D2D2D2]'}`;
            bubble.textContent = text;

            const timeSpan = document.createElement('span');
            timeSpan.className = 'text-[9px] text-outline mt-0.5 px-1';
            timeSpan.textContent = timeNow;

            div.appendChild(senderSpan);
            div.appendChild(bubble);
            div.appendChild(timeSpan);
            list.appendChild(div);
            scrollToBottom();
        }

        async function pollChatMessages() {
            try {
                const res = await fetch(`/api/chat/${bookingId}`);
                if (!res.ok) return;
                const data = await res.json();

                if (data.messages && Array.isArray(data.messages)) {
                    let hasNew = false;
                    data.messages.forEach(msg => {
                        if (!knownMessageIds.has(msg.id)) {
                            knownMessageIds.add(msg.id);
                            const isMe = msg.sender_id === currentUserId;
                            const senderName = msg.sender ? msg.sender.name : 'Pengguna';
                            appendChatMessage(senderName, msg.pesan, isMe, msg.id);
                            if (!isMe) {
                                playChimeSound();
                            }
                            hasNew = true;
                        }
                    });
                    if (hasNew) scrollToBottom();
                }
            } catch (e) {}
        }

        async function teknisiSetStatus(newStatus) {
            const formData = new FormData();
            formData.append('status_order', newStatus);

            try {
                await fetch(`/teknisi/job-status/${bookingId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                applyOrderStatus(newStatus);
                showLiveToast('Status Berhasil Diubah', `Status pesanan kini: ${newStatus.toUpperCase()}`, '✅');
                pollChatMessages();
            } catch (err) {}
        }

        function simulateTeknisiBerangkat() {
            teknisiSetStatus('otw');
        }

        function activateStep(stepId) {
            const step = document.getElementById(stepId);
            if (!step) return;
            step.className = 'flex flex-col items-center gap-1 text-primary font-bold';
            const circle = step.querySelector('div');
            if (circle) {
                circle.className = 'w-7 h-7 rounded-full bg-primary-container text-on-primary flex items-center justify-center text-xs shadow';
            }
        }

        function applyOrderStatus(newStatus) {
            const prevStatus = currentOrderStatus;
            currentOrderStatus = newStatus;

            const badge = document.getElementById('badge-status');
            const banner = document.getElementById('waiting-otw-banner');
            const gpsDot = document.getElementById('gps-pulse-dot');
            const gpsText = document.getElementById('gps-status-text');

            if (newStatus === 'paid') {
                badge.textContent = 'MENUNGGU TEKNISI BERANGKAT';
                badge.className = 'px-3 py-0.5 rounded-full text-[10px] font-bold bg-tertiary-fixed text-on-tertiary-fixed animate-bounce';
                if (banner) banner.classList.remove('hidden');
                gpsDot.className = 'w-2.5 h-2.5 rounded-full bg-tertiary';
                gpsText.textContent = 'Menunggu Keberangkatan Teknisi';
            } else if (newStatus === 'otw') {
                badge.textContent = 'MELUNCUR (OTW)';
                badge.className = 'px-3 py-0.5 rounded-full text-[10px] font-bold bg-secondary-container text-primary animate-pulse';
                if (banner) banner.classList.add('hidden');
                gpsDot.className = 'w-2.5 h-2.5 rounded-full bg-secondary animate-ping';
                gpsText.textContent = 'Pelacakan Live GPS (BR-06)';
                activateStep('step-otw');

                if (prevStatus === 'paid') {
                    showLiveToast('🛵 Teknisi Sudah Berangkat!', `Mitra teknisi ${technicianName} telah meluncur menuju alamat rumah Anda.`, '🛵');
                }
                startGpsAnimation();
            } else if (newStatus === 'working') {
                badge.textContent = 'SEDANG DIKERJAKAN';
                badge.className = 'px-3 py-0.5 rounded-full text-[10px] font-bold bg-primary-fixed text-on-primary-fixed';
                if (banner) banner.classList.add('hidden');
                activateStep('step-otw');
                activateStep('step-working');

                if (prevStatus !== 'working') {
                    showLiveToast('🔧 Teknisi Telah Tiba', `${technicianName} sudah berada di lokasi Anda dan memulai proses perbaikan.`, '🔧');
                }
            } else if (newStatus === 'completed') {
                badge.textContent = 'SELESAI';
                badge.className = 'px-3 py-0.5 rounded-full text-[10px] font-bold bg-secondary-container text-primary';
                if (banner) banner.classList.add('hidden');
                activateStep('step-otw');
                activateStep('step-working');
                activateStep('step-completed');
                if (isCustomer) {
                    openReviewModal();
                } else if (isTeknisi && prevStatus !== 'completed') {
                    showLiveToast('Pekerjaan Selesai!', 'Status pesanan tuntas. Hak bersih 95% tercatat di Dompet Mitra Anda.', '🎉');
                }
            }
        }

        async function pollGpsStatus() {
            try {
                const res = await fetch(`/api/gps/${bookingId}`);
                if (!res.ok) return;
                const data = await res.json();
                if (data.status_order && data.status_order !== currentOrderStatus) {
                    applyOrderStatus(data.status_order);
                }
            } catch (e) {}
        }

        function haversineMeters(a, b) {
            const R = 6371000;
            const dLat = (b[0] - a[0]) * Math.PI / 180;
            const dLng = (b[1] - a[1]) * Math.PI / 180;
            const lat1 = a[0] * Math.PI / 180;
            const lat2 = b[0] * Math.PI / 180;
            const x = Math.sin(dLat / 2) ** 2 + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dLng / 2) ** 2;
            return 2 * R * Math.atan2(Math.sqrt(x), Math.sqrt(1 - x));
        }

        function buildRouteMetrics(coords) {
            routeCoords = coords;
            routeCumDist = [0];
            let sum = 0;
            for (let i = 1; i < coords.length; i++) {
                sum += haversineMeters(coords[i - 1], coords[i]);
                routeCumDist.push(sum);
            }
            if (sum > 0) {
                totalRouteMeters = sum;
            }
        }

        function interpolateAlongRoute(fraction) {
            if (!routeCoords || routeCoords.length < 2) {
                return { point: [startTekLat, startTekLng], traveled: [], remaining: [] };
            }
            const clamped = Math.max(0, Math.min(1, fraction));
            const totalLen = routeCumDist[routeCumDist.length - 1] || 1;
            const targetDist = clamped * totalLen;

            let segIdx = 0;
            while (segIdx < routeCumDist.length - 2 && routeCumDist[segIdx + 1] < targetDist) {
                segIdx++;
            }

            const segStartDist = routeCumDist[segIdx];
            const segEndDist = routeCumDist[segIdx + 1];
            const segRatio = segEndDist > segStartDist ? (targetDist - segStartDist) / (segEndDist - segStartDist) : 0;

            const p1 = routeCoords[segIdx];
            const p2 = routeCoords[segIdx + 1];
            const currentPoint = [
                p1[0] + (p2[0] - p1[0]) * segRatio,
                p1[1] + (p2[1] - p1[1]) * segRatio,
            ];

            const traveled = routeCoords.slice(0, segIdx + 1).concat([currentPoint]);
            const remaining = [currentPoint].concat(routeCoords.slice(segIdx + 1));

            return { point: currentPoint, traveled, remaining };
        }

        function getTurnIcon(type, modifier) {
            if (type === 'arrive') return 'flag';
            if (modifier.includes('left')) return 'turn_left';
            if (modifier.includes('right')) return 'turn_right';
            if (type === 'roundabout') return 'roundabout_right';
            return 'straight';
        }

        function updateNavBanner(currentPoint) {
            const pill = document.getElementById('nav-instruction-pill');
            const roadText = document.getElementById('nav-road-text');
            const turnIcon = document.getElementById('nav-turn-icon');
            if (!pill || !routeSteps.length) return;

            let nearest = routeSteps[0];
            let bestDist = Infinity;
            for (const step of routeSteps) {
                const d = haversineMeters(currentPoint, [step.lat, step.lng]);
                if (d < bestDist) {
                    bestDist = d;
                    nearest = step;
                }
            }

            pill.classList.remove('hidden');
            roadText.textContent = nearest.type === 'arrive'
                ? 'Hampir tiba di alamat rumah Anda'
                : `Melintasi ${nearest.road}`;
            turnIcon.textContent = getTurnIcon(nearest.type, nearest.modifier || '');
        }

        async function loadRoadRoute() {
            try {
                const res = await fetch(`{{ route('api.route.fetch', $booking->id) }}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Route fetch failed');
                const data = await res.json();

                if (data.coordinates && data.coordinates.length >= 2) {
                    buildRouteMetrics(data.coordinates);
                    if (data.distance_m > 0) totalRouteMeters = data.distance_m;
                    if (data.duration_s > 0) totalRouteSeconds = Math.max(120, Math.round(data.duration_s));
                    routeSteps = Array.isArray(data.steps) ? data.steps : [];

                    // Render Google Maps style road route (white casing + solid FixHome espresso route)
                    if (routeCasingLine) map.removeLayer(routeCasingLine);
                    if (remainingRouteLine) map.removeLayer(remainingRouteLine);
                    if (traveledRouteLine) map.removeLayer(traveledRouteLine);

                    routeCasingLine = L.polyline(routeCoords, {
                        color: '#ffffff',
                        weight: 9,
                        opacity: 0.92,
                        lineCap: 'round',
                        lineJoin: 'round',
                    }).addTo(map);

                    traveledRouteLine = L.polyline([routeCoords[0]], {
                        color: '#b5a89d',
                        weight: 5,
                        opacity: 0.75,
                        dashArray: '6, 8',
                        lineCap: 'round',
                        lineJoin: 'round',
                    }).addTo(map);

                    remainingRouteLine = L.polyline(routeCoords, {
                        color: '#775537',
                        weight: 5.5,
                        opacity: 0.95,
                        lineCap: 'round',
                        lineJoin: 'round',
                    }).addTo(map);

                    tekMarker.setLatLng(routeCoords[0]);
                    map.fitBounds(remainingRouteLine.getBounds(), { padding: [48, 48] });

                    const initialKm = (totalRouteMeters / 1000).toFixed(1);
                    if (currentOrderStatus === 'paid') {
                        document.getElementById('distance-display').textContent = `${initialKm} km (Standby)`;
                    } else if (currentOrderStatus === 'otw') {
                        document.getElementById('distance-display').textContent = `${initialKm} km`;
                    }

                    updateNavBanner(routeCoords[0]);
                }
            } catch (e) {
                buildRouteMetrics([[startTekLat, startTekLng], [custLat, custLng]]);
                remainingRouteLine = L.polyline(routeCoords, { color: '#775537', weight: 5, lineCap: 'round' }).addTo(map);
            }
        }

        async function initMap() {
            map = L.map('map-tracking', {
                center: [(custLat + startTekLat) / 2, (custLng + startTekLng) / 2],
                zoom: 15,
                zoomControl: false
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Custom Customer House Pin (FixHome theme)
            const homeIcon = L.divIcon({
                className: 'custom-home-pin',
                html: '<div style="background-color:#4c6264; color:white; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; border:3px solid #ffffff; box-shadow:0 6px 14px rgba(76,98,100,0.4); font-size:17px;">🏠</div>',
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });
            L.marker([custLat, custLng], { icon: homeIcon }).addTo(map).bindPopup('Rumah Anda (Customer)');

            // Custom Technician Scooter Pin
            const tekIcon = L.divIcon({
                className: 'custom-tek-pin',
                html: '<div style="background-color:#775537; color:white; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; border:3px solid #ffffff; box-shadow:0 6px 14px rgba(93,62,34,0.45); font-size:19px;">🛵</div>',
                iconSize: [40, 40],
                iconAnchor: [20, 20]
            });
            tekMarker = L.marker([startTekLat, startTekLng], { icon: tekIcon, zIndexOffset: 500 }).addTo(map).bindPopup(technicianName);

            await loadRoadRoute();

            if (currentOrderStatus === 'otw') {
                startGpsAnimation();
            } else if (currentOrderStatus === 'working' || currentOrderStatus === 'completed') {
                const endPt = routeCoords.length ? routeCoords[routeCoords.length - 1] : [custLat, custLng];
                tekMarker.setLatLng(endPt);
                if (traveledRouteLine && routeCoords.length) traveledRouteLine.setLatLngs(routeCoords);
                if (remainingRouteLine) remainingRouteLine.setLatLngs([]);
                document.getElementById('eta-display').textContent = 'Teknisi Telah Tiba di Lokasi!';
                document.getElementById('distance-display').textContent = '0 km';
                document.getElementById('speed-display').textContent = '0 km/jam';
            }
        }

        function startGpsAnimation() {
            if (animInterval) clearInterval(animInterval);
            if (!routeCoords || routeCoords.length < 2) {
                buildRouteMetrics([[startTekLat, startTekLng], [custLat, custLng]]);
            }

            animProgress = 0;
            const totalSteps = 160;
            const baseEtaSeconds = totalRouteSeconds || 420;

            animInterval = setInterval(() => {
                if (animProgress < totalSteps) {
                    animProgress += 0.5;
                    const fraction = animProgress / totalSteps;
                    const state = interpolateAlongRoute(fraction);

                    tekMarker.setLatLng(state.point);
                    if (traveledRouteLine) traveledRouteLine.setLatLngs(state.traveled);
                    if (remainingRouteLine) remainingRouteLine.setLatLngs(state.remaining);

                    updateNavBanner(state.point);

                    const remKm = Math.max(0.1, ((totalRouteMeters * (1 - fraction)) / 1000)).toFixed(1);
                    document.getElementById('distance-display').textContent = `${remKm} km`;

                    const remSeconds = Math.max(15, Math.round(baseEtaSeconds * (1 - fraction)));
                    const mins = Math.floor(remSeconds / 60);
                    const secs = remSeconds % 60;
                    document.getElementById('eta-display').textContent = `${mins} Menit ${secs} Detik`;

                    const speed = 26 + Math.floor(Math.random() * 10);
                    document.getElementById('speed-display').textContent = `${speed} km/jam`;

                    if (animProgress >= totalSteps * 0.92 && currentOrderStatus === 'otw') {
                        document.getElementById('badge-status').textContent = 'TIBA DI LOKASI';
                        activateStep('step-working');
                    }
                } else {
                    clearInterval(animInterval);
                    const endPt = routeCoords[routeCoords.length - 1];
                    tekMarker.setLatLng(endPt);
                    if (traveledRouteLine) traveledRouteLine.setLatLngs(routeCoords);
                    if (remainingRouteLine) remainingRouteLine.setLatLngs([]);
                    document.getElementById('eta-display').textContent = 'Teknisi Telah Tiba di Lokasi!';
                    document.getElementById('distance-display').textContent = '0 km';
                    document.getElementById('speed-display').textContent = '0 km/jam';
                    const roadText = document.getElementById('nav-road-text');
                    if (roadText) roadText.textContent = 'Teknisi telah tiba di alamat tujuan';
                }
            }, 600);
        }

        function setRating(val) {
            document.getElementById('review-rating-input').value = val;
            const labels = {
                1: '1 Bintang - Sangat Kecewa 😞',
                2: '2 Bintang - Kurang Memuaskan 🙁',
                3: '3 Bintang - Cukup Baik 😐',
                4: '4 Bintang - Puas & Rapi 😊',
                5: '5 Bintang - Sangat Puas! ⭐'
            };
            document.getElementById('rating-label').textContent = labels[val] || `${val} Bintang`;

            document.querySelectorAll('.star-btn').forEach((s, idx) => {
                s.classList.toggle('text-tertiary', idx < val);
                s.classList.toggle('text-outline-variant', idx >= val);
            });
        }

        async function handleReviewSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-review');
            const rating = document.getElementById('review-rating-input').value;
            const comment = document.getElementById('review-comment').value;

            btn.disabled = true;
            btn.textContent = 'Mengirim Ulasan...';

            try {
                const response = await fetch(`/review/${bookingId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ rating: rating, komentar: comment })
                });

                if (response.status === 401) {
                    showLiveToast('Sesi Berakhir', 'Mengarahkan Anda kembali ke halaman login...', '🔒');
                    setTimeout(() => { window.location.href = '/login'; }, 1000);
                    return;
                }

                const data = await response.json();
                if (data.status === 'success') {
                    btn.textContent = '✓ Ulasan Terkirim!';
                    showLiveToast('Ulasan Diterima', 'Terima kasih atas ulasan dan rating Anda!', '⭐');
                    setTimeout(() => {
                        window.location.href = data.redirect || '/customer/orders';
                    }, 1200);
                } else {
                    throw new Error(data.message || 'Gagal mengirim ulasan');
                }
            } catch (err) {
                document.getElementById('review-form').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            initMap();
            scrollToBottom();
            setInterval(pollChatMessages, 2500);
            setInterval(pollGpsStatus, 2500);
        });
    </script>
    @endpush
</x-layouts.app>
