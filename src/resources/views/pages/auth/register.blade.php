<x-layouts.app title="Daftar Akun - FixHome">
    <div class="w-full flex-1 flex items-center justify-center py-space-xl px-gutter lg:px-margin">
        <div class="w-full max-w-md lg:max-w-4xl neu-card-lg overflow-hidden lg:grid lg:grid-cols-12">

            <!-- Left Editorial Panel (Desktop) -->
            <div class="hidden lg:flex lg:col-span-5 bg-primary-container text-inverse-on-surface p-space-xl flex-col justify-between relative overflow-hidden">
                <div class="absolute -bottom-24 -right-20 w-72 h-72 rounded-full bg-tertiary-fixed/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -top-16 -left-16 w-56 h-56 rounded-full bg-secondary-container/15 blur-2xl pointer-events-none"></div>

                <div class="relative z-10 space-y-5">
                    <a href="{{ route('splash') }}" class="inline-flex items-center gap-3">
                        <img alt="FixHome Logo" class="h-10 w-10 rounded-xl object-contain bg-surface p-1 shadow-md" src="{{ asset('images/fixhome-logo.jpg') }}" />
                        <span class="font-headline-sm text-headline-sm text-tertiary-fixed font-recoleta">FixHome</span>
                    </a>

                    <h2 class="font-headline-md text-headline-md text-on-primary font-bold font-recoleta leading-snug pt-2">
                        Bergabung Bersama Pemilik Rumah &amp; Mitra Teknisi Profesional.
                    </h2>

                    <ul class="text-xs text-inverse-on-surface/90 space-y-3 pt-2">
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[18px] shrink-0">location_searching</span>
                            <span>Pencarian berbasis radius koordinat terdekat (BR-02)</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[18px] shrink-0">verified_user</span>
                            <span>Verifikasi identitas &amp; uji kompetensi terjamin</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[18px] shrink-0">receipt_long</span>
                            <span>Transparansi komisi 5% dan 95% hak penuh teknisi</span>
                        </li>
                    </ul>
                </div>

                <div class="relative z-10 pt-5 mt-6 border-t border-inverse-on-surface/15 text-xs text-tertiary-fixed font-label-sm">
                    FixHome &bull; Layanan Perbaikan Rumah Bergaransi 14 Hari
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
                        <div class="flex items-center gap-2">
                            <img alt="FixHome Logo" class="h-8 w-8 rounded-lg object-contain mix-blend-multiply" src="{{ asset('images/fixhome-logo.jpg') }}" />
                            <span class="font-headline-sm text-primary-container font-recoleta">FixHome</span>
                        </div>
                        <div class="w-9"></div>
                    </div>

                    <div class="mb-5">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full neu-pill text-secondary font-label-sm font-semibold mb-2 font-lucy-rose">
                            <span class="material-symbols-outlined text-[14px] text-tertiary">person_add</span>
                            <span>Registrasi Akun Baru</span>
                        </div>
                        <h1 class="font-headline-md text-headline-md text-primary font-bold font-recoleta">Buat Akun Baru</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Lengkapi data diri Anda untuk mulai menggunakan FixHome</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                        @csrf

                        <!-- Role Selector -->
                        <div>
                            <label class="block font-label-md text-label-md text-primary mb-1.5">Daftar Sebagai</label>
                            @php $selectedRole = old('role', request('role') === 'teknisi' ? 'teknisi' : 'customer'); @endphp
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-center gap-2 p-3 rounded-2xl cursor-pointer transition-all neu-card-sm has-[:checked]:bg-primary-container has-[:checked]:text-on-primary text-xs font-bold text-primary">
                                    <input type="radio" name="role" value="customer" {{ $selectedRole === 'customer' ? 'checked' : '' }} onchange="toggleKeahlian(false)" class="sr-only">
                                    <span class="material-symbols-outlined text-[18px]">home</span>
                                    <span>Customer</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 p-3 rounded-2xl cursor-pointer transition-all neu-card-sm has-[:checked]:bg-primary-container has-[:checked]:text-on-primary text-xs font-bold text-primary">
                                    <input type="radio" name="role" value="teknisi" {{ $selectedRole === 'teknisi' ? 'checked' : '' }} onchange="toggleKeahlian(true)" class="sr-only">
                                    <span class="material-symbols-outlined text-[18px]">engineering</span>
                                    <span>Mitra Teknisi</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-primary mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="neu-input px-4 py-2.5 text-xs"
                                placeholder="Contoh: Rahmat Hidayat">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-label-md text-label-md text-primary mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="neu-input px-4 py-2.5 text-xs"
                                    placeholder="nama@email.com">
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-primary mb-1">No. WhatsApp</label>
                                <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                    class="neu-input px-4 py-2.5 text-xs"
                                    placeholder="081234567890">
                            </div>
                        </div>

                        <!-- Extra Fields for Teknisi -->
                        <div id="teknisi-extra-field" class="{{ $selectedRole === 'teknisi' ? '' : 'hidden' }} space-y-3 p-4 neu-inset rounded-[22px]">
                            <div class="flex items-center gap-2 text-xs font-bold text-primary">
                                <span class="material-symbols-outlined text-[17px] text-tertiary">verified</span>
                                <span>Data Verifikasi Mitra Teknisi</span>
                            </div>
                            <div>
                                <label class="block font-label-sm text-on-surface-variant font-semibold mb-1">Keahlian Utama</label>
                                <select name="keahlian" class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-surface text-on-surface shadow-[-2px_-2px_5px_#FFFFFF,2px_2px_5px_#D2D2D2] focus:outline-none">
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
                                    <label class="block font-label-sm text-on-surface-variant font-semibold mb-1">Nomor KTP (Verifikasi)</label>
                                    <input type="text" name="no_ktp" placeholder="16 digit NIK KTP"
                                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-surface text-on-surface shadow-[-2px_-2px_5px_#FFFFFF,2px_2px_5px_#D2D2D2] focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-label-sm text-on-surface-variant font-semibold mb-1">Tarif Dasar Jasa (Rp)</label>
                                    <input type="number" name="tarif_dasar" value="75000"
                                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-surface text-on-surface shadow-[-2px_-2px_5px_#FFFFFF,2px_2px_5px_#D2D2D2] focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block font-label-sm text-on-surface-variant font-semibold mb-1">Bukti Sertifikasi / Pelatihan (Opsional)</label>
                                <input type="text" name="sertifikasi" placeholder="Contoh: Sertifikasi BNSP / SKK Kelistrikan"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-surface text-on-surface shadow-[-2px_-2px_5px_#FFFFFF,2px_2px_5px_#D2D2D2] focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-label-md text-label-md text-primary mb-1">Kata Sandi</label>
                                <input type="password" name="password" required
                                    class="neu-input px-4 py-2.5 text-xs"
                                    placeholder="Min. 6 kar">
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-primary mb-1">Konfirmasi</label>
                                <input type="password" name="password_confirmation" required
                                    class="neu-input px-4 py-2.5 text-xs"
                                    placeholder="Ulangi sandi">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full neu-btn-primary py-3.5 px-6 text-label-lg gap-2">
                                <span class="material-symbols-outlined text-[19px]">how_to_reg</span>
                                <span>Daftar Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="pt-5 text-center text-xs text-on-surface-variant">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-primary-container hover:underline ml-1">Masuk</a>
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
