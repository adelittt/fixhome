<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Monitoring Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan / Booking';

    protected static ?string $navigationGroup = 'Operasional';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan & Pelanggan')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'nama_lengkap')
                            ->required()
                            ->label('Nama Customer'),
                        Forms\Components\Select::make('teknisi_id')
                            ->relationship('teknisi', 'nama_lengkap')
                            ->required()
                            ->label('Nama Mitra Teknisi'),
                        Forms\Components\DateTimePicker::make('jadwal')
                            ->required()
                            ->label('Jadwal Kunjungan'),
                        Forms\Components\Select::make('status_order')
                            ->options([
                                'pending_payment' => 'Menunggu Pembayaran',
                                'paid' => 'Sudah Dibayar (Menunggu Teknisi)',
                                'otw' => 'Teknisi Dalam Perjalanan (OTW)',
                                'working' => 'Sedang Dikerjakan (Working)',
                                'completed' => 'Pekerjaan Selesai (Completed)',
                                'cancelled' => 'Dibatalkan (Cancelled)',
                            ])
                            ->required()
                            ->label('Status Pesanan'),
                        Forms\Components\Textarea::make('deskripsi_kerusakan')
                            ->columnSpanFull()
                            ->label('Keluhan Kerusakan'),
                    ])->columns(2),

                Forms\Components\Section::make('Kalkulasi Biaya & Jarak (KF-05, KF-06, KF-07)')
                    ->schema([
                        Forms\Components\TextInput::make('jarak_km')
                            ->numeric()
                            ->suffix('km')
                            ->label('Jarak Tempuh (Haversine)'),
                        Forms\Components\TextInput::make('biaya_jarak')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Biaya Tambahan Jarak'),
                        Forms\Components\TextInput::make('biaya_layanan')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Biaya Layanan Jasa'),
                        Forms\Components\TextInput::make('total_biaya')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Total Biaya Pemesanan'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->formatStateUsing(fn ($state) => '#BK-' . str_pad($state, 5, '0', STR_PAD_LEFT))
                    ->label('Kode Booking')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.nama_lengkap')
                    ->searchable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('teknisi.nama_lengkap')
                    ->searchable()
                    ->label('Teknisi'),
                Tables\Columns\TextColumn::make('jadwal')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Jadwal'),
                Tables\Columns\TextColumn::make('status_order')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'gray',
                        'paid' => 'info',
                        'otw' => 'primary',
                        'working' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->label('Status Order'),
                Tables\Columns\TextColumn::make('jarak_km')
                    ->suffix(' km')
                    ->sortable()
                    ->label('Jarak'),
                Tables\Columns\TextColumn::make('biaya_jarak')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->label('Biaya Jarak'),
                Tables\Columns\TextColumn::make('total_biaya')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold')
                    ->label('Total Biaya'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_order')
                    ->options([
                        'pending_payment' => 'Pending Payment',
                        'paid' => 'Paid',
                        'otw' => 'OTW',
                        'working' => 'Working',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
