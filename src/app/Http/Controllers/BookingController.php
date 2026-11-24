<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\PelacakanLokasi;
use App\Models\Teknisi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $booking = Booking::with(['customer', 'teknisi.user'])->findOrFail($bookingId);

        // Validasi kepemilikan booking
        if ($booking->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $split = Transaksi::calculateSplit((float) $booking->total_biaya);

        return view('pages.customer.payment', compact('booking', 'split'));
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

        // Buat record Transaksi dengan komisi 5% dan dana teknisi 95% (BR-04, BR-12, KF-10, KF-11)
        $transaksi = Transaksi::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'kode_transaksi' => $kodeTransaksi,
                'gross_amount' => $booking->total_biaya,
                'komisi_admin' => $split['komisi_admin'],
                'dana_teknisi' => $split['dana_teknisi'],
                'biaya_jarak' => $booking->biaya_jarak,
                'status_pembayaran' => 'paid',
                'payment_method' => $validated['payment_method'],
                'payment_gateway_ref' => 'PG-SIM-' . time(),
                'paid_at' => now(),
            ]
        );

        // Update status order booking menjadi paid (menunggu teknisi klik berangkat OTW)
        $booking->update([
            'status_order' => 'paid',
        ]);

        // Kirim pesan otomatis dari customer bahwa pembayaran sudah lunas
        ChatMessage::create([
            'booking_id' => $booking->id,
            'sender_id' => Auth::id(),
            'pesan' => 'Halo pak, pembayaran sebesar Rp ' . number_format($booking->total_biaya, 0, ',', '.') . ' sudah lunas. Mohon konfirmasi saat berangkat ya!',
        ]);

        // Inisialisasi titik koordinat awal pelacakan GPS teknisi (BR-05, BR-06)
        PelacakanLokasi::create([
            'booking_id' => $booking->id,
            'current_lat' => -6.2190,
            'current_lng' => 106.8230,
            'is_active' => true,
        ]);

        return redirect()->route('tracking.chat', $booking->id)
            ->with('success', 'Pembayaran berhasil diverifikasi! Menunggu teknisi berangkat ke lokasi Anda.');
    }
}
