<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DetailTransaksi;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(){
        $customer=Customer::all();
        return view('customer.index',['customer'=>$customer]);
    }

    public function tambah(){
        return view('customer.tambah');
    }
    public function simpan(Request $request){
        $cust=new Customer();
        $cust->nama=$request->nama;
        $cust->alamat=$request->alamat;
        $cust->tgl_lahir=$request->tgl_lahir;
        $cust->nowa=$request->nowa;
        $cust->email=$request->email;
        $cust->instagram=$request->instagram;
        $cust->save();

        return redirect('customer');
    }

    public function hapus(Request $request){
        $cst=Customer::find($request->id);
        $cst->delete();

        return response('ok');
    }

    public function update(Request $request){
        $cust=Customer::find($request->id);
        $cust->nama=$request->nama;
        $cust->alamat=$request->alamat;
        $cust->tgl_lahir=$request->tgl_lahir;
        $cust->nowa=$request->nowa;
        $cust->email=$request->email;
        $cust->instagram=$request->instagram;
        $cust->save();
        return redirect()->back();
    }

    public function transaksi($id){
        $trx=Customer::find($id)->detail->groupBy('kode_transaksi');
        return view('customer.transaksi',['transaksi'=>$trx]);
    }

    public function detail($kode){
        $detail=DetailTransaksi::where('kode_transaksi',$kode)->get();
        return view('customer.detail',['detail'=>$detail]);
    }

}
