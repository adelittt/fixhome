<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransaksiResource\Pages;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Transaksi & Komisi (5%)';

    protected static ?string $pluralModelLabel = 'Transaksi & Komisi';

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rincian Transaksi & Split Komisi')
                    ->description('Skema transparansi 5% komisi platform FixHome dan 95% hak mitra teknisi (Bab 2.2, KF-10, KF-11)')
                    ->schema([
                        Forms\Components\Select::make('booking_id')
                            ->relationship('booking', 'id')
                            ->required()
                            ->label('ID Booking Terkait'),
                        Forms\Components\TextInput::make('kode_transaksi')
                            ->required()
                            ->maxLength(255)
                            ->label('Kode Transaksi'),
                        Forms\Components\TextInput::make('gross_amount')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Total Transaksi (Gross Amount)'),
                        Forms\Components\TextInput::make('komisi_admin')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Komisi Platform (5%)'),
                        Forms\Components\TextInput::make('dana_teknisi')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Hak Mitra Teknisi (95%)'),
                        Forms\Components\TextInput::make('biaya_jarak')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Biaya Tambahan Jarak'),
                        Forms\Components\Select::make('status_pembayaran')
                            ->options([
                                'unpaid' => 'Belum Lunas (Unpaid)',
                                'paid' => 'Lunas (Paid)',
                                'failed' => 'Gagal (Failed)',
                                'refunded' => 'Dikembalikan (Refunded)',
                            ])
                            ->required()
                            ->label('Status Pembayaran'),
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Metode Pembayaran'),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Waktu Pembayaran Diverifikasi'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_transaksi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Kode TRX'),
                Tables\Columns\TextColumn::make('booking.customer.nama_lengkap')
                    ->searchable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('booking.teknisi.nama_lengkap')
                    ->searchable()
                    ->label('Teknisi'),
                Tables\Columns\TextColumn::make('gross_amount')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold')
                    ->label('Total Nilai'),
                Tables\Columns\TextColumn::make('komisi_admin')
                    ->money('IDR', locale: 'id')
                    ->color('info')
                    ->sortable()
                    ->label('Komisi 5% (FixHome)'),
                Tables\Columns\TextColumn::make('dana_teknisi')
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->sortable()
                    ->label('Hak Teknisi (95%)'),
                Tables\Columns\TextColumn::make('biaya_jarak')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->label('Biaya Jarak'),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'info',
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->color('gray')
                    ->label('Metode'),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Waktu Bayar'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->options([
                        'paid' => 'Paid (Lunas)',
                        'unpaid' => 'Unpaid (Belum Bayar)',
                        'failed' => 'Failed',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
