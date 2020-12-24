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
                            <th>Kode Transaksi</th>
                            <th>Paket Treatment</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            {{--<th></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detail as $key=>$item)

                            <tr>
                                <td></td>
                                <td>{{ $item->kode_transaksi }}</td>
                                <td>{{ $item->paket }}</td>
                                <td>{{ formatRp($item->harga_paket) }}</td>
                                <td>{{ $item->paket_qty }}</td>
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
