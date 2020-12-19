<?php

namespace App\Http\Controllers;

use App\Barang;
use App\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    //
    public function index(){
        $barang=Barang::all();
        return view('admin.inventory.index',['barang'=>$barang]);
    }

    public function tambahBarang(){
        return view('admin.inventory.tambahbarang');
    }

    public function simpanBarang(Request $request){
        $rules=[
            'nama'=>'required|unique:barang',
            'jenis'=>'required',
            'stok'=>'required|numeric',
            'satuan'=>'required',
            'harga'=>'required|numeric',
        ];
        $messages=[
            'nama.required'=>'Nama barang harus diisi',
            'nama.unique'=>'Nama barang sudah ada, silahkan diupdate',
            'jenis.required'=>'Jenis barang harus diisi',
            'stok.required'=>'Stok harus diisi (minimal 0)',
            'stok.numeric'=>'Stok harus angka',
            'satuan.required'=>'Satuan harus diisi',
            'harga.required'=>'Harga harus diisi',
            'harga.numeric'=>'Harga harus berupa angka'
        ];
       $validator=Validator::make($request->all(),$rules,$messages);
       if ($validator->fails()){
           return redirect()->back()->withErrors($validator->errors())->withInput();
       }else{
          $barang=new Barang();
          $barang->nama=$request->nama;
          $barang->keterangan=$request->keterangan;
          $barang->jenis_id=$request->jenis;
          $barang->stok=$request->stok;
          $barang->satuan=$request->satuan;
          $barang->sku=$request->sku;
          $barang->harga=$request->harga;
          $barang->save();
          return redirect('admin/inventory');
       }
    }
    public function editBarang($id){
        $barang=Barang::find($id);
        return view('admin.inventory.editbarang',['barang'=>$barang]);
    }
    public function updateBarang(Request $request){
        $rules=[
            'nama'=>'required|unique:barang,id',
            'jenis'=>'required',
            'stok'=>'required|numeric',
            'satuan'=>'required',
            'harga'=>'required|numeric',
        ];
        $messages=[
            'nama.required'=>'Nama barang harus diisi',
            'nama.unique'=>'Nama barang sudah ada, silahkan diupdate',
            'jenis.required'=>'Jenis barang harus diisi',
            'stok.required'=>'Stok harus diisi (minimal 0)',
            'stok.numeric'=>'Stok harus angka',
            'satuan.required'=>'Satuan harus diisi',
            'harga.required'=>'Harga harus diisi',
            'harga.numeric'=>'Harga harus berupa angka'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            Barang::where('id',$request->id)->update([
                'nama'=>$request->nama,
                'keterangan'=>$request->keterangan,
                'jenis_id'=>$request->jenis,
                'stok'=>$request->stok,
                'satuan'=>$request->satuan,
                'sku'=>$request->sku,
                'harga'=>$request->harga,
                ]);
            return redirect('admin/inventory');
        }
    }
    public function hapusBarang(Request $request){
        $barang=Barang::find($request->id);
        $barang->delete();
        return response('success');
    }
    public function jenisBarang(){
        $jenis=JenisBarang::all();
        return view('admin.inventory.tipebarang',['jenisbarang'=>$jenis]);
    }

    public function tambahJenisBarang(){
        return view('admin.inventory.tambahjenis');
    }

    public function simpanJenisBarang(Request $request){
        $rules=[
            'jenis'=>'required'
        ];
        $messages=[
            'jenis.required'=>'Jenis barang harus diisi'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }else{
            $jenis=new JenisBarang();
            $jenis->jenis=$request->jenis;
            $jenis->keterangan=$request->keterangan;
            $jenis->save();
            return redirect('admin/jenisbarang');
        }
    }
    public function hapusJenisBarang(Request $request){
        $jenis=JenisBarang::find($request->id);
        $jenis->delete();
        return response('success');
    }

    public function editJenisBarang($id){
        $jenis=JenisBarang::find($id);
        return view('admin.inventory.editjenis',['jenis'=>$jenis]);
    }

    public function updateJenisBarang( Request $request){
        $rules=[
            'jenis'=>'required'
        ];
        $messages=[
            'jenis.required'=>'Jenis barang harus diisi'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }else{
            $jenis=JenisBarang::find($request->id);
            $jenis->jenis=$request->jenis;
            $jenis->keterangan=$request->keterangan;
            $jenis->save();
            return redirect('admin/jenisbarang');
        }
    }
}
