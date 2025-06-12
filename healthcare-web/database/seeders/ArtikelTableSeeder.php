<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel; 

class ArtikelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artikel::factory()->count(20)->create();
    }
}
