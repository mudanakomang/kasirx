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
                            <label>Pilih Paket</label>
                            <select class="form-control" id="paket" name="paket">
                                <option value="" ><sub>Pilih Paket</sub></option>
                                @foreach(\App\Paket::all() as $item)
                                    <option  {{ statusPaket($item)==0 ? "disabled":"" }} value="{{ $item->id }}">{{ statusPaket($item)==0 ? $item->nama." -- (Tidak aktif, periksa stok)":$item->nama }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger paket">

                            </div>

                        </div>
                        <div class="form-group">
                            <label>Pilih Terapis</label>
                            <select class="form-control" id="pegawai" name="pegawai">
                                <option value="" ><sub>Pilih Terapis</sub></option>
                                @foreach(\App\Pegawai::all() as $item)
                                    <option  value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger pegawai">

                            </div>

                        </div>
                        <div class="form-group">
                            <label for="qty">Jumlah </label>
                            <input type="number" class="form-control" min="1" step="1" id="qty" name="qty" value="1" placeholder="Masukkan jumlah" >
                            <div class="text-danger qty">

                            </div>
                        </div>

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
                    <p>Customer</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ $transaksi->customer->nama }}</strong></p>
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
                    <p><strong class="{{ !empty($transaksi->transaksiBatal) ? 'text-danger':'' }}">{{ $transaksi->print== 'n' ? "Belum dicetak":(!empty($transaksi->transaksiBatal) ? "Batal":"Sudah dicetak") }}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p>Tanggal</p>
                </div>
                <div class="  col-sm-6 col-md-4 col-lg-4">
                    <p><strong>{{ \Carbon\Carbon::parse($transaksi->created_at)->timezone('Asia/Makassar')->format('d/m/Y H:i') }}</strong></p>
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
        @php
            $total=0
        @endphp
        @foreach($transaksi->paket as $key=>$paket)
            <div id="div{{$paket->id}}">

                <div class="input-group" >
                    @if($transaksi->print=='n')
                        <span class="input-group-btn">
                        <button type="button" id="{{ $paket->id }}" onclick="event.preventDefault(); hapusItem(this.id);" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                        <a href="#" data-toggle="modal" data-target="#editItemModal{{ $paket->id }}"  class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                    </span> &nbsp;
                    @endif
                    <p><strong>#{{ (string)($key+1)."  ".$paket->nama }}</strong></p>

                </div>

                <small class="text-muted"><strong> Harga : {{ formatRp($paket->harga) }}</strong></small>
                <br>
                <small class="text-muted"><strong> Terapis : {{ \App\Pegawai::find($paket->pivot->pegawai_id)->nama }}</strong></small>
                <br>
                <small class="text-muted"><strong> Jumlah Item : {{ $paket->pivot->qty  }}</strong></small>
                <br>
                <small class="text-muted"><strong> Subtotal : {{ formatRp($paket->pivot->qty*($paket->harga-$paket->diskon))  }}</strong></small>
                @php
                    $total+=$paket->pivot->qty*($paket->harga-$paket->diskon);
                @endphp
                <hr>
            </div>
            <div class="modal fade" id="editItemModal{{$paket->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <form class="" id="formItem">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Pilih Paket</label>
                                    <select class="form-control" id="paket{{$paket->id}}" name="paket">
                                        <option value="" ><sub>Pilih Paket</sub></option>
                                        @foreach(\App\Paket::all() as $item)
                                            <option  {{ statusPaket($item)==0 ? "disabled":"" }} {{ $paket->id==$item->id ? "selected":"" }} value="{{ $item->id }}">{{ statusPaket($item)==0 ? $item->nama." -- (Tidak aktif, periksa stok)":$item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger paket{{ $paket->id }}">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label>Pilih Terapis</label>
                                    <select class="form-control" id="pegawai{{$paket->id}}" name="pegawai">
                                        <option value="" ><sub>Pilih Terapis</sub></option>
                                        @foreach(\App\Pegawai::all() as $item)
                                            <option {{ $paket->pivot->pegawai_id==$item->id ? "selected":"" }} value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger pegawai{{ $paket->id }}">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="qty{{$paket->id}}">Jumlah </label>
                                    <input type="number" class="form-control" min="1" step="1" id="qty{{$paket->id}}" name="qty" value="{{ $paket->pivot->qty }}" placeholder="Masukkan jumlah" >
                                    <div class="text-danger qty{{$paket->id}}">

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
                                <input type="submit" class="btn btn-primary" onclick="event.preventDefault();updateItem(this.id)" id="item{{$paket->id}}" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-sm-12 col-md-8 col-lg-8">
            <div class="d-flex justify-content-between">
                <div> <h3 id="total">Total {{ isset($total) ? formatRp($total-$transaksi->diskon):"" }}</h3></div>
                <div><h3 id="kembali">Kembali </h3></div>
            </div>
            <div class="form-group">
                <label for="tipe_byr">Tipe Pembayaran</label>
                <select class="form-control" name="tipe_byr" id="tipe_byr">
                    <option value="cash">Tunai</option>
                    <option value="debit">Debit</option>
                    <option value="kredit">Kredit</option>
                </select>
            </div>
            <div class="form-group" id="divcatatan">
                <label for="catatan">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan"  rows="2"></textarea>
            </div>
            <div class="form-group">
                <label for="diskon">Diskon</label>
                <input type="text" pattern="\d*" class="form-control" id="diskon" value="{{ isset($transaksi) ? $transaksi->diskon:""}}" name="diskon" onchange="updateKembali()" onpaste="updateKembali()" onkeyup="updateKembali()">
            </div>
            <div class="form-group">
                <label for="jumlah_byr">Jumlah Pembayaran</label>
                <input type="text" pattern="\d*" class="form-control" id="jumlah_byr" value="{{  $transaksi->totalbayar }}" name="jumlah_byr" onchange="updateKembali()" onpaste="updateKembali()" onkeyup="updateKembali()">
            </div>

            <div class="form-group">
                @if($transaksi->print=="n" )
                    <button id="cetak" class="btn btn-success"><i class="fa fa-print"></i> Cetak</button>
                    <button id="simpan" onclick="simpanAkhir();" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
                @elseif($transaksi->print=='y' && empty($transaksi->transaksiBatal))
                    <button id="cetak" class="btn btn-success"><i class="fa fa-print"></i> Cetak Ulang</button>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function setCookie(key, value, expiry) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }

        function eraseCookie(key) {
            var keyValue = getCookie(key);
            setCookie(key, keyValue, '-1');
        }

        function simpanItem() {
            var kode=getCookie('kode')
            $.ajax({
                url:"{{ route('trx.item.add') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    paket:$("#paket").val(),
                    qty:$("#qty").val(),
                    pegawai:$('#pegawai').val(),
                    kode:kode
                },success:function (s) {
                    if(s==='ok'){
                        window.location.reload()
                    }else if (s==='exists'){
                        Swal.fire({
                            title: 'Item sudah ada',
                            text: "Item sudah ditamhkan, mohon diupdate",
                            icon: 'warning',
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
        function updateItem(itemid) {
            var id=itemid.replace("item","")
            var kode=getCookie('kode')
            $.ajax({
                url:"{{ route('trx.item.update') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    paket:$("#paket"+id).val(),
                    qty:$("#qty"+id).val(),
                    kode:kode,
                    pegawai:$('#pegawai'+id).val()
                },success:function (s) {
                    if(s==='ok'){
                        window.location.reload()
                    }else {
                        $.each($('div.text-danger'),function (k,v) {
                            $(this).text("")
                        })
                        $.each(s,function (k,v) {
                            $('div.'+k+id).text("").text(v)
                        })
                    }
                }
            })
        }
    </script>
    <script>
        $(document).ready(function () {

            $("#jumlah_byr").mask("#.##0", {reverse: true}).val($.number("{{ $transaksi->totalbayar }}",0,"."));
            $("#diskon").mask("#.##0", {reverse: true}).val($.number("{{ $transaksi->diskon }}",0,"."));
            $('#divcatatan').hide()
            $('#tipe_byr').select2()
            $('#cetak').attr("disabled","disabled")
            $('#cetak').css("cursor","not-allowed")
            updateKembali()
        })
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
            $('#jumlah_byr').change()

        })
        $('#diskon').on('change keyup keydown paste',function () {
            var total=parseInt("{{ isset($total) ? $total:0 }}")
            var val=this.value
            val=parseInt(val.replace(/\,/g,'').replace(/\./g,''))
            if(this.value==""){
                val=0
            }
            $('#total').text('Total Harga: Rp.'+$.number(total-val,0,","))
            updateKembali()
        })

        $('#tipe_byr').on('change',function () {
            if(this.value==="cash" || this.value===""){
                $("#divcatatan").hide()
            }else{
                $('#divcatatan').show()
            }
            var total="{{ isset($total) ? $total:"" }}"
            this.value==="cash" || this.value==="" ? $("#jumlah_byr").val(""):$("#jumlah_byr").val($.number(total,0,','))


        })

        $("#jumlah_byr").on("change keyup keypress paste",function () {
            if(!this.value=="0" || !this.value==""){
                var total=parseInt("{{ isset($total) ? $total:0 }}")
                if($("#diskon").val()!==""){
                    var diskon=parseInt($("#diskon").val().replace(/\,/g,'').replace(/\./g,''))

                }else{
                    diskon=0
                }

                console.log(diskon)
                var val=this.value
                val=parseInt(val.replace(/\,/g,'').replace(/\./g,''))
                if(val>=total-diskon){
                    $("#cetak").removeAttr("disabled")
                    $("#cetak").css("cursor","pointer")
                }else{
                    $("#cetak").attr("disabled","disabled").css("cursor","not-allowed")
                }
            }
        })

        function updateKembali() {
            var kembali;
            var jum=$("#jumlah_byr").val()
            var diskon=$("#diskon").val()
            diskon=parseInt(diskon.replace(/\,/g,'').replace(/\./g,''))
            jum=parseInt(jum.replace(/\,/g,'').replace(/\./g,''))
            var total=parseInt({{ isset( $total) ?  $total:0  }})-diskon
            if(jum>total){
                kembali=jum-total;
                $("#kembali").text("")
                $('#kembali').text("Kembali Rp. "+$.number(kembali,0,","))
            }else{
                $("#kembali").text("Kembali Rp. 0")
            }
        }
        function simpanItem() {
            var kode="{{ $transaksi->kode }}"
            $.ajax({
                url:"{{ route('trx.item.add') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    paket:$("#paket").val(),
                    qty:$("#qty").val(),
                    kode:kode,
                    pegawai:$('#pegawai').val()
                },success:function (s) {
                    if(s==='ok'){
                        window.location.reload()
                    }else if (s==='exists'){
                        Swal.fire({
                            title: 'Item sudah ada',
                            text: "Item sudah ditamhkan, mohon diupdate",
                            icon: 'warning',
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
        function updateItem(itemid) {
            var id=itemid.replace("item","")
            var kode="{{ $transaksi->kode }}"
            $.ajax({
                url:"{{ route('trx.item.update') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    paket:$("#paket"+id).val(),
                    qty:$("#qty"+id).val(),
                    kode:kode,
                    pegawai:$('#pegawai'+id).val()
                },success:function (s) {
                    if(s==='ok'){
                        window.location.reload()
                    }else {
                        $.each($('div.text-danger'),function (k,v) {
                            $(this).text("")
                        })
                        $.each(s,function (k,v) {
                            $('div.'+k+id).text("").text(v)
                        })
                    }
                }
            })
        }
        function simpanAkhir(){

            var trxid="{{ isset($transaksi) ? $transaksi->id:0 }}"
            var tipe_byr=$("#tipe_byr").val()
            var jumlah_byr=$("#jumlah_byr").val()
            var catatan=$("#catatan").val()
            if(tipe_byr==="cash"){
                catatan=""
            }
            if($("#diskon").val()!==""){
                var diskon=$("#diskon").val()
                diskon=diskon.replace(/\,/g,'').replace(/\./g,'')
            }else{
                diskon=0
            }

            $.ajax({
                url:"{{ route('trx.simpan') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    trxid:trxid,
                    tipe_byr:tipe_byr,
                    jumlah_byr:jumlah_byr.replace(/\,/g,'').replace(/\./g,''),
                    diskon:diskon,
                    catatan:catatan,
                },success:function(s){
                    if(s==='ok'){
                        eraseCookie('kode')
                        window.location.href="{{ url('transaksi') }}"
                    }
                }
            })




        }

        $("#cetak").on("click",function () {

            var trxid="{{  $transaksi->id }}"
            var tipe_byr=$("#tipe_byr").val()
            var jumlah_byr=$("#jumlah_byr").val()
            var catatan=$("#catatan").val()
            if(tipe_byr==="cash"){
                catatan=""
            }

            if($("#diskon").val()!==""){
                var diskon=$("#diskon").val()
                diskon=diskon.replace(/\,/g,'').replace(/\./g,'')
            }else{
                diskon=0
            }
            $.ajax({
                url:"{{ route('trx.simpan') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    trxid:trxid,
                    tipe_byr:tipe_byr,
                    jumlah_byr:jumlah_byr.replace(/\,/g,'').replace(/\./g,''),
                    catatan:catatan,
                    diskon:diskon,
                },success:function (s) {
                    if(s==='ok'){
                        eraseCookie('kode')
                        $.ajax({
                            url:"{{ route("trx.cetak") }}",
                            type:"POST",
                            data:{
                                _token:"{{ csrf_token() }}",
                                trxid:"{{ isset($transaksi) ? $transaksi->id:0}}"
                            },success:function (s) {
                                if(s==='ok'){
                                    eraseCookie('kode')
                                    window.location.href="{{ url('transaksi') }}"
                                }
                            }
                        })
                    }
                }
            })




        })

        function hapusItem(id){
            var kode="{{ $transaksi->kode }}"

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Item akan dihapus dari transaksi!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('trx.item.delete') }}",
                    type:"POST",
                    data:{
                        _token:"{{ csrf_token() }}",
                        itemid:id,
                        kode:kode,
                    },success:function (s) {
                        if (s==='ok'){
                            window.location.reload()
                        }
                    }
                })
            }
        })
        }
    </script>
@endsection