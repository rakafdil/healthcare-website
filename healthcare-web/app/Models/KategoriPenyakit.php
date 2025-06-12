<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPenyakit extends Model
{
    protected $table = 'kategori_penyakit';

    protected $fillable = ['nama'];

    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'kategori_penyakit_id');
    }
}
