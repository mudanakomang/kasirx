@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Jenis Barang</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Jenis Barang
                <a href="{{ url('admin/jenisbarang/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Jenis Barang
                  </span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Barang</th>
                            <th>Keterangan</th>
                            <th>Total Stok</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jenisbarang as $key=>$jenis)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $jenis->jenis }}</td>
                            <td>{{ $jenis->keterangan }}</td>
                            <td>{{ $jenis->barang()->sum('stok') }}</td>
                            <th><a href="javascript:void(0);" onclick="event.preventDefault(); hapusJenis(this.id)" id="{{ $jenis->id }}"><i class="fa fa-trash"></i> Hapus</a> ||
                                <a href="{{ url('admin/jenisbarang/edit/').'/'.$jenis->id }}"><i class="fa fa-edit"></i> Edit</a></th>
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
        function hapusJenis(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Semua barang yang termasuk dalam jenis ini akan dihapus juga!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:'{{ route('jenisbarang.hapus') }}',
                        type:'POST',
                        data:{
                            _token:'{{ csrf_token() }}',
                            id:id
                        },success:function (s) {
                            if(s==='success'){
                                Swal.fire(
                                    'Berhasil!',
                                    'Jenis barang telah dihapus',
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
