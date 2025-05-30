<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisResult extends Model
{
    protected $table = 'diagnosis_result';
    public $incrementing = false;
    protected $fillable = ['id_session', 'nama_penyakit', 'probabilitas', 'deskripsi', 'precautions'];
    public $timestamps = false;

    public function session()
    {
        return $this->belongsTo(DiagnosisSession::class, 'id_session');
    }
}
