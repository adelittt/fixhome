<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\BookingResource;
use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()
                    ->with(['customer', 'teknisi', 'transaksi'])
                    ->latest()
                    ->limit(8)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Kode')
                    ->formatStateUsing(fn ($state) => '#BK-' . str_pad((string) $state, 5, '0', STR_PAD_LEFT))
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('customer.nama_lengkap')
                    ->label('Customer')
                    ->default('-'),

                Tables\Columns\TextColumn::make('teknisi.nama_lengkap')
                    ->label('Mitra Teknisi')
                    ->description(fn (Booking $record) => $record->teknisi?->keahlian ?? '-')
                    ->default('-'),

                Tables\Columns\TextColumn::make('jadwal')
                    ->label('Jadwal Kunjungan')
                    ->dateTime('d M Y, H:i'),

                Tables\Columns\TextColumn::make('total_biaya')
                    ->label('Total Biaya')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('status_order')
                    ->label('Status Order')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_payment' => 'Menunggu Bayar',
                        'paid' => 'Lunas (Siap OTW)',
                        'otw' => 'OTW',
                        'working' => 'Dikerjakan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'warning',
                        'paid', 'otw', 'working' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('transaksi.status_pembayaran')
                    ->label('Pembayaran')
                    ->badge()
                    ->default('unpaid')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'refunded' => 'Refund',
                        default => 'Belum Bayar',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'paid' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Detail')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn (Booking $record): string => BookingResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
