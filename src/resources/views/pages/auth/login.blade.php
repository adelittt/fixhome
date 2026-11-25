<x-layouts.app title="Masuk - FixHome">
    <div class="w-full flex-1 flex items-center justify-center py-space-xl px-gutter lg:px-margin">
        <div class="w-full max-w-md lg:max-w-4xl neu-card-lg overflow-hidden lg:grid lg:grid-cols-12">

            <!-- Left Editorial Panel (Desktop) -->
            <div class="hidden lg:flex lg:col-span-5 bg-primary-container text-inverse-on-surface p-space-xl flex-col justify-between relative overflow-hidden">
                <div class="absolute -bottom-24 -right-20 w-72 h-72 rounded-full bg-tertiary-fixed/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -top-16 -left-16 w-56 h-56 rounded-full bg-secondary-container/15 blur-2xl pointer-events-none"></div>

                <div class="relative z-10 space-y-5">
                    <a href="{{ route('splash') }}" class="inline-flex items-center rounded-xl bg-surface px-3.5 py-2 shadow-sm w-fit">
                        <img alt="FixHome" class="h-8 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                    </a>

                    <h2 class="font-headline-md text-headline-md text-on-primary font-bold font-recoleta leading-snug pt-2">
                        Satu Pintu Masuk untuk Seluruh Ekosistem FixHome.
                    </h2>
                    <p class="font-body-md text-body-md text-inverse-on-surface/80 leading-relaxed">
                        Masuk menggunakan akun Customer atau Mitra Teknisi. Sistem otomatis mengarahkan Anda ke halaman yang sesuai dengan peran akun Anda.
                    </p>

                    <div class="space-y-2.5 pt-2 text-xs text-inverse-on-surface/90">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[18px]">home</span>
                            <span>Customer — Booking teknisi, lacak GPS &amp; live chat</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[18px]">engineering</span>
                            <span>Mitra Teknisi — Kelola pesanan &amp; dompet 95%</span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 pt-5 mt-6 border-t border-inverse-on-surface/15 text-xs text-inverse-on-surface/80">
                    <span class="font-bold block text-tertiary-fixed mb-1 font-butler">Akses Terpadu &amp; Aman</span>
                    Autentikasi terpusat dengan pemisahan hak akses (RBAC) otomatis sesuai peran pengguna.
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="lg:col-span-7 p-6 sm:p-space-xl flex flex-col justify-between bg-surface">
                <div>
                    <!-- Mobile Brand Bar -->
                    <div class="flex lg:hidden items-center justify-between pb-4">
                        <a href="{{ route('splash') }}" class="w-9 h-9 rounded-full neu-btn-secondary text-primary">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </a>
                        <a href="{{ route('splash') }}" class="flex items-center">
                            <img alt="FixHome" class="h-8 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                        </a>
                        <div class="w-9"></div>
                    </div>

                    <div class="mb-5">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full neu-pill text-secondary font-label-sm font-semibold mb-2 font-lucy-rose">
                            <span class="material-symbols-outlined text-[14px] text-tertiary">lock_open</span>
                            <span>Portal Masuk Terpadu</span>
                        </div>
                        <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">Masuk ke Akun Anda</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                            Berlaku untuk <strong class="text-primary">Customer</strong> dan <strong class="text-primary">Teknisi Mitra</strong>.
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
                    <div id="login-alert" role="alert" class="{{ $serverAlert ? '' : 'hidden' }} mb-4 p-3.5 rounded-2xl bg-error-container text-on-error-container text-xs font-semibold flex items-start gap-2.5 shadow-sm">
                        <span class="material-symbols-outlined text-error text-[19px] shrink-0 mt-0.5">warning</span>
                        <span id="login-alert-text" class="leading-relaxed">{{ $serverAlert }}</span>
                    </div>

                    <form id="login-form" action="{{ route('login') }}" method="POST" novalidate class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block font-label-md text-label-md text-primary mb-1.5">
                                Alamat Email <span class="text-error">*</span>
                            </label>
                            <div id="email-wrap" class="neu-inset rounded-full flex items-center px-4 py-2.5 transition-all {{ ($errors->has('email') || $errors->has('auth')) ? 'ring-2 ring-error/60' : '' }}">
                                <span class="material-symbols-outlined text-primary text-[19px] mr-2.5">mail</span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full bg-transparent text-sm text-on-surface placeholder:text-outline focus:outline-none"
                                    placeholder="nama@email.com">
                            </div>
                            <p id="email-error" class="{{ $errors->has('email') ? '' : 'hidden' }} mt-1.5 px-2 text-[11px] font-semibold text-error flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                <span id="email-error-text">{{ $errors->first('email') }}</span>
                            </p>
                        </div>

                        <div>
                            <label for="password" class="block font-label-md text-label-md text-primary mb-1.5">
                                Kata Sandi <span class="text-error">*</span>
                            </label>
                            <div id="password-wrap" class="neu-inset rounded-full flex items-center px-4 py-2.5 transition-all {{ ($errors->has('password') || $errors->has('auth')) ? 'ring-2 ring-error/60' : '' }}">
                                <span class="material-symbols-outlined text-primary text-[19px] mr-2.5">lock</span>
                                <input type="password" id="password" name="password" required
                                    class="w-full bg-transparent text-sm text-on-surface placeholder:text-outline focus:outline-none"
                                    placeholder="Masukkan kata sandi">
                            </div>
                            <p id="password-error" class="{{ $errors->has('password') ? '' : 'hidden' }} mt-1.5 px-2 text-[11px] font-semibold text-error flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                <span id="password-error-text">{{ $errors->first('password') }}</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-between text-xs pt-1 px-1">
                            <label class="flex items-center gap-2 cursor-pointer text-on-surface-variant">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-primary-container">
                                <span>Ingat saya</span>
                            </label>
                            <a href="{{ route('public.cara-kerja') }}" class="font-semibold text-primary-container hover:underline">Butuh bantuan?</a>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                                <span class="material-symbols-outlined text-[19px]">login</span>
                                <span>Masuk Sekarang</span>
                            </button>
                        </div>
                    </form>

                    <!-- Optional Quick-Fill Demo Credentials -->
                    <div class="mt-6 pt-5 border-t border-outline-variant/40">
                        <span class="block text-[11px] font-semibold text-outline text-center mb-2.5">Isi Cepat Akun Demo:</span>
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <button type="button" onclick="fillDemo('customer@fixhome.com')" class="neu-pill px-3.5 py-1.5 text-xs font-semibold text-primary hover:-translate-y-0.5 transition-all">
                                <span class="material-symbols-outlined text-[14px] text-secondary">person</span>
                                <span>Customer</span>
                            </button>
                            <button type="button" onclick="fillDemo('budi.teknisi@fixhome.com')" class="neu-pill px-3.5 py-1.5 text-xs font-semibold text-primary hover:-translate-y-0.5 transition-all">
                                <span class="material-symbols-outlined text-[14px] text-tertiary">engineering</span>
                                <span>Teknisi</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-5 text-center text-xs text-on-surface-variant">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-primary-container hover:underline ml-1">Daftar Akun Baru</a>
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

        function fillDemo(email) {
            clearAllErrors();
            emailInput.value = email;
            passwordInput.value = 'password123';
            emailInput.focus();
        }
    </script>
    @endpush
</x-layouts.app>
