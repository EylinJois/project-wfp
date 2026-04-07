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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu');
            $table->string('status', 20);
            $table->enum('jenis_konsultasi', ['kosong', 'sedang berlangsung', 'selesai'])->default('kosong');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('member');
            $table->unsignedBigInteger('dokter_id');
            $table->foreign('dokter_id')->references('id')->on('dokter');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
