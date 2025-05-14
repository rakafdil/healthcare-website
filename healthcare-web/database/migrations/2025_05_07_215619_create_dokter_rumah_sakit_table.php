<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokter_rumah_sakit', function (Blueprint $table) {
            $table->integer('id_dokter');
            $table->string('nama', 100);
            $table->string('spesialisasi', 100);
            $table->string('jam_praktek', 100);
            $table->integer('id_rumah_sakit')->index('id_rumah_sakit');

            $table->primary(['id_dokter', 'id_rumah_sakit']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter_rumah_sakit');
    }
};
