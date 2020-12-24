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
                            <select class="form-control" id="barang" name="barang">
                                <option value="" ><sub>Pilih Barang</sub></option>
                                @foreach(\App\Barang::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger barang">

                            </div>

                        </div>
                        <div class="form-group">
                            <label for="kebutuhan">Kebutuhan  <small class="text-muted "><em id="labelsatuan"> Satuan</em></small></label>
                            <input type="number" class="form-control" min="0" step="0.5" id="kebutuhan" name="kebutuhan" value="{{ old('kebutuhan') }}" placeholder="Masukkan kebutuhan barang" >
                            <div class="text-danger kebutuhan">

                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="satuan">Satuan</label>--}}
                            {{--<input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Masukkan satuan dalam ml,lembar,pcs dll." >--}}
                            {{--<div class="text-danger satuan">--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        <small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" onclick="event.preventDefault();simpanItem()" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div><div class="modal fade" id="tambahJasaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fa fa-tag"></i>
                        Tambah Jasa
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="" id="formItem">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Jasa</label>
                            <select class="form-control" id="jasa" name="jasa">
                                <option value="" ><sub>Pilih Jasa</sub></option>
                                @foreach(\App\Jasa::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} -- {{ formatRp($item->harga) }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger jasa">

                            </div>

                        </div>

                        <small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" onclick="event.preventDefault();simpanJasa()" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/paket') }}"> Paket Treatment</a>
            </li>
            <li class="breadcrumb-item active">Detail Paket</li>
        </ol>
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
            {{--<div class="row">--}}
                {{--<div class="  col-sm-6 col-md-4 col-lg-4">--}}
                    {{--<p>Diskon</p>--}}
                {{--</div>--}}
                {{--<div class="  col-sm-6 col-md-4 col-lg-4">--}}
                    {{--<p><strong>{{ $paket->diskon==0 ? "": formatRp($paket->diskon) }}</strong></p>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Total Harga</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ formatRp( $paket->harga-$paket->diskon) }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Status</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong class="{{ statusPaket($paket)==0 || $paket->status=="N" ? "text-danger":"text-success" }}">{{ statusPaket($paket)==0 ? "Tidak Aktif, Mohon perhatikan stok":($paket->status=="N" ? "Tidak Aktif":"Aktif") }}</strong></p>
                </div>
            </div>
        </div>

        <hr>
        <div class="col-sm-12 col-md-8 col-lg-8 d-flex justify-content-between">
            <div class=>
                <h3>Daftar Item </h3>
            </div>
            <div>
                <p class="float-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#tambahItemModal" ><i class="fa fa-plus"></i> Tambah Item</a> </p>
            </div>
            <div>
                <p class="float-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#tambahJasaModal" ><i class="fa fa-plus"></i> Tambah Jasa</a> </p>
            </div>

        </div>
        @php
            $biaya=0;
        @endphp
        @foreach($paket->barang as $barang)
            @php
                $peritem=$barang->harga;
                $biaya+=$barang->pivot->kebutuhan*$peritem
            @endphp
            <div id="div{{$barang->id}}">
                <div class="input-group" >
                   <span class="input-group-btn">
                        <button type="button" id="{{ $barang->id }}" onclick="event.preventDefault(); hapusItem(this.id);" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                        <a href="#" data-toggle="modal" data-target="#editItemModal{{ $barang->id }}"  class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                    </span> &nbsp;
                   <p><strong>{{  $barang->nama }}</strong></p>

                </div>
                <small class="text-muted"><strong> Kebutuhan : {{ $barang->pivot->kebutuhan ." ".$barang->satuan}}</strong></small>
                <br>
                <small class="text-muted"><strong> Jenis Barang : {{ $barang->jenisBarang->jenis}}</strong></small>
                <br>
                <small class="text-muted"><strong> Sisa Stok : {{ $barang->stok .' '.$barang->satuan}}</strong></small>

                <hr>
            </div>

            <div class="modal fade" id="editItemModal{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <i class="fa fa-tag"></i>
                                Edit Item
                            </h5>
                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form class="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="kebutuhan">Kebutuhan   <small class="text-muted"><em>(Dalam {{ $barang->satuan }})</em></small></label>
                                    <input type="number" class="form-control" min="0" step="0.5" id="kebutuhan{{ $barang->id }}" name="kebutuhan" value="{{ $barang->pivot->kebutuhan }}" placeholder="Masukkan kebutuhan barang" >
                                    <div class="text-danger kebutuhan">

                                    </div>
                                </div>

                                <small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <input type="submit" class="btn btn-primary" id="item{{$barang->id}}" onclick="event.preventDefault();updateItem(this.id)" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($paket->jasa as $jasa)
            @php
                $peritemjasa=$jasa->harga;
                $biaya+=$peritemjasa;
            @endphp
            <div id="divjasa{{$jasa->id}}">
                <div class="input-group" >
                   <span class="input-group-btn">
                        <button type="button" id="jasa{{ $jasa->id }}" onclick="event.preventDefault(); hapusJasa(this.id);" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>

                    </span> &nbsp;
                    <p><strong>{{  $jasa->nama }}</strong></p>

                </div>
                <small class="text-muted"><strong> Harga : {{ formatRp($jasa->harga) }}</strong></small>
                <br>

                <hr>
            </div>


        @endforeach
        <div class="col-sm-12 col-md-8 col-lg-8  ">
            <div class=>
                <h3>Perkiraan Biaya Barang : {{ formatRp($biaya) }}</h3>
            </div>
            <div class=>
                <h3 class="{{ $paket->harga-$paket->diskon-$biaya<=0 ? "text-danger":"text-primary" }}">Perkiraan Keuntungan : {{ formatRp($paket->harga-$paket->diskon-$biaya) }}</h3>
            </div>
        </div>
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


        function hapusJasa(jasaid) {
            var id=jasaid.replace('jasa','')
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data jasa akan dihapus dari paket!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('paket.jasa.hapus') }}",
                    type:"POST",
                    data:{
                        _token:"{{ csrf_token() }}",
                        jasa_id:id,
                        paket_id:"{{ $paket->id }}"
                    },success:function(s){
                        if (s==='success'){
                            $('#divjasa'+id).hide()
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
                },success:function (s) {
                    if(s==='success'){
                        window.location.reload()
                    }else if(s==='exists'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Item sudah masuk dalam paket ini, silahkan update',
                        })
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

        function simpanJasa() {
            $.ajax({
                url:"{{ route('paket.jasa.tambah') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    paket:"{{ $paket->id }}",
                    jasa:$("#jasa").val(),
                },success:function (s) {
                    if(s==='success'){
                        window.location.reload()
                    }else if(s==='exists'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Item sudah masuk dalam paket ini, silahkan update',
                        })
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

        function updateItem(id) {
           var itemid=id.replace('item','')
            console.log(itemid)

            $.ajax({
                url:"{{ route('item.update') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    itemid:itemid,
                    paketid:"{{ $paket->id }}",
                    kebutuhan:$("#kebutuhan"+itemid).val(),
                },success:function (s) {
                    if(s==='success'){
                        window.location.reload()
                    }
                }
            })
        }

        $(function () {
            $('#barang').on('change',function () {

                var satuan='{!! \App\Barang::all() !!}'
                var data=JSON.parse(satuan)
                var val=this.value
                $.each(data,function (k,v) {

                    if(parseInt(val)===v.id){
                       $('#labelsatuan').text('').text("(Satuan dalam "+v.satuan+" )")
                    }

                })
            })
        })
    </script>
@endsection