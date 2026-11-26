<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TeknisiResource\Pages;
use App\Models\Teknisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeknisiResource extends Resource
{
    protected static ?string $model = Teknisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Mitra Teknisi';

    protected static ?string $pluralModelLabel = 'Mitra Teknisi';

    protected static ?string $navigationGroup = 'Operasional';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $pending = static::getModel()::where('status_verifikasi', 'pending')->count();
        if ($pending > 0) {
            return $pending . ' baru';
        }

        return (string) static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pending = static::getModel()::where('status_verifikasi', 'pending')->count();

        return $pending > 0 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun & Identitas')
                    ->description('Data identitas dan verifikasi dokumen mitra teknisi (Bab 2.2 & KF-12)')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->label('Akun Pengguna'),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap Teknisi'),
                        Forms\Components\TextInput::make('no_ktp')
                            ->maxLength(30)
                            ->label('Nomor Induk Kependudukan (KTP)'),
                        Forms\Components\Select::make('status_verifikasi')
                            ->options([
                                'pending' => 'Pending (Menunggu Verifikasi)',
                                'verified' => 'Terverifikasi (Verified)',
                                'rejected' => 'Ditolak (Rejected)',
                            ])
                            ->required()
                            ->default('verified')
                            ->label('Status Verifikasi KTP / Keahlian'),
                    ])->columns(2),

                Forms\Components\Section::make('Keahlian & Layanan')
                    ->schema([
                        Forms\Components\Select::make('keahlian')
                            ->options([
                                'AC & Pendingin' => 'AC & Pendingin',
                                'Instalasi Listrik' => 'Instalasi Listrik',
                                'Pipa & Saluran Air' => 'Pipa & Saluran Air',
                                'Atap & Plafon Bocor' => 'Atap & Plafon Bocor',
                                'Pengecatan & Tembok' => 'Pengecatan & Tembok',
                                'Kunci & Pintu Rusak' => 'Kunci & Pintu Rusak',
                            ])
                            ->required()
                            ->label('Kategori Keahlian Utama'),
                        Forms\Components\TextInput::make('sertifikasi')
                            ->maxLength(255)
                            ->label('Dokumen Sertifikasi Keahlian'),
                        Forms\Components\TextInput::make('tarif_dasar')
                            ->required()
                            ->numeric()
                            ->minValue(10000)
                            ->rule('min:10000')
                            ->prefix('Rp')
                            ->helperText('Minimal Rp 10.000 (tidak boleh Rp 0).')
                            ->label('Tarif Dasar Kunjungan'),
                        Forms\Components\Select::make('status_kesiapan')
                            ->options([
                                'ready' => 'Ready (Siap Menerima Order)',
                                'off' => 'Off / Istirahat',
                            ])
                            ->required()
                            ->label('Status Kesiapan Kerja'),
                    ])->columns(2),

                Forms\Components\Section::make('Koordinat Lokasi (Untuk Perhitungan Jarak)')
                    ->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->label('Latitude'),
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->label('Longitude'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Nama Teknisi'),
                Tables\Columns\TextColumn::make('keahlian')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->label('Keahlian'),
                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->label('Verifikasi (KF-12)'),
                Tables\Columns\TextColumn::make('no_ktp')
                    ->searchable()
                    ->label('No. KTP'),
                Tables\Columns\TextColumn::make('tarif_dasar')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->label('Tarif Dasar'),
                Tables\Columns\TextColumn::make('status_kesiapan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ready' => 'success',
                        'off' => 'gray',
                        default => 'info',
                    })
                    ->label('Kesiapan'),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable()
                    ->label('Rating ★'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('status_kesiapan')
                    ->options([
                        'ready' => 'Ready',
                        'off' => 'Off',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('verifikasi')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Verifikasi Mitra Teknisi')
                    ->modalDescription('Teknisi yang disetujui akan langsung aktif (READY) dan muncul di pencarian customer.')
                    ->visible(fn (Teknisi $record): bool => $record->status_verifikasi !== 'verified')
                    ->action(function (Teknisi $record): void {
                        $record->update([
                            'status_verifikasi' => 'verified',
                            'status_kesiapan' => 'ready',
                        ]);

                        Notification::make()
                            ->title('Mitra teknisi disetujui')
                            ->body("{$record->nama_lengkap} sekarang terverifikasi dan siap menerima pesanan.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pendaftaran Mitra Teknisi')
                    ->modalDescription('Teknisi yang ditolak tidak akan tampil di pencarian customer dan tidak dapat menerima order.')
                    ->visible(fn (Teknisi $record): bool => $record->status_verifikasi === 'pending')
                    ->action(function (Teknisi $record): void {
                        $record->update([
                            'status_verifikasi' => 'rejected',
                            'status_kesiapan' => 'off',
                        ]);

                        Notification::make()
                            ->title('Pendaftaran teknisi ditolak')
                            ->body("Pengajuan {$record->nama_lengkap} telah ditolak.")
                            ->danger()
                            ->send();
                    }),
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
            'index' => Pages\ListTeknisis::route('/'),
            'create' => Pages\CreateTeknisi::route('/create'),
            'edit' => Pages\EditTeknisi::route('/{record}/edit'),
        ];
    }
}
