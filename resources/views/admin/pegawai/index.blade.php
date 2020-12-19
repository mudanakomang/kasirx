@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Pegawai & Kasir</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Pegawai
                <a href="{{ url('admin/pegawai/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Pegawai
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
                            <th>Nomor HP</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pegawai as $key=>$item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->tgl_lahir }}</td>
                                <td>{{ $item->nomorhp }}</td>
                                <td>{{ $item->email }}</td>
                                <td><a href="javascript:void(0);" id="{{ $item->id }}" onclick="event.preventDefault();hapusPegawai(this.id);"><i class="fa fa-trash"></i> Hapus</a> ||
                                    <a href="{{ url('admin/pegawai/edit/').'/'.$item->id }}" ><i class="fa fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted"></div>
        </div>
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                User
                <a href="{{ url('admin/user/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah User
                  </span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user as $key=>$item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->role->name }}</td>
                                <td><a href="javascript:void(0);" id="{{ $item->id }}" onclick="event.preventDefault();hapusUser(this.id);"><i class="fa fa-trash"></i> Hapus</a> ||
                                    <a href="{{ url('admin/user/edit/').'/'.$item->id }}" ><i class="fa fa-edit"></i> Edit</a>
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
        function hapusPegawai(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data pegawai akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:'{{ route('pegawai.hapus') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id
                    },success:function (s) {
                        if(s==='success'){
                            Swal.fire(
                                'Berhasil!',
                                'Data pegawai telah dihapus',
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

        function hapusUser(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data user akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:'{{ route('user.hapus') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id
                    },success:function (s) {
                        if(s==='success'){
                            Swal.fire(
                                'Berhasil!',
                                'Data user telah dihapus',
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
    </script>
@endsection
