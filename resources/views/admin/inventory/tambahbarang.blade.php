@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/inventory') }}"> Barang</a>
            </li>
            <li class="breadcrumb-item active">Tambah Barang</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Tambah Barang

            </div>
            <div class="card-body">
                <form class="" method="POST" action="{{ route('barang.tambah') }}" >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Barang</label>
                            <input type="text" id="nama"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama barang" >
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
                            <label for="jenis">Jenis Barang</label>
                            <select class="form-control{{ $errors->has('jenis') ? ' is-invalid' : '' }}" id="jenis" name="jenis" >
                                <option value="">Pilih Jenis Barang</option>
                               @foreach(\App\JenisBarang::all() as $item)
                                   <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('jenis'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('jenis') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                                <label for="stok">Jumlah</label>
                                <input type="number" id="stok" min="0" step="1"  class="form-control{{ $errors->has('stok') ? ' is-invalid' : '' }}" name="stok" value="{{ old('stok') }}" placeholder="Masukkan jumlah" >
                                @if ($errors->has('stok'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stok') }}</strong>
                                    </span>
                                @endif

                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" id="satuan"  class="form-control{{ $errors->has('satuan') ? ' is-invalid' : '' }}" name="satuan" value="{{ old('satuan') }}" placeholder="Masukkan satuan" >
                            @if ($errors->has('satuan'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('satuan') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sku">SKU / Kode Produk <small class="text-muted">(Optional)</small></label>
                            <input type="text" id="sku"  class="form-control{{ $errors->has('sku') ? ' is-invalid' : '' }}" name="sku" value="{{ old('sku') }}" placeholder="Masukkan SKU" >
                            @if ($errors->has('sku'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sku') }}</strong>
                                </span>
                            @endif
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
                        <input type="submit" class="btn btn-primary" value="Simpan Barang">
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