<?php

function formatRp($num){
   return "Rp. ".  number_format($num,0,",",".");
}
function formatPersen($num){
    return $num. " %";
}

function statusPaket($paket){
    $hasempty=$paket->whereHas('barang',function ($q){
        return $q->where('stok','<=',0);
    })->count();
    if($hasempty>0){
        return 0;
    }else{
        return 1;
    }
}