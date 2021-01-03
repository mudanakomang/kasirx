<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    //
    protected $table='detail_transaksi';
    protected $fillable=['transaksi_id','kode_transaksi','customer','paket','harga_paket','paket_qty','harga_pokok','diskon','total_harga','total_biaya','jumlah_bayar','kembali','kasir','terapis','status','tgl_transaksi','tgl_batal'];

    public function pelanggan(){
        return $this->belongsTo(Customer::class,'customer');
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
}
