<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKebutuhanToPaketBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paket_barang', function (Blueprint $table) {
            //
            $table->float('kebutuhan',5,2)->after('barang_id')->default(0);
            $table->string('satuan')->after('kebutuhan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paket_barang', function (Blueprint $table) {
            //
            $table->dropColumn('kebutuhan');
            $table->dropColumn('satuan');
        });
    }
}
