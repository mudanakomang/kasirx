<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    //
   protected $table='jasa';
   protected $fillable=['nama','keterangan','harga','diskon'];

   public function paket(){
       return $this->belongsToMany(Paket::class,'paket_jasa');
   }
}
