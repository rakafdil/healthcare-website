<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'tabel_artikel'; 
    protected $guarded = ['id'];

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
    'judul',
    'penulis',
    'gambar',
    'bahasan_penyakit', 
    'isi',
    'kategori_penyakit_id'
    ];

     public function kategori()
    {
        return $this->belongsTo(KategoriPenyakit::class, 'kategori_penyakit_id');
    }

    // Tentukan kolom yang tidak bisa diisi (bisa kosong jika tidak ada)
    // protected $guarded = ['id'];
}
