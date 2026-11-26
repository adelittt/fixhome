<x-layouts.app title="Daftar Teknisi - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <div class="max-w-[1140px] mx-auto w-full px-gutter lg:px-margin pt-space-md sm:pt-space-lg">

            <!-- Page Header -->
            <div class="mb-space-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4 neu-card p-6">
                <div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('customer.home') }}" class="lg:hidden w-9 h-9 rounded-full neu-btn-secondary text-primary">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </a>
                        <div>
                            <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta leading-tight">Daftar Teknisi Siap Kerja (Ready)</h1>
                        </div>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Disaring berdasarkan radius jarak terdekat dan ketersediaan kerja aktif.</p>
                </div>

                <div class="flex items-center gap-2 text-xs shrink-0">
                    <span id="counter-badge" class="px-4 py-2 rounded-full bg-secondary-container text-primary font-bold shadow-[inset_2px_2px_4px_#B2CED0,inset_-2px_-2px_4px_#E6FAFC]">
                        {{ $technicians->count() }} Teknisi Ditemukan
                    </span>
                </div>
            </div>

            <!-- 2-Column Layout: Sidebar Filter + Grid Results -->
            <div class="lg:grid lg:grid-cols-12 lg:gap-space-lg items-start">

                <!-- Left Sidebar Filter -->
                <div class="lg:col-span-3 space-y-4 mb-6 lg:mb-0">
                    <div class="neu-card p-5 space-y-5 sticky top-24">
                        <div class="flex items-center justify-between">
                            <h3 class="font-title-sm text-sm font-bold text-primary font-butler">Cari &amp; Saring Instan</h3>
                            <button type="button" onclick="resetFilters()" class="text-xs font-bold text-secondary hover:text-primary transition-colors">Reset</button>
                        </div>

                        <!-- Live Search Input -->
                        <div>
                            <label class="block font-label-sm text-on-surface-variant font-semibold mb-1.5">Ketik Nama / Layanan</label>
                            <div class="neu-inset rounded-full flex items-center px-3.5 py-2">
                                <span class="material-symbols-outlined text-primary text-[18px] mr-2">search</span>
                                <input type="text" id="live-search" oninput="applyFilters()" value="{{ $search ?? '' }}"
                                    class="w-full bg-transparent text-xs text-on-surface placeholder:text-outline focus:outline-none"
                                    placeholder="Cari Budi, AC, listrik...">
                            </div>
                        </div>

                        <!-- Live Radius Distance Slider -->
                        <div class="space-y-2.5 pt-3 border-t border-outline-variant/40">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-on-surface-variant">Maksimal Radius:</span>
                                <span id="radius-val" class="text-primary font-extrabold bg-tertiary-fixed px-2.5 py-0.5 rounded-full">35 km</span>
                            </div>
                            <input type="range" id="radius-slider" min="1" max="35" value="35" step="1" oninput="updateRadius(this.value)"
                                class="w-full h-2 bg-surface-container-highest rounded-lg appearance-none cursor-pointer accent-primary-container">
                            <div class="flex justify-between text-[10px] text-outline font-semibold">
                                <span>1 km</span>
                                <span>10 km</span>
                                <span>20 km</span>
                                <span class="text-primary font-bold">35 km</span>
                            </div>
                        </div>

                        <!-- Category Selector -->
                        <div class="pt-3 border-t border-outline-variant/40">
                            <label class="block font-label-sm text-on-surface-variant font-semibold mb-2.5">Kategori Spesialisasi</label>
                            <div class="flex lg:flex-col gap-2 overflow-x-auto hide-scrollbar pb-1 lg:pb-0">
                                <button type="button" onclick="selectCategory('')" id="cat-btn-all"
                                    class="cat-filter-btn px-3.5 py-2.5 rounded-full text-xs font-bold text-left shrink-0 transition-all bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(22,163,74,0.24)]">
                                    Semua Kategori
                                </button>
                                @foreach($categories as $catName)
                                    <button type="button" onclick="selectCategory('{{ $catName }}')" id="cat-btn-{{ Str::slug($catName) }}"
                                        class="cat-filter-btn px-3.5 py-2.5 rounded-full text-xs font-semibold text-left shrink-0 transition-all bg-surface text-on-surface-variant hover:text-primary shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]">
                                        {{ $catName }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Area: Technicians Grid -->
                <div class="lg:col-span-9">
                    <div id="technicians-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-space-lg">
                        @foreach($technicians as $tek)
                            <div class="tek-card neu-card p-5 hover:-translate-y-1 transition-all flex flex-col justify-between group"
                                 data-name="{{ strtolower($tek->nama_lengkap) }}"
                                 data-category="{{ strtolower($tek->keahlian) }}"
                                 data-distance="{{ (float) $tek->distance }}">

                                <div class="space-y-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <img
                                                alt="{{ $tek->nama_lengkap }}"
                                                class="w-14 h-14 rounded-2xl object-cover border border-[#E5E7EB] shadow-xs shrink-0"
                                                loading="lazy"
                                                src="{{ $tek->foto_url }}"
                                            />
                                            <div>
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <h3 class="font-title-sm font-bold text-primary font-butler">{{ $tek->nama_lengkap }}</h3>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-secondary-container text-primary">
                                                        Ready
                                                    </span>
                                                </div>
                                                <span class="inline-block mt-0.5 text-xs font-semibold text-secondary">{{ $tek->keahlian }}</span>

                                                <div class="flex flex-wrap items-center gap-1.5 mt-2 text-xs text-on-surface-variant font-medium">
                                                    <span class="text-tertiary font-bold">★ {{ number_format($tek->rating, 1) }}</span>
                                                    <span>&bull;</span>
                                                    <span class="text-primary font-bold">📍 {{ $tek->distance }} km</span>
                                                    @if(($tek->biaya_jarak ?? 0) > 0)
                                                        <span class="text-[10px] font-bold text-on-tertiary-fixed bg-tertiary-fixed px-2 py-0.5 rounded-full">+Rp{{ number_format($tek->biaya_jarak, 0, ',', '.') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2">
                                        <span class="text-[11px] text-outline font-medium">Tarif Mulai</span>
                                        <span class="px-3 py-1 rounded-full neu-inset-sm text-xs font-bold text-primary">Rp {{ number_format($tek->tarif_dasar, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3.5 border-t border-outline-variant/40 flex items-center justify-between gap-2.5">
                                    <a href="{{ route('customer.technician-detail', $tek->id) }}" class="flex-1 py-2.5 neu-btn-secondary text-xs text-primary">
                                        Lihat Profil
                                    </a>
                                    <a href="{{ route('booking.form', $tek->id) }}" class="flex-1 py-2.5 neu-btn-primary text-xs">
                                        Booking
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No Results Fallback -->
                    <div id="no-results" class="hidden p-12 text-center neu-inset rounded-[28px]">
                        <div class="w-14 h-14 rounded-2xl neu-icon-teal mx-auto mb-3">
                            <span class="material-symbols-outlined text-[28px]">search_off</span>
                        </div>
                        <h4 class="font-title-md text-primary font-bold font-butler">Tidak ada teknisi pada filter ini</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Coba perbesar slider radius atau pilih kategori lain.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let selectedCategory = @json(strtolower($category ?? ''));
        let maxRadius = 35;

        const catActiveClass = 'cat-filter-btn px-3.5 py-2.5 rounded-full text-xs font-bold text-left shrink-0 transition-all bg-primary-container text-on-primary shadow-[0_6px_14px_rgba(22,163,74,0.24)]';
        const catInactiveClass = 'cat-filter-btn px-3.5 py-2.5 rounded-full text-xs font-semibold text-left shrink-0 transition-all bg-surface text-on-surface-variant hover:text-primary shadow-[-3px_-3px_8px_#FFFFFF,3px_3px_8px_#D2D2D2]';

        function updateRadius(val) {
            maxRadius = parseFloat(val);
            document.getElementById('radius-val').textContent = `${maxRadius} km`;
            applyFilters();
        }

        function selectCategory(cat) {
            selectedCategory = cat.toLowerCase();

            document.querySelectorAll('.cat-filter-btn').forEach(btn => {
                btn.className = catInactiveClass;
            });

            if (!cat) {
                document.getElementById('cat-btn-all').className = catActiveClass;
            } else {
                const activeBtn = Array.from(document.querySelectorAll('.cat-filter-btn')).find(b => b.textContent.trim().toLowerCase().includes(selectedCategory));
                if (activeBtn) {
                    activeBtn.className = catActiveClass;
                }
            }

            applyFilters();
        }

        function resetFilters() {
            document.getElementById('live-search').value = '';
            document.getElementById('radius-slider').value = 35;
            updateRadius(35);
            selectCategory('');
        }

        function applyFilters() {
            const query = document.getElementById('live-search').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.tek-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const cat = card.getAttribute('data-category') || '';
                const dist = parseFloat(card.getAttribute('data-distance')) || 0;

                const matchQuery = !query || name.includes(query) || cat.includes(query);
                const matchCategory = !selectedCategory || cat.includes(selectedCategory);
                const matchDistance = dist <= maxRadius;

                if (matchQuery && matchCategory && matchDistance) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            document.getElementById('counter-badge').textContent = `${visibleCount} Teknisi Ditemukan`;

            const noResults = document.getElementById('no-results');
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (selectedCategory) {
                selectCategory(selectedCategory);
            }
        });
    </script>
    @endpush
</x-layouts.app>
