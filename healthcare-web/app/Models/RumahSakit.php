<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    protected $table = 'rumah_sakit';
    protected $primaryKey = 'id_rumah_sakit';
    public $timestamps = false; // Karena kamu tidak pakai `created_at` dan `updated_at`
}
