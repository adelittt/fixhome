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

        // 4. Data 10 Mitra Teknisi dengan 10 Kategori Berbeda + Foto Profil
        (new TeknisiCatalogSeeder())->run();

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
