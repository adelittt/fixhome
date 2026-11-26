<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Mitra Teknisi FixHome</title>
</head>
<body style="margin:0; padding:0; background-color:#F8FAFC; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#F8FAFC; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:520px; background-color:#FFFFFF; border:1px solid #E5E7EB; border-radius:20px; overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px 20px; border-bottom:1px solid #E5E7EB;">
                            <span style="display:inline-block; background-color:#DCFCE7; color:#15803D; font-size:11px; font-weight:700; padding:4px 12px; border-radius:999px; letter-spacing:0.04em; text-transform:uppercase;">
                                Verifikasi Mitra Teknisi
                            </span>
                            <h1 style="margin:14px 0 6px; font-size:20px; font-weight:800; color:#111827;">
                                Kode Verifikasi Pendaftaran Anda
                            </h1>
                            <p style="margin:0; font-size:13.5px; color:#4B5563; line-height:1.5;">
                                Halo <strong>{{ $recipientName }}</strong>, masukkan kode OTP 6 digit berikut pada formulir pendaftaran Mitra Teknisi FixHome:
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:28px 32px;">
                            <div style="display:inline-block; background-color:#F0FDF4; border:2px dashed #16A34A; border-radius:16px; padding:16px 32px; font-size:32px; font-weight:800; letter-spacing:0.28em; color:#15803D; font-family:'Courier New', Courier, monospace;">
                                {{ $otpCode }}
                            </div>
                            <p style="margin:18px 0 0; font-size:12.5px; color:#6B7280; line-height:1.5;">
                                Kode ini berlaku selama <strong>10 menit</strong>. Demi keamanan akun Anda, jangan bagikan kode ini kepada siapa pun termasuk pihak yang mengaku dari FixHome.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 32px; background-color:#F8FAFC; border-top:1px solid #E5E7EB; text-align:center; font-size:11.5px; color:#6B7280;">
                            &copy; {{ date('Y') }} FixHome Indonesia &middot; Pendaftaran Mitra Teknisi Resmi
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
