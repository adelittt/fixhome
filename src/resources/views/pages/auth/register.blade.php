<x-layouts.app title="Daftar Akun - FixHome">
    <div class="w-full flex-1 flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6">
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
                    <!-- Mobile Brand Bar -->
                    <div class="flex lg:hidden items-center justify-between pb-6">
                        <a href="{{ route('splash') }}" class="w-9 h-9 rounded-full bg-[#F8FAFC] border border-[#E5E7EB] flex items-center justify-center text-[#111827]">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </a>
                        <a href="{{ route('splash') }}" class="flex items-center">
                            <img alt="FixHome" class="h-7 w-auto object-contain" src="{{ asset('images/fixhome-logo-full.png') }}" />
                        </a>
                        <div class="w-9"></div>
                    </div>

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
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                placeholder="Contoh: Rahmat Hidayat">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full rounded-xl bg-white border border-[#D1D5DB] px-3.5 py-2.5 text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#16A34A] focus:ring-4 focus:ring-[#16A34A]/10 focus:outline-none transition-all"
                                    placeholder="nama@email.com">
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
                                    <option value="AC & Pendingin">AC &amp; Pendingin</option>
                                    <option value="Instalasi Listrik">Instalasi Listrik</option>
                                    <option value="Pipa & Saluran Air">Pipa &amp; Saluran Air</option>
                                    <option value="Atap & Plafon Bocor">Atap &amp; Plafon Bocor</option>
                                    <option value="Pengecatan & Tembok">Pengecatan &amp; Tembok</option>
                                    <option value="Kunci & Pintu Rusak">Kunci &amp; Pintu Rusak</option>
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
                                    <input type="number" name="tarif_dasar" value="75000"
                                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11.5px] text-[#4B5563] font-semibold mb-1">Bukti Sertifikasi / Pelatihan (Opsional)</label>
                                <input type="text" name="sertifikasi" placeholder="Contoh: Sertifikasi BNSP / SKK Kelistrikan"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-white border border-[#D1D5DB] text-[#111827] focus:border-[#16A34A] focus:ring-2 focus:ring-[#16A34A]/20 focus:outline-none">
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
        function toggleKeahlian(show) {
            const extra = document.getElementById('teknisi-extra-field');
            if (show) {
                extra.classList.remove('hidden');
            } else {
                extra.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-layouts.app>
