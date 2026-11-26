<x-layouts.auth title="Daftar Akun - FixHome">
    <div class="w-full flex items-center justify-center py-5 sm:py-8 px-4 sm:px-6">
        <div class="w-full max-w-[460px] lg:max-w-[940px] bg-white rounded-[24px] border border-[#E5E7EB] shadow-[0_12px_40px_rgba(17,24,39,0.06)] overflow-hidden lg:grid lg:grid-cols-12">

            <!-- Left Visual Photographic Panel (Desktop) -->
            <div class="hidden lg:flex lg:col-span-5 relative flex-col justify-between p-7 overflow-hidden bg-[#111827]">
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

                <div class="relative z-10 space-y-3">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[11px] font-medium text-white">
                        <span class="material-symbols-outlined text-[14px] text-[#4ADE80]">verified_user</span>
                        <span>Komisi Transparan 95% / 5%</span>
                    </div>
                    <h2 class="text-[22px] leading-[1.25] font-bold text-white tracking-[-0.02em]">
                        Gabung ekosistem perbaikan rumah terpercaya.
                    </h2>
                    <p class="text-[12.5px] leading-relaxed text-white/80">
                        Pesan teknisi terdekat secara cepat sebagai Customer, atau dapatkan order rutin setiap hari sebagai Mitra Teknisi.
                    </p>
                </div>
            </div>

            <!-- Right Minimalist Form Column -->
            <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-between bg-white">
                <div>
                    <div class="mb-6">
                        <h1 class="text-[24px] font-extrabold text-[#111827] tracking-[-0.02em]">Buat Akun Baru</h1>
                        <p class="text-[13.5px] text-[#6B7280] mt-1">Lengkapi data diri Anda untuk mulai menggunakan FixHome.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Role Selector -->
                        <div>
                            <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Daftar Sebagai</label>
                            @php $selectedRole = old('role', request('role') === 'teknisi' ? 'teknisi' : 'customer'); @endphp
                            <div class="grid grid-cols-2 gap-2.5">
                                <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl cursor-pointer transition-all bg-[#F8FAFC] border border-[#E5E7EB] has-[:checked]:bg-[#F0FDF4] has-[:checked]:border-[#16A34A] has-[:checked]:text-[#15803D] text-[13px] font-semibold text-[#4B5563]">
                                    <input type="radio" name="role" value="customer" {{ $selectedRole === 'customer' ? 'checked' : '' }} onchange="toggleKeahlian(false)" class="sr-only">
                                    <span class="material-symbols-outlined text-[18px]">home</span>
                                    <span>Customer</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 p-2.5 rounded-xl cursor-pointer transition-all bg-[#F8FAFC] border border-[#E5E7EB] has-[:checked]:bg-[#F0FDF4] has-[:checked]:border-[#16A34A] has-[:checked]:text-[#15803D] text-[13px] font-semibold text-[#4B5563]">
                                    <input type="radio" name="role" value="teknisi" {{ $selectedRole === 'teknisi' ? 'checked' : '' }} onchange="toggleKeahlian(true)" class="sr-only">
                                    <span class="material-symbols-outlined text-[18px]">engineering</span>
                                    <span>Mitra Teknisi</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Nama Lengkap</label>
                            <input type="text" id="register-name" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                placeholder="Contoh: Rahmat Hidayat">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Alamat Gmail (@gmail.com)</label>
                                <input type="email" id="register-email" name="email" value="{{ old('email') }}" required pattern="^[A-Za-z0-9._%+-]+@gmail\.com$" title="Gunakan alamat Gmail aktif (@gmail.com)"
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                    placeholder="nama@gmail.com">
                            </div>
                            <div>
                                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">No. WhatsApp</label>
                                <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                    placeholder="081234567890">
                            </div>
                        </div>

                        <!-- Extra Fields for Teknisi -->
                        <div id="teknisi-extra-field" class="{{ $selectedRole === 'teknisi' ? '' : 'hidden' }} space-y-3 p-4 rounded-2xl bg-[#F8FAFC] border border-[#E5E7EB]">
                            <div class="flex items-center gap-2 text-xs font-bold text-[#111827]">
                                <span class="material-symbols-outlined text-[17px] text-[#16A34A]">verified</span>
                                <span>Data Verifikasi Mitra Teknisi</span>
                            </div>
                            <div>
                                <label class="block text-[11.5px] text-[#4B5563] font-semibold mb-1">Keahlian Utama</label>
                                <select name="keahlian" class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <div>
                                    <label class="block text-[11.5px] text-[#4B5563] font-semibold mb-1">Nomor KTP (Verifikasi)</label>
                                    <input type="text" name="no_ktp" placeholder="16 digit NIK KTP"
                                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[11.5px] text-[#4B5563] font-semibold mb-1">Tarif Dasar Jasa (Rp)</label>
                                    <input type="number" id="tarif-dasar-input" name="tarif_dasar" value="{{ old('tarif_dasar', 75000) }}" min="10000" step="1000" {{ $selectedRole === 'teknisi' ? 'required' : '' }}
                                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                    <p class="mt-1 text-[10.5px] text-[#6B7280]">Minimal Rp 10.000 (tidak boleh Rp 0)</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11.5px] text-[#4B5563] font-semibold mb-1">Bukti Sertifikasi / Pelatihan (Opsional)</label>
                                <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}" placeholder="Contoh: Sertifikasi BNSP / SKK Kelistrikan"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                            </div>

                            <!-- Verifikasi Kode OTP via Gmail -->
                            <div class="pt-2 border-t border-[#E5E7EB] space-y-2">
                                <label class="block text-[11.5px] text-[#111827] font-bold">
                                    Verifikasi Kode OTP Gmail <span class="text-red-500">*</span>
                                </label>
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
                                        placeholder="6 digit kode OTP dari Gmail"
                                        class="flex-1 px-3.5 py-2 text-xs font-mono tracking-[0.2em] rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none"
                                    >
                                    <button
                                        type="button"
                                        id="btn-send-otp"
                                        onclick="sendTeknisiOtp()"
                                        class="px-3.5 py-2 rounded-xl bg-[#111827] hover:bg-[#1F2937] disabled:opacity-50 text-white text-[11.5px] font-semibold transition-all shrink-0 inline-flex items-center gap-1.5"
                                    >
                                        <span class="material-symbols-outlined text-[15px]">mail</span>
                                        <span id="btn-send-otp-text">Kirim Kode</span>
                                    </button>
                                </div>
                                <p id="otp-feedback" class="text-[11px] text-[#6B7280] leading-snug">
                                    Klik <strong>Kirim Kode</strong> setelah mengisi alamat Gmail Anda di atas.
                                </p>
                                @error('otp_code')
                                    <p class="text-[11.5px] text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Kata Sandi</label>
                                <input type="password" name="password" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                    placeholder="Min. 6 karakter">
                            </div>
                            <div>
                                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Konfirmasi</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                    placeholder="Ulangi sandi">
                            </div>
                        </div>

                        <!-- Persetujuan Pelindungan Data Pribadi (UU PDP) -->
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-[#F8FAFC] border border-[#E5E7EB] cursor-pointer">
                            <input type="checkbox" name="privacy_consent" value="1" {{ old('privacy_consent') ? 'checked' : '' }} required
                                class="mt-0.5 h-4 w-4 rounded border-[#D1D5DB] text-[#16A34A] focus:ring-[#16A34A] shrink-0">
                            <span class="text-[11.5px] leading-relaxed text-[#4B5563]">
                                Saya menyetujui <strong class="text-[#111827]">Kebijakan Privasi &amp; Pelindungan Data Pribadi (UU PDP)</strong> FixHome. Nomor HP, alamat, dan data identitas saya dienkripsi (AES-256) dan hanya digunakan untuk kebutuhan layanan servis.
                            </span>
                        </label>
                        @error('privacy_consent')
                            <p class="text-[11.5px] text-red-600 font-medium -mt-2">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="w-full py-3 px-5 rounded-xl bg-[#16A34A] hover:bg-[#15803D] text-white text-[13.5px] font-semibold shadow-[0_6px_16px_rgba(22,163,74,0.22)] active:scale-[0.99] transition-all inline-flex items-center justify-center gap-2">
                            <span>Daftar Sekarang</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </button>
                    </form>
                </div>

                <div class="pt-6 text-center text-[12.5px] text-[#6B7280]">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-[#16A34A] hover:underline ml-1">Masuk sekarang</a>
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
