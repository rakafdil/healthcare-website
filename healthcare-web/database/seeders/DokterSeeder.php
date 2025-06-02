<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/dokter.csv');
        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $handle = fopen($csvFile, 'r');
        $isFirstRow = true;

        while (($data = fgetcsv($handle)) !== false) {
            // Skip header
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }

            // Validasi jumlah kolom
            if (count($data) < 5) continue;

            // Data sanitasi
            $id_dokter = (int) $data[0];
            $nama = substr(trim($data[1]), 0, 100);
            $spesialisasi = substr(trim($data[2]), 0, 100);
            $jam_praktek = substr(trim($data[3]), 0, 100);
            $id_rumah_sakit = (int) $data[4];

            // Lewati jika data penting kosong
            if (!$id_dokter || !$id_rumah_sakit || $nama === '' || $spesialisasi === '' || $jam_praktek === '') {
                continue;
            }

            DB::table('dokter_rumah_sakit')->insert([
                'id_dokter' => $id_dokter,
                'nama' => $nama,
                'spesialisasi' => $spesialisasi,
                'jam_praktek' => $jam_praktek,
                'id_rumah_sakit' => $id_rumah_sakit,
            ]);
        }

        fclose($handle);
        $this->command->info('Dokter data seeded successfully.');
    }
}