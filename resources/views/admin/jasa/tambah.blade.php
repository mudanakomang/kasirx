@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/jasa') }}"> Jasa</a>
            </li>
            <li class="breadcrumb-item active">Tambah Jasa</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Tambah Jasa

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('jasa.tambah') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Jasa</label>
                            <input type="text" id="nama"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama jasa" >
                            @if ($errors->has('nama'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan <small class="text-muted">(Optional)</small></label>
                            <textarea name="keterangan" class="form-control" rows="8" cols="80" placeholder="keterangan"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga <small class="text-muted"> (Rp.) / Satuan</small></label>
                            <input type="text" id="harga"  class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}" name="harga" value="{{ old('harga') }}" placeholder="Masukkan Harga" >
                            @if ($errors->has('harga'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('harga') }}</strong>
                                </span>
                            @endif
                        </div>
                        <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan Jasa">
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