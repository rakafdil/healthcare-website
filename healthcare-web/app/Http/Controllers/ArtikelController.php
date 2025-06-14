<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Exception;


class ArtikelController extends Controller
{
    /**
     * Tampilkan daftar artikel
     *
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Ambil 3 artikel per halaman
        $artikels = Artikel::paginate(3);

        // Kirim data ke view
        return view('artikel.index', compact('artikels'));
    }

    /**
     * Cari artikel berdasarkan query
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $artikels = Artikel::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('isi', 'LIKE', "%{$query}%")
            ->paginate(3)
            ->appends(['query' => $query]); // tetap menyimpan query saat pindah halaman

        return view('artikel.index', compact('artikels'));
    }

    /**
     * Tampilkan detail artikel
     */
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('artikel.show', compact('artikel'));
    }

    /**
     * Sinkronisasi artikel dari API MediaStack
     */
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
                if (!empty($newsData['image'])) {
                    Artikel::updateOrCreate(
                        ['judul' => $newsData['title']],
                        [
                            'penulis' => $newsData['author'] ?? 'Admin',
                            'gambar' => $newsData['image'],
                            'isi' => $newsData['description'] ?? '',
                            'link' => $newsData['url'] ?? '',
                            'created_at' => $newsData['published_at'],
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
