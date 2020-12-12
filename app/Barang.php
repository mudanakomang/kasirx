<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    protected $table='barang';
    protected $fillable=['nama','keterangan','jenis_id','stok','satuan','sku','harga','diskon'];

    public function jenisBarang(){
        return $this->belongsTo(JenisBarang::class,'jenis_id');
    }

    public function paket(){
        return $this->belongsToMany(Paket::class,'paket_barang');
    }
}
