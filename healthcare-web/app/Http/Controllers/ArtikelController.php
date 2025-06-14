<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Exception;




class ArtikelController extends Controller
{
    /*
     @return Illuminate\Http\Response;
    */
    public function index()
    {
        // Ambil 10 artikel per halaman
        $artikels = Artikel::paginate(3);

        // Kirim data ke view
        return view('artikel.index', compact('artikels'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $artikels = Artikel::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('isi', 'LIKE', "%{$query}%")
            ->orWhere('bahasan_penyakit', 'LIKE', "%{$query}%")
            ->paginate(3)  // paginate juga untuk hasil pencarian
            ->appends(['query' => $query]); // supaya query pencarian tetap di URL saat pindah halaman

        return view('artikel.index', compact('artikels'));
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('artikel.show', compact('artikel'));
    }

    public function syncFromAPI()
    {
        try {
            $queryString = http_build_query([
                'access_key' => env('MEDIASTACK_ACCESS_KEY'),
                'categories' => 'health',
                'sort' => 'published_desc',
                'limit' => 100
            ]);
            $ch = curl_init(sprintf('%s?%s', 'https://api.mediastack.com/v1/news', $queryString));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $json = curl_exec($ch);

            if (curl_error($ch)) {
                throw new Exception('cURL Error: ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                throw new Exception('HTTP Error: ' . $httpCode);
            }
            $apiResult = json_decode($json, true);

            if (!$apiResult || !isset($apiResult['data'])) {
                throw new Exception('Invalid API response');
            }

            if (isset($apiResult['error'])) {
                throw new Exception('API Error: ' . $apiResult['error']['message']);
            }
            $syncCount = 0;
            foreach ($apiResult['data'] as $newsData) {
                if (!empty($newsData['image'])) {  // pastikan ada gambar, bukan null atau kosong
                    Artikel::updateOrCreate(
                        ['judul' => $newsData['title']], // cek duplikat berdasarkan judul
                        [
                            'penulis' => $newsData['author'] ?? 'Admin',
                            'gambar' => $newsData['image'],
                            'bahasan_penyakit' => $newsData['categories'] ?? '',
                            'isi' => $newsData['description'] ?? '',
                            'link' => $newsData['url'] ?? '',
                            'created_at' => $newsData['published_at'],
                            'kategori_penyakit_id' => null // sesuaikan dengan ID kategori yang ada
                        ]
                    );
                    $syncCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Sync artikel kesehatan berhasil!',
                'total_synced' => $syncCount,
                'pagination' => $apiResult['pagination'] ?? null
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Sync gagal: ' . $e->getMessage()
            ], 500);
        }
    }

}
