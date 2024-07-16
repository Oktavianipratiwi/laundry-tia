<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pakaian_id');
            $table->unsignedBigInteger('pemesanan_id');
            $table->float('total_berat');
            $table->integer('diskon')->default(0);
            $table->dateTime('tgl_ditimbang');
            $table->dateTime('tgl_diambil')->nullable();
            $table->float('total_bayar');
            $table->enum('status_pembayaran', ['belum lunas', 'lunas'])->default('belum lunas');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pakaian_id')->references('id')->on('pakaian')->onDelete('cascade');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
