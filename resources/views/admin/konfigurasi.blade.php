@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}"> Home</a>
            </li>
            <li class="breadcrumb-item active">Konfigurasi</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Konfigurasi

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('konfig.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ $konfig->nama }}" placeholder="Masukkan nama usaha" >
                            @if ($errors->has('nama'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat<small class="text-muted"></small></label>
                            <input type="text" id="alamat"  class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ $konfig->alamat }}" placeholder="Masukkan alamat" >
                            @if ($errors->has('alamat'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('alamat') }}</strong>
                                </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="nohp">Nomor HP<small class="text-muted"></small></label>
                            <input type="text" id="nohp" pattern="\d*" class="form-control{{ $errors->has('nohp') ? ' is-invalid' : '' }}" name="nohp" value="{{ $konfig->nohp }}" placeholder="Masukkan Nomor HP" >
                            @if ($errors->has('nohp'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nohp') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="email">Email </label>
                            <input name="email" type="email" id="email" class="form-control{{ $errors->has('eamil') ? 'is-invalid':'' }}" value="{{ $konfig->email }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="printer">Printer </label>
                            <input name="printer" type="text" id="printer" class="form-control{{ $errors->has('printer') ? 'is-invalid':'' }}" value="{{ $konfig->printer }}">
                            @if ($errors->has('printer'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('printer') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="footnote">Foot Note </label>
                            <input name="footnote" type="text" id="footnote" class="form-control{{ $errors->has('footnote') ? 'is-invalid':'' }}" value="{{ $konfig->footnote }}">
                            @if ($errors->has('footnote'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('footnote') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan Paket">
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
            $("#harga").mask("#.##0", {reverse: true})
            $("#diskon").mask("#.##0", {reverse: true})
        })
    </script>
@endsection