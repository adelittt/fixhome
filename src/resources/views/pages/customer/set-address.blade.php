<x-layouts.app title="Tentukan Lokasi Rumah Anda - FixHome">
    <div class="w-full flex-1 flex flex-col justify-center py-space-lg lg:py-space-xl px-gutter lg:px-margin">
        <div class="max-w-[1140px] mx-auto w-full">

            <!-- Header Title -->
            <div class="mb-space-lg">
                <div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full neu-pill text-secondary font-label-sm font-semibold mb-space-xs font-lucy-rose">
                    <span class="material-symbols-outlined text-[15px] text-tertiary">pin_drop</span>
                    <span>Langkah 1: Penentuan Alamat Rumah</span>
                </div>
                <h1 class="font-headline-lg text-headline-lg-mobile sm:text-headline-lg text-primary font-bold font-recoleta">Tentukan Titik Koordinat Rumah Anda</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Cari alamat melalui kolom pencarian di peta atau klik langsung pada peta untuk memposisikan penanda pengerjaan servis.</p>
            </div>

            <!-- 2-Column Tactile Map Console -->
            <div class="neu-card-lg overflow-hidden lg:grid lg:grid-cols-12 min-h-[620px]">

                <!-- Left Form Column -->
                <div class="lg:col-span-5 p-6 lg:p-space-xl flex flex-col justify-between order-2 lg:order-1 bg-surface z-20">
                    <div class="space-y-5">

                        <!-- Quick Location Chips -->
                        <div>
                            <label class="block font-label-sm text-on-surface-variant uppercase tracking-wider font-semibold mb-2.5">Pilih Cepat Area Populer</label>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="flyToLocation(-6.185685, 106.778909, 'Universitas Esa Unggul, Jl. Arjuna Utara No.9, Duri Kepa, Kebon Jeruk, Jakarta Barat')" class="neu-pill px-3 py-1.5 text-xs font-bold text-primary hover:-translate-y-0.5 transition-all">
                                    <span>🎓</span><span>Esa Unggul</span>
                                </button>
                                <button type="button" onclick="flyToLocation(-6.2155, 106.8205, 'Jl. Jenderal Sudirman No. 45, Kebayoran Baru, Jakarta Selatan')" class="neu-pill px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                    Sudirman
                                </button>
                                <button type="button" onclick="flyToLocation(-6.2250, 106.8000, 'Jl. Senopati No. 18, Kebayoran Baru, Jakarta Selatan')" class="neu-pill px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                    Senopati
                                </button>
                                <button type="button" onclick="flyToLocation(-6.2200, 106.8450, 'Jl. Tebet Barat Dalam No. 12, Tebet, Jakarta Selatan')" class="neu-pill px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                    Tebet
                                </button>
                                <button type="button" onclick="flyToLocation(-6.2600, 106.8150, 'Jl. Kemang Raya No. 25, Mampang Prapatan, Jakarta Selatan')" class="neu-pill px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                    Kemang
                                </button>
                                <button type="button" onclick="flyToLocation(-6.1550, 106.9050, 'Jl. Boulevard Raya Blok LB3, Kelapa Gading, Jakarta Utara')" class="neu-pill px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary hover:-translate-y-0.5 transition-all">
                                    Kelapa Gading
                                </button>
                            </div>
                        </div>

                        <form id="address-form" action="{{ route('customer.store-address') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="latitude" id="lat" value="{{ $customer->latitude ?? -6.2155 }}">
                            <input type="hidden" name="longitude" id="lng" value="{{ $customer->longitude ?? 106.8205 }}">

                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block font-label-md text-label-md text-primary">Alamat Lengkap Rumah</label>
                                    <button type="button" onclick="searchFromTextarea()" class="text-xs font-bold text-secondary hover:text-primary inline-flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[15px]">search</span>
                                        <span>Cari di Peta</span>
                                    </button>
                                </div>
                                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" required
                                    class="neu-input text-xs p-3.5 font-medium leading-relaxed"
                                    placeholder="Contoh: Jl. Sudirman No. 45, Kebayoran Baru. Pagar putih dekat pos satpam">{{ $customer->alamat_lengkap ?? 'Jl. Jenderal Sudirman No. 45, Kebayoran Baru, Jakarta Selatan' }}</textarea>
                            </div>

                            <div class="p-3.5 neu-inset text-xs flex items-center justify-between">
                                <span class="text-on-surface-variant font-medium flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-primary">my_location</span>
                                    <span>Titik Pin Terpilih:</span>
                                </span>
                                <span id="coord-display" class="font-mono font-bold text-primary">{{ number_format($customer->latitude ?? -6.2155, 4) }}, {{ number_format($customer->longitude ?? 106.8205, 4) }}</span>
                            </div>

                            <div class="p-3.5 rounded-[18px] bg-secondary-container/50 text-xs text-on-secondary-fixed leading-relaxed flex items-start gap-2.5 shadow-[inset_2px_2px_5px_#B2CED0,inset_-2px_-2px_5px_#E6FAFC]">
                                <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">tips_and_updates</span>
                                <span><strong>Tips:</strong> Ketik alamat di kolom cari pada peta atau klik langsung di area peta mana saja untuk memindahkan pin penanda secara presisi.</span>
                            </div>

                            <!-- Persetujuan Privasi Lokasi (UU PDP) -->
                            <label class="flex items-start gap-2.5 p-3.5 rounded-2xl bg-white border border-[#E5E7EB] cursor-pointer">
                                <input type="checkbox" name="address_consent" value="1" checked required
                                    class="mt-0.5 h-4 w-4 rounded border-[#D1D5DB] text-[#16A34A] focus:ring-[#16A34A] shrink-0">
                                <span class="text-[11.5px] leading-relaxed text-[#4B5563]">
                                    <strong class="text-[#111827]">Perlindungan Data Pribadi (UU PDP):</strong> Alamat rumah Anda disimpan terenkripsi (AES-256) dan hanya ditampilkan kepada teknisi yang menangani pesanan aktif Anda.
                                </span>
                            </label>
                            @error('address_consent')
                                <p class="text-xs text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>

                    <div class="pt-5">
                        <button type="submit" form="address-form" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                            <span>Simpan Titik Alamat &amp; Lanjutkan</span>
                            <span class="material-symbols-outlined text-[19px]">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Right Map Canvas Column -->
                <div class="lg:col-span-7 relative h-96 lg:h-full min-h-[460px] order-1 lg:order-2">

                    <!-- Floating Map Search Box -->
                    <div class="absolute top-4 left-4 right-4 z-30 max-w-lg mx-auto" id="map-search-wrapper">
                        <div class="relative bg-surface/95 backdrop-blur-md rounded-full shadow-[-6px_-6px_14px_rgba(255,255,255,0.8),6px_6px_16px_rgba(0,0,0,0.18)] p-1.5 flex items-center gap-2">
                            <span class="material-symbols-outlined pl-3 text-primary text-[20px] shrink-0">search</span>

                            <input type="text" id="map-search-input"
                                class="w-full text-xs font-semibold text-on-surface placeholder:text-outline bg-transparent border-0 focus:outline-none py-2 px-1"
                                placeholder="Cari nama lokasi, jalan, kampus (cth: Esa Unggul, Sudirman)..."
                                autocomplete="off">

                            <div id="search-spinner" class="hidden pr-1 shrink-0">
                                <div class="w-4 h-4 border-2 border-outline-variant border-t-primary rounded-full animate-spin"></div>
                            </div>

                            <button type="button" id="clear-search-btn" onclick="clearSearch()" class="hidden p-1 text-outline hover:text-primary shrink-0">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>

                            <button type="button" onclick="executeSearch()" class="px-4 py-2 rounded-full bg-primary-container text-on-primary text-xs font-bold shrink-0 hover:opacity-95 transition-all">
                                Cari
                            </button>
                        </div>

                        <!-- Search Autocomplete Dropdown -->
                        <div id="search-results-dropdown" class="hidden mt-2 bg-surface rounded-[22px] shadow-2xl border border-outline-variant/40 overflow-hidden divide-y divide-outline-variant/30 max-h-72 overflow-y-auto">
                        </div>
                    </div>

                    <!-- Map Canvas -->
                    <div id="map" class="w-full h-full z-0"></div>

                    <!-- Center Pin Marker Overlay -->
                    <div class="absolute inset-0 pointer-events-none z-10 flex items-center justify-center">
                        <div class="relative -translate-y-6 flex flex-col items-center">
                            <div class="w-11 h-11 rounded-full bg-primary-container border-2 border-surface shadow-2xl flex items-center justify-center text-on-primary animate-bounce">
                                <span class="material-symbols-outlined text-[24px]">location_on</span>
                            </div>
                            <div class="w-3 h-1 bg-primary/40 rounded-full blur-[1px] -mt-1"></div>
                        </div>
                    </div>

                    <!-- Click Instructions Chip -->
                    <div class="absolute bottom-6 left-6 z-20 bg-surface/95 backdrop-blur-md px-4 py-2 rounded-full shadow-lg text-xs font-bold text-primary flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-secondary animate-ping"></span>
                        <span>Klik area peta untuk geser titik</span>
                    </div>

                    <!-- Detect GPS Button -->
                    <button type="button" onclick="getCurrentLocation()" class="absolute bottom-6 right-6 z-20 w-12 h-12 bg-surface rounded-full shadow-xl flex items-center justify-center text-primary hover:scale-105 active:scale-95 transition-all" title="Deteksi Lokasi GPS Saya">
                        <span class="material-symbols-outlined text-[22px]">my_location</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let map;
        let searchDebounceTimeout;
        let reverseDebounceTimeout;

        function updateCoords(lat, lng, labelText = null) {
            document.getElementById('lat').value = lat.toFixed(6);
            document.getElementById('lng').value = lng.toFixed(6);
            document.getElementById('coord-display').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;

            if (labelText) {
                document.getElementById('alamat_lengkap').value = labelText;
            }
        }

        function flyToLocation(lat, lng, addressText) {
            if (map) {
                map.flyTo([lat, lng], 17, { animate: true, duration: 1.2 });
                updateCoords(lat, lng, addressText);
                hideSearchResults();
            }
        }

        function clearSearch() {
            const input = document.getElementById('map-search-input');
            input.value = '';
            document.getElementById('clear-search-btn').classList.add('hidden');
            hideSearchResults();
        }

        function hideSearchResults() {
            document.getElementById('search-results-dropdown').classList.add('hidden');
        }

        function executeSearch() {
            const query = document.getElementById('map-search-input').value.trim();
            if (query.length < 2) return;
            performSearch(query);
        }

        function searchFromTextarea() {
            const query = document.getElementById('alamat_lengkap').value.trim();
            if (query.length < 2) return;
            document.getElementById('map-search-input').value = query;
            performSearch(query);
        }

        function performSearch(query) {
            const spinner = document.getElementById('search-spinner');
            const clearBtn = document.getElementById('clear-search-btn');
            const dropdown = document.getElementById('search-results-dropdown');

            spinner.classList.remove('hidden');
            clearBtn.classList.remove('hidden');

            fetch(`{{ route('customer.api.geocode') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    spinner.classList.add('hidden');
                    dropdown.replaceChildren();

                    if (!data || data.length === 0) {
                        const emptyDiv = document.createElement('div');
                        emptyDiv.className = 'p-4 text-center text-xs text-on-surface-variant';
                        emptyDiv.textContent = `Alamat "${query}" tidak ditemukan. Coba ketik kata kunci lain atau pilih dari peta.`;
                        dropdown.appendChild(emptyDiv);
                        dropdown.classList.remove('hidden');
                        return;
                    }

                    data.forEach(item => {
                        const lat = parseFloat(item.lat);
                        const lon = parseFloat(item.lon);
                        const displayName = item.display_name || '';
                        const title = item.name || displayName.split(',')[0];

                        const itemEl = document.createElement('div');
                        itemEl.className = 'p-3 hover:bg-secondary-container/40 cursor-pointer transition-all flex items-start gap-2.5 group';

                        const iconBadge = document.createElement('span');
                        iconBadge.className = 'w-7 h-7 rounded-xl bg-secondary-container text-primary flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold group-hover:bg-primary-container group-hover:text-on-primary transition-all';
                        iconBadge.textContent = '📍';

                        const textWrap = document.createElement('div');
                        textWrap.className = 'overflow-hidden flex-1';

                        const h4 = document.createElement('h4');
                        h4.className = 'text-xs font-bold text-primary truncate';
                        h4.textContent = title;

                        const p = document.createElement('p');
                        p.className = 'text-[11px] text-on-surface-variant line-clamp-1 leading-snug mt-0.5';
                        p.textContent = displayName;

                        textWrap.appendChild(h4);
                        textWrap.appendChild(p);
                        itemEl.appendChild(iconBadge);
                        itemEl.appendChild(textWrap);

                        itemEl.addEventListener('click', () => {
                            flyToLocation(lat, lon, displayName);
                            document.getElementById('map-search-input').value = title;
                        });

                        dropdown.appendChild(itemEl);
                    });

                    dropdown.classList.remove('hidden');
                })
                .catch(() => {
                    spinner.classList.add('hidden');
                });
        }

        function triggerReverseGeocode(lat, lng) {
            clearTimeout(reverseDebounceTimeout);
            reverseDebounceTimeout = setTimeout(() => {
                fetch(`{{ route('customer.api.reverse-geocode') }}?lat=${lat}&lng=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('alamat_lengkap').value = data.display_name;
                        }
                    })
                    .catch(() => {});
            }, 500);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const initialLat = parseFloat(document.getElementById('lat').value) || -6.2155;
            const initialLng = parseFloat(document.getElementById('lng').value) || 106.8205;

            map = L.map('map', {
                center: [initialLat, initialLng],
                zoom: 16,
                zoomControl: false
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            map.on('moveend', function () {
                const center = map.getCenter();
                updateCoords(center.lat, center.lng);
            });

            map.on('click', function (e) {
                map.panTo(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
                triggerReverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            const searchInput = document.getElementById('map-search-input');
            const clearBtn = document.getElementById('clear-search-btn');

            searchInput.addEventListener('input', function (e) {
                const val = e.target.value.trim();
                if (val.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                    hideSearchResults();
                }

                clearTimeout(searchDebounceTimeout);
                if (val.length >= 2) {
                    searchDebounceTimeout = setTimeout(() => {
                        performSearch(val);
                    }, 400);
                }
            });

            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    executeSearch();
                }
            });

            document.addEventListener('click', function (e) {
                const searchContainer = document.getElementById('map-search-wrapper');
                if (searchContainer && !searchContainer.contains(e.target)) {
                    hideSearchResults();
                }
            });

            window.getCurrentLocation = function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        flyToLocation(position.coords.latitude, position.coords.longitude, 'Lokasi GPS Anda Terdeteksi');
                    }, function () {
                        flyToLocation(-6.185685, 106.778909, 'Universitas Esa Unggul, Jl. Arjuna Utara No.9, Duri Kepa, Kebon Jeruk, Jakarta Barat');
                    });
                }
            };
        });
    </script>
    @endpush
</x-layouts.app>
