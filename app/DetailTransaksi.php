<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    //
    protected $table='detail_transaksi';
    protected $fillable=['transaksi_id','kode_transaksi','customer','paket','harga_paket','paket_qty','harga_pokok','diskon','total_harga','jumlah_bayar','kembali','kasir','terapis','status','tgl_transaksi','tgl_batal'];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer');
    }
}
