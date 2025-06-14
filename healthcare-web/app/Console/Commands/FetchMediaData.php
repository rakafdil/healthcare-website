<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
            
            $this->info('Data berhasil diambil dari API');
            $this->info('Mulai menyimpan artikel ke database...');
            
            $syncCount = 0;
            $totalArticles = count($apiResult['data']);
            
            // Create progress bar
            $bar = $this->output->createProgressBar($totalArticles);
            $bar->start();
            
            foreach ($apiResult['data'] as $newsData) {
                try {
                    \App\Models\Artikel::updateOrCreate(
                        ['judul' => $newsData['title']], // Sama seperti controller
                        [
                            'penulis' => $newsData['author'] ?? 'Admin',
                            'gambar' => $newsData['image'] ?? null,
                            
                            'isi' => $newsData['description'] ?? '',
                            'link' => $newsData['url'] ?? '',
                            'created_at' => $newsData['published_at'] ?? now(),
                        ]
                    );
                    $syncCount++;
                    
                } catch (Exception $articleError) {
                    // Log error dengan detail untuk debugging
                    $this->warn(" Gagal menyimpan artikel: " . ($newsData['title'] ?? 'Unknown'));
                    $this->error("   Error: " . $articleError->getMessage());
                }
                
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            
            $this->info("Sync berhasil!");
            $this->info("Total artikel yang ditemukan: {$totalArticles}");
            $this->info("Total artikel yang disimpan: {$syncCount}");
            
            if (isset($apiResult['pagination'])) {
                $this->info("Pagination info:");
                $this->line("   - Limit: " . ($apiResult['pagination']['limit'] ?? 'N/A'));
                $this->line("   - Offset: " . ($apiResult['pagination']['offset'] ?? 'N/A'));
                $this->line("   - Count: " . ($apiResult['pagination']['count'] ?? 'N/A'));
                $this->line("   - Total: " . ($apiResult['pagination']['total'] ?? 'N/A'));
            }
            
            return Command::SUCCESS;
            
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error('Pastikan:');
            $this->error('   - Koneksi internet stabil');
            $this->error('   - API key MediaStack valid');
            $this->error('   - Database dapat diakses');
            
            return Command::FAILURE;
        }
    }
}