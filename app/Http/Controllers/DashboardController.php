<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DetailTransaksi;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        $role=Auth::user()->hasRole('admin') ? 'admin':'kasir';
        if ($role=='admin'){
            return view('admin.dashboard');
        }else{
            return redirect('transaksi');
        }
    }

    public function profil(){
        $user=Auth::user();
        return view('profil',['user'=>$user]);
    }

    public function inventory(){
        $label=[];
        $value=[];
        $color=[];
        $inventory=Barang::all();
        foreach ($inventory as $item) {
            array_push($label,$item->nama);
            array_push($value,$item->stok);
            array_push($color,randomColor());
        }
        $data['labels']=$label;
        $data['datasets']['data']=$value;
        $data['datasets']['backgroundColor']=$color;

       return response(json_encode($data));
    }

    public function profit(Request $request){
        $data=[];
        $tahun=$request->tahun;
        if ($tahun==null){
           $tahun=today('Asia/Makassar')->format('Y');
        }
        //dd(Carbon::parse($request->tahun)->timezone('Asia/Makassar')->format('Y'));
//        if ($request->tahun==null){
//            $tahun=today('Asia/Makassar')->format('Y');
//        }else{
//            $tahun=Carbon::parse($request->tahun)->format('Y');
//        }

        $months=['Jan'=>'01','Feb'=>'02','Mar'=>'03','Apr'=>'04','May'=>'05','Jun'=>'06','Jul'=>'07','Aug'=>'08','Sep'=>'09','Oct'=>'10','Nov'=>'11','Dec'=>'12'];
        foreach ($months as $key=>$month){

            $trx=DetailTransaksi::whereMonth('updated_at',$month)->whereYear('updated_at',$tahun)->where('status','selesai')->get();
            $biaya=0;
            $harga=0;
            $profit=0;
            foreach ($trx->unique('kode_transaksi') as $tr){
                $biaya+=$tr->total_biaya;
                $harga+=$tr->total_harga;
               // $profit+=$harga-$biaya;

            }
            $profit=$harga-$biaya;
            $data[$key]['biaya']=$biaya;
            $data[$key]['harga']=$harga;
            $data[$key]['profit']=$profit;
        }

        //dd($data);
        return response(json_encode($data));
    }
}
