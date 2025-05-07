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
        Schema::table('dokter_rumah_sakit', function (Blueprint $table) {
            $table->foreign(['id_dokter'], 'dokter_rumah_sakit_ibfk_1')->references(['id_dokter'])->on('dokter')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_rumah_sakit'], 'dokter_rumah_sakit_ibfk_2')->references(['id_rumah_sakit'])->on('rumah_sakit')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokter_rumah_sakit', function (Blueprint $table) {
            $table->dropForeign('dokter_rumah_sakit_ibfk_1');
            $table->dropForeign('dokter_rumah_sakit_ibfk_2');
        });
    }
};
