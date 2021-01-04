
@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Laporan Inventory</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Laporan Inventory
            </div>
            <div class="card-body">
                <div class="col-sm-9 col-md-4 col-lg-4">
                    <div class="form-group">
                        <form action="{{ route('inventory.export') }}" method="POST" id="postexpor">
                            @csrf
                        </form>
                        <button id="expor" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatableTransaksi" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Harga/Satuan</th>
                            <th>Nilai Stok</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inventory as $inventory)
                            <tr>
                                <td>{{ $inventory->nama }}</td>
                                <td>{{ $inventory->keterangan }}</td>
                                <td>{{ $inventory->jenisBarang->jenis }}</td>
                                <td>{{ $inventory->stok }}</td>
                                <td>{{ $inventory->satuan }}</td>
                                <td>{{ formatRp($inventory->harga).'/'.$inventory->satuan }}</td>
                                <td>{{ formatRp($inventory->stok*$inventory->harga) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted"></div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        $('#expor').on('click',function (e) {
            e.preventDefault()
            var bulan=$('#bulan').val()

            $('input[name="bln"]:hidden').val(bulan);
            $('#postexpor').submit()
        })
    </script>
@endsection
