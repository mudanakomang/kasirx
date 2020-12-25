<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePegawaiIdFromTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (Schema::hasColumn('transaksi','pegawai_id')){
           Schema::table('transaksi', function (Blueprint $table) {
               //
               $table->dropForeign(['pegawai_id']);
               $table->dropColumn('pegawai_id');
           });
       }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
        });
    }
}
