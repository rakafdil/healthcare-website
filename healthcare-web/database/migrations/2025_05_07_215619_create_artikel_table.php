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
            Schema::create('tabel_artikel', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('judul', 255)->nullable();
            $table->string('penulis', 100)->nullable();
            $table->string('gambar')->nullable();
            $table->string('bahasan_penyakit', 100)->nullable();
            $table->text('isi')->nullable();
            $table->string('link')->nullable();
            $table->dateTime('created_at')->nullable(); // ganti jadi dateTime biar akurat
            $table->dateTime('updated_at')->nullable(); // ✅ Tambahkan ini
            
           
            $table->unsignedBigInteger('kategori_penyakit_id')->nullable(); // ✅ ini aman


            $table->foreign('kategori_penyakit_id')->references('id')->on('kategori_penyakit')->onDelete('set null');


        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_artikel');
    }

    
};
