@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Jasa</li>
        </ol>
        <!-- Page Content -->
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Data Jasa
                <a href="{{ url('admin/jasa/tambah') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Jasa
                  </span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Jasa</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jasa as $key=>$item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ formatRp($item->harga) }}</td>
                                <td><a href="javascript:void(0);" id="hapus{{ $item->id }}" onclick="event.preventDefault();hapusJasa(this.id);"><i class="fa fa-trash"></i> Hapus</a> ||
                                    <a href="{{ url('admin/jasa/edit/').'/'.$item->id }}" ><i class="fa fa-edit"></i> Edit</a>
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
        function hapusJasa(jasaid) {
            var id=jasaid.replace("hapus","")
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data jasa akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url:'{{ route('jasa.hapus') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id
                    },success:function (s) {
                        if(s==='ok'){
                            Swal.fire(
                                'Berhasil!',
                                'Data jasa telah dihapus',
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
