<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPegawaiIdToPaketTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paket_transaksi', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('pegawai_id')->after('qty')->nullable();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('paket_tansaksi','pegawai_id')){
            Schema::table('paket_transaksi', function (Blueprint $table) {
                $table->dropForeign(['pegawai_id']);
                $table->dropColumn('pegawai_id');
            });
        }

    }
}
