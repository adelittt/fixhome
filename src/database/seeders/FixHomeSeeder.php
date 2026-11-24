<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class FixHomeSeeder extends Seeder
{
    public function run(): void
    {
        Model::withoutEvents(function (): void {
            $this->seedData();
        });
    }

    private function seedData(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $hashedPassword = Hash::make('password123');
        $now = now();

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'teknisi', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Seed seluruh permission Filament Shield dalam 1 batch query agar cepat di cloud Postgres (Neon)
        $resourceEntities = ['activity', 'booking', 'role', 'teknisi', 'transaksi', 'user'];
        $resourceActions = ['view', 'view_any', 'create', 'update', 'delete', 'delete_any'];
        $permissionRows = [
            ['name' => 'widget_LatestAccessLogs', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'widget_OverlookWidget', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
        ];
        foreach ($resourceEntities as $entity) {
            foreach ($resourceActions as $action) {
                $permissionRows[] = [
                    'name' => "{$action}_{$entity}",
                    'guard_name' => 'web',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('permissions')->insertOrIgnore($permissionRows);
        if ($superAdminRole->permissions()->count() < count($permissionRows)) {
            $superAdminRole->syncPermissions(Permission::where('guard_name', 'web')->get());
        }

        // 1. Akun Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@fixhome.com'],
            [
                'name' => 'Administrator FixHome',
                'password' => $hashedPassword,
                'role' => 'admin',
                'no_telepon' => '081100000001',
            ]
        );
        $adminUser->assignRole('super_admin');

        // 2. Akun Customer 1 (Sudah isi alamat)
        $customerUser1 = User::firstOrCreate(
            ['email' => 'customer@fixhome.com'],
            [
                'name' => 'Aditya Pratama',
                'password' => $hashedPassword,
                'role' => 'customer',
                'no_telepon' => '081234567890',
            ]
        );
        $customerUser1->assignRole('customer');

        Customer::firstOrCreate(
            ['user_id' => $customerUser1->id],
            [
                'nama_lengkap' => 'Aditya Pratama',
                'alamat_lengkap' => 'Jl. Sudirman No. 45, Kebayoran Baru, Jakarta Selatan',
                'latitude' => -6.2155,
                'longitude' => 106.8205,
                'is_address_completed' => true,
            ]
        );

        // 3. Akun Customer 2 (Baru mendaftar / belum isi alamat untuk demo BR-01)
        $customerUser2 = User::firstOrCreate(
            ['email' => 'baru@fixhome.com'],
            [
                'name' => 'Rina Lestari',
                'password' => $hashedPassword,
                'role' => 'customer',
                'no_telepon' => '081399887766',
            ]
        );
        $customerUser2->assignRole('customer');

        Customer::firstOrCreate(
            ['user_id' => $customerUser2->id],
            [
                'nama_lengkap' => 'Rina Lestari',
                'alamat_lengkap' => null,
                'latitude' => null,
                'longitude' => null,
                'is_address_completed' => false,
            ]
        );

        // 4. Data Mitra Teknisi (Kategori sesuai Figma & Laporan: AC, Listrik, Pipa, Atap, Cat, Kunci)
        $techniciansData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.teknisi@fixhome.com',
                'phone' => '085712345671',
                'keahlian' => 'AC & Pendingin',
                'tarif' => 75000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.2190,
                'lng' => 106.8230, // ~0.5 km (Jarak < 10 km: Biaya Jarak Rp0)
                'no_ktp' => '3171010101900001',
                'sertifikasi' => 'Sertifikasi BNSP Teknisi Pendingin & Tata Udara (Level 3)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.teknisi@fixhome.com',
                'phone' => '085712345672',
                'keahlian' => 'Instalasi Listrik',
                'tarif' => 85000,
                'status' => 'ready',
                'rating' => 4.8,
                'lat' => -6.2120,
                'lng' => 106.8180, // ~0.6 km (Jarak < 10 km: Biaya Jarak Rp0)
                'no_ktp' => '3171010101900002',
                'sertifikasi' => 'Sertifikat Kompetensi Ketenagalistrikan (SKT/SKK)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.teknisi@fixhome.com',
                'phone' => '085712345673',
                'keahlian' => 'Pipa & Saluran Air',
                'tarif' => 70000,
                'status' => 'ready',
                'rating' => 4.7,
                'lat' => -6.2230,
                'lng' => 106.8250, // ~1.0 km (Jarak < 10 km: Biaya Jarak Rp0)
                'no_ktp' => '3171010101900003',
                'sertifikasi' => 'Sertifikasi Plumbing & Perpipaan Gedung Konstruksi',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Hendra Setiawan',
                'email' => 'hendra.teknisi@fixhome.com',
                'phone' => '085712345674',
                'keahlian' => 'Atap & Plafon Bocor',
                'tarif' => 90000,
                'status' => 'ready',
                'rating' => 4.9,
                'lat' => -6.2080,
                'lng' => 106.8150, // ~1.0 km (Jarak < 10 km: Biaya Jarak Rp0)
                'no_ktp' => '3171010101900004',
                'sertifikasi' => 'Sertifikasi Tukang Pasang Plafon & Atap Baja Ringan (LPJK)',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Rian Kurniawan',
                'email' => 'rian.teknisi@fixhome.com',
                'phone' => '085712345675',
                'keahlian' => 'Pengecatan & Tembok',
                'tarif' => 65000,
                'status' => 'ready',
                'rating' => 4.6,
                'lat' => -6.3700,
                'lng' => 106.8300, // ~17.2 km (Jarak >= 10 km: Dikenakan Biaya Tambahan Jarak Rp10.000)
                'no_ktp' => '3171010101900005',
                'sertifikasi' => 'Sertifikasi Ahli Cat Bangunan & Waterproofing',
                'status_verifikasi' => 'verified',
            ],
            [
                'name' => 'Yusuf Maulana',
                'email' => 'yusuf.teknisi@fixhome.com',
                'phone' => '085712345676',
                'keahlian' => 'Kunci & Pintu Rusak',
                'tarif' => 60000,
                'status' => 'off',
                'off_start_date' => now()->subDays(45), // Demo inaktif > 30 hari untuk reminder
                'rating' => 4.5,
                'lat' => -6.2400,
                'lng' => 106.9800, // ~18.5 km (Jarak >= 10 km: Biaya Jarak Rp10.000)
                'no_ktp' => '3171010101900006',
                'sertifikasi' => 'Sertifikat Spesialis Mekanisme Pintu & Kunci Digital',
                'status_verifikasi' => 'verified',
            ],
        ];

        $existingTeknisiUserIds = Teknisi::pluck('user_id')->flip()->all();

        foreach ($techniciansData as $data) {
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

            if (!isset($existingTeknisiUserIds[$user->id])) {
                Teknisi::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $data['name'],
                    'keahlian' => $data['keahlian'],
                    'tarif_dasar' => $data['tarif'],
                    'status_kesiapan' => $data['status'],
                    'off_start_date' => $data['off_start_date'] ?? null,
                    'rating' => $data['rating'],
                    'latitude' => $data['lat'],
                    'longitude' => $data['lng'],
                    'no_ktp' => $data['no_ktp'],
                    'sertifikasi' => $data['sertifikasi'],
                    'status_verifikasi' => $data['status_verifikasi'],
                ]);
            }
        }

        // 5. Data Transaksi & Booking Contoh (Mendukung Pembuktian KF-05 s/d KF-14)
        $budiTeknisi = Teknisi::where('nama_lengkap', 'Budi Santoso')->first();
        $rianTeknisi = Teknisi::where('nama_lengkap', 'Rian Kurniawan')->first();
        $adityaCust = Customer::where('nama_lengkap', 'Aditya Pratama')->first();

        if ($budiTeknisi && $adityaCust) {
            // Booking 1: Jarak Dekat (< 10 km -> Biaya Jarak Rp0) - Status Completed
            $b1 = \App\Models\Booking::updateOrCreate(
                ['customer_id' => $adityaCust->id, 'teknisi_id' => $budiTeknisi->id],
                [
                    'jadwal' => now()->subDays(2),
                    'deskripsi_kerusakan' => 'AC menetes dan hembusan angin tidak dingin di kamar utama.',
                    'catatan_perbaikan' => 'Tangga lipat tersedia di samping rumah.',
                    'status_order' => 'completed',
                    'jarak_km' => 0.5,
                    'biaya_layanan' => 75000,
                    'biaya_jarak' => 0,
                    'total_biaya' => 75000,
                ]
            );

            $split1 = \App\Models\Transaksi::calculateSplit(75000);
            \App\Models\Transaksi::updateOrCreate(
                ['booking_id' => $b1->id],
                [
                    'kode_transaksi' => 'TRX-FIXHOME001',
                    'gross_amount' => 75000,
                    'komisi_admin' => $split1['komisi_admin'],
                    'dana_teknisi' => $split1['dana_teknisi'],
                    'biaya_jarak' => 0,
                    'status_pembayaran' => 'paid',
                    'payment_method' => 'BCA Virtual Account',
                    'paid_at' => now()->subDays(2),
                ]
            );

            \App\Models\Ulasan::updateOrCreate(
                ['booking_id' => $b1->id],
                [
                    'customer_id' => $adityaCust->id,
                    'teknisi_id' => $budiTeknisi->id,
                    'rating' => 5,
                    'komentar' => 'Teknisi datang tepat waktu, pengerjaan sangat rapi dan AC langsung dingin kembali!',
                ]
            );
        }

        if ($rianTeknisi && $adityaCust) {
            // Booking 2: Jarak Jauh (>= 10 km -> Biaya Tambahan Jarak Rp10.000) - Status Paid
            $b2 = \App\Models\Booking::updateOrCreate(
                ['customer_id' => $adityaCust->id, 'teknisi_id' => $rianTeknisi->id],
                [
                    'jadwal' => now()->addDay()->setHour(10)->setMinute(0),
                    'deskripsi_kerusakan' => 'Pengecatan ulang dinding ruang tamu yang terkena rembesan air.',
                    'catatan_perbaikan' => 'Warna cat abu-abu terang catylac sudah dibeli.',
                    'status_order' => 'paid',
                    'jarak_km' => 17.2,
                    'biaya_layanan' => 65000,
                    'biaya_jarak' => 10000,
                    'total_biaya' => 75000,
                ]
            );

            $split2 = \App\Models\Transaksi::calculateSplit(75000);
            \App\Models\Transaksi::updateOrCreate(
                ['booking_id' => $b2->id],
                [
                    'kode_transaksi' => 'TRX-FIXHOME002',
                    'gross_amount' => 75000,
                    'komisi_admin' => $split2['komisi_admin'],
                    'dana_teknisi' => $split2['dana_teknisi'],
                    'biaya_jarak' => 10000,
                    'status_pembayaran' => 'paid',
                    'payment_method' => 'QRIS / E-Wallet',
                    'paid_at' => now()->subHours(1),
                ]
            );
        }
    }
}
