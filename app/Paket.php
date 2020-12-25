<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    //
    protected $table='paket';
    protected $fillable=['nama','keterangan','harga','diskon','status'];

    public function barang(){
        return $this->belongsToMany(Barang::class,'paket_barang')->withPivot(['kebutuhan']);
    }
    public function jasa(){
        return $this->belongsToMany(Jasa::class,'paket_jasa');
    }

    public function transaksi(){
        return $this->belongsToMany(Transaksi::class,'paket_transaksi')->withPivot(['qty','pegawai_id']);
    }


}
