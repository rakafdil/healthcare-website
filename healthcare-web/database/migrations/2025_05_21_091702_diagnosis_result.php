<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diagnosis_result', function (Blueprint $table) {
            $table->id('id_result');
            $table->unsignedBigInteger('id_session');
            $table->string('nama_penyakit', 150);
            $table->float('probabilitas');
            $table->text('deskripsi')->nullable();
            $table->text('precautions')->nullable();

            $table->foreign('id_session')->references('id_session')->on('diagnosis_session')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_result');
    }
};
