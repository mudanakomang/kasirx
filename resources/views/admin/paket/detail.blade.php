@extends('layouts.master')
@section('content')


    <div class="modal fade" id="tambahItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fa fa-tag"></i>
                        Tambah Item
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="" id="formItem">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Barang</label>
                            <select class="form-control " id="barang" name="barang">
                                <option value="" ><sub>Pilih Barang</sub></option>
                                @foreach(\App\Barang::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger barang">

                            </div>

                        </div>
                        <div class="form-group">
                            <label for="kebutuhan">Kebutuhan</label>
                            <input type="number" class="form-control" min="0" step="0.5" id="kebutuhan" name="kebutuhan" value="{{ old('kebutuhan') }}" placeholder="Masukkan kebutuhan barang" >
                            <div class="text-danger kebutuhan">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Masukkan satuan dalam ml,lembar,pcs dll." >
                            <div class="text-danger satuan">

                            </div>
                        </div>
                        <small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" onclick="event.preventDefault();simpanItem()" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/pegawai') }}"> Paket Treatment</a>
            </li>
            <li class="breadcrumb-item active">Detail Paket</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        {{--<div class="card mb-3">--}}
            {{--<div class="card-header bg-primary text-white">--}}
                {{--<i class="fa fa-table"></i>--}}
                {{--Detail Paket {{ $paket->nama }}--}}

            {{--</div>--}}
            {{--<div class="card-body">--}}
                {{--<h2>Detail</h2>--}}
            {{--</div>--}}
            {{--<div class="card-footer small text-muted"></div>--}}
        {{--</div>--}}
        <h2>Detail Paket Treatment {{ $paket->nama }}</h2>
        <hr>
        <div class="col-sm-12 col-md-8 col-lg-8">
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Harga Paket</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ formatRp($paket->harga) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Keterangan</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ $paket->keterangan }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Diskon</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ $paket->diskon==0 ? "": formatPersen($paket->diskon) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Total Harga</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ formatRp( $paket->harga-($paket->harga*$paket->diskon)/100) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Status</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong class="{{ statusPaket($paket)==0 ? "text-danger":"text-success" }}">{{ statusPaket($paket)==0 ? "Tidak Aktif":"Aktif" }}</strong></p>
                </div>
            </div>
        </div>

        <hr>
        <h3>Daftar Item </h3> <p class="float-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#tambahItemModal" ><i class="fa fa-plus"></i> Tambah Item</a> </p>
        @foreach($paket->barang as $barang)
            <div id="div{{$barang->id}}">
                <div class="input-group" >
                   <span class="input-group-btn">
                        <button type="button" id="{{ $barang->id }}" onclick="event.preventDefault(); hapusItem(this.id);" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                    </span> &nbsp;
                   <p><strong>{{  $barang->nama }}</strong></p>

                </div>
                <small class="text-muted"><strong> Kebutuhan : {{ $barang->pivot->kebutuhan ." ".$barang->pivot->satuan}}</strong></small>
                <br>
                <small class="text-muted"><strong> Jenis Barang : {{ $barang->jenisBarang->jenis}}</strong></small>
                <br>
                <small class="text-muted"><strong> Sisa Stok : {{ $barang->stok .' '.$barang->satuan}}</strong></small>

                <hr>
            </div>
        @endforeach

    </div>
@endsection
@section('script')
    <script>
        function hapusItem(id) {

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data item akan dihapus dari paket!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('item.hapus') }}",
                    type:"POST",
                    data:{
                        _token:"{{ csrf_token() }}",
                        barang_id:id,
                        paket_id:"{{ $paket->id }}"
                    },success:function(s){
                        if (s==='success'){
                            $('#div'+id).hide()
                        }
                    }
                })
            }
        })
        }


        function simpanItem() {
            $.ajax({
                url:"{{ route('item.tambah') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    paket:"{{ $paket->id }}",
                    barang:$("#barang").val(),
                    kebutuhan:$("#kebutuhan").val(),
                    satuan:$("#satuan").val()
                },success:function (s) {
                    if(s==='success'){
                        window.location.reload()
                    }else{
                        $.each($('div.text-danger'),function (k,v) {
                          $(this).text("")
                        })
                        $.each(s,function (k,v) {
                           $('div.'+k).text("").text(v)
                        })
                    }
                }
            })
        }
    </script>
@endsection