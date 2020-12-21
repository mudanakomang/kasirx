<?php

function formatRp($num){
   return "Rp. ".  number_format($num,0,",",".");
}
function formatPersen($num){
    return $num. " %";
}

function statusPaket($paket){
//    $hasempty=$paket->whereHas('barang',function ($q){
//        return $q->where('stok','<=',0);
//    })->count();
//    if($hasempty>0){
//        return 0;
//    }else{
//        return 1;
//    }
    $st=[];
    foreach ($paket->barang as $barang){
        if ($barang->stok<$barang->pivot->kebutuhan){
           array_push($st,0);
        }else{
            array_push($st,1);
        }
    }
    if (in_array(0,$st)){
        return 0;
    }else{
        return 1;
    }

}

function totalHarga($transaksi){
    $total=0;
    $diskon=0;
    $harga=[];
    foreach ($transaksi->paket as $paket){
        $qty=$paket->pivot->qty;
        $total+=$paket->harga*$qty;
        $diskon+=$qty*($paket->harga*$paket->diskon/100);

    }
    $totalbyr=$total-$diskon;

    $harga['total']=$total;
    $harga['diskon']=$diskon;
    $harga['harga']=$totalbyr;
    return $harga;

}