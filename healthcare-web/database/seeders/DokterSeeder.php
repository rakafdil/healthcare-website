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

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 5) continue;

            DB::table('dokter_rumah_sakit')->insert([
                'id_dokter' => $data[0],
                'nama' => $data[1],
                'spesialisasi' => $data[2],
                'jam_praktek' => $data[3],
                'id_rumah_sakit' => $data[4],
            ]);
        }

        fclose($handle);
    }
}
