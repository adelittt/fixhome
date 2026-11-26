<x-layouts.app title="Profil & Pengaturan Akun - FixHome">
    <div class="flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <!-- Mobile Header -->
        <div class="lg:hidden bg-surface/90 backdrop-blur-md px-5 pt-5 pb-4 sticky top-0 z-30 flex items-center justify-between shadow-sm">
            <h1 class="font-headline-sm text-primary font-bold font-recoleta leading-tight">Edit Profil</h1>
            <a href="{{ $user->isTeknisi() ? route('teknisi.dashboard') : route('customer.home') }}" class="w-9 h-9 rounded-full neu-btn-secondary text-primary">
                <span class="material-symbols-outlined text-[18px]">home</span>
            </a>
        </div>

        <div class="max-w-3xl mx-auto w-full px-gutter py-space-lg space-y-5 flex-1">

            <!-- Main Edit Profile & Photo Form -->
            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[24px] border border-[#E5E7EB] shadow-[0_4px_20px_rgba(17,24,39,0.04)] p-6 sm:p-8 space-y-6">
                @csrf
                <input type="hidden" name="remove_avatar" id="remove-avatar-input" value="0">

                <!-- Avatar Picker Header -->
                <div class="flex flex-col sm:flex-row items-center gap-5 pb-6 border-b border-[#E5E7EB]">
                    <div class="relative group shrink-0">
                        @php $avatarUrl = $user->avatar_display_url; @endphp
                        <img
                            id="avatar-preview-img"
                            src="{{ $avatarUrl ?? '' }}"
                            alt="{{ $user->name }}"
                            class="{{ $avatarUrl ? '' : 'hidden' }} w-24 h-24 rounded-3xl object-cover border-2 border-[#E5E7EB] shadow-sm"
                        />
                        <div
                            id="avatar-fallback"
                            class="{{ $avatarUrl ? 'hidden' : 'flex' }} w-24 h-24 rounded-3xl bg-[#DCFCE7] text-[#15803D] items-center justify-center font-extrabold text-3xl border-2 border-[#BBF7D0]"
                        >
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <label for="avatar-file-input" class="absolute -bottom-1.5 -right-1.5 w-9 h-9 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white flex items-center justify-center shadow-md cursor-pointer transition-all" title="Ubah Foto Profil">
                            <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                        </label>
                        <input
                            type="file"
                            id="avatar-file-input"
                            name="avatar"
                            accept="image/jpeg,image/png,image/webp"
                            class="hidden"
                            onchange="previewAvatar(this)"
                        />
                    </div>

                    <div class="flex-1 text-center sm:text-left space-y-1.5">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h2 class="text-[20px] font-extrabold text-[#111827] leading-tight">{{ $user->name }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[11px] font-semibold text-[#15803D] uppercase">
                                {{ $user->role }}
                            </span>
                        </div>
                        <p class="text-[12.5px] text-[#6B7280]">{{ $user->email }}</p>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1.5">
                            <label for="avatar-file-input" class="px-3.5 py-1.5 rounded-full bg-white border border-[#D1D5DB] hover:border-[#16A34A] text-[12px] font-semibold text-[#374151] hover:text-[#15803D] cursor-pointer transition-all inline-flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[15px]">upload</span>
                                <span>Pilih Foto Baru</span>
                            </label>
                            <button
                                type="button"
                                id="btn-remove-avatar"
                                onclick="clearAvatar()"
                                class="{{ $avatarUrl ? '' : 'hidden' }} px-3 py-1.5 rounded-full bg-white border border-[#E5E7EB] hover:border-[#EF4444] text-[12px] font-semibold text-[#6B7280] hover:text-[#DC2626] transition-all"
                            >
                                Hapus Foto
                            </button>
                        </div>
                        <p class="text-[11px] text-[#9CA3AF]">Format JPG, PNG, atau WebP (maks. 3 MB).</p>
                        @error('avatar')
                            <p class="text-[11.5px] text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Basic Account Fields -->
                <div class="space-y-4">
                    <h3 class="text-[14px] font-bold text-[#111827]">Informasi Pribadi</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                            />
                            @error('name')
                                <p class="text-[11px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">No. WhatsApp / Telepon</label>
                            <input
                                type="tel"
                                name="no_telepon"
                                value="{{ old('no_telepon', $user->no_telepon) }}"
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                            />
                            @error('no_telepon')
                                <p class="text-[11px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Alamat Gmail Terdaftar</label>
                        <input
                            type="email"
                            value="{{ $user->email }}"
                            disabled
                            class="w-full rounded-xl bg-[#F8FAFC] border border-[#E5E7EB] px-3.5 py-2.5 text-[13px] text-[#6B7280] cursor-not-allowed"
                        />
                    </div>
                </div>

                <!-- Teknisi-Specific Profile Fields -->
                @if($user->isTeknisi() && $teknisi)
                    <div class="pt-5 border-t border-[#E5E7EB] space-y-4">
                        <h3 class="text-[14px] font-bold text-[#111827]">Profil Keahlian Mitra Teknisi</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Keahlian Utama</label>
                                <select name="keahlian" class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none">
                                    @foreach([
                                        'AC & Pendingin',
                                        'Instalasi Listrik',
                                        'Pipa & Saluran Air',
                                        'Atap & Plafon Bocor',
                                        'Pengecatan & Tembok',
                                        'Kunci & Pintu Rusak',
                                        'Kebersihan & Deep Cleaning',
                                        'Pompa Air & Toren',
                                        'Renovasi & Keramik',
                                        'Furniture & Pertukangan Kayu',
                                    ] as $skillOpt)
                                        <option value="{{ $skillOpt }}" {{ old('keahlian', $teknisi->keahlian) === $skillOpt ? 'selected' : '' }}>{{ $skillOpt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Tarif Dasar Jasa (Rp)</label>
                                <input
                                    type="number"
                                    name="tarif_dasar"
                                    value="{{ old('tarif_dasar', (int) $teknisi->tarif_dasar) }}"
                                    min="10000"
                                    step="1000"
                                    required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none"
                                />
                                @error('tarif_dasar')
                                    <p class="text-[11px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Sertifikasi / Pelatihan</label>
                            <input
                                type="text"
                                name="sertifikasi"
                                value="{{ old('sertifikasi', $teknisi->sertifikasi) }}"
                                placeholder="Contoh: Sertifikasi BNSP / SKK Kelistrikan"
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none"
                            />
                        </div>
                    </div>
                @endif

                <!-- Optional Password Change -->
                <div class="pt-5 border-t border-[#E5E7EB] space-y-3">
                    <div>
                        <h3 class="text-[14px] font-bold text-[#111827]">Ubah Kata Sandi <span class="text-[12px] font-normal text-[#6B7280]">(Opsional)</span></h3>
                        <p class="text-[11.5px] text-[#6B7280]">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Kata Sandi Baru</label>
                            <input
                                type="password"
                                name="new_password"
                                placeholder="Minimal 6 karakter"
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input
                                type="password"
                                name="new_password_confirmation"
                                placeholder="Ulangi kata sandi baru"
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13px] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none"
                            />
                        </div>
                    </div>
                    @error('new_password')
                        <p class="text-[11px] text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Save Button -->
                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13px] font-semibold shadow-sm active:scale-[0.98] transition-all inline-flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>

            <!-- Address Card (Customer Only) -->
            @if(!$user->isTeknisi() && $customer)
                <div class="bg-white rounded-[22px] border border-[#E5E7EB] p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[14px] font-bold text-[#111827] flex items-center gap-2">
                            <span class="material-symbols-outlined text-[19px] text-[#16A34A]">location_on</span>
                            <span>Alamat Rumah Terdaftar</span>
                        </span>
                        <a href="{{ route('customer.set-address') }}" class="px-3.5 py-1.5 rounded-full bg-white border border-[#D1D5DB] hover:border-[#16A34A] text-xs font-semibold text-[#15803D] transition-all">Ubah Lokasi</a>
                    </div>
                    <div class="p-3.5 rounded-xl bg-[#F8FAFC] border border-[#E5E7EB] text-xs text-[#374151] leading-relaxed">
                        {{ $customer->alamat_lengkap ?? 'Belum ada alamat tersimpan.' }}
                    </div>
                    <div class="text-[11px] text-[#6B7280] font-mono flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">my_location</span>
                        <span>Koordinat: {{ $customer->latitude ?? '-' }}, {{ $customer->longitude ?? '-' }}</span>
                    </div>
                </div>
            @endif

            <!-- Logout Card -->
            <div class="bg-white rounded-[22px] border border-[#E5E7EB] p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-[#FEF2F2] text-[#DC2626] transition-colors text-xs font-bold">
                        <span class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-[#FEE2E2] text-[#DC2626] flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </span>
                            <span>Keluar dari Akun (Logout)</span>
                        </span>
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Bottom Navigation (Customer) -->
        @if(!$user->isTeknisi())
            <nav class="lg:hidden fixed bottom-0 inset-x-0 max-w-md mx-auto bg-surface/95 backdrop-blur-md shadow-[0_-6px_18px_rgba(0,0,0,0.08)] py-2.5 px-6 flex items-center justify-between z-30 rounded-t-3xl">
                <a href="{{ route('customer.home') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[22px]">home</span>
                    <span class="text-[10px] font-medium">Beranda</span>
                </a>
                <a href="{{ route('customer.orders') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[22px]">receipt_long</span>
                    <span class="text-[10px] font-medium">Pesanan</span>
                </a>
                <a href="{{ route('customer.technicians') }}" class="flex flex-col items-center gap-0.5 text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined text-[22px]">search</span>
                    <span class="text-[10px] font-medium">Cari Teknisi</span>
                </a>
                <a href="{{ route('customer.profile') }}" class="flex flex-col items-center gap-0.5 text-primary-container">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                    <span class="text-[10px] font-bold">Profil</span>
                </a>
            </nav>
        @endif

    </div>

    @push('scripts')
    <script>
        function previewAvatar(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            if (file.size > 3 * 1024 * 1024) {
                alert('Ukuran foto maksimal 3 MB.');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('avatar-preview-img');
                const fallback = document.getElementById('avatar-fallback');
                const removeBtn = document.getElementById('btn-remove-avatar');
                const removeInput = document.getElementById('remove-avatar-input');

                img.src = e.target.result;
                img.classList.remove('hidden');
                fallback.classList.add('hidden');
                fallback.classList.remove('flex');
                if (removeBtn) removeBtn.classList.remove('hidden');
                if (removeInput) removeInput.value = '0';
            };
            reader.readAsDataURL(file);
        }

        function clearAvatar() {
            const img = document.getElementById('avatar-preview-img');
            const fallback = document.getElementById('avatar-fallback');
            const fileInput = document.getElementById('avatar-file-input');
            const removeBtn = document.getElementById('btn-remove-avatar');
            const removeInput = document.getElementById('remove-avatar-input');

            img.src = '';
            img.classList.add('hidden');
            fallback.classList.remove('hidden');
            fallback.classList.add('flex');
            if (fileInput) fileInput.value = '';
            if (removeBtn) removeBtn.classList.add('hidden');
            if (removeInput) removeInput.value = '1';
        }
    </script>
    @endpush
</x-layouts.app>
