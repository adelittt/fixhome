<x-layouts.app title="Profil Pengguna - FixHome">
    <div class="flex-1 flex flex-col justify-between pb-24 lg:pb-12">

        <!-- Mobile Header -->
        <div class="lg:hidden bg-surface/90 backdrop-blur-md px-5 pt-5 pb-4 sticky top-0 z-30 flex items-center justify-between shadow-sm">
            <h1 class="font-headline-sm text-primary font-bold font-recoleta leading-tight">Profil Pengguna</h1>
            <a href="{{ route('customer.home') }}" class="w-9 h-9 rounded-full neu-btn-secondary text-primary">
                <span class="material-symbols-outlined text-[18px]">home</span>
            </a>
        </div>

        <div class="max-w-2xl mx-auto w-full px-gutter py-space-lg space-y-5 flex-1">

            <!-- Profile Info Card -->
            <div class="neu-card-lg p-7 text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-3xl neu-icon-primary font-extrabold text-3xl font-recoleta mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="font-headline-md text-primary font-bold font-recoleta">{{ $user->name }}</h2>
                <span class="inline-block mt-1 text-xs text-on-surface-variant">{{ $user->email }}</span>
                <span class="inline-flex items-center gap-1 mt-3 px-4 py-1 rounded-full text-[11px] font-bold bg-secondary-container text-primary">
                    <span class="material-symbols-outlined text-[14px] text-tertiary">verified</span>
                    <span>Akun {{ ucfirst($user->role) }}</span>
                </span>
            </div>

            <!-- Address Card (BR-01) -->
            <div class="neu-card p-6 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-title-sm text-primary font-bold font-butler flex items-center gap-2">
                        <span class="material-symbols-outlined text-[19px] text-secondary">location_on</span>
                        <span>Alamat Terdaftar (BR-01)</span>
                    </span>
                    <a href="{{ route('customer.set-address') }}" class="neu-btn-secondary px-3.5 py-1.5 text-xs text-primary">Ubah Lokasi</a>
                </div>
                <div class="p-4 neu-inset text-xs text-on-surface leading-relaxed">
                    {{ $customer->alamat_lengkap ?? 'Belum ada alamat tersimpan.' }}
                </div>
                <div class="text-[11px] text-outline font-mono flex items-center gap-1.5 px-1">
                    <span class="material-symbols-outlined text-[14px]">my_location</span>
                    <span>Koordinat: {{ $customer->latitude ?? '-' }}, {{ $customer->longitude ?? '-' }}</span>
                </div>
            </div>

            <!-- Action Menu -->
            <div class="neu-card p-4 space-y-2.5 text-xs">
                <a href="{{ route('customer.orders') }}" class="flex items-center justify-between p-3.5 rounded-[18px] hover:bg-surface-container-low transition-colors font-bold text-primary">
                    <span class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl neu-icon-teal">
                            <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                        </span>
                        <span>Riwayat Pesanan Servis</span>
                    </span>
                    <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                </a>

                <a href="{{ route('customer.technicians') }}" class="flex items-center justify-between p-3.5 rounded-[18px] hover:bg-surface-container-low transition-colors font-bold text-primary">
                    <span class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl neu-icon-gold">
                            <span class="material-symbols-outlined text-[18px]">engineering</span>
                        </span>
                        <span>Cari Teknisi Terdekat</span>
                    </span>
                    <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between p-3.5 rounded-[18px] hover:bg-error-container/50 text-error transition-colors font-bold">
                        <span class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-error-container text-on-error-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </span>
                            <span>Keluar dari Akun (Logout)</span>
                        </span>
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
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

    </div>
</x-layouts.app>
