@extends('layouts.master')
@section('content')
    <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Inventory</li>
    </ol>
    <!-- Page Content -->
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-table"></i>
            Data Barang
            <a href="{{ url('admin/tambahbarang') }}" class="text-white" >
                  <span class="float-right">
                    <i class="fa fa-plus"></i>
                    Tambah Barang
                  </span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Keterangan</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga / Satuan</th>
                        <th>Jenis</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $key=>$item)
                              <tr>
                                  <td>{{ $key+1 }}</td>
                                  <td>{{ $item->id }}</td>
                                  <td>{{ $item->nama }}</td>
                                  <td>{{ $item->keterangan }}</td>
                                  <td>{{ $item->stok }}</td>
                                  <td>{{ $item->satuan }}</td>
                                  <td>{{ formatRp($item->harga) .' / '.$item->satuan}}</td>
                                  <td>{{ $item->jenisBarang->jenis }}</td>
                                  <td><a href="javascript:void(0);" id="{{ $item->id }}" onclick="event.preventDefault();hapusBarang(this.id);"><i class="fa fa-trash"></i> Hapus</a> ||
                                        <a href="{{ url('admin/barang/edit/').'/'.$item->id }}" ><i class="fa fa-edit"></i> Edit</a>||
                                      <a href="" data-toggle="modal" data-target="#tambahStok{{ $item->id }}"> <i class="fa fa-plus"></i> Tambah Stok</a>
                                  </td>
                              </tr>

                              <div class="modal fade" id="tambahStok{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                          <form class="" id="formItem">
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <label>Sisa stok Terakhir :{{ $item->stok }}</label>
                                                  </div>
                                                  <div class="form-group">
                                                      <label>Jumlah Stok Masuk <small class="text-muted">(Dalam {{ $item->satuan }})</small></label>
                                                      <input type="number" min="0" step="0.5" id="stok{{ $item->id }}" name="stok" value="{{ old('stok') }}" class="form-control">
                                                      <div class="text-danger stok">

                                                      </div>

                                                  </div>


                                              </div>
                                              <div class="modal-footer">
                                                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                  <input type="submit" id="barang{{$item->id}}" class="btn btn-primary" onclick="event.preventDefault();updateStok(this.id)" value="Simpan">
                                              </div>
                                          </form>
                                      </div>
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
    function hapusBarang(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data barang akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText:'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                url:'{{ route('barang.hapus') }}',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id
                },success:function (s) {
                    if(s==='success'){
                        Swal.fire(
                            'Berhasil!',
                            'Data barang telah dihapus',
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
