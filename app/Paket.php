<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    //
    protected $table='paket';
    protected $fillable=['nama','keterangan','harga','diskon'];

    public function barang(){
        return $this->belongsToMany(Barang::class,'paket_barang');
    }
    public function jasa(){
        return $this->belongsToMany(Jasa::class,'paket_jasa');
    }
}
