@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Customer</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
               Data Customer
                <a href="{{ url('customer/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Customer
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
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor WhatsApp / HP</th>
                            <th>Email</th>
                            <th>Instagram</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customer as $key=>$item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ !empty($item->tgl_lahir) ? Carbon\Carbon::parse($item->tgl_lahir)->format('d M Y'):"" }}</td>
                                <td>
                                    @if(!empty($item->nowa))
                                        @php
                                            $ptn = "/^0|^\+62/";
                                            $str = $item->nowa;
                                            $rpltxt = "62";
                                            $wa= preg_replace($ptn, $rpltxt, $str);
                                            $text=urlencode("Halo ".$item->nama);
                                            $url='https://wa.me/'.$wa.'?text='.$text;

                                        @endphp
                                        <a href="{{url($url)}}" target="_blank">{{ $item->nowa }}</a>
                                        @endif
                                </td>
                                <td>@if(!empty($item->email))
                                    <a href="{{ url('mailto:').$item->email }}" target="_blank">{{$item->email}}</a>
                                    @endif
                                </td>
                                <td>@if(!empty($item->instagram))
                                       <a href="{{ url('https://instagram.com').'/'.$item->instagram }}" target="_blank">{{$item->instagram}}</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#customerModal{{$item->id}}" id="edit{{$item->id}}" ><i class="fa fa-edit"></i> Edit</a> ||
                                    <a href="" onclick="event.preventDefault();hapusCustomer(this.id)" id="hapus{{$item->id}}" ><i class="fa fa-trash"></i> Hapus</a>
                                </td>

                            </tr>

                            <div class="modal fade" id="customerModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <i class="fa fa-tag"></i>
                                                Update Stok
                                            </h5>
                                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form class="" method="POST" action="{{ route('customer.update') }}" >
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="nama">Nama Customer</label>
                                                    <input type="text" id="nama{{ $item->id }}"  class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{ $item->nama }}" placeholder="Masukkan nama customer" >
                                                    @if ($errors->has('nama'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                                    @endif

                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat">Alamat Customer</label>
                                                    <input type="text" id="alamat{{$item->id}}"  class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ $item->alamat }}" placeholder="Masukkan alamat customer" >
                                                    @if ($errors->has('alamat'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                                    @endif

                                                </div>

                                                <div class="form-group">
                                                    <label for="tgl_lahir">Tanggal Lahir Customer</label>
                                                    <input type="date" id="tgl_lahir{{$item->id}}"  class="form-control{{ $errors->has('tgl_lahir') ? ' is-invalid' : '' }}" name="tgl_lahir" value="{{ $item->tgl_lahir }}" placeholder="Masukkan tanggal lahir customer" >
                                                    @if ($errors->has('tgl_lahir'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tgl_lahir') }}</strong>
                                                </span>
                                                                @endif

                                                </div>

                                                <div class="form-group">
                                                    <label for="nowa">Nomor HP/WA Customer</label>
                                                    <input type="text" id="nowa{{$item->id}}" pattern="\d*"  class="form-control{{ $errors->has('nowa') ? ' is-invalid' : '' }}" name="nowa" value="{{ $item->nowa }}" placeholder="Masukkan nomor HP customer" >
                                                    @if ($errors->has('nowa'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nowa') }}</strong>
                                    </span>
                                                    @endif

                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email Customer</label>
                                                    <input type="email" id="email{{$item->id}}"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $item->email }}" placeholder="Masukkan email customer" >
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                    @endif

                                                </div>
                                                <div class="form-group">
                                                    <label for="instagram">Instagram Customer</label>
                                                    <input type="text" id="instagram{{$item->id}}"  class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}" name="instagram" value="{{ $item->instagram }}" placeholder="Masukkan Instagram customer" >
                                                    @if ($errors->has('instagram'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('instagram') }}</strong>
                                    </span>
                                                    @endif

                                                </div>
                                                <input type="hidden" name="id" id="id{{$item->id}}" value="{{ $item->id }}">

                                                <small class="text-muted"><em>Cek kembali sebelum menyimpan</em></small>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary" value="Simpan Customer">
                                            </div>
                                        </form>
                                </div>
                            </div>
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
        function hapusCustomer(custid) {
            var id=custid.replace("hapus","")
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data customer akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:'{{ route('customer.hapus') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id
                    },success:function (s) {
                        if(s==='ok'){
                            Swal.fire(
                                'Berhasil!',
                                'Data customer telah dihapus',
                                'success'
                            )
                            setTimeout(function(){
                                window.location.reload()
                            }, 3000);
                        }
                    }
                })

            }
        })
        }

        function updateStok(barangid) {
            var id=barangid.replace("barang","")
            $.ajax({
                url:"{{ route('stok.update') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:id,
                    stok:$("#stok"+id).val()
                },success:function (s) {
                    if(s==="ok"){
                        window.location.reload()
                    }
                }
            })
        }
    </script>
@endsection
