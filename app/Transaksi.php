<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table='transaksi';
    protected $fillable=['kode','tipe_byr','catatan','pegawai_id','user_id','totalbayar','print'];

    public function paket(){
        return $this->belongsToMany(Paket::class,'paket_transaksi')->withPivot(['qty']);
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }

    public function transaksiBatal(){
        return $this->hasOne(TransaksiBatal::class);
    }
}
