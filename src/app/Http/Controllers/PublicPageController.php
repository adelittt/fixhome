<?php

namespace App\Http\Controllers;

use App\Models\Teknisi;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public static function serviceCatalog(): array
    {
        return [
            [
                'slug' => 'pipa-air',
                'title' => 'Perbaikan Pipa & Saluran Air',
                'category' => 'Pipa & Saluran Air',
                'icon' => 'plumbing',
                'image' => 'images/services/pipa-air.jpg',
                'price' => 'Mulai Rp75.000',
                'base_price' => 75000,
                'duration' => '45 – 90 menit',
                'count' => '320+ Teknisi Siap',
                'desc' => 'Solusi tuntas pipa bocor, saluran mampet, instalasi toren, kloset, dan pompa booster otomatis.',
                'includes' => [
                    'Deteksi & tambal kebocoran pipa PVC/PPR/besi',
                    'Pembersihan saluran wastafel, floor drain, & kloset mampet',
                    'Pemasangan & servis pompa air, booster, dan pelampung toren',
                    'Penggantian kran, jet shower, & seal karet anti-rembes',
                ],
                'warranty' => 'Pengerjaan rapi sesuai standar teknisi terverifikasi',
            ],
            [
                'slug' => 'listrik',
                'title' => 'Instalasi Listrik',
                'category' => 'Instalasi Listrik',
                'icon' => 'electric_bolt',
                'image' => 'images/services/listrik.jpg',
                'price' => 'Mulai Rp85.000',
                'base_price' => 85000,
                'duration' => '45 – 120 menit',
                'count' => '240+ Teknisi Siap',
                'desc' => 'Penanganan korsleting, pasang titik lampu baru, perapian panel MCB, dan grounding bersertifikasi.',
                'includes' => [
                    'Penelusuran & perbaikan korsleting listrik serta MCB sering turun',
                    'Tambah titik stop kontak, saklar, dan pemasangan lampu LED/gantung',
                    'Perapian & upgrade box MCB / ELCB anti-sengat',
                    'Pengecekan beban daya & instalasi grounding rumah',
                ],
                'warranty' => 'Pemeriksaan keamanan instalasi standar SNI',
            ],
            [
                'slug' => 'ac-pendingin',
                'title' => 'Perawatan AC & Pendingin',
                'category' => 'AC & Pendingin',
                'icon' => 'ac_unit',
                'image' => 'images/services/ac-pendingin.jpg',
                'price' => 'Mulai Rp65.000',
                'base_price' => 65000,
                'duration' => '45 – 75 menit',
                'count' => '190+ Teknisi Siap',
                'desc' => 'Cuci unit indoor & outdoor, isi freon R32/R410A, perbaikan bocor air, dan pemindahan posisi AC.',
                'includes' => [
                    'Cuci menyeluruh unit indoor, filter, evaporator, & outdoor',
                    'Cek tekanan & isi ulang freon R32 / R410A sesuai standar',
                    'Atasi AC netes air, bau tidak sedap, & unit kurang dingin',
                    'Bongkar-pasang AC baru/lama serta penggantian kapasitor',
                ],
                'warranty' => 'Pengecekan tekanan & kebersihan unit menyeluruh',
            ],
            [
                'slug' => 'atap-plafon',
                'title' => 'Perbaikan Atap & Plafon',
                'category' => 'Atap & Plafon Bocor',
                'icon' => 'roofing',
                'image' => 'images/services/atap-plafon.jpg',
                'price' => 'Mulai Rp120.000',
                'base_price' => 120000,
                'duration' => '90 – 180 menit',
                'count' => '180+ Teknisi Siap',
                'desc' => 'Pencegahan atap rembes bocor, ganti genteng retak, tambal plafon gypsum berjamur, & talang air.',
                'includes' => [
                    'Pencarian titik rembesan atap, nok, & sambungan dak beton',
                    'Penggantian genteng pecah, seng/spandek, & perbaikan talang',
                    'Tambal & ganti papan plafon gypsum/GRC yang lapuk atau berjamur',
                    'Pelapisan waterproofing anti-bocor untuk area rawan hujan',
                ],
                'warranty' => 'Pengecekan titik rembesan secara menyeluruh',
            ],
            [
                'slug' => 'pengecatan',
                'title' => 'Pengecatan Rumah',
                'category' => 'Pengecatan & Tembok',
                'icon' => 'format_paint',
                'image' => 'images/services/pengecatan.jpg',
                'price' => 'Mulai Rp90.000',
                'base_price' => 90000,
                'duration' => '2 – 6 jam',
                'count' => '210+ Teknisi Siap',
                'desc' => 'Pengecatan interior kamar, dinding eksterior fasad cuaca tropis, waterproofing, dan perbaikan plamir retak.',
                'includes' => [
                    'Kerok cat mengelupas, perbaikan retak rambut, & perataan plamir',
                    'Pengecatan interior kamar, ruang tamu, & plafon rapi tanpa noda',
                    'Pengecatan eksterior cuaca tropis & lapisan sealer anti-lembab',
                    'Pembersihan area kerja & penutupan furnitur sebelum mengecat',
                ],
                'warranty' => 'Hasil lapisan cat rapi dan bersih',
            ],
            [
                'slug' => 'kebersihan',
                'title' => 'Kebersihan & Deep Cleaning',
                'category' => null,
                'icon' => 'cleaning_services',
                'image' => 'images/services/kebersihan.jpg',
                'price' => 'Mulai Rp50.000',
                'base_price' => 50000,
                'duration' => '60 – 150 menit',
                'count' => '150+ Teknisi Siap',
                'desc' => 'Pembersihan kerak toren air, sedot tungau kasur/sofa hidro-alergi, dan pembersihan menyeluruh pasca renovasi.',
                'includes' => [
                    'Kuras & sikat lumut/kerak toren air hingga higienis',
                    'Deep cleaning kamar mandi, dapur, & area pasca renovasi',
                    'Vacuum tungau & debu halus untuk kasur, sofa, dan karpet',
                    'Pembersihan kaca jendela, kusen, & lantai secara menyeluruh',
                ],
                'warranty' => 'Pembersihan menyeluruh sesuai daftar layanan',
            ],
        ];
    }

    public function layanan(Request $request)
    {
        return view('pages.public.layanan', [
            'services' => self::serviceCatalog(),
            'activeSlug' => $request->query('kategori'),
        ]);
    }

    public function teknisi(Request $request)
    {
        $selectedCategory = $request->query('category');

        try {
            \App\Services\TeknisiCatalogService::ensureSeeded();
            $query = Teknisi::ready()->orderByDesc('rating');
            $likeOperator = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
            if ($selectedCategory) {
                $query->where('keahlian', $likeOperator, '%' . $selectedCategory . '%');
            }
            $technicians = $query->get();
            $categories = Teknisi::ready()->orderBy('id')->pluck('keahlian')->filter()->unique()->values();
        } catch (\Throwable $e) {
            $technicians = collect();
            $categories = collect();
        }

        return view('pages.public.teknisi', [
            'services' => self::serviceCatalog(),
            'categories' => $categories,
            'technicians' => $technicians,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function caraKerja()
    {
        return view('pages.public.cara-kerja', [
            'services' => self::serviceCatalog(),
        ]);
    }

    public function jadiMitra()
    {
        return view('pages.public.jadi-mitra', [
            'services' => self::serviceCatalog(),
        ]);
    }

    public function tentangKami()
    {
        return view('pages.public.tentang-kami', [
            'services' => self::serviceCatalog(),
        ]);
    }
}
