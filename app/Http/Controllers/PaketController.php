<?php

namespace App\Http\Controllers;

use App\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    //
    public function index(){
        $paket=Paket::all();
        return view('admin.paket.index',['paket'=>$paket]);
    }

    public function detail($id){
        $paket=Paket::find($id);
        return view('admin.paket.detail',['paket'=>$paket]);
    }

    public function hapusItem(Request $request){
       $paket=Paket::find($request->paket_id);
       $paket->barang()->detach($request->barang_id);
       return response('success');
    }
    public function tambahItem(Request $request){

        $rules=[
            'barang'=>'required',
            'kebutuhan'=>'required',
            'satuan'=>'required',
        ];
        $messages=[
            'barang.required'=>"Barang harus dipilih!",
            'kebutuhan.required'=>'Kebutuhan barang harus diisi!',
            'satuan.required'=>'Satuan harus diisi!',
        ];
        $vld=Validator::make($request->all(),$rules,$messages);
        if ($vld->fails()){
            return response($vld->errors());
        }else{
            $paket=Paket::find($request->paket);
            $paket->barang()->attach($request->barang,['kebutuhan'=>$request->kebutuhan,'satuan'=>$request->satuan]);
            return response('success');
        }

    }
}
