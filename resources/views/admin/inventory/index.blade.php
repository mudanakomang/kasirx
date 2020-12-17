@extends('layouts.master')
@section('content')
    <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Inventory</li>
    </ol>
    <!-- Page Content -->
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-table"></i>
            Inventory Records
            <a href="{{ url('admin/tambahbarang') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Barang
                  </span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Jenis</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $key=>$item)
                              <tr>
                                  <td>{{ $key+1 }}</td>
                                  <td>{{ $item->id }}</td>
                                  <td>{{ $item->nama }}</td>
                                  <td>{{ $item->keterangan }}</td>
                                  <td>{{ $item->stok }}</td>
                                  <td>{{ $item->satuan }}</td>
                                  <td>{{ $item->jenisBarang->jenis }}</td>
                                  <td></td>
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
