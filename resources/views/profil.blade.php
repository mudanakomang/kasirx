@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/pegawai') }}"> Pegawai</a>
            </li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Edit User {{ $user->name }}

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('profil.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" placeholder="Masukkan nama user" >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username"  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $user->username }}" placeholder="Masukkan username" >
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="password">Password  <small class="text-muted">(Optional)</small></label>
                            <input type="password" id="password"  class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="" placeholder="Biarkan kosong jika password tidak akan diubah" >
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif

                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label for="role">Role  </label>--}}
                            {{--<select name="role" id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">--}}
                                {{--<option value="">Pilih Role</option>--}}
                                {{--@foreach(\App\Role::all() as $role)--}}
                                    {{--<option {{ $role->id==$user->role_id ? "selected":""}} value="{{ $role->id }}">{{ $role->name }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                            {{--@if ($errors->has('role'))--}}
                                {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('role') }}</strong>--}}
                                    {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}
                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                        <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan Pegawai">
                    </div>
                </form>
            </div>
            <div class="card-footer small text-muted"></div>
        </div>


    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#role').select2()
        })
    </script>
@endsection