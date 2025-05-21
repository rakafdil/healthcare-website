<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokterRumahSakit extends Model
{
    protected $table = 'dokter_rumah_sakit';

    // Laravel tidak mendukung composite key langsung, jadi disable auto-incrementing & timestamps
    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = null; // Karena menggunakan composite key

    // Jika perlu, isi dengan daftar kolom yang bisa diisi massal
    protected $fillable = [
        'id_dokter',
        'nama',
        'spesialisasi',
        'jam_praktek',
        'id_rumah_sakit',
    ];

    // Jika ingin menambahkan relasi ke model RumahSakit atau Dokter
    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class, 'id_rumah_sakit');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }
}
