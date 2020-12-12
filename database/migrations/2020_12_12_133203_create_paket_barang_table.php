<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaketBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_barang', function (Blueprint $table) {
           $table->unsignedBigInteger('paket_id');
           $table->foreign('paket_id')->references('id')->on('paket')->onDelete('cascade');
           $table->unsignedBigInteger('barang_id');
           $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_barang');
    }
}
