<x-layouts.app title="Invoice {{ $invoiceNumber }} - FixHome">
    <div class="w-full flex-1 flex flex-col justify-between pb-16">
        <div class="max-w-[820px] mx-auto w-full px-4 sm:px-6 pt-6 sm:pt-8 space-y-5">

            <!-- Payment Success & Gmail Delivery Notification Banner -->
            <div class="rounded-[20px] bg-[#F0FDF4] border border-[#BBF7D0] p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-full bg-[#16A34A] text-white flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">check_circle</span>
                    </div>
                    <div>
                        <h1 class="text-[16px] font-extrabold text-[#14532D]">
                            Pembayaran Berhasil Diverifikasi!
                        </h1>
                        <p class="text-[13px] text-[#15803D] mt-0.5 leading-relaxed">
                            Invoice resmi <strong>{{ $invoiceNumber }}</strong> telah otomatis dikirimkan ke Gmail kamu:
                            <strong class="underline">{{ $customerEmail }}</strong>.
                        </p>
                    </div>
                </div>
                <form action="{{ route('booking.invoice-resend', $booking->id) }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white border border-[#BBF7D0] hover:border-[#16A34A] text-[12px] font-semibold text-[#15803D] shadow-xs transition-all">
                        <span class="material-symbols-outlined text-[16px]">mail</span>
                        <span>Kirim Ulang ke Gmail</span>
                    </button>
                </form>
            </div>

            <!-- Printable Invoice Card -->
            <div class="bg-white rounded-[24px] border border-[#E5E7EB] shadow-[0_8px_30px_rgba(17,24,39,0.05)] overflow-hidden print:shadow-none print:border-0">
                <!-- Invoice Header -->
                <div class="p-6 sm:p-8 border-b border-[#E5E7EB] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <img alt="FixHome" class="h-8 w-auto object-contain mb-3" src="{{ asset('images/fixhome-logo-full.png') }}" />
                        <p class="text-[12px] text-[#6B7280]">Layanan Perbaikan Rumah Terverifikasi</p>
                    </div>
                    <div class="sm:text-right">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#DCFCE7] text-[#15803D] text-[11px] font-bold uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            LUNAS
                        </span>
                        <h2 class="text-[20px] font-extrabold text-[#111827] mt-2">{{ $invoiceNumber }}</h2>
                        <p class="text-[12px] text-[#6B7280]">Kode Transaksi: {{ $transaksi->kode_transaksi }}</p>
                    </div>
                </div>

                <!-- Customer & Order Metadata -->
                <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-6 bg-[#F8FAFC] border-b border-[#E5E7EB] text-[13px]">
                    <div class="space-y-1.5">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280]">Ditagihkan Kepada</p>
                        <p class="font-bold text-[#111827] text-[14.5px]">{{ $booking->customer->nama_lengkap ?? $booking->customer->user->name }}</p>
                        <p class="text-[#4B5563]">{{ $customerEmail }}</p>
                        @if ($booking->customer->alamat_lengkap)
                            <p class="text-[#4B5563] text-[12.5px]">{{ $booking->customer->alamat_lengkap }}</p>
                        @endif
                    </div>

                    <div class="space-y-1.5 sm:text-right">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280]">Detail Pembayaran &amp; Teknisi</p>
                        <p class="text-[#374151]">Metode: <strong class="text-[#111827]">{{ $transaksi->payment_method ?? 'Midtrans QRIS' }}</strong></p>
                        <p class="text-[#374151]">Tanggal Lunas: <strong class="text-[#111827]">{{ ($transaksi->paid_at ?? now())->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</strong></p>
                        <p class="text-[#374151]">Teknisi: <strong class="text-[#111827]">{{ $booking->teknisi->nama_lengkap ?? '-' }}</strong> ({{ $booking->teknisi->keahlian ?? 'Teknisi' }})</p>
                        <p class="text-[#374151]">Jadwal: <strong class="text-[#111827]">{{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y, H:i') }} WIB</strong></p>
                    </div>
                </div>

                <!-- Itemized Table -->
                <div class="p-6 sm:p-8">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280] mb-3">Rincian Layanan</p>
                    <div class="divide-y divide-[#E5E7EB] border-y border-[#E5E7EB]">
                        <div class="py-3.5 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[14px] font-bold text-[#111827]">Jasa Perbaikan — {{ $booking->teknisi->keahlian ?? 'Layanan Rumah' }}</p>
                                <p class="text-[12.5px] text-[#6B7280] mt-0.5">{{ $booking->deskripsi_kerusakan }}</p>
                            </div>
                            <span class="text-[14px] font-semibold text-[#111827] whitespace-nowrap">
                                Rp{{ number_format((float) $booking->biaya_layanan, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="py-3.5 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[13.5px] font-medium text-[#374151]">Biaya Jarak Operasional</p>
                                <p class="text-[12px] text-[#6B7280]">Jarak estimasi {{ number_format((float) $booking->jarak_km, 1) }} km (&lt; 10 km gratis)</p>
                            </div>
                            <span class="text-[14px] font-semibold text-[#111827] whitespace-nowrap">
                                {{ (float) $booking->biaya_jarak > 0 ? 'Rp' . number_format((float) $booking->biaya_jarak, 0, ',', '.') : 'Rp0' }}
                            </span>
                        </div>

                        <div class="py-4 flex items-center justify-between gap-4">
                            <span class="text-[15px] font-extrabold text-[#111827]">Total Pembayaran Lunas</span>
                            <span class="text-[20px] font-extrabold text-[#16A34A] whitespace-nowrap">
                                Rp{{ number_format((float) $booking->total_biaya, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 p-4 rounded-2xl bg-[#F8FAFC] border border-[#E5E7EB] flex items-start gap-3 text-[12.5px] text-[#4B5563]">
                        <span class="material-symbols-outlined text-[#16A34A] text-[20px] shrink-0">verified_user</span>
                        <p>
                            <strong class="text-[#111827]">Bukti Pembayaran Resmi FixHome.</strong>
                            Pesanan ini tercatat secara transparan (95% hak mitra teknisi &amp; 5% komisi pemeliharaan platform).
                        </p>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="px-6 sm:px-8 py-5 bg-[#F8FAFC] border-t border-[#E5E7EB] flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 print:hidden">
                    <button type="button" onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-white border border-[#D1D5DB] hover:border-[#16A34A] text-[13px] font-semibold text-[#111827] transition-all">
                        <span class="material-symbols-outlined text-[18px]">print</span>
                        <span>Cetak / Simpan PDF</span>
                    </button>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                        <a href="{{ route('customer.orders') }}" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-full bg-white border border-[#D1D5DB] hover:border-[#16A34A] text-[13px] font-semibold text-[#374151] transition-all">
                            <span>Riwayat Pesanan</span>
                        </a>
                        <a href="{{ route('tracking.chat', $booking->id) }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-[#16A34A] hover:bg-[#15803D] text-white text-[13px] font-semibold shadow-sm transition-all">
                            <span class="material-symbols-outlined text-[18px]">map</span>
                            <span>Lacak GPS &amp; Live Chat</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
