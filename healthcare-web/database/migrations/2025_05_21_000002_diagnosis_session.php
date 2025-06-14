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
        Schema::create('diagnosis_session', function (Blueprint $table) {
            $table->bigIncrements('id_session');
            $table->unsignedBigInteger('user_id');
            $table->integer('umur');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_session');
    }
};
