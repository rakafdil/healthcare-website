<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RumahSakit;
use App\Models\Dokter; // Model Dokter yang perlu dibuat

class HospitalController extends Controller
{
    // Method untuk menampilkan detail rumah sakit
    public function showHospitalDetail($id = null)
    {
        if (!$id) {
            return redirect('/peta');
        }
        
        // Untuk detail rumah sakit, gunakan view 'detail' yang sudah ada
        return view('detail', ['hospital_id' => $id]);
    }
    
    // Method untuk mendapatkan data rumah sakit berdasarkan ID
    public function getHospitalData($id)
    {
        // Ambil data rumah sakit dari database menggunakan model
        $hospital = RumahSakit::find($id);
        
        if (!$hospital) {
            return response()->json(['error' => 'Rumah sakit tidak ditemukan'], 404);
        }
        
        // Ambil semua dokter yang bekerja di rumah sakit tersebut
        // Asumsi ada tabel dokter dengan kolom rumah_sakit_id
        $doctors = DB::table('dokter')
                    ->where('rumah_sakit_id', $id)
                    ->get();
        
        // Format dokter untuk ditampilkan
        $formattedDoctors = [];
        foreach ($doctors as $doctor) {
            $formattedDoctors[] = [
                'name' => $doctor->nama,
                'specialty' => $doctor->spesialisasi,
                'schedule' => $doctor->jadwal,
                'gender' => $doctor->jenis_kelamin
            ];
        }
        
        // Jika tidak ada dokter di database, beri array kosong
        if (empty($formattedDoctors)) {
            $formattedDoctors = [];
        }
        
        // Format data sesuai dengan struktur yang diharapkan oleh aplikasi
        $result = [
            'name' => $hospital->nama,
            'address' => $hospital->alamat,
            'capacity' => $hospital->kapasitas,
            'rating' => $hospital->rating,
            'doctors' => $formattedDoctors,
            // Tambahan informasi lengkap rumah sakit
            'phone' => $hospital->telepon ?? '',
            'email' => $hospital->email ?? '',
            'website' => $hospital->website ?? '',
            'facilities' => $hospital->fasilitas ?? '',
            'description' => $hospital->deskripsi ?? '',
            'services' => $hospital->layanan ?? '',
            'insurance' => $hospital->asuransi ?? '',
            'operational_hours' => $hospital->jam_operasional ?? ''
        ];
        
        return response()->json($result);
    }

    // Method untuk mendapatkan data kapasitas rumah sakit
    public function getHospitalCapacity($id)
    {
        // Ambil data kapasitas dari database menggunakan model
        $hospital = RumahSakit::find($id);
                    
        if (!$hospital) {
            return response()->json(['error' => 'Rumah sakit tidak ditemukan'], 404);
        }
        
        // Jika format kapasitas adalah "available/total" seperti "20/80"
        if (strpos($hospital->kapasitas, '/') !== false) {
            list($available, $total) = explode('/', $hospital->kapasitas);
            return response()->json([
                'available' => (int)$available,
                'total' => (int)$total,
                'percentage' => ($total > 0) ? round(($available / $total) * 100, 2) : 0
            ]);
        }
        
        // Jika kapasitas hanya berupa angka tunggal, anggap sebagai total
        if (is_numeric($hospital->kapasitas)) {
            $total = (int)$hospital->kapasitas;
            $available = DB::table('tempat_tidur')
                        ->where('rumah_sakit_id', $id)
                        ->where('status', 'tersedia')
                        ->count();
            
            return response()->json([
                'available' => $available,
                'total' => $total,
                'percentage' => ($total > 0) ? round(($available / $total) * 100, 2) : 0
            ]);
        }
        
        // Jika format kapasitas tidak sesuai
        return response()->json([
            'error' => 'Format kapasitas tidak valid',
            'raw_capacity' => $hospital->kapasitas
        ], 400);
    }

    // Method untuk mendapatkan rumah sakit terdekat tanpa batasan jumlah
    public function getNearbyHospitals(Request $request)
    {
        $lat = $request->input('lat', -6.9147); // Default ke Bandung jika tidak ada
        $lng = $request->input('lng', 107.6098);
        $radius = $request->input('radius', 5); // Radius pencarian dalam kilometer
        $limit = $request->input('limit', 0); // 0 berarti tanpa batas
        
        // Query dasar untuk menghitung jarak dengan rumus Haversine
        $query = DB::table('rumah_sakit')
            ->select(
                'id_rumah_sakit as id',
                'id_rumah_sakit as place_id',
                'nama as name',
                'alamat as vicinity',
                'rating',
                'kapasitas',
                'lat',
                'lng',
                DB::raw("(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) AS distance")
            )
            ->having('distance', '<', $radius)
            ->orderBy('distance');
        
        // Terapkan limit jika diberikan
        if ($limit > 0) {
            $query->limit($limit);
        }
        
        $hospitals = $query->get();
        
        // Format hasil untuk kompatibilitas dengan kode frontend yang sudah ada
        $results = [];
        foreach ($hospitals as $hospital) {
            // Parse kapasitas untuk mendapatkan ketersediaan
            $availability = null;
            if (strpos($hospital->kapasitas, '/') !== false) {
                list($available, $total) = explode('/', $hospital->kapasitas);
                $availability = [
                    'available' => (int)$available,
                    'total' => (int)$total,
                    'percentage' => ($total > 0) ? round(($available / $total) * 100, 2) : 0
                ];
            }
            
            $results[] = [
                'id' => $hospital->id,
                'place_id' => $hospital->place_id,
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
            'results' => $results,
            'total' => count($results),
            'radius' => $radius,
            'center' => [
                'lat' => (float)$lat,
                'lng' => (float)$lng
            ]
        ]);
    }
    
    // Method baru untuk mendapatkan semua rumah sakit tanpa filter lokasi
    public function getAllHospitals(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'nama');
        $order = $request->input('order', 'asc');
        
        $query = RumahSakit::query();
        
        // Filter pencarian jika ada
        if (!empty($search)) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
        }
        
        // Urutan data
        $query->orderBy($sort, $order);
        
        // Ambil semua data
        $hospitals = $query->get();
        
        // Format hasil
        $results = [];
        foreach ($hospitals as $hospital) {
            $results[] = [
                'id' => $hospital->id_rumah_sakit,
                'place_id' => $hospital->id_rumah_sakit,
                'name' => $hospital->nama,
                'vicinity' => $hospital->alamat,
                'rating' => $hospital->rating,
                'kapasitas' => $hospital->kapasitas,
                'geometry' => [
                    'location' => [
                        'lat' => (float)$hospital->lat,
                        'lng' => (float)$hospital->lng
                    ]
                ]
            ];
        }
        
        return response()->json([
            'results' => $results,
            'total' => count($results)
        ]);
    }
}