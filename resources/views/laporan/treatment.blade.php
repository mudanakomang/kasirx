
@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Laporan Treatment</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Laporan Treatment
            </div>
            <div class="card-body">
                <div class="col-sm-9 col-md-4 col-lg-4">
                    <form id="formdate" action="{{ route('treatment.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="bulan">Pilih Bulan</label>
                            <input type="month" id="bulan"  class="form-control{{ $errors->has('bulan') ? ' is-invalid' : '' }}" name="bulan" value="{{ !empty($bulan) ? $bulan:'' }}" placeholder="Pilih Bulan" >

                        </div>
                    </form>
                    <div class="form-group">
                        <form action="{{ route('treatment.export') }}" method="POST" id="postexpor">
                            @csrf
                            <input type="hidden" name="bln" id="bln" value="">
                        </form>
                        <button id="expor" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatableTransaksi" width="100%" cellspacing="0">
                        <thead>
                        <tr>

                            <th>Kode Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Pegawai</th>
                            <th>Customer</th>
                            <th>Paket</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($treatment as $treatment)
                                <tr>
                                    <td>{{ $treatment->kode_transaksi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($treatment->tgl_transaksi)->format('d F Y H:i') }}</td>
                                    <td>{{ $treatment->terapis }}</td>
                                    <td>{{ $treatment->pelanggan->nama }}</td>
                                    <td>{{ $treatment->paket }}</td>
                                    <td>{{ $treatment->paket_qty }}</td>
                                    <td>{{ formatRp($treatment->harga_paket) }}</td>
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
@section('script')
<script>
    $('#bulan').on('change',function (e) {
        e.preventDefault();
        var bulan=this.value

        $('#formdate').submit()
    })

    $('#expor').on('click',function (e) {
        e.preventDefault()
        var bulan=$('#bulan').val()

        $('input[name="bln"]:hidden').val(bulan);
        $('#postexpor').submit()
    })
</script>
@endsection
