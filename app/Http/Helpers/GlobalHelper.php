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
        $diskon+=$qty*$paket->diskon;

    }
    $totalbyr=$total-$diskon;

    $harga['total']=$total;
    $harga['diskon']=$diskon;
    $harga['harga']=$totalbyr;
    return $harga;

}

function sumPaket($arry){
    $sumArray = [];

    foreach ($arry as $agentInfo) {

        // create new item in result array if pair 'id'+'name' not exists
        if (!isset($sumArray[$agentInfo['nama']])) {
            $sumArray[$agentInfo['nama']] = $agentInfo;
        } else {
            // apply sum to existing element otherwise
            $sumArray[$agentInfo['nama']]['qty'] += $agentInfo['qty'];
        }
    }

// optional action to flush keys of array
    $sumArray = array_values($sumArray);

    return $sumArray;
}

function grosProfit(){
    $profit=0;
    $omzet=0;
    $tr=\App\Transaksi::whereDate('created_at',today('Asia/Makassar'))->where('print','y')->whereDoesntHave('transaksiBatal')->get();
    foreach ($tr as $t){
        foreach ($t->paket as $paket){
          $qty=$paket->pivot->qty;
          $omzet+=($qty*$paket->harga)-($qty*$paket->diskon);

          $harga=($qty*$paket->harga)-($qty*$paket->diskon);
          $hargatotal=0;
            foreach ($paket->barang as $barang){
               $hargatotal+=$barang->pivot->kebutuhan*$qty*$barang->harga;
            }
            $profit+=$harga-$hargatotal;
        }

    }
    return ['omzet'=>formatRp($omzet),'profit'=>formatRp($profit)];
}