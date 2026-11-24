<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Hitung perkiraan jarak (dalam km) menggunakan formula Haversine (KF-05).
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) {
            return 1.5; // default fallback
        }

        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 1);
    }

    /**
     * Hitung biaya tambahan jarak:
     * Setiap penambahan/kelipatan 10 km dikenakan Rp 10.000.
     * Jarak < 10 km = Rp 0, Jarak 10-19 km = Rp 10.000, Jarak 30 km = Rp 30.000.
     */
    public static function calculateBiayaJarak(float $distanceKm): float
    {
        if ($distanceKm < 10.0) {
            return 0.0;
        }

        $multiplier = floor($distanceKm / 10.0);
        return (float) ($multiplier * 10000.0);
    }

    /**
     * Pencarian lokasi / geocoding alamat via OpenStreetMap Nominatim API.
     */
    public function searchLocation(Request $request)
    {
        $query = trim($request->query('q', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $cacheKey = 'geocode_' . md5(strtolower($query));
        $results = cache()->remember($cacheKey, 3600, function () use ($query) {
            try {
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'User-Agent' => 'FixHome-Platform/1.0 (admin@fixhome.com)',
                    'Accept-Language' => 'id,en',
                ])->timeout(6)->get('https://nominatim.openstreetmap.org/search', [
                    'format' => 'json',
                    'q' => $query,
                    'countrycodes' => 'id',
                    'limit' => 6,
                    'addressdetails' => 1,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                // Fallback di bawah jika request eksternal timeout
            }

            // Fallback populer lokal jika jaringan terputus
            $localFallbacks = [
                ['name' => 'Universitas Esa Unggul (Kebon Jeruk)', 'lat' => -6.1856846, 'lon' => 106.7789088, 'display_name' => 'Universitas Esa Unggul, Jl. Arjuna Utara No.9, Duri Kepa, Kebon Jeruk, Jakarta Barat, 11470'],
                ['name' => 'Universitas Esa Unggul (Kampus Bekasi)', 'lat' => -6.1584869, 'lon' => 106.9723170, 'display_name' => 'Universitas Esa Unggul Kampus Bekasi, Jl. Harapan Indah Boulevard, Pusakarakyat, Bekasi, Jawa Barat'],
                ['name' => 'Universitas Esa Unggul (Kampus Tangerang)', 'lat' => -6.2415, 'lon' => 106.5280, 'display_name' => 'Universitas Esa Unggul Kampus Tangerang, Citra Raya, Panongan, Tangerang, Banten'],
                ['name' => 'Jl. Jenderal Sudirman (Kebayoran Baru)', 'lat' => -6.2155, 'lon' => 106.8205, 'display_name' => 'Jl. Jenderal Sudirman No. 45, Kebayoran Baru, Jakarta Selatan'],
                ['name' => 'Senopati (Kebayoran Baru)', 'lat' => -6.2250, 'lon' => 106.8000, 'display_name' => 'Jl. Senopati No. 18, Senayan, Kebayoran Baru, Jakarta Selatan'],
                ['name' => 'Tebet Barat (Jakarta Selatan)', 'lat' => -6.2200, 'lon' => 106.8450, 'display_name' => 'Jl. Tebet Barat Dalam No. 12, Tebet, Jakarta Selatan'],
                ['name' => 'Kemang Raya (Mampang Prapatan)', 'lat' => -6.2600, 'lon' => 106.8150, 'display_name' => 'Jl. Kemang Raya No. 25, Bangka, Mampang Prapatan, Jakarta Selatan'],
                ['name' => 'Mall Kelapa Gading (Jakarta Utara)', 'lat' => -6.1550, 'lon' => 106.9050, 'display_name' => 'Mall Kelapa Gading, Jl. Boulevard Raya, Kelapa Gading, Jakarta Utara'],
                ['name' => 'Grand Indonesia (Bundaran HI)', 'lat' => -6.1950, 'lon' => 106.8210, 'display_name' => 'Grand Indonesia Shopping Town, Jl. M.H. Thamrin No.1, Menteng, Jakarta Pusat'],
            ];

            return array_values(array_filter($localFallbacks, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false || stripos($item['display_name'], $query) !== false;
            }));
        });

        return response()->json($results);
    }

    /**
     * Reverse geocoding (koordinat ke alamat teks).
     */
    public function reverseGeocode(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!$lat || !$lng) {
            return response()->json(['display_name' => null]);
        }

        $cacheKey = 'rev_geocode_' . round((float) $lat, 4) . '_' . round((float) $lng, 4);
        $result = cache()->remember($cacheKey, 3600, function () use ($lat, $lng) {
            try {
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'User-Agent' => 'FixHome-Platform/1.0 (admin@fixhome.com)',
                    'Accept-Language' => 'id,en',
                ])->timeout(4)->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lng,
                    'zoom' => 18,
                    'addressdetails' => 1,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                // Ignore exception
            }
            return null;
        });

        return response()->json($result);
    }

    public function showSetAddress()
    {
        $user = Auth::user();
        $customer = $user->customer;
        return view('pages.customer.set-address', compact('customer'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'alamat_lengkap' => ['required', 'string', 'min:5'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $customer = Auth::user()->customer;
        if (!$customer) {
            $customer = Customer::create([
                'user_id' => Auth::id(),
                'nama_lengkap' => Auth::user()->name,
            ]);
        }

        $customer->update([
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'is_address_completed' => true,
        ]);

        return redirect()->route('customer.home')->with('success', 'Alamat rumah berhasil disimpan!');
    }

    public function home()
    {
        $user = Auth::user();
        $customer = $user->customer;

        // Cek jika alamat belum diisi per BR-01
        if (!$customer || !$customer->is_address_completed) {
            return redirect()->route('customer.set-address');
        }

        // Ambil teknisi dengan status Ready (BR-02) yang berada dalam jangkauan maksimal 35 km
        $technicians = Teknisi::ready()->with('user')->get()->map(function ($tek) use ($customer) {
            $tek->distance = self::calculateDistance(
                $customer->latitude, $customer->longitude,
                $tek->latitude, $tek->longitude
            );
            $tek->biaya_jarak = self::calculateBiayaJarak($tek->distance);
            return $tek;
        })->filter(function ($tek) {
            // Batas jangkauan maksimal: di atas 35 km teknisi tidak dapat ditemukan
            return $tek->distance <= 35.0;
        })->sortBy('distance')->values()->take(5);

        // Kategori servis sesuai Dokumen Bab 1 & 2
        $categories = [
            ['name' => 'Listrik', 'icon' => 'zap', 'tag' => 'Instalasi Listrik', 'color' => 'bg-amber-100 text-amber-700'],
            ['name' => 'AC & Pendingin', 'icon' => 'wind', 'tag' => 'AC & Pendingin', 'color' => 'bg-blue-100 text-blue-700'],
            ['name' => 'Pipa Air', 'icon' => 'droplet', 'tag' => 'Pipa & Saluran Air', 'color' => 'bg-cyan-100 text-cyan-700'],
            ['name' => 'Atap & Bangunan', 'icon' => 'home', 'tag' => 'Atap & Plafon Bocor', 'color' => 'bg-emerald-100 text-emerald-700'],
            ['name' => 'Pengecatan', 'icon' => 'paint-bucket', 'tag' => 'Pengecatan & Tembok', 'color' => 'bg-rose-100 text-rose-700'],
            ['name' => 'Kunci & Pintu', 'icon' => 'key', 'tag' => 'Kunci & Pintu Rusak', 'color' => 'bg-purple-100 text-purple-700'],
        ];

        // Pesanan aktif jika ada
        $activeBooking = Booking::where('customer_id', $customer->id)
            ->whereIn('status_order', ['pending_payment', 'paid', 'otw', 'working'])
            ->latest()
            ->with(['teknisi', 'transaksi'])
            ->first();

        return view('pages.customer.home', compact('customer', 'technicians', 'categories', 'activeBooking'));
    }

    public function technicians(Request $request)
    {
        $customer = Auth::user()->customer;
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Teknisi::ready()->with('user');

        if ($category) {
            $query->where('keahlian', 'like', "%{$category}%");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('keahlian', 'like', "%{$search}%");
            });
        }

        // Ambil teknisi dan filter: jarak > 35 km tidak dapat ditemukan
        $technicians = $query->get()->map(function ($tek) use ($customer) {
            $tek->distance = self::calculateDistance(
                $customer?->latitude, $customer?->longitude,
                $tek->latitude, $tek->longitude
            );
            $tek->biaya_jarak = self::calculateBiayaJarak($tek->distance);
            return $tek;
        })->filter(function ($tek) {
            // Batas operasional maksimal platform: 35 km
            return $tek->distance <= 35.0;
        })->sortBy('distance')->values();

        return view('pages.customer.technicians', compact('technicians', 'category', 'search'));
    }

    public function technicianDetail(int $id)
    {
        $technician = Teknisi::with(['user', 'ulasans.customer'])->findOrFail($id);
        $customer = Auth::user()->customer;
        $technician->distance = self::calculateDistance(
            $customer?->latitude, $customer?->longitude,
            $technician->latitude, $technician->longitude
        );
        $technician->biaya_jarak = self::calculateBiayaJarak($technician->distance);
        $isOutOfRange = $technician->distance > 35.0;

        return view('pages.customer.technician-detail', compact('technician', 'isOutOfRange'));
    }

    public function orders()
    {
        $customer = Auth::user()->customer;
        $bookings = Booking::where('customer_id', $customer->id)
            ->with(['teknisi', 'transaksi', 'ulasan'])
            ->latest()
            ->get();

        return view('pages.customer.orders', compact('bookings'));
    }

    public function profile()
    {
        $user = Auth::user();
        $customer = $user->customer;
        return view('pages.customer.profile', compact('user', 'customer'));
    }
}
