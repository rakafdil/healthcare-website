<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ArtikelController;
use Exception;

class FetchMediaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch health articles from MediaStack API and store to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Memulai pengambilan artikel kesehatan dari MediaStack API...');
        
        try {
            // Gunakan logic yang sama dengan ArtikelController
            $queryString = http_build_query([
                'access_key' => env('MEDIASTACK_ACCESS_KEY'),
                'categories' => 'health',
                'sort' => 'published_desc',
                'limit' => 100 // bisa disesuaikan
            ]);
            
            $this->info('📡 Menghubungi API MediaStack...');
            
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
            
            $this->info('✅ Data berhasil diambil dari API');
            $this->info('📝 Mulai menyimpan artikel ke database...');
            
            $syncCount = 0;
            $totalArticles = count($apiResult['data']);
            
            // Create progress bar
            $bar = $this->output->createProgressBar($totalArticles);
            $bar->start();
            
            foreach ($apiResult['data'] as $newsData) {
                try {
                    // Skip artikel yang tidak memiliki gambar
                    if (empty($newsData['image'])) {
                        $bar->advance();
                        continue;
                    }
                    
                    // Handle categories dengan aman
                    $categories = 'Health'; // default
                    if (isset($newsData['categories'])) {
                        if (is_array($newsData['categories'])) {
                            $categories = implode(', ', $newsData['categories']);
                        } else {
                            $categories = $newsData['categories'];
                        }
                    }
                    
                    \App\Models\Artikel::updateOrCreate(
                        ['judul' => $newsData['title'] ?? 'Untitled'], // cek duplikat berdasarkan judul
                        [
                            'penulis' => $newsData['author'] ?? 'Admin',
                            'gambar' => $newsData['image'],
                            'bahasan_penyakit' => $categories,
                            'isi' => $newsData['description'] ?? 'No description available',
                            'link' => $newsData['url'] ?? '',
                            'created_at' => isset($newsData['published_at']) ? $newsData['published_at'] : now(),
                            'kategori_penyakit_id' => null
                        ]
                    );
                    $syncCount++;
                    
                } catch (Exception $articleError) {
                    // Log error tapi lanjutkan ke artikel berikutnya
                    $this->warn("⚠️  Gagal menyimpan artikel: " . ($newsData['title'] ?? 'Unknown'));
                }
                
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            
            $this->info("✅ Sync berhasil!");
            $this->info("📊 Total artikel yang ditemukan: {$totalArticles}");
            $this->info("💾 Total artikel yang disimpan: {$syncCount}");
            
            if (isset($apiResult['pagination'])) {
                $this->info("📄 Pagination info:");
                $this->line("   - Limit: " . ($apiResult['pagination']['limit'] ?? 'N/A'));
                $this->line("   - Offset: " . ($apiResult['pagination']['offset'] ?? 'N/A'));
                $this->line("   - Count: " . ($apiResult['pagination']['count'] ?? 'N/A'));
                $this->line("   - Total: " . ($apiResult['pagination']['total'] ?? 'N/A'));
            }
            
            return Command::SUCCESS;
            
        } catch (Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('💡 Pastikan:');
            $this->error('   - Koneksi internet stabil');
            $this->error('   - API key MediaStack valid');
            $this->error('   - Database dapat diakses');
            
            return Command::FAILURE;
        }
    }
}