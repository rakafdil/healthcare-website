<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPenyakitSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_penyakit')->insert([
             ['id' => 1, 'nama' => 'Umum'],
            ['id' => 2, 'nama' => 'Penyakit Jantung'],
            ['id' => 3, 'nama' => 'Diabetes'],
        ]);
    }
}
