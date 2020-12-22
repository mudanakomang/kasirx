<?php

namespace App\Http\Controllers;

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
}
