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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_pemesanan');
            $table->dateTime('tgl_penjemputan');
            $table->dateTime('tgl_pengantaran')->nullable();
            $table->time('jam_jemput');
            $table->time('jam_antar')->default('00:00:00');
            $table->string('alamat');
            $table->string('no_telp');
            $table->enum('status_pemesanan', ['pesanan belum diproses', 'kurir jemput pesanan',  'pesanan sedang diproses', 'kurir antar pesanan','pesanan selesai', 'pesanan ditolak'])->default('pesanan belum diproses');
            $table->string('alasan_penolakan')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('id_kurir')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_layanan');

            $table->foreign('id_kurir')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_layanan')->references('id')->on('layanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropForeign(['courier_id']);
            $table->dropColumn('courier_id');
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
    });
}
};
