<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RumahSakit;

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
        $lat = $request->input('lat', -6.2088); // Default ke Jakarta
        $lng = $request->input('lng', 106.8456);
        $radius = $request->input('radius', 10); // Radius default 10 km
        $limit = $request->input('limit', 20); // Limit default 20 rumah sakit

        // Validasi input
        if (!is_numeric($lat) || !is_numeric($lng) || !is_numeric($radius)) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter lokasi tidak valid'
            ], 400);
        }

        // Query untuk mencari rumah sakit dalam radius tertentu
        $hospitals = DB::table('rumah_sakit')
            ->select(
                'id_rumah_sakit as id',
                'nama as name',
                'alamat as vicinity',
                'kapasitas',
                'rating',
                'lat',
                'lng',
                DB::raw("(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) AS distance")
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->limit($limit)
            ->get();

        // Format data untuk response
        $formattedHospitals = [];
        foreach ($hospitals as $hospital) {
            $availability = $this->parseCapacity($hospital->kapasitas);
            
            $formattedHospitals[] = [
                'id' => $hospital->id,
                'place_id' => $hospital->id, // Menggunakan ID yang sama untuk place_id
                'name' => $hospital->name,
                'vicinity' => $hospital->vicinity,
                'rating' => $hospital->rating,
                'kapasitas' => $hospital->kapasitas,
                'availability' => $availability,
                'distance' => round($hospital->distance, 2),
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
            'results' => $formattedHospitals
        ]);
    }

    // Method untuk mendapatkan statistik rumah sakit (API)
    public function getHospitalStats(Request $request)
    {
        $lat = $request->input('lat', -6.2088);
        $lng = $request->input('lng', 106.8456);
        $radius = $request->input('radius', 10);

        // Hitung total rumah sakit dalam radius
        $totalHospitals = DB::table('rumah_sakit')
            ->select(DB::raw("COUNT(*) as total"))
            ->whereRaw("(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) <= $radius")
            ->first()
            ->total;

        // Hitung rating rata-rata
        $averageRating = DB::table('rumah_sakit')
            ->select(DB::raw("AVG(rating) as average"))
            ->whereRaw("(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) <= $radius")
            ->first()
            ->average;

        // Hitung total tempat tidur tersedia (contoh sederhana)
        $totalBeds = 0;
        $occupiedBeds = 0;
        
        $hospitals = DB::table('rumah_sakit')
            ->select('kapasitas')
            ->whereRaw("(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) <= $radius")
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
                'total_available_beds' => $totalBeds - $occupiedBeds,
                'occupancy_rate' => $occupancyRate
            ]
        ]);
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

    // Tambahkan setelah method getHospitalData()
    public function getHospitalDoctors($id)
    {
        $doctors = DB::table('dokter_rumah_sakit')
            ->where('id_rumah_sakit', $id)
            ->select('id_dokter', 'nama', 'spesialisasi', 'jam_praktek')
            ->get();
        
        // Format data dokter
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

    // Tambahkan juga method untuk mengambil kapasitas rumah sakit
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

    // Helper function untuk parsing data kapasitas
    private function parseCapacity($capacity)
    {
        if (preg_match('/(\d+)\s*\/\s*(\d+)/', $capacity, $matches)) {
            $available = (int)$matches[1];
            $total = (int)$matches[2];
            $percentage = ($total > 0) ? round(($available / $total) * 100, 2) : 0;
            
            // Tentukan status ketersediaan
            if ($percentage >= 50) {
                $status = 'high';
            } elseif ($percentage >= 20) {
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
        
        return null;
    }
}