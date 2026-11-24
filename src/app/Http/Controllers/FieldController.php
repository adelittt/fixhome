<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatMessage;
use App\Models\PelacakanLokasi;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FieldController extends Controller
{
    public function showTrackingChat(int $bookingId)
    {
        $booking = Booking::with(['customer.user', 'teknisi.user', 'transaksi', 'chatMessages.sender', 'latestPelacakan', 'ulasan'])
            ->findOrFail($bookingId);

        $currentUser = Auth::user();

        // Validasi akses (hanya customer atau teknisi yang terlibat)
        $isCustomer = $currentUser->customer && $currentUser->customer->id === $booking->customer_id;
        $isTeknisi = $currentUser->teknisi && $currentUser->teknisi->id === $booking->teknisi_id;

        if (!$isCustomer && !$isTeknisi && $currentUser->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Cek klausul BR-03: Chat hanya boleh aktif setelah pembayaran lunas
        $chatAllowed = $booking->canChat();
        $trackingAllowed = $booking->canTrack();

        return view('pages.customer.tracking-chat', compact('booking', 'chatAllowed', 'trackingAllowed', 'isCustomer', 'isTeknisi'));
    }

    public function sendChatMessage(int $bookingId, Request $request)
    {
        $booking = Booking::findOrFail($bookingId);

        // Klausul BR-03: Tolak chat jika belum dibayar
        if (!$booking->canChat()) {
            return response()->json([
                'error' => 'Fitur chat hanya aktif setelah pembayaran diverifikasi (BR-03).'
            ], 403);
        }

        $validated = $request->validate([
            'pesan' => ['required', 'string', 'max:1000'],
        ]);

        $message = ChatMessage::create([
            'booking_id' => $booking->id,
            'sender_id' => Auth::id(),
            'pesan' => strip_tags($validated['pesan']),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message->load('sender'),
            ]);
        }

        return back();
    }

    public function fetchChatMessages(int $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if (!$booking->canChat()) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatMessage::where('booking_id', $bookingId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'current_user_id' => Auth::id(),
        ]);
    }

    public function fetchGpsLocation(int $bookingId)
    {
        $booking = Booking::with('customer')->findOrFail($bookingId);

        $location = PelacakanLokasi::where('booking_id', $bookingId)
            ->latest()
            ->first();

        return response()->json([
            'technician_lat' => $location ? (float) $location->current_lat : -6.2190,
            'technician_lng' => $location ? (float) $location->current_lng : 106.8230,
            'customer_lat' => $booking->customer ? (float) $booking->customer->latitude : -6.2155,
            'customer_lng' => $booking->customer ? (float) $booking->customer->longitude : 106.8205,
            'status' => $booking->status_order,
            'status_order' => $booking->status_order,
            'is_otw' => in_array($booking->status_order, ['otw', 'working', 'completed']),
            'is_working' => in_array($booking->status_order, ['working', 'completed']),
            'is_completed' => $booking->status_order === 'completed',
        ]);
    }

    public function updateGpsLocation(int $bookingId, Request $request)
    {
        $validated = $request->validate([
            'current_lat' => ['required', 'numeric'],
            'current_lng' => ['required', 'numeric'],
        ]);

        $location = PelacakanLokasi::create([
            'booking_id' => $bookingId,
            'current_lat' => $validated['current_lat'],
            'current_lng' => $validated['current_lng'],
            'is_active' => true,
        ]);

        return response()->json(['status' => 'updated', 'location' => $location]);
    }

    /**
     * Ambil rute jalan raya nyata (turn-by-turn seperti Google Maps) via OSRM BFF proxy.
     */
    public function fetchNavigationRoute(int $bookingId)
    {
        $booking = Booking::with(['customer', 'teknisi', 'latestPelacakan'])->findOrFail($bookingId);

        $currentUser = Auth::user();
        $isCustomer = $currentUser->customer && $currentUser->customer->id === $booking->customer_id;
        $isTeknisi = $currentUser->teknisi && $currentUser->teknisi->id === $booking->teknisi_id;

        if (!$isCustomer && !$isTeknisi && !$currentUser->isAdmin()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $custLat = (float) ($booking->customer?->latitude ?? -6.2155);
        $custLng = (float) ($booking->customer?->longitude ?? 106.8205);

        $tekLat = (float) ($booking->latestPelacakan?->current_lat ?? $booking->teknisi?->latitude ?? -6.2240);
        $tekLng = (float) ($booking->latestPelacakan?->current_lng ?? $booking->teknisi?->longitude ?? 106.8260);

        // Jika koordinat teknisi terlalu dekat (< 150m) atau identik, geser sedikit agar simulasi rute tetap terlihat jelas
        if (abs($tekLat - $custLat) < 0.0015 && abs($tekLng - $custLng) < 0.0015) {
            $tekLat = $custLat - 0.0085;
            $tekLng = $custLng + 0.0065;
        }

        $cacheKey = sprintf('osrm_route_%.5f_%.5f_%.5f_%.5f', $tekLat, $tekLng, $custLat, $custLng);

        $routeData = Cache::remember($cacheKey, 900, function () use ($tekLat, $tekLng, $custLat, $custLng) {
            $endpoints = [
                'https://router.project-osrm.org/route/v1/driving',
                'https://routing.openstreetmap.de/routed-car/route/v1/driving',
            ];

            $coordSegment = "{$tekLng},{$tekLat};{$custLng},{$custLat}";

            foreach ($endpoints as $baseUrl) {
                try {
                    $response = Http::withHeaders([
                        'User-Agent' => 'FixHomePlus-Navigation/1.0',
                    ])->timeout(6)->get("{$baseUrl}/{$coordSegment}", [
                        'overview' => 'full',
                        'geometries' => 'geojson',
                        'steps' => 'true',
                    ]);

                    if ($response->successful()) {
                        $json = $response->json();
                        $route = $json['routes'][0] ?? null;

                        if ($route && !empty($route['geometry']['coordinates'])) {
                            // Konversi GeoJSON [lng, lat] -> Leaflet [lat, lng]
                            $coords = array_map(
                                fn ($pt) => [(float) $pt[1], (float) $pt[0]],
                                $route['geometry']['coordinates']
                            );

                            $steps = [];
                            foreach ($route['legs'][0]['steps'] ?? [] as $step) {
                                $roadName = trim((string) ($step['name'] ?? ''));
                                $maneuver = $step['maneuver'] ?? [];
                                $loc = $maneuver['location'] ?? null;
                                if ($loc && count($loc) === 2) {
                                    $steps[] = [
                                        'lat' => (float) $loc[1],
                                        'lng' => (float) $loc[0],
                                        'road' => $roadName !== '' ? $roadName : 'Jalan Menuju Lokasi',
                                        'type' => (string) ($maneuver['type'] ?? 'continue'),
                                        'modifier' => (string) ($maneuver['modifier'] ?? ''),
                                    ];
                                }
                            }

                            return [
                                'source' => 'osrm',
                                'coordinates' => $coords,
                                'distance_m' => (float) ($route['distance'] ?? 0),
                                'duration_s' => (float) ($route['duration'] ?? 0),
                                'steps' => $steps,
                            ];
                        }
                    }
                } catch (\Throwable $e) {
                    // Coba endpoint cadangan
                }
            }

            return null;
        });

        if (!$routeData) {
            // Fallback halus jika semua routing server eksternal sedang offline
            $midLat = ($tekLat + $custLat) / 2;
            $midLng = ($tekLng + $custLng) / 2;
            return response()->json([
                'source' => 'fallback',
                'coordinates' => [
                    [$tekLat, $tekLng],
                    [$tekLat, $midLng],
                    [$midLat, $midLng],
                    [$midLat, $custLng],
                    [$custLat, $custLng],
                ],
                'distance_m' => 1800,
                'duration_s' => 420,
                'steps' => [
                    ['lat' => $tekLat, 'lng' => $tekLng, 'road' => 'Menuju Alamat Customer', 'type' => 'depart', 'modifier' => ''],
                ],
            ]);
        }

        return response()->json($routeData);
    }

    public function submitReview(int $bookingId, Request $request)
    {
        if (!Auth::check()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Sesi Anda telah berakhir. Silakan login kembali.'], 401);
            }
            return redirect()->route('login')->with('warning', 'Sesi Anda telah berakhir. Silakan masuk kembali.');
        }

        $booking = Booking::with('teknisi')->findOrFail($bookingId);

        $currentUser = Auth::user();
        if (!$currentUser->customer || $booking->customer_id !== $currentUser->customer->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ]);

        Ulasan::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'customer_id' => $booking->customer_id,
                'teknisi_id' => $booking->teknisi_id,
                'rating' => $validated['rating'],
                'komentar' => $validated['komentar'] ?? null,
            ]
        );

        // Pastikan status order booking disetel completed jika belum
        if ($booking->status_order !== 'completed') {
            $booking->update(['status_order' => 'completed']);
        }

        // Rekalkulasi rating teknisi
        $avgRating = Ulasan::where('teknisi_id', $booking->teknisi_id)->avg('rating');
        if ($avgRating) {
            $booking->teknisi->update(['rating' => round($avgRating, 2)]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Terima kasih atas ulasan dan rating Anda!',
                'redirect' => route('customer.orders'),
            ]);
        }

        return redirect()->route('customer.orders')
            ->with('success', 'Terima kasih atas ulasan dan rating Anda!');
    }
}
