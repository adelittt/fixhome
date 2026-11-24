<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\PelacakanLokasi;
use App\Models\Teknisi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function showBookingForm(int $teknisiId)
    {
        $technician = Teknisi::with('user')->findOrFail($teknisiId);
        $customer = Auth::user()->customer;

        // Perhitungan Jarak dan Biaya Tambahan (KF-05, KF-06, KF-07)
        $distance = CustomerController::calculateDistance(
            $customer->latitude, $customer->longitude,
            $technician->latitude, $technician->longitude
        );

        // Validasi batas jangkauan maksimal 35 km
        if ($distance > 35.0) {
            return redirect()->route('customer.technicians')
                ->with('error', "Maaf, jarak lokasi Anda ({$distance} km) melebihi jangkauan operasional maksimal mitra (35 km). Teknisi tidak dapat ditemukan / dipesan.");
        }

        $biayaJarak = CustomerController::calculateBiayaJarak($distance);

        return view('pages.customer.booking-form', compact('technician', 'customer', 'distance', 'biayaJarak'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'teknisi_id' => ['required', 'exists:teknisi,id'],
            'jadwal_tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jadwal_jam' => ['required', 'string'],
            'deskripsi_kerusakan' => ['required', 'string', 'min:5'],
            'catatan_perbaikan' => ['nullable', 'string'],
            'addon_outdoor' => ['nullable'],
            'addon_freon' => ['nullable'],
        ]);

        $customer = Auth::user()->customer;
        $technician = Teknisi::findOrFail($validated['teknisi_id']);

        $jadwalDateTime = $validated['jadwal_tanggal'] . ' ' . $validated['jadwal_jam'] . ':00';

        // Hitung jarak dan biaya tambahan jarak (KF-05, KF-06)
        $distance = CustomerController::calculateDistance(
            $customer->latitude, $customer->longitude,
            $technician->latitude, $technician->longitude
        );

        // Validasi batas operasional 35 km
        if ($distance > 35.0) {
            return redirect()->route('customer.technicians')
                ->with('error', "Pemesanan dibatalkan: Jarak lokasi Anda ({$distance} km) melebihi jangkauan maksimal operasional 35 km.");
        }
        $biayaJarak = CustomerController::calculateBiayaJarak($distance);

        // Hitung biaya layanan (tarif dasar + addon)
        $biayaLayanan = (float) $technician->tarif_dasar;
        if ($request->has('addon_outdoor')) {
            $biayaLayanan += 25000;
        }
        if ($request->has('addon_freon')) {
            $biayaLayanan += 50000;
        }

        $totalBiaya = $biayaLayanan + $biayaJarak;

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'teknisi_id' => $technician->id,
            'jadwal' => $jadwalDateTime,
            'deskripsi_kerusakan' => $validated['deskripsi_kerusakan'],
            'catatan_perbaikan' => $validated['catatan_perbaikan'] ?? null,
            'status_order' => 'pending_payment',
            'jarak_km' => $distance,
            'biaya_layanan' => $biayaLayanan,
            'biaya_jarak' => $biayaJarak,
            'total_biaya' => $totalBiaya,
        ]);

        return redirect()->route('booking.payment', $booking->id);
    }

    public function showPayment(int $bookingId)
    {
        $booking = Booking::with(['customer.user', 'teknisi.user', 'transaksi'])->findOrFail($bookingId);

        // Validasi kepemilikan booking
        if ($booking->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($booking->status_order !== 'pending_payment' && $booking->transaksi?->isPaid()) {
            return redirect()->route('tracking.chat', $booking->id);
        }

        $split = Transaksi::calculateSplit((float) $booking->total_biaya);
        $midtransServerKey = (string) config('services.midtrans.server_key');
        $midtransClientKey = (string) config('services.midtrans.client_key');
        $midtransIsProduction = (bool) config('services.midtrans.is_production');
        $midtransEnabled = $midtransServerKey !== '';
        $midtransSnapJsUrl = $midtransIsProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
        $midtransClientKeyValid = $midtransClientKey !== '' && (
            $midtransIsProduction
                ? !str_starts_with($midtransClientKey, 'SB-')
                : str_starts_with($midtransClientKey, 'SB-')
        );
        $midtransExpiryHours = (int) config('services.midtrans.expiry_hours', 2);

        return view('pages.customer.payment', compact(
            'booking',
            'split',
            'midtransEnabled',
            'midtransClientKey',
            'midtransClientKeyValid',
            'midtransSnapJsUrl',
            'midtransIsProduction',
            'midtransExpiryHours'
        ));
    }

    public function createMidtransSnap(int $bookingId, Request $request)
    {
        $booking = Booking::with(['customer.user', 'teknisi.user', 'transaksi'])->findOrFail($bookingId);

        if ($booking->customer_id !== Auth::user()->customer->id) {
            return response()->json(['message' => 'Akses tidak diizinkan.'], 403);
        }

        if ($booking->status_order !== 'pending_payment' && $booking->transaksi?->isPaid()) {
            return response()->json([
                'already_paid' => true,
                'redirect_url' => route('tracking.chat', $booking->id),
            ]);
        }

        $serverKey = (string) config('services.midtrans.server_key');
        if ($serverKey === '') {
            return response()->json(['message' => 'Midtrans Server Key belum dikonfigurasi.'], 500);
        }

        $isProduction = (bool) config('services.midtrans.is_production');
        $expiryHours = max(2, (int) config('services.midtrans.expiry_hours', 2));

        // Reuse existing active GoPay/QRIS Core API token if not expired & not forced to regenerate
        $forceNew = (bool) $request->boolean('force_new', false);
        $existing = $booking->transaksi;
        if (
            !$forceNew
            && $existing
            && $existing->status_pembayaran === 'unpaid'
            && is_string($existing->payment_gateway_ref)
            && $existing->updated_at
            && $existing->updated_at->gt(now()->subHours($expiryHours)->addMinutes(5))
        ) {
            if (str_starts_with($existing->payment_gateway_ref, 'DEEPLINK:')) {
                $deeplink = substr($existing->payment_gateway_ref, 9);
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=6&data=' . rawurlencode($deeplink);

                return response()->json([
                    'mode' => 'core_qris',
                    'qr_url' => $qrUrl,
                    'deeplink_url' => $deeplink,
                    'order_id' => $existing->kode_transaksi,
                    'expiry_hours' => $expiryHours,
                ]);
            }

            if (str_starts_with($existing->payment_gateway_ref, 'QRIMG:')) {
                $qrUrl = substr($existing->payment_gateway_ref, 6);

                return response()->json([
                    'mode' => 'core_qris',
                    'qr_url' => $qrUrl,
                    'order_id' => $existing->kode_transaksi,
                    'expiry_hours' => $expiryHours,
                ]);
            }
        }

        $grossAmount = (int) round((float) $booking->total_biaya);
        $biayaJarak = (int) round((float) $booking->biaya_jarak);
        $biayaLayanan = max(0, $grossAmount - $biayaJarak);
        $split = Transaksi::calculateSplit((float) $grossAmount);

        $orderId = 'FH-' . $booking->id . '-' . time();

        $items = [
            [
                'id' => 'SRV-' . $booking->id,
                'price' => $biayaLayanan,
                'quantity' => 1,
                'name' => Str::limit('Jasa Perbaikan - ' . ($booking->teknisi->nama_lengkap ?? 'Teknisi FixHome'), 50, ''),
            ],
        ];
        if ($biayaJarak > 0) {
            $items[] = [
                'id' => 'DIST-' . $booking->id,
                'price' => $biayaJarak,
                'quantity' => 1,
                'name' => 'Biaya Jarak Operasional (>= 10 km)',
            ];
        }

        $user = Auth::user();
        $customerDetails = [
            'first_name' => $booking->customer->nama_lengkap ?? $user->name,
            'email' => $user->email,
            'phone' => $user->no_telepon ?? '081234567890',
        ];

        // 1. Try Midtrans Core API GoPay/QRIS first:
        //    - In Sandbox: encode Midtrans `deeplink-redirect` as QR so scanning with phone camera opens Midtrans Simulator directly!
        //    - In Production: use Midtrans `generate-qr-code` directly.
        $coreApiUrl = $isProduction
            ? 'https://api.midtrans.com/v2/charge'
            : 'https://api.sandbox.midtrans.com/v2/charge';

        $coreResponse = Http::withBasicAuth($serverKey, '')
            ->acceptJson()
            ->timeout(20)
            ->post($coreApiUrl, [
                'payment_type' => 'gopay',
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'item_details' => $items,
                'customer_details' => $customerDetails,
                'custom_expiry' => [
                    'expiry_duration' => $expiryHours * 60,
                    'unit' => 'minute',
                ],
            ]);

        if ($coreResponse->successful()) {
            $coreData = $coreResponse->json();
            $qrImageUrl = '';
            $deeplinkUrl = '';
            foreach ((array) ($coreData['actions'] ?? []) as $action) {
                $name = (string) ($action['name'] ?? '');
                $url = (string) ($action['url'] ?? '');
                if ($name === 'generate-qr-code' && $url !== '') {
                    $qrImageUrl = $url;
                }
                if ($name === 'deeplink-redirect' && $url !== '') {
                    $deeplinkUrl = $url;
                }
            }

            $useDeeplinkQr = !$isProduction && $deeplinkUrl !== '';
            $finalQrUrl = $useDeeplinkQr
                ? 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=6&data=' . rawurlencode($deeplinkUrl)
                : $qrImageUrl;
            $storedRef = $useDeeplinkQr
                ? 'DEEPLINK:' . Str::limit($deeplinkUrl, 240, '')
                : 'QRIMG:' . Str::limit($qrImageUrl, 240, '');

            if ($finalQrUrl !== '') {
                Transaksi::updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'kode_transaksi' => $orderId,
                        'gross_amount' => $grossAmount,
                        'komisi_admin' => $split['komisi_admin'],
                        'dana_teknisi' => $split['dana_teknisi'],
                        'biaya_jarak' => $biayaJarak,
                        'status_pembayaran' => 'unpaid',
                        'payment_method' => 'Midtrans GoPay QRIS',
                        'payment_gateway_ref' => $storedRef,
                        'paid_at' => null,
                    ]
                );

                return response()->json([
                    'mode' => 'core_qris',
                    'qr_url' => $finalQrUrl,
                    'deeplink_url' => $deeplinkUrl,
                    'order_id' => $orderId,
                    'expiry_hours' => $expiryHours,
                ]);
            }
        }

        // 2. Fallback to Midtrans Snap QRIS if Core API permission is not yet enabled on the Server Key
        $snapApiUrl = $isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $items,
            'customer_details' => $customerDetails,
            'enabled_payments' => ['other_qris'],
            'expiry' => [
                'unit' => 'hours',
                'duration' => $expiryHours,
            ],
            'callbacks' => [
                'finish' => route('booking.midtrans-status', $booking->id),
            ],
        ];

        $response = Http::withBasicAuth($serverKey, '')
            ->acceptJson()
            ->timeout(20)
            ->post($snapApiUrl, $payload);

        if (!$response->successful()) {
            Log::error('Midtrans Snap creation failed', [
                'booking_id' => $booking->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $errorMessages = $response->json('error_messages');
            $statusMessage = $response->json('status_message') ?? $response->json('message');
            if (is_array($errorMessages) && count($errorMessages) > 0) {
                $msg = implode(', ', $errorMessages);
            } elseif (is_string($statusMessage) && $statusMessage !== '') {
                $msg = 'Midtrans (' . $response->status() . '): ' . $statusMessage;
            } else {
                $msg = 'Gagal membuat transaksi Midtrans (HTTP ' . $response->status() . ').';
            }

            return response()->json(['message' => $msg], 502);
        }

        $data = $response->json();
        $token = (string) ($data['token'] ?? '');
        $redirectUrl = (string) ($data['redirect_url'] ?? '');

        Transaksi::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'kode_transaksi' => $orderId,
                'gross_amount' => $grossAmount,
                'komisi_admin' => $split['komisi_admin'],
                'dana_teknisi' => $split['dana_teknisi'],
                'biaya_jarak' => $biayaJarak,
                'status_pembayaran' => 'unpaid',
                'payment_method' => 'Midtrans QRIS',
                'payment_gateway_ref' => 'SNAP:' . $token,
                'paid_at' => null,
            ]
        );

        return response()->json([
            'mode' => 'snap',
            'token' => $token,
            'redirect_url' => $redirectUrl,
            'order_id' => $orderId,
            'expiry_hours' => $expiryHours,
        ]);
    }

    public function checkMidtransStatus(int $bookingId, Request $request)
    {
        try {
            $booking = Booking::with(['customer.user', 'teknisi', 'transaksi'])->findOrFail($bookingId);

            if ($booking->customer_id !== Auth::user()->customer?->id) {
                abort(403, 'Akses tidak diizinkan.');
            }

            $transaksi = $booking->transaksi;
            if (!$transaksi) {
                if ($request->wantsJson()) {
                    return response()->json(['paid' => false, 'status' => 'no_transaction']);
                }

                return redirect()->route('booking.payment', $booking->id)
                    ->with('error', 'Belum ada tagihan Midtrans untuk pesanan ini. Klik Muat Ulang QRIS terlebih dahulu.');
            }

            if ($transaksi->isPaid()) {
                if ($request->wantsJson()) {
                    return response()->json(['paid' => true, 'redirect_url' => route('tracking.chat', $booking->id)]);
                }

                return redirect()->route('tracking.chat', $booking->id)
                    ->with('success', 'Pembayaran sudah terverifikasi!');
            }

            $serverKey = (string) config('services.midtrans.server_key');
            if ($serverKey === '') {
                if ($request->wantsJson()) {
                    return response()->json(['paid' => false, 'status' => 'unconfigured']);
                }

                return redirect()->route('booking.payment', $booking->id)
                    ->with('error', 'Midtrans Server Key belum dikonfigurasi.');
            }

            $isProduction = (bool) config('services.midtrans.is_production');
            $statusUrl = ($isProduction ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com')
                . '/v2/' . urlencode($transaksi->kode_transaksi) . '/status';

            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->timeout(15)
                ->get($statusUrl);

            if (!$response->successful()) {
                if ($request->wantsJson()) {
                    return response()->json(['paid' => false, 'status' => 'http_' . $response->status()]);
                }

                return redirect()->route('booking.payment', $booking->id)
                    ->with('error', 'Status pembayaran belum tersedia di Midtrans (HTTP ' . $response->status() . '). Selesaikan pembayaran lalu coba cek kembali.');
            }

            $statusData = $response->json() ?? [];
            $trxStatus = (string) ($statusData['transaction_status'] ?? '');
            $fraudStatus = (string) ($statusData['fraud_status'] ?? 'accept');
            $paymentType = (string) ($statusData['payment_type'] ?? 'gopay');
            $transactionId = Str::limit((string) ($statusData['transaction_id'] ?? $transaksi->kode_transaksi), 250, '');

            if ($trxStatus === 'settlement' || ($trxStatus === 'capture' && $fraudStatus === 'accept')) {
                $this->markBookingAsPaid($booking, $transaksi, $this->formatMidtransPaymentMethod($paymentType), $transactionId);

                if ($request->wantsJson()) {
                    return response()->json(['paid' => true, 'redirect_url' => route('tracking.chat', $booking->id)]);
                }

                return redirect()->route('tracking.chat', $booking->id)
                    ->with('success', 'Pembayaran Midtrans berhasil diverifikasi! Menunggu teknisi berangkat ke lokasi Anda.');
            }

            if ($request->wantsJson()) {
                return response()->json(['paid' => false, 'status' => $trxStatus ?: 'pending']);
            }

            if (in_array($trxStatus, ['expire', 'cancel', 'deny'], true)) {
                $transaksi->update(['status_pembayaran' => 'failed']);

                return redirect()->route('booking.payment', $booking->id)
                    ->with('error', 'Tagihan sebelumnya sudah kedaluwarsa atau dibatalkan. Silakan klik Muat Ulang QRIS untuk membuat tagihan baru.');
            }

            return redirect()->route('booking.payment', $booking->id)
                ->with('info', 'Pembayaran masih berstatus menunggu (pending). Selesaikan pembayaran dalam batas waktu 2 jam lalu klik Cek Status Pembayaran.');
        } catch (\Throwable $e) {
            Log::error('Midtrans checkStatus exception', [
                'booking_id' => $bookingId,
                'error' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
            ]);

            if ($request->wantsJson()) {
                return response()->json(['paid' => false, 'error' => $e->getMessage()], 500);
            }

            return redirect()->route('booking.payment', $bookingId)
                ->with('error', 'Gagal memverifikasi status pembayaran: ' . $e->getMessage());
        }
    }

    public function handleMidtransNotification(Request $request)
    {
        $serverKey = (string) config('services.midtrans.server_key');
        if ($serverKey === '') {
            return response()->json(['message' => 'Midtrans not configured'], 500);
        }

        $orderId = (string) $request->input('order_id', '');
        $statusCode = (string) $request->input('status_code', '');
        $grossAmount = (string) $request->input('gross_amount', '');
        $signatureKey = (string) $request->input('signature_key', '');

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::warning('Midtrans webhook invalid signature', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaksi = Transaksi::with(['booking.customer'])->where('kode_transaksi', $orderId)->first();
        if (!$transaksi || !$transaksi->booking) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $trxStatus = (string) $request->input('transaction_status', '');
        $fraudStatus = (string) $request->input('fraud_status', 'accept');
        $paymentType = (string) $request->input('payment_type', 'Midtrans Snap');
        $transactionId = (string) $request->input('transaction_id', $orderId);

        if ($trxStatus === 'settlement' || ($trxStatus === 'capture' && $fraudStatus === 'accept')) {
            $this->markBookingAsPaid($transaksi->booking, $transaksi, $this->formatMidtransPaymentMethod($paymentType), $transactionId);
        } elseif (in_array($trxStatus, ['expire', 'cancel', 'deny'], true)) {
            if (!$transaksi->isPaid()) {
                $transaksi->update(['status_pembayaran' => 'failed']);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function processPayment(int $bookingId, Request $request)
    {
        $booking = Booking::with(['customer', 'teknisi'])->findOrFail($bookingId);

        if ($booking->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string'],
        ]);

        $split = Transaksi::calculateSplit((float) $booking->total_biaya);
        $kodeTransaksi = 'TRX-' . strtoupper(Str::random(10));

        $transaksi = Transaksi::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'kode_transaksi' => $kodeTransaksi,
                'gross_amount' => $booking->total_biaya,
                'komisi_admin' => $split['komisi_admin'],
                'dana_teknisi' => $split['dana_teknisi'],
                'biaya_jarak' => $booking->biaya_jarak,
                'status_pembayaran' => 'unpaid',
                'payment_method' => $validated['payment_method'],
                'payment_gateway_ref' => 'PG-SIM-' . time(),
            ]
        );

        $this->markBookingAsPaid($booking, $transaksi, $validated['payment_method'], 'PG-SIM-' . time());

        return redirect()->route('tracking.chat', $booking->id)
            ->with('success', 'Pembayaran berhasil diverifikasi! Menunggu teknisi berangkat ke lokasi Anda.');
    }

    private function markBookingAsPaid(Booking $booking, Transaksi $transaksi, string $paymentMethod, string $gatewayRef): void
    {
        DB::transaction(function () use ($booking, $transaksi, $paymentMethod, $gatewayRef) {
            $freshBooking = Booking::with('customer')->find($booking->id);
            $freshTransaksi = Transaksi::find($transaksi->id);

            if (!$freshBooking || !$freshTransaksi) {
                return;
            }

            if ($freshTransaksi->isPaid() && $freshBooking->status_order !== 'pending_payment') {
                return;
            }

            $freshTransaksi->update([
                'status_pembayaran' => 'paid',
                'payment_method' => Str::limit($paymentMethod, 100, ''),
                'payment_gateway_ref' => Str::limit($gatewayRef, 250, ''),
                'paid_at' => now(),
            ]);

            if ($freshBooking->status_order === 'pending_payment') {
                $freshBooking->update([
                    'status_order' => 'paid',
                ]);
            }

            $senderId = $freshBooking->customer?->user_id ?? Auth::id();
            if ($senderId && !ChatMessage::where('booking_id', $freshBooking->id)->exists()) {
                ChatMessage::create([
                    'booking_id' => $freshBooking->id,
                    'sender_id' => $senderId,
                    'pesan' => 'Halo pak, pembayaran sebesar Rp ' . number_format((float) $freshBooking->total_biaya, 0, ',', '.') . ' sudah lunas. Mohon konfirmasi saat berangkat ya!',
                ]);
            }

            if (!PelacakanLokasi::where('booking_id', $freshBooking->id)->exists()) {
                PelacakanLokasi::create([
                    'booking_id' => $freshBooking->id,
                    'current_lat' => -6.2190,
                    'current_lng' => 106.8230,
                    'is_active' => true,
                ]);
            }
        });
    }

    private function formatMidtransPaymentMethod(string $paymentType): string
    {
        return match ($paymentType) {
            'bank_transfer' => 'Midtrans Virtual Account',
            'echannel' => 'Midtrans Mandiri Bill',
            'qris' => 'Midtrans QRIS',
            'gopay' => 'Midtrans GoPay',
            'shopeepay' => 'Midtrans ShopeePay',
            'credit_card' => 'Midtrans Kartu Kredit',
            'cstore' => 'Midtrans Minimarket',
            default => 'Midtrans (' . $paymentType . ')',
        };
    }
}
