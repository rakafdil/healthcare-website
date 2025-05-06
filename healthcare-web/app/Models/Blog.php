<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'blogs'; 

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'judul',
        'konten',
        'penulis',
        'created_at',
        'isi',
    ];

    // Tentukan kolom yang tidak bisa diisi (bisa kosong jika tidak ada)
    // protected $guarded = ['id'];
}
