<?php

namespace App\Http\Controllers;

use App\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    //

    public function tambahPaket(){
        return view('admin.paket.tambah');
    }
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

    public function jasaHapus(Request $request){
        $paket=Paket::find($request->paket_id);
        $paket->jasa()->detach($request->jasa_id);
        return response('success');
    }

    public function tambahItem(Request $request){
        $paket=Paket::find($request->paket);
        if(!$paket->barang->contains($request->barang)){
            $rules=[
                'barang'=>'required',
                'kebutuhan'=>'required',

            ];
            $messages=[
                'barang.required'=>"Barang harus dipilih!",
                'kebutuhan.required'=>'Kebutuhan barang harus diisi!',

            ];
            $vld=Validator::make($request->all(),$rules,$messages);
            if ($vld->fails()){
                return response($vld->errors());
            }else{
                $paket=Paket::find($request->paket);
                $paket->barang()->attach($request->barang,['kebutuhan'=>$request->kebutuhan]);
                return response('success');
            }
        }else{
            return response('exists');
        }


    }

    public function jasaTambah(Request $request){
        $paket=Paket::find($request->paket);
        if(!$paket->jasa->contains($request->jasa)){
            $rules=[
                'jasa'=>'required',

            ];
            $messages=[
                'jasa.required'=>"Jasa harus dipilih!",
            ];
            $vld=Validator::make($request->all(),$rules,$messages);
            if ($vld->fails()){
                return response($vld->errors());
            }else{
                $paket=Paket::find($request->paket);
                $paket->jasa()->attach($request->jasa);
                return response('success');
            }
        }else{
            return response('exists');
        }

    }

    public function updateItem(Request $request){

        $paket=Paket::find($request->paketid);
        $paket->barang()->updateExistingPivot($request->itemid,['kebutuhan'=>$request->kebutuhan]);
        return response('success');
    }

    public function simpanPaket(Request $request){
        $rules=[
            'nama'=>'required',
            'harga'=>'required',
        ];
        $messages=[
            'nama.required'=>'Nama paket harus diisi!',
            'harga.required'=>'Harga paket harus diisi!'
        ];
        $val=Validator::make($request->all(),$rules,$messages);

        if ($val->fails()){
            return redirect()->back()->withErrors($val->errors())->withInput();
        }else{
            $paket=new Paket();
            $paket->nama=$request->nama;
            $paket->harga=str_replace(".","",$request->harga);
            if ($request->diskon==0 || $request->diskon==""){
                $paket->diskon=0;
            }else{
                $paket->diskon=str_replace(".","",$request->diskon);
            }

            $paket->keterangan=$request->keterangan;
            $paket->save();

            return redirect('admin/paket/detail/'.$paket->id);
        }
    }
    public function edit($id){
        $paket=Paket::find($id);
        return view('admin.paket.edit',['paket'=>$paket]);
    }

    public function update(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'harga' => 'required',
        ];
        $messages = [
            'nama.required' => 'Nama paket harus diisi!',
            'harga.required' => 'Harga paket harus diisi!'
        ];
        $val = Validator::make($request->all(), $rules, $messages);

        if ($val->fails()) {
            return redirect()->back()->withErrors($val->errors())->withInput();
        } else {
            $paket = Paket::find($request->id);
            $paket->nama = $request->nama;
            $paket->harga = str_replace(".", "", $request->harga);
            if ($request->diskon==0 || $request->diskon==""){
                $paket->diskon=0;
            }else{
                $paket->diskon = str_replace(".", "", $request->diskon);
            }

            $paket->keterangan = $request->keterangan;
            $paket->update();

            return redirect('admin/paket');
        }
    }
}
