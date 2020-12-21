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
                            <label for="qty">Jumlah </label>
                            <input type="number" class="form-control" min="1" step="1" id="qty" name="qty" value="1" placeholder="Masukkan jumlah" >
                            <div class="text-danger qty">

                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<label for="satuan">Satuan</label>--}}
                        {{--<input type="text" class="form-control" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Masukkan satuan dalam ml,lembar,pcs dll." >--}}
                        {{--<div class="text-danger satuan">--}}

                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<small class="text-muted"><em>Periksa kembali sebelum menyimpan!</em></small>--}}
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
            <li class="breadcrumb-item active">Tambah Transaksi</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Tambah Transaksi

            </div>
            <div class="card-body">
                <form >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pegawai">Pegawai</label>
                            <select class="form-control{{ $errors->has('pegawai') ? ' is-invalid' : '' }}" id="pegawai" name="pegawai" >
                                <option value="">Pilih Pegawai</option>
                                @foreach(\App\Pegawai::all() as $item)
                                    <option {{ isset($transaksi) && $transaksi->pegawai_id==$item->id ? "selected":"" }} value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('pegawai'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pegawai') }}</strong>
                                    </span>
                            @endif

                        </div>


                        <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                    </div>
                    {{--<div class="modal-footer">--}}
                        {{--<input type="submit" class="btn btn-primary" value="Simpan Barang">--}}
                    {{--</div>--}}
                </form>
            </div>

        </div>
        <div class="col-sm-12 col-md-8 col-lg-8 d-flex justify-content-between">
            <div class=>
                <h3>Daftar Item </h3>
            </div>
            <div>
                <p class="float-right"><a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#tambahItemModal" ><i class="fa fa-plus"></i> Tambah Item</a> </p>
            </div>

        </div>
        @if(isset($transaksi))
            @php
                $total=0
            @endphp
            @foreach($transaksi->paket as $key=>$paket)
                <div id="div{{$paket->id}}">

                    <div class="input-group" >
                        @if($transaksi->print=='n')
                            <span class="input-group-btn">
                        <button type="button" id="{{ $paket->id }}" onclick="event.preventDefault(); hapusItem(this.id);" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                        <a href="#" data-toggle="modal" data-target="#tambahItemModal{{ $paket->id }}"  class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
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
                    <small class="text-muted"><strong> Subtotal : {{ formatRp($paket->pivot->qty*($paket->harga-($paket->harga*$paket->diskon/100)))  }}</strong></small>
                        @php
                        $total+=$paket->pivot->qty*($paket->harga-($paket->harga*$paket->diskon/100))
                        @endphp
                    <hr>

                    <div class="modal fade" id="tambahItemModal{{$paket->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div>
            @endforeach
            @endif
        <div class="col-sm-12 col-md-8 col-lg-8">
            <div class="d-flex justify-content-between">
                <div> <h3>Total {{ isset($total) ? formatRp($total):"" }}</h3></div>
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
                <label for="jumlah_byr">Jumlah Pembayaran</label>
                <input type="text" pattern="\d*" class="form-control" id="jumlah_byr" value="{{ isset($transaksi) ? $transaksi->totalbayar:""}}" name="jumlah_byr" onchange="updateKembali()" onpaste="updateKembali()" onkeyup="updateKembali()">
            </div>

            <div class="form-group">
               <button id="cetak" class="btn btn-success"><i class="fa fa-print"></i> Cetak</button>
               <button id="simpan" onclick="simpanAkhir();" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $("#jumlah_byr").mask("#.##0", {reverse: true}).val("");
            $('#divcatatan').hide()
            $('#pegawai').select2()
            $('#tipe_byr').select2()
            if(getCookie('kode')===null){
                var dt= new Date();
                var kode=dt.getFullYear()+""+dt.getMonth()+""+dt.getDate()+""+dt.getHours()+""+dt.getMinutes()+""+dt.getSeconds()
                setCookie('kode',kode,1)

            }
            console.log(kode)

            $('#cetak').attr("disabled","disabled")
            $('#cetak').css("cursor","not-allowed")



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
    </script>

    <script >
        $("#jumlah_byr").on("change keyup keypress paste",function () {
            if(!this.value=="0" || !this.value==""){
                var total=parseInt("{{ isset($total) ? $total:0 }}")
                var val=this.value
                val=parseInt(val.replace(/\,/g,'').replace(/\./g,''))
                if(val>=total){
                    $("#cetak").removeAttr("disabled")
                    $("#cetak").css("cursor","hand")
                }else{
                    $("#cetak").attr("disabled","disabled").css("cursor","not-allowed")
                }
            }
        })
        function trueOrFalse(data) {
            if (data==='ok'){
              return true
            }else{
                return false
            }
        }
        function cekTrs(kode) {
            $.ajax({
                url:"{{ route('trx.cek') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    kode:kode
                },success:trueOrFalse
            })
        }
        $('#pegawai').on('change',function () {
            var kode=getCookie('kode')
            if (!cekTrs(kode)){
                var pg=this.value
                $.ajax({
                    url:"{{ route('trx.tambah') }}",
                    type:"POST",
                    data:{
                        _token:"{{ csrf_token() }}",
                        pegawai:pg,
                        kode:kode
                    },success:function () {

                    }
                })
            }

        })
    </script>

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
                    kode:kode
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
        function updateKembali() {
            var kembali;
           var jum=$("#jumlah_byr").val()
           jum=parseInt(jum.replace(/\,/g,'').replace(/\./g,''))
           var total=parseInt({{ isset( $total) ?  $total:0  }})
            if(jum>total){
               kembali=jum-total;
               $("#kembali").text("")
               $('#kembali').text("Kembali Rp. "+$.number(kembali,0,","))
            }else{
                $("#kembali").text("Kembali Rp. 0")
            }
        }
    </script>

    <script>
        function hapusItem(id){
            var kode=getCookie('kode')

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

        function simpanAkhir(){

                var trxid="{{ isset($transaksi) ? $transaksi->id:0 }}"
                var tipe_byr=$("#tipe_byr").val()
                var jumlah_byr=$("#jumlah_byr").val()
                var catatan=$("#catatan").val()
                if(tipe_byr==="cash"){
                    catatan=""
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
                    }
                })




        }
        $("#cetak").on("click",function () {

                var trxid="{{ isset($transaksi) ? $transaksi->id:0 }}"
                var tipe_byr=$("#tipe_byr").val()
                var jumlah_byr=$("#jumlah_byr").val()
                var catatan=$("#catatan").val()
                if(tipe_byr==="cash"){
                    catatan=""
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
                    },success:function (s) {
                        if(s==='ok'){
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
    </script>
@endsection