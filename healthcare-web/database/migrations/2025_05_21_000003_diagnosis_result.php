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
            $table->unsignedBigInteger('id_session');

            $table->string('nama_penyakit');
            $table->text('deskripsi');
            $table->text('precautions');
            $table->float('probabilitas');

            $table->timestamps();

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
