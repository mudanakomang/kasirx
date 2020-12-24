<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('transaksi_id')->unsigned();
            $table->string('kode_transaksi');
            $table->string('customer');
            $table->string('paket');
            $table->float('harga_paket',12,2);
            $table->integer('paket_qty');
            $table->float('harga_pokok',12,2);
            $table->float('diskon',12,2);
            $table->float('total_harga',12,2);
            $table->float('jumlah_bayar',12,2);
            $table->float('kembali',12,2);
            $table->string('kasir');
            $table->string('terapis');
            $table->enum('status',['selesai','batal'])->default('selesai');
            $table->dateTime('tgl_transaksi');
            $table->dateTime('tgl_batal')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi');
    }
}
