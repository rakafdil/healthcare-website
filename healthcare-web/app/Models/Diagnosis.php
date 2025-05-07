<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    // Tabel yang dipakai (opsional kalau nama model = nama tabel jamak)
    protected $table = 'diagnoses';

    // Kolom yang bisa diisi massal (penting untuk seeder / create)
    protected $fillable = [
        'name_en',
        'name_id',
    ];
}
