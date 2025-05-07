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
        Schema::create('gejala', function (Blueprint $table) {
            $table->integer('id_gejala', true);
            $table->string('nama_gejala_ind', 150)->nullable();
            $table->string('nama_gejala_eng', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};
