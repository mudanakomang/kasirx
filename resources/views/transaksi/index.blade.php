
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
                    <table class="table table-bordered" id="datatableTransaksi" width="100%" cellspacing="0">
                        <thead>
                        <tr>

                            <th>Kode Transaksi</th>
                            <th>Tipe Pembayaran</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Pembayaran</th>
                            <th>Therapist</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transaksi as $key=>$item)

                            <div class="modal fade" id="batalModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <i class="fa fa-tag"></i>
                                                Pembatalan Transaksi
                                            </h5>
                                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form >
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Alasan Pembatalan</label>
                                                   <strong> <p>{{ !empty($item->transaksiBatal) ? $item->transaksiBatal->keterangan:"" }}</p></strong>
                                                </div>
                                                <div class="form-group">
                                                    <label >Dibatalkan Oleh </label>
                                                 <strong>   <p>{{!empty($item->transaksiBatal) ?  $item->transaksiBatal->user->name:"" }}</p></strong>
                                                </div>
                                                <div class="form-group">
                                                    <label >Tanggal Transaksi / Batal</label>
                                                    <strong>   <p>{{ \Carbon\Carbon::parse($item->created_at)->timezone("Asia/Makassar")->format("d M Y H:i")}} / {{ !empty($item->transaksiBatal) ?  \Carbon\Carbon::parse($item->transaksiBatal->created_at)->timezone("Asia/Makassar")->format("d M Y H:i"):"" }}</p></strong>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <tr class="{{ !empty($item->transaksiBatal) ? "table-danger" : ($item->print=='y' ? 'table-success':'') }}">

                                <td><a href="{{ url('transaksi/detail/').'/'.$item->id }}"> {{ $item->kode }}</a></td>
                                <td>{{ $item->tipe_byr }}</td>
                                <td>{{ formatRp(totalHarga($item)['total'])  }}</td>
                                <td>{{ formatRp($item->diskon)  }}</td>
                                <td>{{ formatRp($item->totalbayar)  }}</td>
                                <td>{{ $item->pegawai->nama  }}</td>
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
        $(function () {
            $("#datatableTransaksi").dataTable({
                "order":[[5,"desc"]]
            })
        })

        function hapusTransaksi(trxid) {
            var id=trxid.replace("trx","")
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data transaksi akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('trx.hapus') }}",
                    type:"POST",
                    data:{
                        _token:"{{ csrf_token() }}",
                        trx:id,
                    },success:function(s){
                        if (s==='ok'){
                            window.location.reload()
                        }
                    }
                })
            }
        })
        }

        function batalTransaksi(trxid) {
            var id=trxid.replace("trx","")
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Transaksi akan dibatalkan dan stok dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Batalkan Transaksi!',
                input:"textarea",
                inputAttributes:{
                    placeholder:"Keterangan pembatalan transaksi",
                    required:true,
                },
                inputValidator:(value)=>{
                    return !value && "Alasan pembatalan harus diisi!"
            }


            }).then((result) => {
                if (result.isConfirmed) {
                    if(result.value){
                        $.ajax({
                            url:"{{ route('trx.batal') }}",
                            type:"POST",
                            data:{
                                    _token:"{{ csrf_token() }}",
                                    trx:id,
                                    keterangan:result.value
                            },success:function(s){
                                if (s==='ok'){
                                window.location.reload()
                                }
                            }
                        })
                    }

            }
        })
        }
    </script>
@endsection
