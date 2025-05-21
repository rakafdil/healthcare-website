<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala';
    protected $primaryKey = 'id_gejala';
    protected $fillable = ['nama_gejala_ind', 'nama_gejala_eng'];
    public $timestamps = false;

    public function sessions()
    {
        return $this->belongsToMany(DiagnosisSession::class, 'session_gejala', 'id_gejala', 'id_session');
    }
}
