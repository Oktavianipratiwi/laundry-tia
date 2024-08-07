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
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_layanan');
            $table->string('harga'); // Harga dalam bentuk decimal (8 digit, 2 digit di belakang koma)
            $table->enum('jenis_satuan', ['satuan', 'kiloan']);
            $table->enum('durasi_layanan', ['2 hari', '12 jam']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
