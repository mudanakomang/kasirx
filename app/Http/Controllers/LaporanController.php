<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DetailTransaksi;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $transaksi=DetailTransaksi::whereDate('updated_at','<=',$datemax)->where('status','selesai')->get();
        }elseif ( empty($request->max) && !empty($request->min)){
            $title="Laporan Transaksi ".$request->min;
            $datemin=Carbon::parse($request->min)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',$datemin)->where('status','selesai')->get();
        }elseif(empty($request->min) && empty($request->max)){
            $title ="Laporan Transaksi";
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',today('Asia/Makassar')->format('Y-m-d'))->where('status','selesai')->get();
        }else{
            $title="Laporan Transaksi ".$request->min. " - ". $request->max;
            $datemin=Carbon::parse($request->min)->timezone('Asia/Makassar')->format('Y-m-d');
            $datemax=Carbon::parse($request->max)->timezone('Asia/Makassar')->format('Y-m-d');
            $transaksi=DetailTransaksi::whereDate('updated_at','>=',$datemin)->whereDate('updated_at','<=',$datemax)->where('status','selesai')->get();
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

    public function treatment(){
        $bulan=today('Asia/Makassar')->format('m');
        $tahun=today('Asia/Makassar')->format('Y');
        $tr=DetailTransaksi::with('pelanggan')->where('status','selesai')->whereMonth('updated_at',$bulan)->whereYear('updated_at',$tahun)->get();
        return view('laporan.treatment',['treatment'=>$tr]);
    }

    public function treatmentPost(Request $request){
       $bulan= Carbon::parse($request->bulan)->format('m');
       $tahun= Carbon::parse($request->bulan)->format('Y');
       $tr=DetailTransaksi::with('pelanggan')->where('status','selesai')->whereMonth('updated_at',$bulan)->whereYear('updated_at',$tahun)->get();

       return view('laporan.treatment',['treatment'=>$tr,'bulan'=>$tahun.'-'.$bulan]);
    }
    public function treatmentExport(Request $request){
        $bulan= Carbon::parse($request->bln)->format('m');
        $tahun= Carbon::parse($request->bln)->format('Y');
        $tr=DetailTransaksi::with('pelanggan')->where('status','selesai')->whereMonth('updated_at',$bulan)->whereYear('updated_at',$tahun)->get();

        $treatment=[];
        $terapis=$tr->groupBy('terapis');
        foreach ($terapis as $key=>$t){
           $paket=$t->groupBy('paket');
           foreach ($paket as $k=>$p){
               $treatment[$key][$k]=$p->sum('paket_qty');
           }

        }

        Excel::create("Laporan Treatment ".$tahun."-".$bulan,function ($excel) use($tr,$treatment){
            $excel->setTitle("Laporan Treatment");
            $excel->setCreator("Nerrisa Beauty House");
            $data=[["Kode Transaksi","Tanggal","Pegawai","Customer","Paket","Jumlah","Harga"]];
            foreach ($tr as $key=>$value){
                array_push($data,[$value->kode_transaksi,$value->tgl_transaksi,$value->terapis,$value->pelanggan->nama,$value->paket,$value->paket_qty,$value->harga_paket]);
            }
            $excel->sheet('Sheet 1',function ($sheet) use ($data,$treatment) {
                $index = count($data) + 2;
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A0');
                $sheet->cell('A'.$index,function ($cell) use ($treatment){
                    $cell->setValue("Summary");
                });
                $sheet->cell('A'.($index+1),function ($cell) use ($treatment){
                    $cell->setValue("Terapis");
                });
                $sheet->cell('B'.($index+1),function ($cell) use ($treatment){
                    $cell->setValue("Paket");
                });
                $sheet->cell('C'.($index+1),function ($cell) use ($treatment){
                    $cell->setValue("Jumlah Treatment");
                });
                $counttrp=count($data)+4;
                foreach ($treatment as $key=>$terapis){
                    $sheet->cell('A'.($counttrp),function ($cell) use($key){
                        $cell->setValue($key);
                    });
                    $count=$counttrp;
                    foreach ($terapis as $k=>$paket){

                        $sheet->cell('B'.($count),function ($cell) use($k){
                            $cell->setValue($k);
                        });
                        $sheet->cell('C'.($count),function ($cell) use($k,$paket){
                            $cell->setValue($paket);
                        });
                        $count+=1;

                    }
                    $counttrp=$count;
                }
            });


        })->download('xlsx');
    }

    public function inventory(){
        $inventory=Barang::all();
        return view('laporan.inventory',['inventory'=>$inventory]);
    }
    public function inventoryExport(Request $request){
        $inventory=Barang::all();
        Excel::create("Laporan Stok Barang",function ($excel) use($inventory){
            $excel->setCreator("Nerrisa Beauty House");
            $data=[["Nama Barang","Keterangan","Jenis","Stok","Satuan","Harga/Satuan","Nilai Stok"]];
            foreach ($inventory as $key=>$inv){
                array_push($data,[$inv->nama,$inv->keterangan,$inv->jenisBarang->jenis,$inv->stok,$inv->satuan,$inv->harga,$inv->stok*$inv->harga]);
            }
            $excel->sheet('Sheet 1',function ($sheet) use($data){
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, NULL, 'A0');
                $sheet->cell('F'.(count($data)+2),function ($cell){
                    $cell->setValue("Total Nilai Stok :");
                });
                $sheet->cell('G'.(count($data)+2),function ($cell) use($data){
                    $cell->setValue('=SUM(G1:G'.count($data).')');
                });
            });
        })->download('xlsx');
    }
}
