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
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->foreign(['id_gejala'], 'diagnosis_ibfk_1')->references(['id_gejala'])->on('gejala')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->dropForeign('diagnosis_ibfk_1');
        });
    }
};
