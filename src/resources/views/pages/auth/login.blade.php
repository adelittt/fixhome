<x-layouts.auth title="Masuk - FixHome" :noScroll="true">
    <div class="w-full flex items-center justify-center py-2 px-4 sm:px-6">
        <div class="w-full max-w-[440px] lg:max-w-[900px] bg-white rounded-[24px] border border-[#E5E7EB] shadow-[0_12px_40px_rgba(17,24,39,0.06)] overflow-hidden lg:grid lg:grid-cols-12">

            <!-- Left Visual Photographic Panel (Desktop) -->
            <div class="hidden lg:flex lg:col-span-5 relative flex-col justify-between p-7 overflow-hidden bg-[#111827]">
                <img
                    alt="Teknisi FixHome"
                    class="absolute inset-0 w-full h-full object-cover object-[50%_22%]"
                    src="{{ asset('images/fixhome-auth-teknisi.jpg') }}"
                />
                <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/20 to-transparent"></div>

                <!-- Top Frosted Logo Pill -->
                <div class="relative z-10">
                    <a href="{{ route('splash') }}" class="inline-flex items-center rounded-full bg-white/95 backdrop-blur-md px-3.5 py-1.5 shadow-sm">
                        <img alt="FixHome" class="h-6 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </a>
                </div>

                <!-- Bottom Clean Editorial Copy -->
                <div class="relative z-10 space-y-3">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[11px] font-medium text-white">
                        <span class="material-symbols-outlined text-[14px] text-[#4ADE80]">verified</span>
                        <span>Terverifikasi &amp; Bergaransi 14 Hari</span>
                    </div>
                    <h2 class="text-[22px] leading-[1.25] font-bold text-white tracking-[-0.02em]">
                        Perbaikan rumah tuntas, tanpa ribet.
                    </h2>
                    <p class="text-[12.5px] leading-relaxed text-white/80">
                        Satu pintu masuk untuk Customer dan Mitra Teknisi FixHome dengan pemantauan pesanan &amp; live chat real-time.
                    </p>
                </div>
            </div>

            <!-- Right Minimalist Form Column -->
            <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between bg-white">
                <div>
                    <div class="mb-5">
                        <h1 class="text-[22px] sm:text-[24px] font-extrabold text-[#111827] tracking-[-0.02em]">Masuk ke FixHome</h1>
                        <p class="text-[13px] text-[#6B7280] mt-1">
                            Masuk menggunakan akun Customer atau Mitra Teknisi Anda.
                        </p>
                    </div>

                    <!-- Inline Login Reminder / Error Alert -->
                    @php
                        $serverAlert = $errors->first('auth');
                        if (!$serverAlert && $errors->has('email') && $errors->has('password')) {
                            $serverAlert = 'Alamat email dan kata sandi wajib diisi untuk masuk.';
                        } elseif (!$serverAlert && $errors->any()) {
                            $serverAlert = $errors->first();
                        }
                    @endphp
                    <div id="login-alert" role="alert" class="{{ $serverAlert ? '' : 'hidden' }} mb-4 p-3.5 rounded-xl bg-[#FEF2F2] border border-[#FECACA] text-[#991B1B] text-xs font-medium flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-[#EF4444] text-[18px] shrink-0 mt-0.5">error</span>
                        <span id="login-alert-text" class="leading-relaxed">{{ $serverAlert }}</span>
                    </div>

                    <form id="login-form" action="{{ route('login') }}" method="POST" novalidate class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                                Alamat Email
                            </label>
                            <div id="email-wrap" class="flex items-center rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 focus-within:border-[#16A34A] focus-within:ring-4 focus-within:ring-[#16A34A]/10 transition-all {{ ($errors->has('email') || $errors->has('auth')) ? 'border-[#EF4444] ring-2 ring-[#EF4444]/15' : '' }}">
                                <span class="material-symbols-outlined text-[#9CA3AF] text-[18px] mr-2.5">mail</span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full bg-transparent text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none"
                                    placeholder="nama@email.com">
                            </div>
                            <p id="email-error" class="{{ $errors->has('email') ? '' : 'hidden' }} mt-1.5 text-[11.5px] font-medium text-[#DC2626] flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                <span id="email-error-text">{{ $errors->first('email') }}</span>
                            </p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-[12.5px] font-semibold text-[#374151]">
                                    Kata Sandi
                                </label>
                                <a href="{{ route('public.cara-kerja') }}" class="text-[12px] font-medium text-[#16A34A] hover:underline">Butuh bantuan?</a>
                            </div>
                            <div id="password-wrap" class="flex items-center rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 focus-within:border-[#16A34A] focus-within:ring-4 focus-within:ring-[#16A34A]/10 transition-all {{ ($errors->has('password') || $errors->has('auth')) ? 'border-[#EF4444] ring-2 ring-[#EF4444]/15' : '' }}">
                                <span class="material-symbols-outlined text-[#9CA3AF] text-[18px] mr-2.5">lock</span>
                                <input type="password" id="password" name="password" required
                                    class="w-full bg-transparent text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none"
                                    placeholder="Masukkan kata sandi">
                                <button type="button" onclick="togglePassword()" aria-label="Tampilkan kata sandi" class="text-[#9CA3AF] hover:text-[#4B5563] transition-colors ml-2 flex items-center">
                                    <span id="password-eye" class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                            <p id="password-error" class="{{ $errors->has('password') ? '' : 'hidden' }} mt-1.5 text-[11.5px] font-medium text-[#DC2626] flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                <span id="password-error-text">{{ $errors->first('password') }}</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-between pt-0.5">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-[12.5px] text-[#4B5563]">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-[#D1D5DB] text-[#16A34A] focus:ring-[#16A34A] accent-[#16A34A]">
                                <span>Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-3 px-5 rounded-xl bg-[#16A34A] hover:bg-[#15803D] text-white text-[13.5px] font-semibold shadow-[0_6px_16px_rgba(22,163,74,0.22)] active:scale-[0.99] transition-all inline-flex items-center justify-center gap-2">
                            <span>Masuk</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Clean Minimal Demo Quick-Fill -->
                    <div class="mt-5 pt-4 border-t border-[#F3F4F6]">
                        <span class="block text-[11px] font-medium text-[#9CA3AF] text-center mb-2">Isi cepat akun demo</span>
                        <div class="grid grid-cols-2 gap-2.5">
                            <button type="button" onclick="fillDemo('customer@fixhome.com')" class="py-2 px-3 rounded-xl bg-[#F8FAFC] hover:bg-[#F0FDF4] border border-[#E5E7EB] hover:border-[#BBF7D0] text-[12px] font-semibold text-[#374151] hover:text-[#15803D] transition-all inline-flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-[#16A34A]">person</span>
                                <span>Akun Customer</span>
                            </button>
                            <button type="button" onclick="fillDemo('budi.teknisi@fixhome.com')" class="py-2 px-3 rounded-xl bg-[#F8FAFC] hover:bg-[#F0FDF4] border border-[#E5E7EB] hover:border-[#BBF7D0] text-[12px] font-semibold text-[#374151] hover:text-[#15803D] transition-all inline-flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-[#16A34A]">engineering</span>
                                <span>Akun Teknisi</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-4 text-center text-[12.5px] text-[#6B7280]">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-[#16A34A] hover:underline ml-1">Daftar sekarang</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const loginForm = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailWrap = document.getElementById('email-wrap');
        const passwordWrap = document.getElementById('password-wrap');
        const emailError = document.getElementById('email-error');
        const emailErrorText = document.getElementById('email-error-text');
        const passwordError = document.getElementById('password-error');
        const passwordErrorText = document.getElementById('password-error-text');
        const loginAlert = document.getElementById('login-alert');
        const loginAlertText = document.getElementById('login-alert-text');

        function setFieldError(wrap, errEl, errTextEl, message) {
            if (message) {
                wrap.classList.add('ring-2', 'ring-error/60');
                errTextEl.textContent = message;
                errEl.classList.remove('hidden');
            } else {
                wrap.classList.remove('ring-2', 'ring-error/60');
                errTextEl.textContent = '';
                errEl.classList.add('hidden');
            }
        }

        function setAlert(message) {
            if (message) {
                loginAlertText.textContent = message;
                loginAlert.classList.remove('hidden');
            } else {
                loginAlertText.textContent = '';
                loginAlert.classList.add('hidden');
            }
        }

        function clearAllErrors() {
            setAlert('');
            setFieldError(emailWrap, emailError, emailErrorText, '');
            setFieldError(passwordWrap, passwordError, passwordErrorText, '');
        }

        emailInput.addEventListener('input', () => {
            setFieldError(emailWrap, emailError, emailErrorText, '');
            if (passwordError.classList.contains('hidden')) setAlert('');
        });

        passwordInput.addEventListener('input', () => {
            setFieldError(passwordWrap, passwordError, passwordErrorText, '');
            if (emailError.classList.contains('hidden')) setAlert('');
        });

        loginForm.addEventListener('submit', function (e) {
            const emailVal = emailInput.value.trim();
            const passVal = passwordInput.value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            let emailMsg = '';
            let passMsg = '';

            if (!emailVal) {
                emailMsg = 'Alamat email wajib diisi.';
            } else if (!emailPattern.test(emailVal)) {
                emailMsg = 'Format alamat email tidak valid (contoh: nama@email.com).';
            }

            if (!passVal) {
                passMsg = 'Kata sandi wajib diisi.';
            }

            if (emailMsg || passMsg) {
                e.preventDefault();
                setFieldError(emailWrap, emailError, emailErrorText, emailMsg);
                setFieldError(passwordWrap, passwordError, passwordErrorText, passMsg);

                if (!emailVal && !passVal) {
                    setAlert('Alamat email dan kata sandi wajib diisi untuk masuk ke akun Anda.');
                    emailInput.focus();
                } else if (emailMsg) {
                    setAlert(emailMsg);
                    emailInput.focus();
                } else {
                    setAlert(passMsg);
                    passwordInput.focus();
                }
            }
        });

        function togglePassword() {
            const eye = document.getElementById('password-eye');
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            if (eye) eye.textContent = isHidden ? 'visibility_off' : 'visibility';
        }

        function fillDemo(email) {
            clearAllErrors();
            emailInput.value = email;
            passwordInput.value = 'password123';
            emailInput.focus();
        }
    </script>
    @endpush
</x-layouts.auth>
