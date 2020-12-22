<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiBatal extends Model
{
    //
    protected $table='transaksi_batal';
    protected  $fillable=['transaksi_id','user_id','keterangan'];

    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
