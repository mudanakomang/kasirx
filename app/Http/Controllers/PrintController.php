<?php

namespace App\Http\Controllers;

use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
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
        $conn=new WindowsPrintConnector($connector);
        $printer=new Printer($conn);
        $printer->setFont(Printer::FONT_C);
//        $printer->setTextSize(1,1);
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Toko\n");
        $printer -> text("Alamat\n");
        $printer -> text("NoHP\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($this->line('='));
        $printer -> text($this->rows("TrxID #".$content->kode,"",""));
        $printer->text($this->line('='));
//        $printer->text($this->rows('Item X Qty','','Subtotal',true));
//        $printer->text($this->line('='));

        foreach ($content->paket as $paket){
            $printer->text($this->rows($paket->nama." X ".$paket->pivot->qty,"","",true));
            $printer->text($this->rows("Subtotal: ". number_format($paket->harga*$paket->pivot->qty,0,"","."),"","",true));
            if ($paket->diskon>0){
                $harga=number_format(($paket->harga*$paket->pivot->qty)-($paket->pivot->qty*($paket->harga-($paket->harga*$paket->diskon/100))),0,"",".");
                $printer->text($this->rows('Disc ('.$paket->diskon.'%) '." -".$harga,"",""));
            }
            $printer->text($this->line('-'));
        }
        $printer->feed();

        $printer -> text($this->rows('','Total :', formatRP(totalHarga($content)['harga'])));
        $printer -> text($this->rows('','Dibayar :', formatRp($content->totalbayar)));
        //$printer -> setEmphasis(false);
        // $printer -> setEmphasis(true);
        $printer -> text($this->rows('','Kembali :',formatRp($content->totalbayar-totalHarga($content)['harga'])));
        //$printer -> setEmphasis(false);

        $printer->text($this->line('='));
        $printer->feed();
        $printer -> text("Terima kasih \n");
        $printer -> feed();
        $printer -> text(Carbon::now('Asia/Makassar')->format('d/m/Y H:i') . " by ".Auth::user()->name."\n");
        /* Cut the receipt and open the cash drawer */
        $printer->feed(2);

        $printer -> close();

    }

    public function cetakTrx(Request $request){
        $trx=Transaksi::find($request->trxid);
        $this->cetak('POS58',$trx);
        usleep(5000);
        $this->cetak('POS58',$trx);
        $trx->update(['print'=>"y"]);



        return response('ok');
    }
}
