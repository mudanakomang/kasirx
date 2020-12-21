
@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Transaksi</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Transaksi
                <a href="{{ url('transaksi/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Transaksi Baru
                  </span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Transaksi</th>
                            <th>Tipe Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transaksi as $key=>$item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><a href="{{ url('transaksi/detail/').'/'.$item->id }}"> {{ $item->kode }}</a></td>
                                <td>{{ $item->tipe_byr }}</td>
                                <td>{{ formatRp($item->totalbayar)  }}</td>
                                <td>{{ $item->print=="n" ? "Belum Selesai":"Selesai" }}</td>
                                <td>
                                </td>
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

    </script>
@endsection
