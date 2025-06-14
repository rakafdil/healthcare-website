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
        'isi',
        'link',
    ];


    public static function getArticlesByDisease($disease)
    {
        return self::where('judul', 'LIKE', "%{$disease}%")
            ->orWhere('isi', 'LIKE', "%{$disease}%")
            ->take(3)
            ->get();
    }

    // Tentukan kolom yang tidak bisa diisi (bisa kosong jika tidak ada)
    // protected $guarded = ['id'];
}
