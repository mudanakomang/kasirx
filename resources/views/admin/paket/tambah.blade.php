@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/paket') }}"> Paket Treatment</a>
            </li>
            <li class="breadcrumb-item active">Tambah Paket</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Tambah Paket

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('paket.tambah') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama paket" >
                            @if ($errors->has('nama'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Paket<small class="text-muted">(Rp)</small></label>
                            <input type="text" id="harga"  class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}" name="harga" value="{{ old('harga') }}" placeholder="Masukkan harga" >
                            @if ($errors->has('harga'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('harga') }}</strong>
                                </span>
                            @endif

                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="diskon">Diskon<small class="text-muted">(Rp)</small></label>--}}
                            {{--<input type="text" id="diskon" class="form-control{{ $errors->has('diskon') ? ' is-invalid' : '' }}" name="diskon" value="0" min="0" placeholder="Masukkan diskon" >--}}
                            {{--@if ($errors->has('diskon'))--}}
                                {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $errors->first('diskon') }}</strong>--}}
                                {{--</span>--}}
                            {{--@endif--}}

                        {{--</div>--}}

                        <div class="form-group">
                            <label for="keterangan">Keterangan<small class="text-muted">(Optional)</small> </label>
                            <textarea name="keterangan" id="keterangan" class="form-control{{ $errors->has('keterangan') ? 'is-invalid':'' }}" rows="3">{{ old('keterangan') }}</textarea>
                            @if ($errors->has('keterangan'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('keterangan') }}</strong>
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
//            $("#diskon").mask("#.##0", {reverse: true})
        })
    </script>
@endsection