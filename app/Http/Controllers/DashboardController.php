<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        $role=Auth::user()->hasRole('admin') ? 'admin':'kasir';
        return view($role.'.dashboard');
    }
}
