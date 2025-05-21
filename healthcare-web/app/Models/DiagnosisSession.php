<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisSession extends Model
{
    protected $table = 'diagnosis_session';
    protected $primaryKey = 'id_session';
    protected $fillable = ['user_id', 'created_at'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'session_gejala', 'id_session', 'id_gejala');
    }

    public function results()
    {
        return $this->hasMany(DiagnosisResult::class, 'id_session');
    }
}
