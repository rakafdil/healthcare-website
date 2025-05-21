<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'rumah_sakit';
    
    /**
     * Primary key untuk tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_rumah_sakit';
    
    /**
     * Menentukan apakah model menggunakan timestamp.
     * Karena tabel rumah_sakit tidak memiliki kolom created_at dan updated_at.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Atribut yang dapat diisi (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'alamat',
        'lat',
        'lng',
        'rating',
        'kapasitas'
    ];
    
    /**
     * Atribut yang harus dikonversi ke tipe data native.
     *
     * @var array
     */
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'rating' => 'float'
    ];
}