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
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('sip', 50)->unique();
            $table->string('pengalaman', 255);

            $table->string('foto', 255)->nullable();
            $table->unsignedBigInteger('spesialisasi_id');
            $table->foreign('spesialisasi_id')->references('id')->on('spesialisasi');
            $table->time('mulai_praktik');
            $table->time('selesai_praktik');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
