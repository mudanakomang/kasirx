<?php

namespace App\Http\Controllers;

use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    //

    public function index(){
        $transaksi=Transaksi::all();
        return view('transaksi.index',['transaksi'=>$transaksi]);
    }

    public function detail($id){
        $transaksi=Transaksi::find($id);
        return view('transaksi.detail',['transaksi'=>$transaksi]);
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
        Transaksi::updateOrCreate(['kode'=>$request->kode],['pegawai_id'=>$request->pegawai,'user_id'=>Auth::user()->id]);
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
            ];
            $messages=[
                'paket.required'=>"Paket harus dipilih!",
                'qty.required'=>"Jumlah harus diisi!"
            ];
            $val=Validator::make($request->all(),$rules,$messages);
            if (!$val->fails()){

                $pivot=$trx->paket->contains($request->paket);

                if(!$pivot) {
                    $trx->paket()->attach($request->paket,
                        ["qty" => $request->qty] );
                }else{
                    $trx->paket()->updateExistingPivot($request->paket,['qty' => $request->qty],false );
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
        ];
        $messages=[
            'paket.required'=>"Paket harus dipilih!",
            'qty.required'=>"Jumlah harus diisi!"
        ];
        $val=Validator::make($request->all(),$rules,$messages);
        if (!$val->fails()){

            $pivot=$trx->paket->contains($request->paket);

            if(!$pivot) {
                $trx->paket()->attach($request->paket,
                    ["qty" => $request->qty] );
            }else{
                $trx->paket()->updateExistingPivot($request->paket,['qty' => $request->qty],false );
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
        $trx->update(['tipe_byr'=>$request->tipe_byr,"totalbayar"=>$request->jumlah_byr,"catatan"=>$request->catatan]);

        return response('ok');
    }
}
