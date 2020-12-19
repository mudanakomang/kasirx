@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/pegawai') }}"> Pegawai</a>
            </li>
            <li class="breadcrumb-item active">Tambah Pegawai</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Tambah Pegawai

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('pegawai.tambah') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama pegawai" >
                            @if ($errors->has('nama'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat"  class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat pegawai" >
                            @if ($errors->has('alamat'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" id="tgl_lahir"  class="form-control{{ $errors->has('tgl_lahir') ? ' is-invalid' : '' }}" name="tgl_lahir" value="{{ old('tgl_lahir') }}" placeholder="Masukkan tanggal lahir pegawai" >
                            @if ($errors->has('tgl_lahir'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tgl_lahir') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="nomorhp">Nomor HP  <small class="text-muted">(Optional)</small></label>
                            <input type="text" id="nomorhp"  class="form-control{{ $errors->has('nomorhp') ? ' is-invalid' : '' }}" name="nomorhp" value="{{ old('nomorhp') }}" placeholder="Masukkan nomor HP" >
                            @if ($errors->has('nomorhp'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nomorhp') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="email">Email  <small class="text-muted">(Optional)</small></label>
                            <input type="email" id="email"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Masukkan email" >
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

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
            $('#jenis').select2()
        })
    </script>
@endsection