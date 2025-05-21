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
        Schema::create('session_gejala', function (Blueprint $table) {
            $table->unsignedBigInteger('id_session');
            $table->unsignedBigInteger('id_gejala');

            $table->primary(['id_session', 'id_gejala']);
            $table->foreign('id_session')->references('id_session')->on('diagnosis_session')->onDelete('cascade');
            $table->foreign('id_gejala')->references('id_gejala')->on('gejala')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_gejala');
    }
};
