<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RumahSakit;
use App\Models\DokterRumahSakit; // Import model yang sudah dibuat
use Illuminate\Support\Facades\Log;

class HospitalController extends Controller
{
    // Method untuk menampilkan view peta
    public function showMap()
    {
        return view('peta');
    }

    // Method untuk mendapatkan rumah sakit terdekat (API)
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

            // Query menggunakan Eloquent Model
            $hospitals = RumahSakit::select(
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
                
                $hospitals = RumahSakit::select(
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
                    'place_id' => (string)$hospital->id,
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

    // Method untuk mendapatkan statistik rumah sakit (API)
    public function getHospitalStats(Request $request)
    {
        try {
            $lat = $request->input('lat', -6.2088);
            $lng = $request->input('lng', 106.8456);
            $radius = $request->input('radius', 10);

            // Hitung total rumah sakit dalam radius
            $totalHospitals = RumahSakit::whereNotNull('lat')
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
            $averageRating = RumahSakit::whereNotNull('lat')
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
            
            $hospitals = RumahSakit::select('kapasitas')
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
        try {
            $hospital = RumahSakit::where('id_rumah_sakit', $id)->first();
            
            if (!$hospital) {
                return redirect()->route('peta')->with('error', 'Rumah sakit tidak ditemukan');
            }
            
            return view('detail', [
                'hospital' => $hospital,
                'hospital_id' => $id
            ]);
        } catch (\Exception $e) {
            Log::error('Error in showHospitalDetail', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('peta')->with('error', 'Terjadi kesalahan saat memuat detail rumah sakit');
        }
    }

    // Method untuk mendapatkan data rumah sakit (API)
    public function getHospitalData($id)
    {
        try {
            $hospital = RumahSakit::where('id_rumah_sakit', $id)->first();
            
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
        } catch (\Exception $e) {
            Log::error('Error in getHospitalData', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data rumah sakit'
            ], 500);
        }
    }

    // **METHOD BARU: Mendapatkan kapasitas rumah sakit yang dibutuhkan oleh frontend**
    public function getHospitalCapacity($id)
    {
        try {
            $hospital = RumahSakit::where('id_rumah_sakit', $id)->first();
            
            if (!$hospital) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rumah sakit tidak ditemukan'
                ], 404);
            }

            $availability = $this->parseCapacity($hospital->kapasitas);
            
            if (!$availability) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data kapasitas tidak valid'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'current' => $availability['available'],
                'total' => $availability['total'],
                'percentage' => $availability['percentage'],
                'status' => $availability['status']
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getHospitalCapacity', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kapasitas'
            ], 500);
        }
    }

    // Method untuk mendapatkan dokter rumah sakit - MENGGUNAKAN MODEL
    public function getHospitalDoctors($id)
    {
        try {
            // Log untuk debugging
            Log::info('Getting doctors for hospital', ['hospital_id' => $id]);
            
            // Validasi input
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID rumah sakit tidak valid'
                ], 400);
            }
            
            // Cek apakah hospital ada
            $hospital = RumahSakit::where('id_rumah_sakit', $id)->first();
                
            if (!$hospital) {
                Log::warning('Hospital not found', ['hospital_id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Rumah sakit tidak ditemukan'
                ], 404);
            }
            
            // Query dokter menggunakan Model
            $doctors = DokterRumahSakit::where('id_rumah_sakit', $id)
                ->select('id_dokter', 'nama', 'spesialisasi', 'jam_praktek')
                ->orderBy('spesialisasi', 'asc')
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Doctors query result', [
                'hospital_id' => $id,
                'doctors_count' => $doctors->count()
            ]);
            
            $formattedDoctors = [];
            foreach ($doctors as $doctor) {
                $formattedDoctors[] = [
                    'id' => $doctor->id_dokter,
                    'name' => trim($doctor->nama ?? 'Nama tidak tersedia'),
                    'specialty' => trim($doctor->spesialisasi ?? 'Umum'),
                    'schedule' => trim($doctor->jam_praktek ?? 'Jadwal tidak tersedia')
                ];
            }
            
            // Jika tidak ada dokter ditemukan
            if (empty($formattedDoctors)) {
                Log::info('No doctors found for hospital', ['hospital_id' => $id]);
                
                return response()->json([
                    'success' => true,
                    'doctors' => [],
                    'total' => 0,
                    'message' => 'Belum ada dokter yang terdaftar untuk rumah sakit ini'
                ]);
            }
            
            return response()->json([
                'success' => true,
                'doctors' => $formattedDoctors,
                'total' => count($formattedDoctors),
                'hospital_name' => $hospital->nama
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in getHospitalDoctors', [
                'hospital_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dokter: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk mendapatkan daftar spesialisasi dokter di rumah sakit
    public function getHospitalSpecialties($id)
    {
        try {
            // Validasi input
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID rumah sakit tidak valid'
                ], 400);
            }
            
            // Ambil daftar spesialisasi unik menggunakan Model
            $specialties = DokterRumahSakit::where('id_rumah_sakit', $id)
                ->select('spesialisasi')
                ->distinct()
                ->orderBy('spesialisasi')
                ->pluck('spesialisasi')
                ->filter() // Hapus nilai kosong/null
                ->values(); // Reset index array
            
            return response()->json([
                'success' => true,
                'specialties' => $specialties,
                'total' => $specialties->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in getHospitalSpecialties', [
                'hospital_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data spesialisasi'
            ], 500);
        }
    }

    // Method untuk mendapatkan dokter berdasarkan spesialisasi
    public function getDoctorsBySpecialty($hospitalId, $specialty)
    {
        try {
            // Validasi input
            if (!is_numeric($hospitalId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID rumah sakit tidak valid'
                ], 400);
            }
            
            $doctors = DokterRumahSakit::where('id_rumah_sakit', $hospitalId)
                ->where('spesialisasi', 'LIKE', '%' . $specialty . '%')
                ->select('id_dokter', 'nama', 'spesialisasi', 'jam_praktek')
                ->orderBy('nama')
                ->get();
            
            $formattedDoctors = [];
            foreach ($doctors as $doctor) {
                $formattedDoctors[] = [
                    'id' => $doctor->id_dokter,
                    'name' => trim($doctor->nama ?? 'Nama tidak tersedia'),
                    'specialty' => trim($doctor->spesialisasi ?? 'Umum'),
                    'schedule' => trim($doctor->jam_praktek ?? 'Jadwal tidak tersedia')
                ];
            }
            
            return response()->json([
                'success' => true,
                'doctors' => $formattedDoctors,
                'total' => count($formattedDoctors),
                'specialty' => $specialty
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in getDoctorsBySpecialty', [
                'hospital_id' => $hospitalId,
                'specialty' => $specialty,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data dokter berdasarkan spesialisasi'
            ], 500);
        }
    }

    // Helper function untuk parsing data kapasitas
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
        
        // Pastikan available tidak melebihi total
        $available = min($available, $total);
        
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

    // Method untuk debugging - mengecek data dokter
    public function debugDoctors($hospitalId = null)
    {
        try {
            // Cek struktur tabel
            $tableStructure = DB::select('DESCRIBE dokter_rumah_sakit');
            
            if ($hospitalId) {
                // Ambil data dokter untuk hospital tertentu menggunakan Model
                $doctors = DokterRumahSakit::where('id_rumah_sakit', $hospitalId)->get();
                    
                // Cek apakah hospital ada
                $hospital = RumahSakit::where('id_rumah_sakit', $hospitalId)->first();
            } else {
                // Ambil semua data dokter
                $doctors = DokterRumahSakit::limit(10)->get();
                $hospital = null;
            }
            
            // Hitung total dokter per rumah sakit
            $doctorCounts = DokterRumahSakit::select('id_rumah_sakit', DB::raw('COUNT(*) as total_doctors'))
                ->groupBy('id_rumah_sakit')
                ->orderBy('total_doctors', 'desc')
                ->limit(10)
                ->get();
            
            return response()->json([
                'success' => true,
                'hospital_id' => $hospitalId,
                'hospital_info' => $hospital,
                'total_doctors' => $doctors->count(),
                'doctors' => $doctors,
                'table_structure' => $tableStructure,
                'doctor_counts_per_hospital' => $doctorCounts,
                'query_info' => [
                    'table_name' => 'dokter_rumah_sakit',
                    'hospital_column' => 'id_rumah_sakit',
                    'doctor_columns' => ['id_dokter', 'nama', 'spesialisasi', 'jam_praktek']
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}