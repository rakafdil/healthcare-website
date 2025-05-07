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
        Schema::create('blog', function (Blueprint $table) {
            $table->integer('id_blog', true);
            $table->string('judul', 150)->nullable();
            $table->string('bahasan_penyakit', 100)->nullable();
            $table->text('isi')->nullable();
            $table->date('created_at')->nullable();
            $table->string('penulis', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
