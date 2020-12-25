@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('customer') }}">Customer</a>
            </li>
            <li class="breadcrumb-item active">Transaksi</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Data Transaksi
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Dibayar</th>
                            <th>Kasir</th>
                            <th>Terapis</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status</th>
                            {{--<th></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transaksi as $key=>$item)
                            <tr class="{{ $item[0]->status=="batal" ? 'table-danger':'' }}">
                                <td></td>
                                <td><a href="{{ url('customer/transaksi/detail/').'/'.$key }}">{{ $key }}</a> </td>
                                <td>{{ formatRp($item[0]->harga_pokok) }}</td>
                                <td>{{ formatRp($item[0]->diskon) }}</td>
                                <td>{{ formatRp($item[0]->jumlah_bayar) }}</td>
                                <td>{{ $item[0]->kasir}}</td>
                                <td>{{ $item[0]->terapis }}</td>
                                <td>{{ \Carbon\Carbon::parse($item[0]->tgl_transaksi)->format('Y-m-d') }}</td>
                                <td>{{ $item[0]->status=='selesai' ? "Selesai":"Dibatalkan" }}</td>
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
