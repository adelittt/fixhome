<?php

namespace Database\Seeders;

use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeknisiCatalogSeeder extends Seeder
{
    public static function techniciansData(): array
    {
        return [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.teknisi@fixhome.com',
                'phone' => '085712345671',
                'foto' => 'images/technicians/teknisi-1.jpg',
                'keahlian' => 'AC & Pendingin',
                'tarif' => 75000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.2190,
                'lng' => 106.8230,
                'no_ktp' => '3171010101900001',
                'sertifikasi' => 'Sertifikasi BNSP Teknisi Pendingin & Tata Udara (Level 3)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.teknisi@fixhome.com',
                'phone' => '085712345672',
                'foto' => 'images/technicians/teknisi-2.jpg',
                'keahlian' => 'Instalasi Listrik',
                'tarif' => 85000,
                'status' => 'ready',
                'rating' => 4.8,
                'lat' => -6.2120,
                'lng' => 106.8180,
                'no_ktp' => '3171010101900002',
                'sertifikasi' => 'Sertifikat Kompetensi Ketenagalistrikan (SKT/SKK)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.teknisi@fixhome.com',
                'phone' => '085712345673',
                'foto' => 'images/technicians/teknisi-3.jpg',
                'keahlian' => 'Pipa & Saluran Air',
                'tarif' => 70000,
                'status' => 'ready',
                'rating' => 4.8,
                'lat' => -6.2230,
                'lng' => 106.8250,
                'no_ktp' => '3171010101900003',
                'sertifikasi' => 'Sertifikasi Plumbing & Perpipaan Gedung Konstruksi',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Hendra Setiawan',
                'email' => 'hendra.teknisi@fixhome.com',
                'phone' => '085712345674',
                'foto' => 'images/technicians/teknisi-4.jpg',
                'keahlian' => 'Atap & Plafon Bocor',
                'tarif' => 90000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.2080,
                'lng' => 106.8150,
                'no_ktp' => '3171010101900004',
                'sertifikasi' => 'Sertifikasi Tukang Pasang Plafon & Atap Baja Ringan (LPJK)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Rian Kurniawan',
                'email' => 'rian.teknisi@fixhome.com',
                'phone' => '085712345675',
                'foto' => 'images/technicians/teknisi-5.jpg',
                'keahlian' => 'Pengecatan & Tembok',
                'tarif' => 65000,
                'status' => 'ready',
                'rating' => 4.7,
                'lat' => -6.2500,
                'lng' => 106.8300,
                'no_ktp' => '3171010101900005',
                'sertifikasi' => 'Sertifikasi Ahli Cat Bangunan & Waterproofing',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Yusuf Maulana',
                'email' => 'yusuf.teknisi@fixhome.com',
                'phone' => '085712345676',
                'foto' => 'images/technicians/teknisi-6.jpg',
                'keahlian' => 'Kunci & Pintu Rusak',
                'tarif' => 60000,
                'status' => 'ready',
                'rating' => 4.7,
                'lat' => -6.2350,
                'lng' => 106.8400,
                'no_ktp' => '3171010101900006',
                'sertifikasi' => 'Sertifikat Spesialis Mekanisme Pintu & Kunci Digital',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Dedi Suryadi',
                'email' => 'dedi.teknisi@fixhome.com',
                'phone' => '085712345677',
                'foto' => 'images/technicians/teknisi-7.jpg',
                'keahlian' => 'Kebersihan & Deep Cleaning',
                'tarif' => 55000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.2050,
                'lng' => 106.8280,
                'no_ktp' => '3171010101900007',
                'sertifikasi' => 'Sertifikat Hygiene & Home Deep Cleaning Specialist',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.teknisi@fixhome.com',
                'phone' => '085712345678',
                'foto' => 'images/technicians/teknisi-8.jpg',
                'keahlian' => 'Pompa Air & Toren',
                'tarif' => 80000,
                'status' => 'ready',
                'rating' => 4.8,
                'lat' => -6.2280,
                'lng' => 106.8050,
                'no_ktp' => '3171010101900008',
                'sertifikasi' => 'Sertifikasi Instalasi Pompa Booster, Jet Pump & Toren',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Agus Salim',
                'email' => 'agus.teknisi@fixhome.com',
                'phone' => '085712345679',
                'foto' => 'images/technicians/teknisi-9.jpg',
                'keahlian' => 'Renovasi & Keramik',
                'tarif' => 110000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.1980,
                'lng' => 106.8120,
                'no_ktp' => '3171010101900009',
                'sertifikasi' => 'Sertifikasi Tukang Pasang Keramik, Granit & Renovasi (LPJK)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti.teknisi@fixhome.com',
                'phone' => '085712345680',
                'foto' => 'images/technicians/teknisi-10.jpg',
                'keahlian' => 'Furniture & Pertukangan Kayu',
                'tarif' => 95000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.2310,
                'lng' => 106.8190,
                'no_ktp' => '3171010101900010',
                'sertifikasi' => 'Sertifikat Kompetensi Perakitan & Restorasi Furniture Kayu',
                'status_verifikasi' => 'verified',
            ],
        ];
    }

    public function run(): void
    {
        Model::withoutEvents(function (): void {
            Role::firstOrCreate(['name' => 'teknisi', 'guard_name' => 'web']);
            $hashedPassword = Hash::make('password123');

            foreach (self::techniciansData() as $data) {
                $user = User::firstOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['name'],
                        'password' => $hashedPassword,
                        'role' => 'teknisi',
                        'no_telepon' => $data['phone'],
                    ]
                );

                if (!$user->hasRole('teknisi')) {
                    $user->assignRole('teknisi');
                }

                Teknisi::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama_lengkap' => $data['name'],
                        'foto' => $data['foto'],
                        'keahlian' => $data['keahlian'],
                        'tarif_dasar' => $data['tarif'],
                        'status_kesiapan' => $data['status'],
                        'off_start_date' => null,
                        'rating' => $data['rating'],
                        'latitude' => $data['lat'],
                        'longitude' => $data['lng'],
                        'no_ktp' => $data['no_ktp'],
                        'sertifikasi' => $data['sertifikasi'],
                        'status_verifikasi' => $data['status_verifikasi'],
                    ]
                );
            }
        });
    }
}
