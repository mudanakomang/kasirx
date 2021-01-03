<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;



class LaporanController extends Controller
{
    //

    public function transaksi(Request $request){
        $transaksi=DetailTransaksi::whereDate('updated_at','=',today('Asia/Makassar'))->get();
        return view('laporan.transaksi',['transaksi'=>$transaksi]);
    }
    public function transaksiPost(Request $request){
       if (empty($request->datemin)){
            $datemax=Carbon::parse($request->datemax)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','<=',$datemax)->get();
       }elseif ($request->method()=='POST' && empty($request->datemax)){
            $datemin=Carbon::parse($request->datemin)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',$datemin)->get();
       }else{
            $datemin=Carbon::parse($request->datemin)->timezone('Asia/Makassar')->format('Y-m-d');
            $datemax=Carbon::parse($request->datemax)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',$datemin)->whereDate('updated_at','<=',$datemax)->get();
       }
        return view('laporan.transaksi',['transaksi'=>$transaksi,'datemin'=>$request->datemin,'datemax'=>$request->datemax]);
    }

    public function exportTransaksi(Request $request){

        if (empty($request->min) && !empty($request->max)){
            $title="Laporan Transaksi ".$request->max;
            $datemax=Carbon::parse($request->max)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','<=',$datemax)->get();
        }elseif ( empty($request->max) && !empty($request->min)){
            $title="Laporan Transaksi ".$request->min;
            $datemin=Carbon::parse($request->min)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',$datemin)->get();
        }elseif(empty($request->min) && empty($request->max)){
            $title ="Laporan Transaksi";
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',today('Asia/Makassar')->format('Y-m-d'))->get();
        }else{
            $title="Laporan Transaksi ".$request->min. " - ". $request->max;
            $datemin=Carbon::parse($request->min)->timezone('Asia/Makassar')->format('Y-m-d');
            $datemax=Carbon::parse($request->max)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',$datemin)->whereDate('updated_at','<=',$datemax)->get();
        }

        Excel::create($title,function ($excel) use($transaksi,$title) {
            $excel->setTitle($title);
            $excel->setCreator("Nerrisa Beauty House");
            $data=[["Kode Transaksi","Tipe Pembayaran","Harga Pokok","Diskon","Total Harga","Biaya","Keuntungan","Tanggal Transaksi"]];
            foreach ($transaksi->unique('kode_transaksi') as $key=>$value){
                $profit=$value->total_harga-$value->total_biaya;
                $tipebyr=!empty($value->transaksi) ? strtoupper($value->transaksi->tipe_byr):'';
                array_push($data,[$value->kode_transaksi,$tipebyr,$value->harga_pokok,$value->diskon,$value->total_harga,$value->total_biaya,$profit,$value->tgl_transaksi]);
            }
            $excel->sheet('Sheet 1',function ($sheet) use ($data){
              $index=count($data)+2;
              $sheet->setOrientation('landscape');
              $sheet->fromArray($data,NULL,'A0');

              $sheet->cell('G'.($index+2),function ($cell) use($data){
                  $cell->setValue('=SUM(G1:G'.count($data).')');
              });

              $sheet->cell('G'.($index+1),function ($cell) use($data){
                    $cell->setValue('=SUM(F1:F'.count($data).')');
                });
              $sheet->cell('G'.($index),function ($cell) use($data){
                    $cell->setValue('=SUM(E1:E'.count($data).')');
                });

                $sheet->cell('F'.($index),function ($cell) use($data){
                    $cell->setValue('Total Omset :');
                });
                $sheet->cell('F'.($index+1),function ($cell) use($data){
                    $cell->setValue('Total Biaya :');
                });
                $sheet->cell('F'.($index+2),function ($cell) use($data){
                    $cell->setValue('Total Profit :');
                });
            });
        })->download('xlsx');

    }
}
