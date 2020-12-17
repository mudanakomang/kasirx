@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/jenisbarang') }}">Jenis Barang</a>
            </li>
            <li class="breadcrumb-item active">Edit Jenis Barang </li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Edit Jenis Barang {{ $jenis->jenis }}

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('jenisbarang.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenis">Jenis Barang</label>
                            <input type="text" id="jenis"  class="form-control{{ $errors->has('jenis') ? ' is-invalid' : '' }}" name="jenis" value="{{ $jenis->jenis }}" placeholder="Masukkan jenis barang" >
                            @if ($errors->has('jenis'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('jenis') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan <small class="text-muted">(Optional)</small></label>
                            <textarea name="keterangan" class="form-control" rows="8" cols="80" placeholder="keterangan">{{ $jenis->keterangan }}</textarea>
                        </div>
                        <input type="hidden" value="{{ $jenis->id }}" id="id" name="id">
                        <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan Jenis Barang">
                    </div>
                </form>
            </div>
            <div class="card-footer small text-muted"></div>
        </div>


    </div>
@endsection
