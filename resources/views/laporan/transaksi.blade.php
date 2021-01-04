
@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Laporan Transaksi</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Laporan Transaksi
            </div>
            <div class="card-body">
                <div class="col-sm-9 col-md-4 col-lg-4">
                    <form id="formdate" action="{{ route('laporan.post') }}" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="datemin">Pilih Tanggal Min</label>
                        <input type="date" id="datemin"  class="form-control{{ $errors->has('datemin') ? ' is-invalid' : '' }}" name="datemin" value="{{ !empty($datemin) ? $datemin:'' }}" placeholder="Pilih Tanggal" >

                    </div>
                    <div class="form-group">
                        <label for="datemax">Pilih Tanggal Max</label>
                        <input type="date" id="datemax"  class="form-control{{ $errors->has('datemax') ? ' is-invalid' : '' }}" name="datemax" value="{{ !empty($datemax) ? $datemax:'' }}" placeholder="Pilih Tanggal" >

                    </div>
                    </form>
                    <div class="form-group">
                        <form action="{{ route('transaksi.export') }}" method="POST" id="postexpor">
                            @csrf
                            <input type="hidden" name="min" id="min" value="">
                            <input type="hidden" name="max" id="max" value="">
                        </form>
                        <button id="expor" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatableTransaksi" width="100%" cellspacing="0">
                        <thead>
                        <tr>

                            <th>Kode Transaksi</th>
                            <th>Tipe Pembayaran</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Pembayaran</th>
                            {{--<th>Therapist</th>--}}
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transaksi->unique('kode_transaksi') as $key=>$item)

                            <tr class="{{ !empty($item->transaksiBatal) ? "table-danger" : ($item->print=='y' ? 'table-success':'') }}">

                                <td>@if($item->print=='y')<a href="{{ url('transaksi/detail/').'/'.$item->id }}"> {{ $item->kode_transaksi }}</a>@else<a href="{{ url('transaksi/detailx/').'/'.$item->id }}"> {{ $item->kode_transaksi }}</a> @endif</td>
                                <td>{{ !empty($item->transaksi) ? strtoupper($item->transaksi->tipe_byr):'' }}</td>
                                <td>{{ formatRp($item->harga_pokok)  }}</td>
                                <td>{{ formatRp($item->diskon)  }}</td>
                                <td>{{ formatRp($item->total_harga)  }}</td>
                                {{--<td>{{ $item->pegawai->nama  }}</td>--}}
                                <td>@if(!empty($item->transaksiBatal))
                                        <a href='#' data-toggle='modal' data-target='#batalModal{{$item->id}}' >Dibatalkan</a>
                                    @else
                                        {{$item->print=="n" ? "Belum Selesai":"Selesai"}}
                                    @endif
                                </td>
                                <td>{{ empty($item->created_at) ? "":Carbon\Carbon::parse($item->created_at)->timezone('Asia/Makassar')->format('d M Y H:i')}}</td>
                                <td>
                                    @if($item->print=="y")
                                        @if(Auth::user()->hasRole('admin') && empty($item->transaksiBatal) )
                                            <a href="" id="trx{{$item->id}}" onclick="event.preventDefault();batalTransaksi(this.id)"><span class="text-danger"><i class="fa fa-times-rectangle"></i> Batal </span> </a>
                                        @endif

                                    @else
                                        <a href="" id="trx{{$item->id}}" onclick="event.preventDefault();hapusTransaksi(this.id)"><i class="fa fa-trash"></i> Hapus </a>
                                    @endif
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
      $(document).ready(function () {
          draw()
      })

        function draw() {
            var t = $("#datatableTransaksi").dataTable({
                "order":[[0,"desc"]]
            })

        }

        $('#datemin , #datemax').on('change',function () {
            $('#formdate').submit()
        })

        $('#expor').on('click',function (e) {
            e.preventDefault()
            var datemin=$('#datemin').val()
            var datemax=$('#datemax').val()
            $('input[name="min"]:hidden').val(datemin);
            $('input[name="max"]:hidden').val(datemax);

            $("#postexpor").submit()
        })
    </script>
@endsection
