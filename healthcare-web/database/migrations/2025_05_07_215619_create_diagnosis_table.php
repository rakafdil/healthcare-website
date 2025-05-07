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
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->integer('id_diagnosa', true);
            $table->integer('id_gejala')->index('id_gejala');
            $table->string('nama_penyakit_ind', 150)->nullable();
            $table->string('nama_penyakit_eng', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis');
    }
};
