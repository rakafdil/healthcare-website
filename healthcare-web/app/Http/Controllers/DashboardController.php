<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use App\Models\Blog;
use App\Models\DiagnosisResult;
use App\Models\SistemPakar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // // Data statistik
        // $totalPengunjung = History::count();
        // $totalPengguna = User::count();
        // $totalDiagnosa = DiagnosisResult::count();
        // $totalPencarianArtikel = Artikel::count();

        // // Data untuk chart pengunjung harian
        // $pengunjungHarian = History::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        //     ->where('created_at', '>=', now()->subDays(7))
        //     ->groupBy('date')
        //     ->orderBy('date')
        //     ->get();

        // // Data penggunaan fitur
        // $penggunaanFitur = [
        //     'diagnosa' => SistemPakar::count(),
        //     'konsultasi' => 0, // Ganti jika ada model konsultasi
        //     'artikel' => Blog::count(),
        //     'rumah_sakit' => 0 // Ganti jika ada model rumah sakit
        // ];

        // // Artikel terpopuler (misal berdasarkan created_at karena views tidak ada)
        // $artikelTerpopuler = Blog::orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        // // Gejala tersering (asumsi tabel SistemPakar punya kolom 'gejala')
        // $gejalaTersering = SistemPakar::select('gejala')
        //     ->selectRaw('COUNT(*) as count')
        //     ->groupBy('gejala')
        //     ->orderBy('count', 'desc')
        //     ->take(5)
        //     ->get();

        // // Lokasi pengguna (asumsi kolom 'city' ada di tabel users)
        // $lokasiPengguna = User::select('city')
        //     ->selectRaw('COUNT(*) as count')
        //     ->groupBy('city')
        //     ->orderBy('count', 'desc')
        //     ->take(4)
        //     ->get();

        // // Aktivitas terbaru
        // $aktivitasTerbaru = History::with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        // return view('dashboard', [
        //     'totalPengunjung' => $totalPengunjung,
        //     'totalPengguna' => $totalPengguna,
        //     'totalDiagnosa' => $totalDiagnosa,
        //     'totalPencarianArtikel' => $totalPencarianArtikel,
        //     'pengunjungHarian' => $pengunjungHarian,
        //     'penggunaanFitur' => $penggunaanFitur,
        //     'artikelTerpopuler' => $artikelTerpopuler,
        //     'gejalaTersering' => $gejalaTersering,
        //     'lokasiPengguna' => $lokasiPengguna,
        //     'aktivitasTerbaru' => $aktivitasTerbaru
        // ]);
    }
}
