<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    //
    protected $table='jenis_barang';
    protected $fillable=['jenis','keterangan'];

    public function barang(){
        return $this->hasMany(Barang::class,'jenis_id');
    }
}
