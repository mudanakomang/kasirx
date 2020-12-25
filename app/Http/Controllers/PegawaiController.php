<?php

namespace App\Http\Controllers;

use App\Paket;
use App\Pegawai;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PegawaiController extends Controller
{
    //
    public  function index(){
        $pegawai=Pegawai::all();
        $user=User::all();
        return view('admin.pegawai.index',['pegawai'=>$pegawai,'user'=>$user]);
    }

    public function tambahPegawai(){
        return view('admin.pegawai.tambahpegawai');
    }
    public function simpanPegawai(Request $request){
        $rules=[
            'nama'=>'required',
            'alamat'=>'required',
            'tgl_lahir'=>'required',
            'nomorhp'=>'numeric',
        ];
        $messages=[
            'nama.required'=>'Nama pegawai harus diisi!',
            'alamat.required'=>'Alamat pegawai harus diisi!',
            'tgl_lahir.required'=>'Tanggal lahir harus diisi',
            'nomorhp.numeric'=>'Nomor Hp tidak valid!',
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();

        }else{
            $pg=new Pegawai();
            $pg->nama=$request->nama;
            $pg->alamat=$request->alamat;
            $pg->tgl_lahir=Carbon::parse($request->tgl_lahir)->format('Y-m-d');
            $pg->nomorhp=$request->nomorhp;
            if (empty($request->email)){
                $email='';
            }else{
                $email=$request->email;
            }
            $pg->email=$email;
            $pg->save();
            return redirect('admin/pegawai');
        }
    }

    public function editPegawai($id){
        $pg=Pegawai::find($id);
        return view('admin.pegawai.editpegawai',['pegawai'=>$pg]);
    }
    public function updatePegawai(Request $request){
        $rules=[
            'nama'=>'required',
            'alamat'=>'required',
            'tgl_lahir'=>'required',
            'nomorhp'=>'numeric',
            'email'=>'unique:pegawai'
        ];
        $messages=[
            'nama.required'=>'Nama pegawai harus diisi!',
            'alamat.required'=>'Alamat pegawai harus diisi!',
            'tgl_lahir.required'=>'Tanggal lahir harus diisi',
            'nomorhp.numeric'=>'Nomor Hp tidak valid!',
            'email.unique'=>'Email sudah digunakan!'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();

        }else{
            $pg=Pegawai::find($request->id);
            $pg->nama=$request->nama;
            $pg->alamat=$request->alamat;
            $pg->tgl_lahir=Carbon::parse($request->tgl_lahir)->format('Y-m-d');
            $pg->nomorhp=$request->nomorhp;
            $pg->email=$request->email;
            $pg->save();
            return redirect('admin/pegawai');
        }
    }

    public function hapusPegawai(Request $request){
        $pg=Pegawai::find($request->id);
        $pg->delete();
        return response('success');
    }

    public function editUser($id){
        $u=User::find($id);
        return view('admin.pegawai.edituser',['user'=>$u]);
    }
    public function updateUser(Request $request){
        $rules=[
            'name'=>'required',
            'username'=>'required|unique:users,id',
            'role'=>'required'
        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'username.required'=>'Username harus diisi!',
            'username.unique'=>'Username sudah digunakan!',
            'role.required'=>'Role harus dipilih!'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
           if (empty($request->password)){
               User::where('id',$request->id)->update([
                   'name'=>$request->name,
                   'username'=>$request->username,
                   'role_id'=>$request->role,
               ]);
               return redirect('admin/pegawai');
           }else{
               User::where('id',$request->id)->update([
                   'name'=>$request->name,
                   'username'=>$request->username,
                   'password'=>bcrypt($request->password),
                   'role_id'=>$request->role,
               ]);
               return redirect('admin/pegawai');
           }
        }
    }

    public function tambahUser(){
        return view('admin.pegawai.tambahuser');
    }

    public function simpanUser(Request $request){
        $rules=[
            'name'=>'required',
            'username'=>'required|unique:users',
            'role'=>'required',
            'password'=>'required|confirmed|min:6'
        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'username.required'=>'Username harus diisi!',
            'username.unique'=>'Username sudah digunakan!',
            'role.required'=>'Role harus dipilih!',
            'password.required'=>'Password harus diisi!',
            'password.confirmed'=>'Pasword tidak cocok!',
            'password.min'=>'Minimal 6 karakter!'
        ];

        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $user= new User();
            $user->name=$request->name;
            $user->username=$request->username;
            $user->role_id=$request->role;
            $user->password=bcrypt($request->password);
            $user->save();
            return redirect('admin/pegawai');
        }
    }

    public function hapusUser(Request $request){
        $user=User::find($request->id);
        $user->delete();
        return response('success');
    }

    public function profilUpdate(Request $request){
        $rules=[
            'name'=>'required',
            'username'=>'required|unique:users,id',
        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'username.required'=>'Username harus diisi!',
            'username.unique'=>'Username sudah digunakan!',
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            if (empty($request->password)){
                User::where('id',$request->id)->update([
                    'name'=>$request->name,
                    'username'=>$request->username,
                ]);
                return redirect()->back();
            }else{
                User::where('id',$request->id)->update([
                    'name'=>$request->name,
                    'username'=>$request->username,
                    'password'=>bcrypt($request->password),
                ]);
                return redirect()->back();
            }
        }
    }

}
