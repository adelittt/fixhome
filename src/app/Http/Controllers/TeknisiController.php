<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $teknisi = $user->teknisi;

        if (!$teknisi) {
            abort(403, 'Profil teknisi tidak ditemukan.');
        }

        // Hitung total saldo akumulasi 95% dari transaksi yang lunas (BR-04)
        $totalPendapatan = Transaksi::whereHas('booking', function ($q) use ($teknisi) {
            $q->where('teknisi_id', $teknisi->id);
        })->where('status_pembayaran', 'paid')->sum('dana_teknisi');

        // Pesanan aktif dan pesanan terbaru
        $activeOrders = Booking::where('teknisi_id', $teknisi->id)
            ->whereIn('status_order', ['paid', 'otw', 'working'])
            ->with(['customer.user', 'transaksi'])
            ->latest()
            ->get();

        $recentOrders = Booking::where('teknisi_id', $teknisi->id)
            ->with(['customer.user', 'transaksi', 'ulasan'])
            ->latest()
            ->take(10)
            ->get();

        $inactiveDays = $teknisi->getInactiveDays();

        return view('pages.teknisi.dashboard', compact('teknisi', 'totalPendapatan', 'activeOrders', 'recentOrders', 'inactiveDays'));
    }

    public function toggleStatus(Request $request)
    {
        $teknisi = Auth::user()->teknisi;

        if (!$teknisi->isVerified()) {
            $msg = $teknisi->isRejected()
                ? 'Pendaftaran Anda ditolak oleh Admin. Hubungi Admin FixHome untuk informasi lebih lanjut.'
                : 'Akun Anda masih menunggu konfirmasi verifikasi dari Admin FixHome sebelum dapat mengaktifkan status READY.';

            return back()->withErrors(['verification' => $msg]);
        }

        $newStatus = $teknisi->isReady() ? 'off' : 'ready';

        $teknisi->update([
            'status_kesiapan' => $newStatus,
            'off_start_date' => $newStatus === 'off' ? now() : null,
            'last_reminder_sent_day' => null,
        ]);

        $statusText = $newStatus === 'ready' ? 'READY (Siap Menerima Order)' : 'NOT READY / OFF (Istirahat)';

        return back()->with('success', "Status kerja berhasil diubah menjadi: {$statusText}");
    }

    public function updateJobStatus(int $bookingId, Request $request)
    {
        $teknisi = Auth::user()->teknisi;
        $booking = Booking::where('teknisi_id', $teknisi->id)->findOrFail($bookingId);

        $validated = $request->validate([
            'status_order' => ['required', 'in:paid,otw,working,completed,cancelled'],
        ]);

        $booking->update([
            'status_order' => $validated['status_order'],
        ]);

        $statusMessages = [
            'otw' => 'Status diubah: Teknisi sedang meluncur ke lokasi customer.',
            'working' => 'Status diubah: Teknisi mulai mengerjakan perbaikan.',
            'completed' => 'Status diubah: Pekerjaan selesai! Menunggu konfirmasi customer.',
            'cancelled' => 'Status diubah: Pesanan dibatalkan.',
        ];

        // Buat pesan otomatis di ruang chat saat status berubah
        if ($validated['status_order'] === 'otw') {
            ChatMessage::create([
                'booking_id' => $booking->id,
                'sender_id' => Auth::id(),
                'pesan' => '🛵 Halo kak, saya sudah berangkat dari bengkel dan sedang dalam perjalanan menuju rumah Anda. Mohon ditunggu ya!',
            ]);
        } elseif ($validated['status_order'] === 'working') {
            ChatMessage::create([
                'booking_id' => $booking->id,
                'sender_id' => Auth::id(),
                'pesan' => '🔧 Saya sudah tiba di lokasi rumah Anda dan mulai melakukan pengecekan & perbaikan.',
            ]);
        } elseif ($validated['status_order'] === 'completed') {
            ChatMessage::create([
                'booking_id' => $booking->id,
                'sender_id' => Auth::id(),
                'pesan' => '✅ Pengerjaan perbaikan telah selesai! Silakan dicek hasilnya dan beri konfirmasi ya kak, terima kasih.',
            ]);
        }

        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'status' => 'success',
                'status_order' => $booking->status_order,
                'message' => $statusMessages[$validated['status_order']] ?? 'Status berhasil diperbarui.',
            ]);
        }

        return back()->with('success', $statusMessages[$validated['status_order']] ?? 'Status berhasil diperbarui.');
    }

    public function wallet()
    {
        $teknisi = Auth::user()->teknisi;

        $transaksis = Transaksi::whereHas('booking', function ($q) use ($teknisi) {
            $q->where('teknisi_id', $teknisi->id);
        })->with('booking.customer')->latest()->paginate(15);

        $totalPendapatan = Transaksi::whereHas('booking', function ($q) use ($teknisi) {
            $q->where('teknisi_id', $teknisi->id);
        })->where('status_pembayaran', 'paid')->sum('dana_teknisi');

        return view('pages.teknisi.wallet', compact('teknisi', 'transaksis', 'totalPendapatan'));
    }
}
