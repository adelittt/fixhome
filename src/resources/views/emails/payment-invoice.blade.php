<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice {{ $invoiceNumber }} — FixHome</title>
</head>
<body style="margin:0; padding:0; background-color:#F8FAFC; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#F8FAFC; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px; background-color:#FFFFFF; border:1px solid #E5E7EB; border-radius:20px; overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="padding:28px 32px; background-color:#16A34A; color:#FFFFFF;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <span style="display:inline-block; background-color:rgba(255,255,255,0.18); color:#FFFFFF; font-size:11px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; padding:5px 12px; border-radius:999px;">
                                            Pembayaran Berhasil
                                        </span>
                                        <h1 style="margin:12px 0 4px; font-size:22px; font-weight:800; line-height:1.25; color:#FFFFFF;">
                                            Invoice Resmi FixHome
                                        </h1>
                                        <p style="margin:0; font-size:13px; color:#DCFCE7;">
                                            {{ $invoiceNumber }} &middot; Kode Transaksi {{ $transaksi->kode_transaksi }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:28px 32px;">
                            <p style="margin:0 0 18px; font-size:14px; line-height:1.6; color:#374151;">
                                Halo <strong>{{ $booking->customer->nama_lengkap ?? $booking->customer->user->name ?? 'Pelanggan FixHome' }}</strong>,<br />
                                Terima kasih! Pembayaran Anda telah berhasil diverifikasi. Berikut rincian invoice resmi pesanan perbaikan rumah Anda:
                            </p>

                            <!-- Info Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#F8FAFC; border:1px solid #E5E7EB; border-radius:14px; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:16px 20px; font-size:13px; line-height:1.7; color:#374151;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="color:#6B7280; padding:3px 0;">Nomor Invoice</td>
                                                <td align="right" style="font-weight:700; color:#111827; padding:3px 0;">{{ $invoiceNumber }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#6B7280; padding:3px 0;">Status Pembayaran</td>
                                                <td align="right" style="font-weight:700; color:#16A34A; padding:3px 0;">LUNAS</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#6B7280; padding:3px 0;">Metode Pembayaran</td>
                                                <td align="right" style="font-weight:600; color:#111827; padding:3px 0;">{{ $transaksi->payment_method ?? 'Midtrans QRIS' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#6B7280; padding:3px 0;">Tanggal Lunas</td>
                                                <td align="right" style="font-weight:600; color:#111827; padding:3px 0;">{{ ($transaksi->paid_at ?? now())->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#6B7280; padding:3px 0;">Mitra Teknisi</td>
                                                <td align="right" style="font-weight:600; color:#111827; padding:3px 0;">{{ $booking->teknisi->nama_lengkap ?? '-' }} ({{ $booking->teknisi->keahlian ?? 'Teknisi' }})</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#6B7280; padding:3px 0;">Jadwal Kunjungan</td>
                                                <td align="right" style="font-weight:600; color:#111827; padding:3px 0;">{{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y, H:i') }} WIB</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Itemized Breakdown -->
                            <p style="margin:0 0 8px; font-size:11px; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; color:#6B7280;">
                                Rincian Biaya
                            </p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-top:1px solid #E5E7EB; border-bottom:1px solid #E5E7EB; margin-bottom:20px;">
                                <tr>
                                    <td style="padding:12px 0; font-size:13.5px; color:#374151;">
                                        <strong>Biaya Layanan Perbaikan</strong><br />
                                        <span style="font-size:12px; color:#6B7280;">{{ $booking->deskripsi_kerusakan }}</span>
                                    </td>
                                    <td align="right" valign="top" style="padding:12px 0; font-size:13.5px; font-weight:600; color:#111827; white-space:nowrap;">
                                        Rp{{ number_format((float) $booking->biaya_layanan, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0 12px; font-size:13.5px; color:#374151; border-top:1px dashed #E5E7EB;">
                                        Biaya Jarak Operasional ({{ number_format((float) $booking->jarak_km, 1) }} km)
                                    </td>
                                    <td align="right" style="padding:8px 0 12px; font-size:13.5px; font-weight:600; color:#111827; border-top:1px dashed #E5E7EB; white-space:nowrap;">
                                        {{ (float) $booking->biaya_jarak > 0 ? 'Rp' . number_format((float) $booking->biaya_jarak, 0, ',', '.') : 'Gratis (Rp0)' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 0; font-size:15px; font-weight:800; color:#111827; border-top:1px solid #E5E7EB;">
                                        Total Dibayar
                                    </td>
                                    <td align="right" style="padding:14px 0; font-size:16px; font-weight:800; color:#16A34A; border-top:1px solid #E5E7EB; white-space:nowrap;">
                                        Rp{{ number_format((float) $booking->total_biaya, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:18px 32px; background-color:#F8FAFC; border-top:1px solid #E5E7EB; text-align:center; font-size:11.5px; color:#6B7280;">
                            &copy; {{ date('Y') }} FixHome Indonesia &middot; Solusi Perbaikan Rumah Terverifikasi &amp; Bergaransi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
