<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artikel>
 */
class ArtikelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(),
            'bahasan_penyakit' => $this->faker->word(),
            'isi' => $this->faker->paragraphs(3, true),
            'created_at' => now(),
            'penulis' => $this->faker->name(),
        ];
    }
}
