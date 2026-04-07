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
        Schema::create('chat', function (Blueprint $table) {
            $table->id();
            $table->string('pesan', 255);

            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('member');;

            $table->unsignedBigInteger('dokter_id');
            $table->foreign('dokter_id')->references('id')->on('dokter');;

            $table->unsignedBigInteger('konsultasi_id');
            $table->foreign('konsultasi_id')->references('id')->on('konsultasi');;

            $table->timestamp('waktu_kirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
