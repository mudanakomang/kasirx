@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('customer') }}"> Customer</a>
            </li>
            <li class="breadcrumb-item active">Tambah Customer</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Tambah Customer

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('customer.tambah') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Customer</label>
                            <input type="text" id="nama"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama customer" >
                            @if ($errors->has('nama'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Customer</label>
                            <input type="text" id="alamat"  class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat customer" >
                            @if ($errors->has('alamat'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir Customer</label>
                            <input type="date" id="tgl_lahir"  class="form-control{{ $errors->has('tgl_lahir') ? ' is-invalid' : '' }}" name="tgl_lahir" value="{{ old('tgl_lahir') }}" placeholder="Masukkan tanggal lahir customer" >
                            @if ($errors->has('tgl_lahir'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tgl_lahir') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="nowa">Nomor HP/WA Customer</label>
                            <input type="text" id="nowa" pattern="\d*"  class="form-control{{ $errors->has('nowa') ? ' is-invalid' : '' }}" name="nowa" value="{{ old('nowa') }}" placeholder="Masukkan nomor HP customer" >
                            @if ($errors->has('nowa'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nowa') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="email">Email Customer</label>
                            <input type="email" id="email"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Masukkan email customer" >
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="instagram">Instagram Customer</label>
                            <input type="text" id="instagram"  class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}" name="instagram" value="{{ old('instagram') }}" placeholder="Masukkan Instagram customer" >
                            @if ($errors->has('instagram'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('instagram') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan Customer">
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