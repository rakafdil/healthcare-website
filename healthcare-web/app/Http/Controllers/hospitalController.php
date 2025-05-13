<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // Dalam aplikasi sebenarnya, data akan diambil dari database
        // Untuk sementara, gunakan data dummy
        $hospitals = [
            '1' => [
                'name' => 'Rumah Sakit Bhakti Wira Tamtama',
                'address' => 'Jl. Dr. Sutomo No.17',
                'capacity' => '20/80',
                'rating' => '4.2',
                'doctors' => [
                    [
                        'name' => 'dr. Hendrik Cahyono, Sp.PD',
                        'specialty' => 'Penyakit Dalam',
                        'schedule' => '18.00 - Selesai',
                        'gender' => 'male'
                    ],
                    [
                        'name' => 'dr. Tessy Mubarok, Sp.B',
                        'specialty' => 'Bedah Umum',
                        'schedule' => '06.30 - Selesai',
                        'gender' => 'female'
                    ]
                ]
            ],
            '2' => [
                'name' => 'RSUD Dr. Soetomo',
                'address' => 'Jl. Mayjen Prof. Dr. Moestopo No.6-8',
                'capacity' => '15/100',
                'rating' => '4.5',
                'doctors' => [
                    [
                        'name' => 'dr. Bambang Sutrisno, Sp.JP',
                        'specialty' => 'Jantung dan Pembuluh Darah',
                        'schedule' => '09.00 - 14.00',
                        'gender' => 'male'
                    ],
                    [
                        'name' => 'dr. Ratna Dewi, Sp.A',
                        'specialty' => 'Anak',
                        'schedule' => '15.00 - Selesai',
                        'gender' => 'female'
                    ]
                ]
            ],
            '3' => [
                'name' => 'Rumah Sakit Mitra Keluarga',
                'address' => 'Jl. Raya Kemang No.39',
                'capacity' => '35/50',
                'rating' => '4.3',
                'doctors' => [
                    [
                        'name' => 'dr. Siti Aminah, Sp.OG',
                        'specialty' => 'Kandungan',
                        'schedule' => '10.00 - 16.00',
                        'gender' => 'female'
                    ],
                    [
                        'name' => 'dr. Arief Rahman, Sp.S',
                        'specialty' => 'Saraf',
                        'schedule' => '17.00 - Selesai',
                        'gender' => 'male'
                    ]
                ]
            ],
            '4' => [
                'name' => 'RSUP Dr. Sardjito',
                'address' => 'Jl. Kesehatan No.1',
                'capacity' => '10/60',
                'rating' => '4.1',
                'doctors' => [
                    [
                        'name' => 'dr. Yudi Setiawan, Sp.THT',
                        'specialty' => 'Telinga Hidung Tenggorokan',
                        'schedule' => '08.00 - 12.00',
                        'gender' => 'male'
                    ],
                    [
                        'name' => 'dr. Lestari, Sp.KJ',
                        'specialty' => 'Kedokteran Jiwa',
                        'schedule' => '13.00 - 17.00',
                        'gender' => 'female'
                    ]
                ]
            ],
            '5' => [
                'name' => 'Rumah Sakit Hermina',
                'address' => 'Jl. Jatinegara Barat No.126',
                'capacity' => '25/70',
                'rating' => '4.4',
                'doctors' => [
                    [
                        'name' => 'dr. Budi Santoso, Sp.PD',
                        'specialty' => 'Penyakit Dalam',
                        'schedule' => '08.00 - 14.00',
                        'gender' => 'male'
                    ],
                    [
                        'name' => 'dr. Maya Sari, Sp.KK',
                        'specialty' => 'Kulit dan Kelamin',
                        'schedule' => '15.00 - 19.00',
                        'gender' => 'female'
                    ]
                ]
            ]
        ];
        
        // Jika ID tidak ditemukan, kembalikan data pertama
        return response()->json($hospitals[$id] ?? $hospitals['1']);
    }

    // Method untuk mendapatkan data kapasitas rumah sakit
    public function getHospitalCapacity($placeId)
    {
        // Dalam aplikasi nyata, ambil dari database
        // Untuk sementara, kembalikan data acak
        $available = rand(10, 40);
        $total = $available + rand(40, 60);
        
        return response()->json([
            'available' => $available,
            'total' => $total
        ]);
    }

    // Method untuk mendapatkan rumah sakit terdekat
    public function getNearbyHospitals(Request $request)
    {
        $lat = $request->input('lat', -6.9147); // Default ke Bandung jika tidak ada
        $lng = $request->input('lng', 107.6098);
        
        // Dalam aplikasi nyata, ambil dari database berdasarkan koordinat
        // Untuk sementara, kembalikan data dummy
        $dummyHospitals = [
            [
                'id' => 1,
                'place_id' => '1',
                'name' => 'Rumah Sakit Bhakti Wira Tamtama',
                'vicinity' => 'Jl. Dr. Sutomo No.17',
                'rating' => 4.2,
                'geometry' => [
                    'location' => [
                        'lat' => $lat - 0.02,
                        'lng' => $lng + 0.03
                    ]
                ]
            ],
            [
                'id' => 2,
                'place_id' => '2',
                'name' => 'RSUD Dr. Soetomo',
                'vicinity' => 'Jl. Mayjen Prof. Dr. Moestopo No.6-8',
                'rating' => 4.5,
                'geometry' => [
                    'location' => [
                        'lat' => $lat + 0.01,
                        'lng' => $lng - 0.02
                    ]
                ]
            ],
            [
                'id' => 3,
                'place_id' => '3',
                'name' => 'Rumah Sakit Mitra Keluarga',
                'vicinity' => 'Jl. Raya Kemang No.39',
                'rating' => 4.3,
                'geometry' => [
                    'location' => [
                        'lat' => $lat - 0.01,
                        'lng' => $lng - 0.01
                    ]
                ]
            ],
            [
                'id' => 4,
                'place_id' => '4',
                'name' => 'RSUP Dr. Sardjito',
                'vicinity' => 'Jl. Kesehatan No.1',
                'rating' => 4.1,
                'geometry' => [
                    'location' => [
                        'lat' => $lat + 0.02,
                        'lng' => $lng + 0.02
                    ]
                ]
            ],
            [
                'id' => 5,
                'place_id' => '5',
                'name' => 'Rumah Sakit Hermina',
                'vicinity' => 'Jl. Jatinegara Barat No.126',
                'rating' => 4.4,
                'geometry' => [
                    'location' => [
                        'lat' => $lat + 0.03,
                        'lng' => $lng - 0.03
                    ]
                ]
            ]
        ];
        
        return response()->json(['results' => $dummyHospitals]);
    }
}