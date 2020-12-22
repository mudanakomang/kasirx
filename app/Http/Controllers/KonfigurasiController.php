<?php

namespace App\Http\Controllers;

use App\Konfigurasi;
use Illuminate\Http\Request;

class KonfigurasiController extends Controller
{
    //
    public function index(){
        $konfig=Konfigurasi::first();
        return view('admin.konfigurasi',['konfig'=>$konfig]);
    }
    public function update(Request $request){
        Konfigurasi::first()->update([
           'nama'=>$request->nama,
           'alamat'=>$request->alamat,
           'nohp'=>$request->nohp,
            'email'=>$request->email,
            'printer'=>$request->printer,
            'footnote'=>$request->footnote
        ]);
        return redirect()->back();
    }
}
