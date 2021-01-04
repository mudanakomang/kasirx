<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use App\Konfigurasi;
use App\Pegawai;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrintController extends Controller
{
    public function line($str){
        return str_pad("",40,$str).PHP_EOL;
    }

    public function rows($left='',$mid='',$right='',$alignright=false){
        if ($alignright){
            if($left===''){
                $l=str_pad($left,11);
            }  else{
                $l=str_pad($left,20);
            }
            $m=str_pad($mid,15," ",STR_PAD_LEFT);
            $r=str_pad($right,25," ",STR_PAD_LEFT);
        }else{
            if($left===''){
                $l=str_pad($left,20);
            }  else{
                $l=str_pad($left,25);
            }

            $m=str_pad($mid,5);
            $r=str_pad($right,10," ",STR_PAD_LEFT);
        }
        return $l.$m.$r.PHP_EOL;
    }

    public function cetak($connector,$content){
        $konfig=Konfigurasi::first();
        $conn=new WindowsPrintConnector($connector);
        $printer=new Printer($conn);
        $printer->setLineSpacing(32);
        $printer->setFont(Printer::FONT_C);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
//        $printer->setTextSize(1,1);
        $img=EscposImage::load(public_path().'/images/logo1.png');
        $printer->bitImage($img);
        $printer->feed();

        $printer -> text($konfig->nama.PHP_EOL);
        $printer -> text($konfig->alamat.PHP_EOL);
        $printer -> text($konfig->nohp.PHP_EOL);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($this->line('='));
        $printer -> text($this->rows("TrxID #".$content->kode,"",""));
        $printer->text($this->line('='));
//        $printer->text($this->rows('Item X Qty','','Subtotal',true));
//        $printer->text($this->line('='));

        foreach ($content->paket as $paket){
            $printer->text($this->rows($paket->nama." X ".$paket->pivot->qty." @".number_format($paket->harga,0,"","."),"","",true));
            $printer->text($this->rows("Subtotal: ". number_format($paket->harga*$paket->pivot->qty,0,"","."),"","",true));
            $printer->text($this->rows("Terapis: ".Pegawai::find($paket->pivot->pegawai_id)->nama,'','',true));
            $printer->text($this->line('-'));
        }
        $printer->feed();
        $printer -> text($this->rows('',strtoupper($content->tipe_byr),''));



        $printer -> text($this->rows('','Harga :', formatRP(totalHarga($content)['total']),''));
        $printer->text($this->rows('','Diskon :',formatRp($content->diskon),""));
        $printer->text($this->rows('','Total :',formatRp(totalHarga($content)['harga']),''));

        $printer -> text($this->rows('','Dibayar :', formatRp($content->totalbayar)));
        //$printer -> setEmphasis(false);
        // $printer -> setEmphasis(true);
        $printer -> text($this->rows('','Kembali :',formatRp($content->totalbayar-totalHarga($content)['harga'])));
        //$printer -> setEmphasis(false);

        $printer->text($this->line('='));

        $printer -> text($konfig->footnote.PHP_EOL);
        $printer -> feed();
        $printer -> text(Carbon::now('Asia/Makassar')->format('d/m/Y H:i') . " by ".Auth::user()->name."\n");
        //$printer -> text('Terapis: '.$content->pegawai->nama);
        /* Cut the receipt and open the cash drawer */
        $printer->feed(2);

        $printer -> close();

    }

    public function cetakTrx(Request $request){


        $konfig=Konfigurasi::first();
        $printer=!empty($konfig->printer) ? $konfig->printer:'POS58';
        $trx=Transaksi::find($request->trxid);


        foreach ($trx->paket as $paket){
            DetailTransaksi::updateOrCreate([

                'kode_transaksi'=>$trx->kode,
                'transaksi_id'=>$trx->id,
                'paket'=>$paket->nama
            ],[

                'customer'=>$trx->customer_id,
                'harga_paket'=>$paket->harga,
                'paket_qty'=>$paket->pivot->qty,
                'harga_pokok'=>totalHarga($trx)['total'],
                'diskon'=>$trx->diskon,
                'total_harga'=>totalHarga($trx)['total']-$trx->diskon,
                'total_biaya'=>totalHarga($trx)['biaya'],
                'kembali'=>($trx->totalbayar)-totalHarga($trx)['harga'],
                'jumlah_bayar'=>$trx->totalbayar,
                'kasir'=>$trx->kasir->name,
                'terapis'=>Pegawai::find($paket->pivot->pegawai_id)->nama,
                'status'=>'selesai',
                'tgl_transaksi'=>now('Asia/Makassar')->format('Y-m-d H:i:s'),
            ]);
        }



        $this->cetak($printer,$trx);
        sleep(5);
        $this->cetak($printer,$trx);

        foreach ($trx->paket as $paket){
            foreach ($paket->barang as $barang){
                $stok=$barang->stok;
                $kebutuhan=$barang->pivot->kebutuhan;
                $sisa=$stok-$kebutuhan;
                $barang->update(['stok'=>$sisa]);
            }
        }
        $trx->update(['print'=>"y"]);


        return response('ok');
    }
}
