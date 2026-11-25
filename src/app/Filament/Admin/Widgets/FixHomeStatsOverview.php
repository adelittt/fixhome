<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Teknisi;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FixHomeStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '30s';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $paidTransactions = Transaksi::where('status_pembayaran', 'paid');
        $totalOmzet = (float) (clone $paidTransactions)->sum('gross_amount');
        $totalKomisi = (float) (clone $paidTransactions)->sum('komisi_admin');
        $totalDanaTeknisi = (float) (clone $paidTransactions)->sum('dana_teknisi');
        $paidCount = (clone $paidTransactions)->count();

        $totalBookings = Booking::count();
        $completedBookings = Booking::where('status_order', 'completed')->count();
        $activeBookings = Booking::whereIn('status_order', ['paid', 'otw', 'working'])->count();
        $pendingBookings = Booking::where('status_order', 'pending_payment')->count();

        $totalTeknisi = Teknisi::count();
        $readyTeknisi = Teknisi::ready()->count();
        $pendingTeknisi = Teknisi::where('status_verifikasi', 'pending')->count();
        $avgRating = (float) (Teknisi::where('rating', '>', 0)->avg('rating') ?? 0);
        $totalCustomers = Customer::count();

        $teknisiDesc = $pendingTeknisi > 0
            ? "{$pendingTeknisi} menunggu konfirmasi admin · {$totalCustomers} customer"
            : 'Rating ★ ' . number_format($avgRating, 1) . " · {$totalCustomers} customer";

        return [
            Stat::make('Total Omzet (Lunas)', 'Rp ' . number_format($totalOmzet, 0, ',', '.'))
                ->description('Komisi Platform 5%: Rp ' . number_format($totalKomisi, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Hak Mitra Teknisi (95%)', 'Rp ' . number_format($totalDanaTeknisi, 0, ',', '.'))
                ->description($paidCount . ' transaksi terverifikasi lunas')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Monitoring Pesanan', (string) $totalBookings)
                ->description("{$completedBookings} selesai · {$activeBookings} aktif · {$pendingBookings} menunggu bayar")
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color($pendingBookings > 0 ? 'warning' : 'info'),

            Stat::make('Mitra Teknisi Siap', "{$readyTeknisi} / {$totalTeknisi}")
                ->description($teknisiDesc)
                ->descriptionIcon($pendingTeknisi > 0 ? 'heroicon-m-clock' : 'heroicon-m-wrench-screwdriver')
                ->color($pendingTeknisi > 0 ? 'warning' : 'info'),
        ];
    }
}
