<?php

namespace App\Http\Controllers;

use App\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JasaController extends Controller
{
    //
    public function index(){
        $jasa=Jasa::all();
        return view('admin.jasa.index',['jasa'=>$jasa]);
    }

    public function jasaHapus(Request $request){
        $jasa=Jasa::find($request->id);
        foreach ($jasa->paket as $paket){
            $paket->update(['status'=>'N']);
        }
        $jasa->delete();
        return response('ok');
    }

    public function tambah(){
        return view('admin.jasa.tambah');
    }

    public function simpan(Request $request){
        $rules=[
            'nama'=>'required',
            'harga'=>'required'
        ];
        $message=[
            'nama.required'=>'Nama jasa harus diisi!',
            'harga.required'=>'Harga jasa harus diisi!'
        ];
        $vld=Validator::make($request->all(),$rules,$message);
        if ($vld->fails()){
            return redirect()->back()->withErrors($vld->errors())->withInput();
        }else{
            $js=new Jasa();
            $js->nama=$request->nama;
            $js->keterangan=$request->keterangan;
            $js->harga=$request->harga;
            $js->save();
            return redirect('admin/jasa');
        }
    }

    public function edit($id){
        $js=Jasa::find($id);
        return view('admin.jasa.edit',['jasa'=>$js]);
    }

    public function update(Request $request){
        $rules=[
            'nama'=>'required',
            'harga'=>'required'
        ];
        $message=[
            'nama.required'=>'Nama jasa harus diisi!',
            'harga.required'=>'Harga jasa harus diisi!'
        ];
        $vld=Validator::make($request->all(),$rules,$message);
        if ($vld->fails()){
            return redirect()->back()->withErrors($vld->errors())->withInput();
        }else{
            $js=Jasa::find($request->id);
            $js->nama=$request->nama;
            $js->keterangan=$request->keterangan;
            $js->harga=$request->harga;
            $js->save();
            return redirect('admin/jasa');
        }
    }
}
