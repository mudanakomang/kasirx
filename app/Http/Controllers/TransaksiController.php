<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DetailTransaksi;
use App\Pegawai;
use App\Transaksi;
use App\TransaksiBatal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    //

    public function index(){
        $transaksi=Transaksi::orderBy('created_at','asc')->get();
        return view('transaksi.index',['transaksi'=>$transaksi]);
    }

    public function detail($id){
        $transaksi=DetailTransaksi::where('transaksi_id',$id)->get() ;
        return view('transaksi.detail',['transaksi'=>$transaksi]);
    }
    public function detailx($id){
        $transaksi=DetailTransaksi::find($id) ;
        return view('transaksi.detailx',['transaksi'=>$transaksi]);
    }


    public function tambahTransaksi(){

        if (!empty($_COOKIE['kode'])){
            $trx=Transaksi::where('kode',$_COOKIE['kode'])->first();
            return view('transaksi.tambah',['transaksi'=>$trx]);
        }else{
            return view('transaksi.tambah');
        }

        //$kode=Carbon::now('Asia/Makassar')->format('YmdHis');

    }

    public function cekTrx(Request $request){
        $trx=Transaksi::where('kode','=',$request->kode)->count();
        if ($trx>0){
            return response('ok');
        }else{
            return response('no');
        }
    }

    public function saveTrx(Request $request){
        Transaksi::updateOrCreate(['kode'=>$request->kode],['customer_id'=>$request->customer,'user_id'=>Auth::user()->id,'created_at'=>Carbon::now('Asia/Makassar')->format('Y-m-d H:i:s')]);
        $trx=Transaksi::where('kode',$request->kode)->first();

        foreach ($trx->paket as $paket){
            DetailTransaksi::updateOrCreate([
                'kode_transaksi'=>$trx->kode
            ],[
                'transaksi_id'=>$trx->id,
                'customer'=>$trx->customer_id,
                'paket'=>$paket->nama,
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
                'status'=>'pending',
                'tgl_transaksi'=>now('Asia/Makassar')->format('Y-m-d H:i:s'),
            ]);
        }
        return response('ok');
    }

    public function itemAddTrx(Request $request){
        $trx=Transaksi::where('kode',$request->kode)->first();
        if (count($trx->paket->where('id',$request->paket))>0){
            return response('exists');
        }else{
            $rules=[
                'paket'=>'required',
                'qty'=>'required',
                'pegawai'=>'required'
            ];
            $messages=[
                'paket.required'=>"Paket harus dipilih!",
                'qty.required'=>"Jumlah harus diisi!",
                'pegawai.required'=>"Terapis harus dipilih!"
            ];
            $val=Validator::make($request->all(),$rules,$messages);
            if (!$val->fails()){

                $pivot=$trx->paket->contains($request->paket);

                if(!$pivot) {
                    $trx->paket()->attach($request->paket,
                        ["qty" => $request->qty,"pegawai_id"=>$request->pegawai] );
                }else{
                    $trx->paket()->updateExistingPivot($request->paket,['qty' => $request->qty,"pegawai_id"=>$request->pegawai],false );
                }
                return response('ok');
            }else{
                return response($val->errors());
            }

        }

    }

    public function itemUpdateTrx(Request $request){
        $trx=Transaksi::where('kode',$request->kode)->first();
        $rules=[
            'paket'=>'required',
            'qty'=>'required',
            'pegawai'=>'required',
        ];
        $messages=[
            'paket.required'=>"Paket harus dipilih!",
            'qty.required'=>"Jumlah harus diisi!",
            'pegawai.required'=>"Terapis harus dipilih!"
        ];
        $val=Validator::make($request->all(),$rules,$messages);
        if (!$val->fails()){

            $pivot=$trx->paket->contains($request->paket);

            if(!$pivot) {
                $trx->paket()->attach($request->paket,
                    ["qty" => $request->qty,'pegawai_id'=>$request->pegawai] );
            }else{
                $trx->paket()->updateExistingPivot($request->paket,['qty' => $request->qty,'pegawai_id'=>$request->pegawai],false );
            }
            return response('ok');
        }else{
            return response($val->errors());
        }
    }

    public function itemDeleteTrx(Request $request){
        $trx=Transaksi::where('kode',$request->kode)->first();
        $trx->paket()->detach($request->itemid);
        return response('ok');
    }

    public function simpanTrx(Request $request){
        $trx=Transaksi::find($request->trxid);
        $trx->update(['tipe_byr'=>$request->tipe_byr,"totalbayar"=>$request->jumlah_byr,"catatan"=>$request->catatan,'diskon'=>$request->diskon]);

        if (empty($request->jumlah_byr)){
            $jmlbyr=0;
        }else{
            $jmlbyr=$request->jumlah_byr;
        }
        foreach ($trx->paket as $paket){
            DetailTransaksi::updateOrCreate([
                'kode_transaksi'=>$trx->kode
            ],[
                'transaksi_id'=>$trx->id,
                'customer'=>$trx->customer_id,
                'paket'=>$paket->nama,
                'harga_paket'=>$paket->harga,
                'paket_qty'=>$paket->pivot->qty,
                'harga_pokok'=>totalHarga($trx)['total'],
                'diskon'=>$trx->diskon,
                'total_harga'=>totalHarga($trx)['total']-$trx->diskon,
                'total_biaya'=>totalHarga($trx)['biaya'],
                'kembali'=>($trx->totalbayar)-totalHarga($trx)['harga'],
                'jumlah_bayar'=>$jmlbyr,
                'kasir'=>$trx->kasir->name,
                'terapis'=>Pegawai::find($paket->pivot->pegawai_id)->nama,
                'status'=>'pending',
                'tgl_transaksi'=>now('Asia/Makassar')->format('Y-m-d H:i:s'),
            ]);
        }
        return response('ok');
    }

    public function deleteTrx(Request $request){
        $trx=Transaksi::find($request->trx);

        $trx->paket()->detach();
        $trx->delete();
        return response('ok');
    }

    public function batalTrx(Request $request){
       TransaksiBatal::insert(['transaksi_id'=>$request->trx,'user_id'=>Auth::user()->id,'keterangan'=>$request->keterangan,'created_at'=>Carbon::now('Asia/Makassar')->format('Y-m-d H:i:s')]);
        $transaksi=Transaksi::find($request->trx);
        foreach ($transaksi->paket as $paket){
            $qty=$paket->pivot->qty;
            foreach ($paket->barang as $barang){
                $kebutuhan=$barang->pivot->kebutuhan;
                $totalbarang=$kebutuhan*$qty;
                $stoklama=$barang->stok;
                $stokbaru=$stoklama+$totalbarang;
                $barang->update(['stok'=>$stokbaru]);
            }

        }
        foreach ($transaksi->detail as $detail){
            $detail->update(['status'=>'batal','tgl_batal'=>Carbon::now('Asia/Makassar')->format('Y-m-d H:i:s')]);
        }
        return response('ok');
    }
}
