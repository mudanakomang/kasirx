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
    $harga=[];
    $biaya=0;
    foreach ($transaksi->paket as $paket){
        $qty=$paket->pivot->qty;
        $total+=$paket->harga*$qty;
        foreach ($paket->barang as $barang){
            $biaya+=$barang->harga*$barang->pivot->kebutuhan*$qty;
        }
        foreach ($paket->jasa as $jasa) {
            $biaya+=$jasa->harga*$qty;
        }
    }

    $totalbyr=$total-$transaksi->diskon;

    $harga['total']=$total;
    $harga['diskon']=$transaksi->diskon;
    $harga['harga']=$totalbyr;
    $harga['biaya']=$biaya;
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
    $total_transaksi=0;
    foreach ($tr as $t){
        $total_harga_paket=0;
        $total_biaya_paket=0;
        $total_keuntungan_paket=0;
        foreach ($t->paket as $paket){
            $total_biaya_barang=0;
            $total_biaya_jasa=0;
            $qty=$paket->pivot->qty;
            $total_harga_paket+=$paket->harga*$qty;
            foreach ($paket->barang as $barang){
                $total_biaya_barang+=$barang->pivot->kebutuhan*$barang->harga*$qty;
            }

            foreach ($paket->jasa as $jasa){
                $total_biaya_jasa+=$jasa->harga*$qty;
            }

            $total_biaya_paket+=$total_biaya_barang+$total_biaya_jasa;

        }
        $total_keuntungan_paket+=$total_harga_paket-$total_biaya_paket;
        $profit+=$total_keuntungan_paket-$t->diskon;
//        dd($total_keuntungan_paket);
//
//        dd($total_biaya_paket);
//        dd($total_harga_paket);
        $omzet+=$total_harga_paket-$t->diskon;
    }

    return ['omzet'=>formatRp($omzet),'profit'=>formatRp($profit)];
}

function OmsetProfit(){
    $omset=0;
    $biaya=0;
    $profit=0;
    $tr=\App\DetailTransaksi::whereDate('updated_at',today('Asia/Makassar'))->where('status','selesai')->get();
    foreach ($tr->unique('kode_transaksi') as $t){
        $omset+=$t->total_harga;
        $biaya+=$t->total_biaya;
    }
    $profit+=$omset-$biaya;
    return ['omset'=>formatRp($omset),'profit'=>formatRp($profit)];
}

function randomColor(){

    $s= sprintf('#%06X', mt_rand(0x00FF00, 0xFFFF00));
    return (string)$s;

}