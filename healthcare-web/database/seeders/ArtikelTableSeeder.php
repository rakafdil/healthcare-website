<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArtikelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke file CSV
        $csvFile = database_path('seeders/data/tabel_artikel.csv');
        
        // Cek apakah file CSV ada
        if (!File::exists($csvFile)) {
            $this->command->error("File CSV tidak ditemukan: {$csvFile}");
            return;
        }

        // Kosongkan tabel terlebih dahulu
        DB::table('tabel_artikel')->truncate();

        // Baca file CSV
        $csvData = array_map('str_getcsv', file($csvFile));
        
        // Ambil header (baris pertama)
        $header = array_shift($csvData);
        
        // Proses setiap baris data
        foreach ($csvData as $row) {
            // Skip baris kosong
            if (empty(array_filter($row))) {
                continue;
            }
            
            // Kombinasikan header dengan data
            $data = array_combine($header, $row);
            
            // Siapkan data untuk insert
            $insertData = [
                'judul' => $this->cleanData($data['judul'] ?? null),
                'penulis' => $this->cleanData($data['penulis'] ?? null),
                'gambar' => $this->cleanData($data['gambar'] ?? null),
                'isi' => $this->cleanData($data['isi'] ?? null),
                'link' => $this->cleanData($data['link'] ?? null),
                'created_at' => $this->parseDateTime($data['created_at'] ?? null),
                'updated_at' => $this->parseDateTime($data['updated_at'] ?? null),
            ];
            
            // Insert ke database
            DB::table('tabel_artikel')->insert($insertData);
        }
        
        $this->command->info('Seeder ArtikelSeeder berhasil dijalankan!');
        $this->command->info('Total data yang diimport: ' . count($csvData));
    }
    
    /**
     * Membersihkan data dari CSV
     */
    private function cleanData($value)
    {
        if (is_null($value) || $value === '' || $value === 'NULL') {
            return null;
        }
        
        return trim($value);
    }
    
    /**
     * Parse datetime dari string CSV
     */
    private function parseDateTime($value)
    {
        if (is_null($value) || $value === '' || $value === 'NULL') {
            return now(); // Gunakan waktu sekarang jika tidak ada
        }
        
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return now(); // Fallback ke waktu sekarang jika parsing gagal
        }
    }
}