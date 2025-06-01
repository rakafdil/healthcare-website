<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RumahSakit;
use Illuminate\Support\Facades\Log;

class HospitalController extends Controller
{
    // Method untuk menampilkan view peta
    public function showMap()
    {
        return view('peta');
    }

    // Method untuk mendapatkan rumah sakit terdekat (API) - DIPERBAIKI
    public function getNearbyHospitals(Request $request)
    {
        try {
            $lat = $request->input('lat', -6.2088); // Default ke Jakarta
            $lng = $request->input('lng', 106.8456);
            $radius = $request->input('radius', 10); // Radius default 10 km
            $limit = $request->input('limit', 20); // Limit default 20 rumah sakit

            // Log untuk debugging
            Log::info('Searching hospitals', [
                'lat' => $lat,
                'lng' => $lng,
                'radius' => $radius
            ]);

            // Validasi input yang lebih ketat
            if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($radius)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter lokasi tidak valid',
                    'results' => []
                ], 400);
            }

            // Validasi range koordinat
            if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koordinat di luar jangkauan valid',
                    'results' => []
                ], 400);
            }

            // Query yang diperbaiki dengan penanganan error yang lebih baik
            $hospitals = DB::table('rumah_sakit')
                ->select(
                    'id_rumah_sakit as id',
                    'nama as name',
                    'alamat as vicinity',
                    'kapasitas',
                    'rating',
                    'lat',
                    'lng',
                    // Formula Haversine yang diperbaiki dengan penanganan edge case
                    DB::raw("ROUND(
                        (6371 * acos(
                            GREATEST(-1, LEAST(1, 
                                cos(radians($lat)) * cos(radians(COALESCE(lat, 0))) * 
                                cos(radians(COALESCE(lng, 0)) - radians($lng)) + 
                                sin(radians($lat)) * sin(radians(COALESCE(lat, 0)))
                            ))
                        )), 2
                    ) AS distance")
                )
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('lat', '!=', 0)
                ->where('lng', '!=', 0)
                ->havingRaw('distance <= ?', [$radius])
                ->orderBy('distance')
                ->limit($limit)
                ->get();

            Log::info('Hospitals found', ['count' => $hospitals->count()]);

            // Jika tidak ada hasil, coba dengan radius yang lebih besar
            if ($hospitals->isEmpty() && $radius < 50) {
                Log::info('No hospitals found, trying larger radius');
                
                $hospitals = DB::table('rumah_sakit')
                    ->select(
                        'id_rumah_sakit as id',
                        'nama as name',
                        'alamat as vicinity',
                        'kapasitas',
                        'rating',
                        'lat',
                        'lng',
                        DB::raw("ROUND(
                            (6371 * acos(
                                GREATEST(-1, LEAST(1, 
                                    cos(radians($lat)) * cos(radians(COALESCE(lat, 0))) * 
                                    cos(radians(COALESCE(lng, 0)) - radians($lng)) + 
                                    sin(radians($lat)) * sin(radians(COALESCE(lat, 0)))
                                ))
                            )), 2
                        ) AS distance")
                    )
                    ->whereNotNull('lat')
                    ->whereNotNull('lng')
                    ->where('lat', '!=', 0)
                    ->where('lng', '!=', 0)
                    ->havingRaw('distance <= ?', [50]) // Coba radius 50km
                    ->orderBy('distance')
                    ->limit($limit)
                    ->get();
            }

            // Format data untuk response
            $formattedHospitals = [];
            foreach ($hospitals as $hospital) {
                $availability = $this->parseCapacity($hospital->kapasitas);
                
                $formattedHospitals[] = [
                    'id' => $hospital->id,
                    'place_id' => (string)$hospital->id, // Pastikan string
                    'name' => $hospital->name ?? 'Nama tidak tersedia',
                    'vicinity' => $hospital->vicinity ?? 'Alamat tidak tersedia',
                    'rating' => $hospital->rating ?? 0,
                    'kapasitas' => $hospital->kapasitas ?? 'Tidak diketahui',
                    'availability' => $availability,
                    'distance' => $hospital->distance,
                    'geometry' => [
                        'location' => [
                            'lat' => (float)$hospital->lat,
                            'lng' => (float)$hospital->lng
                        ]
                    ]
                ];
            }

            return response()->json([
                'success' => true,
                'results' => $formattedHospitals,
                'total' => count($formattedHospitals),
                'search_params' => [
                    'lat' => $lat,
                    'lng' => $lng,
                    'radius' => $radius
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getNearbyHospitals', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data rumah sakit: ' . $e->getMessage(),
                'results' => []
            ], 500);
        }
    }

    // Method untuk mendapatkan statistik rumah sakit (API) - DIPERBAIKI
    public function getHospitalStats(Request $request)
    {
        try {
            $lat = $request->input('lat', -6.2088);
            $lng = $request->input('lng', 106.8456);
            $radius = $request->input('radius', 10);

            // Hitung total rumah sakit dalam radius
            $totalHospitals = DB::table('rumah_sakit')
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('lat', '!=', 0)
                ->where('lng', '!=', 0)
                ->whereRaw("
                    (6371 * acos(
                        GREATEST(-1, LEAST(1, 
                            cos(radians($lat)) * cos(radians(COALESCE(lat, 0))) * 
                            cos(radians(COALESCE(lng, 0)) - radians($lng)) + 
                            sin(radians($lat)) * sin(radians(COALESCE(lat, 0)))
                        ))
                    )) <= $radius
                ")
                ->count();

            // Hitung rating rata-rata
            $averageRating = DB::table('rumah_sakit')
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('lat', '!=', 0)
                ->where('lng', '!=', 0)
                ->whereNotNull('rating')
                ->whereRaw("
                    (6371 * acos(
                        GREATEST(-1, LEAST(1, 
                            cos(radians($lat)) * cos(radians(COALESCE(lat, 0))) * 
                            cos(radians(COALESCE(lng, 0)) - radians($lng)) + 
                            sin(radians($lat)) * sin(radians(COALESCE(lat, 0)))
                        ))
                    )) <= $radius
                ")
                ->avg('rating') ?? 0;

            // Hitung total tempat tidur tersedia
            $totalBeds = 0;
            $occupiedBeds = 0;
            
            $hospitals = DB::table('rumah_sakit')
                ->select('kapasitas')
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('lat', '!=', 0)
                ->where('lng', '!=', 0)
                ->whereRaw("
                    (6371 * acos(
                        GREATEST(-1, LEAST(1, 
                            cos(radians($lat)) * cos(radians(COALESCE(lat, 0))) * 
                            cos(radians(COALESCE(lng, 0)) - radians($lng)) + 
                            sin(radians($lat)) * sin(radians(COALESCE(lat, 0)))
                        ))
                    )) <= $radius
                ")
                ->get();

            foreach ($hospitals as $hospital) {
                $capacity = $this->parseCapacity($hospital->kapasitas);
                if ($capacity) {
                    $totalBeds += $capacity['total'];
                    $occupiedBeds += ($capacity['total'] - $capacity['available']);
                }
            }

            $occupancyRate = ($totalBeds > 0) ? round(($occupiedBeds / $totalBeds) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_hospitals' => $totalHospitals,
                    'average_rating' => round($averageRating, 1),
                    'total_available_beds' => max(0, $totalBeds - $occupiedBeds),
                    'occupancy_rate' => $occupancyRate
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getHospitalStats', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik rumah sakit'
            ], 500);
        }
    }

    // Method untuk menampilkan detail rumah sakit
    public function showHospitalDetail($id)
    {
        $hospital = DB::table('rumah_sakit')
            ->where('id_rumah_sakit', $id)
            ->first();
        
        if (!$hospital) {
            abort(404);
        }
        
        return view('hospital-detail', [
            'hospital' => $hospital,
            'hospital_id' => $id
        ]);
    }

    // Method untuk mendapatkan data rumah sakit (API)
    public function getHospitalData($id)
    {
        $hospital = DB::table('rumah_sakit')
            ->where('id_rumah_sakit', $id)
            ->first();
        
        if (!$hospital) {
            return response()->json([
                'success' => false,
                'message' => 'Rumah sakit tidak ditemukan'
            ], 404);
        }

        $availability = $this->parseCapacity($hospital->kapasitas);
        
        return response()->json([
            'success' => true,
            'name' => $hospital->nama,
            'address' => $hospital->alamat,
            'capacity' => $hospital->kapasitas,
            'rating' => $hospital->rating,
            'availability' => $availability,
            'geometry' => [
                'location' => [
                    'lat' => (float)$hospital->lat,
                    'lng' => (float)$hospital->lng
                ]
            ]
        ]);
    }

    // Method untuk mendapatkan dokter rumah sakit
    public function getHospitalDoctors($id)
    {
        $doctors = DB::table('dokter_rumah_sakit')
            ->where('id_rumah_sakit', $id)
            ->select('id_dokter', 'nama', 'spesialisasi', 'jam_praktek')
            ->get();
        
        $formattedDoctors = [];
        foreach ($doctors as $doctor) {
            $formattedDoctors[] = [
                'id' => $doctor->id_dokter,
                'name' => $doctor->nama,
                'specialty' => $doctor->spesialisasi,
                'schedule' => $doctor->jam_praktek
            ];
        }
        
        return response()->json([
            'success' => true,
            'doctors' => $formattedDoctors
        ]);
    }

    // Method untuk mengambil kapasitas rumah sakit
    public function getHospitalCapacity($id)
    {
        $hospital = DB::table('rumah_sakit')
            ->where('id_rumah_sakit', $id)
            ->select('kapasitas')
            ->first();
        
        if (!$hospital) {
            return response()->json([
                'success' => false,
                'message' => 'Rumah sakit tidak ditemukan'
            ], 404);
        }
        
        $capacity = $this->parseCapacity($hospital->kapasitas);
        
        return response()->json([
            'success' => true,
            'current' => $capacity ? $capacity['available'] : 0,
            'total' => $capacity ? $capacity['total'] : 0
        ]);
    }

    // Helper function untuk parsing data kapasitas - DIPERBAIKI
    private function parseCapacity($capacity)
    {
        if (!$capacity) {
            return null;
        }

        // Coba berbagai format parsing
        if (preg_match('/(\d+)\s*\/\s*(\d+)/', $capacity, $matches)) {
            $available = (int)$matches[1];
            $total = (int)$matches[2];
        } elseif (preg_match('/(\d+)\s*dari\s*(\d+)/', $capacity, $matches)) {
            $available = (int)$matches[1];
            $total = (int)$matches[2];
        } elseif (preg_match('/(\d+)\s*-\s*(\d+)/', $capacity, $matches)) {
            $available = (int)$matches[1];
            $total = (int)$matches[2];
        } elseif (preg_match('/(\d+)/', $capacity, $matches)) {
            $total = (int)$matches[1];
            $available = intval($total * 0.5);
        } else {
            return null;
        }
        
        $percentage = ($total > 0) ? round(($available / $total) * 100, 2) : 0;
        
        // Tentukan status ketersediaan
        if ($percentage >= 70) {
            $status = 'high';
        } elseif ($percentage >= 30) {
            $status = 'medium';
        } elseif ($percentage > 0) {
            $status = 'low';
        } else {
            $status = 'full';
        }
        
        return [
            'available' => $available,
            'total' => $total,
            'percentage' => $percentage,
            'status' => $status
        ];
    }
}