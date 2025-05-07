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
        Schema::table('history', function (Blueprint $table) {
            $table->foreign(['id_user'], 'history_ibfk_1')->references(['id_user'])->on('user')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_diagnosa'], 'history_ibfk_2')->references(['id_diagnosa'])->on('diagnosis')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropForeign('history_ibfk_1');
            $table->dropForeign('history_ibfk_2');
        });
    }
};
