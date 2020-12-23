<?php

namespace App\Http\Controllers;

use App\Customer;
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
        $cust->nowa=$request->nowa;
        $cust->email=$request->email;
        $cust->instagram=$request->instagram;
        $cust->save();
        return redirect()->back();
    }
}
