@extends('layouts.master')
@section('content')


    {{--<div class="modal fade" id="tambahItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog modal-lg" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header bg-primary text-white">--}}
                    {{--<h5 class="modal-title" id="exampleModalLabel">--}}
                        {{--<i class="fa fa-tag"></i>--}}
                        {{--Tambah Item--}}
                    {{--</h5>--}}
                    {{--<button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">×</span>--}}
                    {{--</button>--}}
                {{--</div>--}}
                {{--<form class="" id="formItem">--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="form-group">--}}
                            {{--<label>Pilih Barang</label>--}}
                            {{--<select class="form-control" id="barang" name="barang">--}}
                                {{--<option value="" ><sub>Pilih Barang</sub></option>--}}
                                {{--@foreach(\App\Barang::all() as $item)--}}
                                    {{--<option value="{{ $item->id }}">{{ $item->nama }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                            {{--<div class="text-danger barang">--}}

                            {{--</div>--}}

                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="kebutuhan">Kebutuhan  <small class="text-muted "><em id="labelsatuan"> Satuan</em></small></label>--}}
                            {{--<input type="number" class="form-control" min="0" step="0.5" id="kebutuhan" name="kebutuhan" value="{{ old('kebutuhan') }}" placeholder="Masukkan kebutuhan barang" >--}}
                            {{--<div class="text-danger kebutuhan">--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="satuan">Satuan</label>--}}
                        {{--<input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Masukkan satuan dalam ml,lembar,pcs dll." >--}}
                        {{--<div class="text-danger satuan">--}}

                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>--}}
                        {{--<input type="submit" class="btn btn-primary" onclick="event.preventDefault();simpanItem()" value="Simpan">--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('transaksi') }}"> Transaksi</a>
            </li>
            <li class="breadcrumb-item active">Detail Transaksi </li>
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
        <h2>Detail Transaksi #{{ $transaksi->kode }}</h2>
        <hr>
        <div class="col-sm-12 col-md-8 col-lg-8">
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Kode Transaksi</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>#{{$transaksi->kode}}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Pembayaran</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ strtoupper($transaksi->tipe_byr) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Total Harga</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ formatRp(totalHarga($transaksi)['total']) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Total Diskon</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ formatRp(totalHarga($transaksi)['diskon']) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Pembayaran</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ formatRp(totalHarga($transaksi)['harga']) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Status</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ $transaksi->print== 'n' ? "Belum dicetak":"Sudah dicetak" }}</strong></p>
                </div>
            </div>

        </div>

        <hr>
        <div class="col-sm-12 col-md-8 col-lg-8 d-flex justify-content-between">
            <div class=>
                <h3>Detail Item </h3>
            </div>
            @if($transaksi->print=='n')
            <div>
                <p class="float-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#tambahItemModal" ><i class="fa fa-plus"></i> Tambah Item</a> </p>
            </div>
                @endif

        </div>

        @foreach($transaksi->paket as $key=>$paket)
            <div id="div{{$paket->id}}">

                    <div class="input-group" >
                        @if($transaksi->print=='n')
                   <span class="input-group-btn">
                        <button type="button" id="{{ $paket->id }}" onclick="event.preventDefault(); hapusPaket(this.id);" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                        <a href="#" data-toggle="modal" data-target="#editItemModal{{ $paket->id }}"  class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                    </span> &nbsp;
                        @endif
                        <p><strong>#{{ (string)($key+1)."  ".$paket->nama }}</strong></p>

                    </div>

                <small class="text-muted"><strong> Harga : {{ formatRp($paket->harga) }}</strong></small>
                <br>
                <small class="text-muted"><strong> Diskon : {{ formatPersen($paket->diskon)  }}</strong></small>
                <br>
                <small class="text-muted"><strong> Jumlah Item : {{ $paket->pivot->qty  }}</strong></small>
                <br>
                <small class="text-muted"><strong> Total Harga : {{ formatRp($paket->pivot->qty*($paket->harga-($paket->harga*$paket->diskon/100)))  }}</strong></small>

                <hr>
            </div>

            {{--<div class="modal fade" id="editItemModal{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
                {{--<div class="modal-dialog modal-lg" role="document">--}}
                    {{--<div class="modal-content">--}}
                        {{--<div class="modal-header bg-primary text-white">--}}
                            {{--<h5 class="modal-title" id="exampleModalLabel">--}}
                                {{--<i class="fa fa-tag"></i>--}}
                                {{--Edit Item--}}
                            {{--</h5>--}}
                            {{--<button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">--}}
                                {{--<span aria-hidden="true">×</span>--}}
                            {{--</button>--}}
                        {{--</div>--}}
                        {{--<form class="">--}}
                            {{--<div class="modal-body">--}}
                                {{--<div class="form-group">--}}
                                {{--<label>Pilih Barang</label>--}}
                                {{--<select class="form-control " id="barang{{ $barang->id }}" name="barang">--}}
                                {{--<option value="" ><sub>Pilih Barang</sub></option>--}}
                                {{--@foreach(\App\Barang::all() as $item)--}}
                                {{--<option {{ $barang->id==$item->id ? "selected":"" }} value="{{ $item->id }}">{{ $item->nama }}</option>--}}
                                {{--@endforeach--}}
                                {{--</select>--}}
                                {{--<div class="text-danger barang">--}}

                                {{--</div>--}}

                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="kebutuhan">Kebutuhan   <small class="text-muted"><em>(Dalam {{ $barang->satuan }})</em></small></label>--}}
                                    {{--<input type="number" class="form-control" min="0" step="0.5" id="kebutuhan{{ $barang->id }}" name="kebutuhan" value="{{ $barang->pivot->kebutuhan }}" placeholder="Masukkan kebutuhan barang" >--}}
                                    {{--<div class="text-danger kebutuhan">--}}

                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>--}}
                            {{--</div>--}}
                            {{--<div class="modal-footer">--}}
                                {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>--}}
                                {{--<input type="submit" class="btn btn-primary" id="item{{$barang->id}}" onclick="event.preventDefault();updateItem(this.id)" value="Simpan">--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        @endforeach
        <div>
            <button  class="btn btn-lg btn-success cetak" id="{{ $transaksi->id }}" onclick="event.preventDefault();cetakTrx(this.id);" ><i class="fa fa-print"></i> Cetak</button>
        </div>
    </div>
@endsection
@section('script')
<script>
    function cetakTrx(id) {
        $.ajax({
            url:"{{ route('trx.cetak') }}",
            type:"POST",
            data:{
                _token:"{{ csrf_token() }}",
                trxid:id,
            },success:function (s) {
                if(s==='ok'){
                    window.location.reload()
                }
            }
        })
    }

   $(document).ready(function () {
       var status="{{ $transaksi->print }}"
       if (status==="n"){
           $(".cetak").removeAttr("disabled")
           $(".cetak").css("cursor","hand")
       }else{
           $(".cetak").attr("disabled","disabled")
           $(".cetak").css("cursor","not-allowed")
       }

   })
</script>
@endsection