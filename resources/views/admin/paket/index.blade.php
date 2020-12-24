@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Paket Treatment</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Paket Treatment
                <a href="{{ url('admin/paket/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Paket Treatment
                  </span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                            <th>Detail</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paket as $key=>$item)
                            <tr class="{{ $item->status=="N" ? 'table-danger':'' }}">
                                <td>{{ $key+1 }}</td>
                                <td><a href="{{ url('admin/paket/detail/').'/'.$item->id }}">{{ $item->nama }}</a></td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ formatRp($item->harga)  }}</td>
                                <td><a href="{{ url('admin/paket/detail/').'/'.$item->id }}">Detail</a> </td>
                                <td> <p><strong class="{{ statusPaket($item)==0 || $item->status=="N" ? "text-danger":"text-success" }}">{{ statusPaket($item)==0 ? "Tidak Aktif, Mohon perhatikan stok":($item->status=="N" ? "Tidak Aktif":"Aktif") }}</strong></p></td>
                                <td><a href="javascript:void(0);" id="{{ $item->id }}" onclick="event.preventDefault();hapusPaket(this.id);"><i class="fa fa-trash"></i> Hapus</a> ||
                                    <a href="{{ url('admin/paket/edit/').'/'.$item->id }}" ><i class="fa fa-edit"></i> Edit</a>
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
