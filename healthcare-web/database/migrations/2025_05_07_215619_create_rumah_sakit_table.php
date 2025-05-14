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
        Schema::create('rumah_sakit', function (Blueprint $table) {
            $table->integer('id_rumah_sakit', true);
            $table->string('nama', 100)->nullable();
            $table->string('alamat')->nullable();
            $table->float('lat', 10, 6)->nullable();     // latitude
            $table->float('lng', 10, 6)->nullable();     // longitude
            $table->float('rating')->nullable();
            $table->string('kapasitas', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_sakit');
    }
};
