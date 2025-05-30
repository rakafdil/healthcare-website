<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/rumah_sakit_no_header.csv');
        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $handle = fopen($csvFile, 'r');
        while (($data = fgetcsv($handle)) !== false) {
            // $data: [name, address, latitude, longitude, rating, review_count]
            DB::table('rumah_sakit')->insert([
                'nama' => $data[0],
                'alamat' => $data[1],
                'lat' => $data[2],
                'lng' => $data[3],
                'rating' => $data[4],
                'kapasitas' => $data[5],
            ]);
        }
        fclose($handle);
    }
}
