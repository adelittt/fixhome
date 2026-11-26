<x-layouts.auth title="Daftar Akun - FixHome" :noScroll="true">
    <div class="w-full h-full flex items-center justify-center px-4 sm:px-6">
        <div class="w-full max-w-[460px] lg:max-w-[980px] bg-white rounded-[24px] border border-[#E5E7EB] shadow-[0_12px_40px_rgba(17,24,39,0.06)] overflow-hidden lg:grid lg:grid-cols-12">

            <!-- Left Visual Photographic Panel (Desktop) -->
            <div class="hidden lg:flex lg:col-span-4 relative flex-col justify-between p-6 overflow-hidden bg-[#111827]">
                <img
                    alt="Tim FixHome"
                    class="absolute inset-0 w-full h-full object-cover object-center scale-[1.02]"
                    src="{{ asset('images/fixhome-hero-tactile.jpg') }}"
                />
                <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/92 via-[#0F172A]/45 to-[#0F172A]/15"></div>

                <div class="relative z-10">
                    <a href="{{ route('splash') }}" class="inline-flex items-center rounded-full bg-white/95 backdrop-blur-md px-3.5 py-1.5 shadow-sm">
                        <img alt="FixHome" class="h-6 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </a>
                </div>

                <div class="relative z-10 space-y-2.5">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[11px] font-medium text-white">
                        <span class="material-symbols-outlined text-[14px] text-[#4ADE80]">verified_user</span>
                        <span>Komisi Transparan 95% / 5%</span>
                    </div>
                    <h2 class="text-[20px] leading-[1.25] font-bold text-white tracking-[-0.02em]">
                        Gabung ekosistem perbaikan rumah terpercaya.
                    </h2>
                    <p class="text-[12px] leading-relaxed text-white/80">
                        Pesan teknisi terdekat secara cepat sebagai Customer, atau dapatkan order rutin setiap hari sebagai Mitra Teknisi.
                    </p>
                </div>
            </div>

            <!-- Right Minimalist Form Column -->
            <div class="lg:col-span-8 p-5 sm:p-6 flex flex-col justify-between bg-white">
                <div>
                    <div class="mb-3 flex items-baseline justify-between gap-3">
                        <div>
                            <h1 class="text-[20px] sm:text-[22px] font-extrabold text-[#111827] tracking-[-0.02em] leading-tight">Buat Akun Baru</h1>
                            <p class="text-[12px] text-[#6B7280] mt-0.5">Lengkapi data diri Anda untuk mulai menggunakan FixHome.</p>
                        </div>
                        <div class="text-[12px] text-[#6B7280] shrink-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-[#16A34A] hover:underline ml-0.5">Masuk</a>
                        </div>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-2.5">
                        @csrf

                        <!-- Role Selector -->
                        @php $selectedRole = old('role', request('role') === 'teknisi' ? 'teknisi' : 'customer'); @endphp
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center justify-center gap-2 py-2 px-3 rounded-xl cursor-pointer transition-all bg-[#F8FAFC] border border-[#E5E7EB] has-[:checked]:bg-[#F0FDF4] has-[:checked]:border-[#16A34A] has-[:checked]:text-[#15803D] text-[12.5px] font-semibold text-[#4B5563]">
                                <input type="radio" name="role" value="customer" {{ $selectedRole === 'customer' ? 'checked' : '' }} onchange="toggleKeahlian(false)" class="sr-only">
                                <span class="material-symbols-outlined text-[17px]">home</span>
                                <span>Customer</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 py-2 px-3 rounded-xl cursor-pointer transition-all bg-[#F8FAFC] border border-[#E5E7EB] has-[:checked]:bg-[#F0FDF4] has-[:checked]:border-[#16A34A] has-[:checked]:text-[#15803D] text-[12.5px] font-semibold text-[#4B5563]">
                                <input type="radio" name="role" value="teknisi" {{ $selectedRole === 'teknisi' ? 'checked' : '' }} onchange="toggleKeahlian(true)" class="sr-only">
                                <span class="material-symbols-outlined text-[17px]">engineering</span>
                                <span>Mitra Teknisi</span>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                            <div>
                                <label class="block text-[11.5px] font-semibold text-[#374151] mb-1">Nama Lengkap</label>
                                <input type="text" id="register-name" name="name" value="{{ old('name') }}" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3 py-1.5 text-[12.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                                    placeholder="Rahmat Hidayat">
                            </div>
                            <div>
                                <label class="block text-[11.5px] font-semibold text-[#374151] mb-1">Alamat Gmail (@gmail.com)</label>
                                <input type="email" id="register-email" name="email" value="{{ old('email') }}" required pattern="^[A-Za-z0-9._%+-]+@gmail\.com$" title="Gunakan alamat Gmail aktif (@gmail.com)"
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3 py-1.5 text-[12.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                                    placeholder="nama@gmail.com">
                            </div>
                            <div>
                                <label class="block text-[11.5px] font-semibold text-[#374151] mb-1">No. WhatsApp</label>
                                <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3 py-1.5 text-[12.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                                    placeholder="081234567890">
                            </div>
                        </div>

                        <!-- Extra Fields for Teknisi -->
                        <div id="teknisi-extra-field" class="{{ $selectedRole === 'teknisi' ? '' : 'hidden' }} space-y-2 p-3 rounded-xl bg-[#F8FAFC] border border-[#E5E7EB]">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] text-[#4B5563] font-semibold mb-0.5">Keahlian Utama</label>
                                    <select name="keahlian" class="w-full px-3 py-1.5 text-[12px] rounded-lg bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                        <option value="AC & Pendingin" {{ old('keahlian') === 'AC & Pendingin' ? 'selected' : '' }}>AC &amp; Pendingin</option>
                                        <option value="Instalasi Listrik" {{ old('keahlian') === 'Instalasi Listrik' ? 'selected' : '' }}>Instalasi Listrik</option>
                                        <option value="Pipa & Saluran Air" {{ old('keahlian') === 'Pipa & Saluran Air' ? 'selected' : '' }}>Pipa &amp; Saluran Air</option>
                                        <option value="Atap & Plafon Bocor" {{ old('keahlian') === 'Atap & Plafon Bocor' ? 'selected' : '' }}>Atap &amp; Plafon Bocor</option>
                                        <option value="Pengecatan & Tembok" {{ old('keahlian') === 'Pengecatan & Tembok' ? 'selected' : '' }}>Pengecatan &amp; Tembok</option>
                                        <option value="Kunci & Pintu Rusak" {{ old('keahlian') === 'Kunci & Pintu Rusak' ? 'selected' : '' }}>Kunci &amp; Pintu Rusak</option>
                                        <option value="Kebersihan & Deep Cleaning" {{ old('keahlian') === 'Kebersihan & Deep Cleaning' ? 'selected' : '' }}>Kebersihan &amp; Deep Cleaning</option>
                                        <option value="Pompa Air & Toren" {{ old('keahlian') === 'Pompa Air & Toren' ? 'selected' : '' }}>Pompa Air &amp; Toren</option>
                                        <option value="Renovasi & Keramik" {{ old('keahlian') === 'Renovasi & Keramik' ? 'selected' : '' }}>Renovasi &amp; Keramik</option>
                                        <option value="Furniture & Pertukangan Kayu" {{ old('keahlian') === 'Furniture & Pertukangan Kayu' ? 'selected' : '' }}>Furniture &amp; Pertukangan Kayu</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] text-[#4B5563] font-semibold mb-0.5">Tarif Dasar Jasa (Min. Rp10.000)</label>
                                    <input type="number" id="tarif-dasar-input" name="tarif_dasar" value="{{ old('tarif_dasar', 75000) }}" min="10000" step="1000" {{ $selectedRole === 'teknisi' ? 'required' : '' }}
                                        class="w-full px-3 py-1.5 text-[12px] rounded-lg bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] text-[#4B5563] font-semibold mb-0.5">Nomor KTP (Verifikasi)</label>
                                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="16 digit NIK KTP"
                                        class="w-full px-3 py-1.5 text-[12px] rounded-lg bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[11px] text-[#4B5563] font-semibold mb-0.5">Sertifikasi / Pelatihan (Opsional)</label>
                                    <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}" placeholder="Contoh: BNSP / SKK Kelistrikan"
                                        class="w-full px-3 py-1.5 text-[12px] rounded-lg bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                </div>
                            </div>

                            <!-- Verifikasi Kode OTP via Gmail -->
                            <div class="pt-1.5 border-t border-[#E5E7EB]">
                                <div class="flex items-center gap-2">
                                    <input
                                        type="text"
                                        id="otp-code-input"
                                        name="otp_code"
                                        value="{{ old('otp_code') }}"
                                        maxlength="6"
                                        inputmode="numeric"
                                        pattern="[0-9]{6}"
                                        {{ $selectedRole === 'teknisi' ? 'required' : '' }}
                                        placeholder="Kode OTP 6 digit dari Gmail *"
                                        class="flex-1 px-3 py-1.5 text-[12px] font-mono tracking-[0.18em] rounded-lg bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none"
                                    >
                                    <button
                                        type="button"
                                        id="btn-send-otp"
                                        onclick="sendTeknisiOtp()"
                                        class="px-3 py-1.5 rounded-lg bg-[#111827] hover:bg-[#1F2937] disabled:opacity-50 text-white text-[11.5px] font-semibold transition-all shrink-0 inline-flex items-center gap-1"
                                    >
                                        <span class="material-symbols-outlined text-[14px]">mail</span>
                                        <span id="btn-send-otp-text">Kirim Kode</span>
                                    </button>
                                </div>
                                <p id="otp-feedback" class="text-[10.5px] text-[#6B7280] mt-1 leading-tight">
                                    Klik <strong>Kirim Kode</strong> setelah mengisi Gmail Anda di atas.
                                </p>
                                @error('otp_code')
                                    <p class="text-[11px] text-red-600 font-semibold mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
                            <div>
                                <label class="block text-[11.5px] font-semibold text-[#374151] mb-1">Kata Sandi</label>
                                <input type="password" name="password" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3 py-1.5 text-[12.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                                    placeholder="Min. 6 karakter">
                            </div>
                            <div>
                                <label class="block text-[11.5px] font-semibold text-[#374151] mb-1">Konfirmasi Sandi</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3 py-1.5 text-[12.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/15 focus:outline-none transition-all"
                                    placeholder="Ulangi sandi">
                            </div>
                        </div>

                        <!-- Persetujuan Pelindungan Data Pribadi (UU PDP) -->
                        <label class="flex items-start gap-2 p-2.5 rounded-xl bg-[#F8FAFC] border border-[#E5E7EB] cursor-pointer">
                            <input type="checkbox" name="privacy_consent" value="1" {{ old('privacy_consent') ? 'checked' : '' }} required
                                class="mt-0.5 h-3.5 w-3.5 rounded border-[#D1D5DB] text-[#16A34A] focus:ring-[#16A34A] shrink-0">
                            <span class="text-[11px] leading-snug text-[#4B5563]">
                                Saya menyetujui <strong class="text-[#111827]">Kebijakan Privasi &amp; UU PDP</strong> FixHome (data pribadi dienkripsi AES-256 khusus untuk kebutuhan layanan).
                            </span>
                        </label>
                        @error('privacy_consent')
                            <p class="text-[11px] text-red-600 font-medium -mt-1">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="w-full py-2.5 px-5 rounded-xl bg-[#16A34A] hover:bg-[#15803D] text-white text-[13px] font-semibold shadow-[0_6px_16px_rgba(22,163,74,0.22)] active:scale-[0.99] transition-all inline-flex items-center justify-center gap-2">
                            <span>Daftar Sekarang</span>
                            <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        let otpCooldownTimer = null;

        function toggleKeahlian(show) {
            const extra = document.getElementById('teknisi-extra-field');
            const tarifInput = document.getElementById('tarif-dasar-input');
            const otpInput = document.getElementById('otp-code-input');
            if (show) {
                extra.classList.remove('hidden');
                if (tarifInput) tarifInput.required = true;
                if (otpInput) otpInput.required = true;
            } else {
                extra.classList.add('hidden');
                if (tarifInput) tarifInput.required = false;
                if (otpInput) otpInput.required = false;
            }
        }

        async function sendTeknisiOtp() {
            const emailInput = document.getElementById('register-email');
            const nameInput = document.getElementById('register-name');
            const btn = document.getElementById('btn-send-otp');
            const btnText = document.getElementById('btn-send-otp-text');
            const feedback = document.getElementById('otp-feedback');

            const email = (emailInput ? emailInput.value : '').trim();
            const name = (nameInput ? nameInput.value : '').trim();

            if (!email || !/^[A-Za-z0-9._%+-]+@gmail\.com$/i.test(email)) {
                feedback.className = 'text-[11px] text-red-600 font-semibold leading-snug';
                feedback.textContent = 'Isi alamat Gmail aktif (@gmail.com) terlebih dahulu sebelum meminta kode OTP.';
                if (emailInput) emailInput.focus();
                return;
            }

            btn.disabled = true;
            btnText.textContent = 'Mengirim...';
            feedback.className = 'text-[11px] text-[#4B5563] leading-snug';
            feedback.textContent = 'Mengirim kode verifikasi 6 digit ke Gmail Anda...';

            try {
                const res = await fetch(@json(route('register.send-otp')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token()),
                    },
                    body: JSON.stringify({ email, name }),
                });

                const data = await res.json();

                if (res.ok && data.ok) {
                    feedback.className = 'text-[11px] text-[#15803D] font-semibold leading-snug';
                    feedback.textContent = data.message;
                    startOtpCooldown(45);
                } else {
                    const errMsg = data.message || (data.errors && data.errors.email ? data.errors.email[0] : 'Gagal mengirim kode OTP.');
                    feedback.className = 'text-[11px] text-red-600 font-semibold leading-snug';
                    feedback.textContent = errMsg;
                    btn.disabled = false;
                    btnText.textContent = 'Kirim Kode';
                }
            } catch (err) {
                feedback.className = 'text-[11px] text-red-600 font-semibold leading-snug';
                feedback.textContent = 'Terjadi gangguan jaringan saat mengirim OTP. Coba lagi.';
                btn.disabled = false;
                btnText.textContent = 'Kirim Kode';
            }
        }

        function startOtpCooldown(seconds) {
            const btn = document.getElementById('btn-send-otp');
            const btnText = document.getElementById('btn-send-otp-text');
            let remaining = seconds;

            clearInterval(otpCooldownTimer);
            btn.disabled = true;
            btnText.textContent = `Tunggu ${remaining}d`;

            otpCooldownTimer = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(otpCooldownTimer);
                    btn.disabled = false;
                    btnText.textContent = 'Kirim Ulang';
                } else {
                    btnText.textContent = `Tunggu ${remaining}d`;
                }
            }, 1000);
        }
    </script>
    @endpush
</x-layouts.auth>
