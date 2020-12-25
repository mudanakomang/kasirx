<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table='transaksi';
    protected $fillable=['kode','tipe_byr','catatan','user_id','totalbayar','print','customer_id','diskon'];

    public function paket(){
        return $this->belongsToMany(Paket::class,'paket_transaksi')->withPivot(['qty','pegawai_id']);
    }


    public function transaksiBatal(){
        return $this->hasOne(TransaksiBatal::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function kasir(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function detail(){
        return $this->hasMany(DetailTransaksi::class,'transaksi_id');
    }
}
