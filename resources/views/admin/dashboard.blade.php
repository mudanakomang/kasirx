@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active"> Dashboard {{ today('Asia/Makassar')->format('d M Y') }}</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-primary text-white">
                        <h1>Stok Barang</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-tags text-white"></i>
                        </div>
                        <div class="card-text text-center">
                            <ul class="list-group">


                            @foreach(\App\Barang::orderBy('stok','asc')->take(10)->get() as $barang)
                                <li class="list-group-item d-flex justify-content-between align-items-center">{{ $barang->nama }} <span class="badge badge-warning badge-pill">{{ $barang->stok }}</span> </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="{{ url('admin/inventory') }}">
                        <span class="float-left"> Detail</span>
                        <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-dark text-white">
                        <h1>Statistik Barang</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-tags"></i>
                        </div>
                        <canvas id="inventory" width="60%" height="60%"></canvas>
                    </div>
                    <a class="card-footer clearfix small z-1" href="{{ url('admin/inventory') }}">
                        <span class="float-left">Detail</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                          </span>
                    </a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-primary text-white">
                        <h1><small class="">Omset & Keuntungan Hari ini</small></h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="card-text text-center">
                            <span class="display-3"><strong>{{ OmsetProfit()['omset'] }}</strong></span>
                        </div>
                        <div class="card-text text-center">
                            <span class="display-3"><strong>{{ OmsetProfit()['profit'] }}</strong></span>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="javascript:void(0)">

                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-warning text-white">
                        <h1>Treatment Hari ini</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-flash"></i>
                        </div>
                        <div class="card-text text-center">
                            <ul class="list-group">
                                @php
                                    $data=[];
                                @endphp
                                @foreach(\Illuminate\Support\Facades\DB::select(\Illuminate\Support\Facades\DB::raw('SELECT nama, paket_transaksi.*  from `transaksi` LEFT JOIN paket_transaksi ON transaksi.id=paket_transaksi.transaksi_id
                                            LEFT JOIN paket ON paket.id=paket_transaksi.paket_id
                                            where date(transaksi.updated_at) = DATE(NOW()) and not exists (select * from `transaksi_batal` where `transaksi`.`id` = `transaksi_batal`.`transaksi_id`) and `print` = "y"')) as $paket)
                                    @php
                                        array_push($data ,['nama'=>$paket->nama,'qty'=>$paket->qty]);
                                    @endphp

                                @endforeach
                                @foreach(sumPaket($data) as $pkt)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">{{ $pkt['nama'] }} <span class="badge badge-warning badge-pill">{{ $pkt['qty'] }}</span> </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="{{ url('transaksi') }}">
                        <span class="float-left"> Detail</span>
                        <span class="float-right">
                      <i class="fa fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-12">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-dark text-white">
                        <h1>Statistik Keuntungan Bulanan</h1>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="tahun">Pilih Tahun</label>
                            <input type="number" id="tahun" max="2100" min="2010"  step="1" class="form-control{{ $errors->has('tahun') ? ' is-invalid' : '' }}" name="tahun" value="{{ old('tahun') }}" placeholder="Masukkan Tahun" >
                            @if ($errors->has('tahun'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tahun') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-tags"></i>
                        </div>
                        <canvas id="omsetprofit" width="60%" height="20%"></canvas>
                    </div>
                    <a class="card-footer clearfix small z-1" href="{{ url('transaksi') }}">
                        <span class="float-left">Detail</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                          </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- DataTables Example -->
        {{--<div class="card mb-3">--}}
            {{--<div class="card-header bg-primary text-white">--}}
                {{--<i class="fa fa-table"></i>--}}
                {{--Recorded Sales--}}
                {{--<a href="#" class="text-white" data-toggle="modal" data-target="#addSaleModal">--}}
                {{--<span class="float-right">--}}
                  {{--<i class="fa fa-plus"></i>--}}
                  {{--Add New Entry--}}
                {{--</span>--}}
                {{--</a>--}}
            {{--</div>--}}
            {{--<div class="card-body">--}}
                {{--<div class="table-responsive">--}}
                    {{--<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th>INVOICE-ID</th>--}}
                            {{--<th>Product</th>--}}
                            {{--<th>In-Stock</th>--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Date</th>--}}
                            {{--<th>Profit</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tfoot>--}}
                        {{--<tr>--}}
                            {{--<th>INVOICE-ID</th>--}}
                            {{--<th>Product</th>--}}
                            {{--<th>In-Stock</th>--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Date</th>--}}
                            {{--<th>Profit</th>--}}
                        {{--</tr>--}}
                        {{--</tfoot>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#451188</td>--}}
                            {{--<td>USB Audio Controller</td>--}}
                            {{--<td class="text-primary">12</td>--}}
                            {{--<td>Rs200</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs25</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>#456488</td>--}}
                            {{--<td>Audionic MIC AM-20</td>--}}
                            {{--<td class="text-danger">03</td>--}}
                            {{--<td>Rs2100</td>--}}
                            {{--<td>04/10/2018</td>--}}
                            {{--<td class="text-primary">Rs80</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>--}}
        {{--</div>--}}
    </div>
    @endsection

@section('script')
    <script>
        $('#tahun').on('change',function () {
            omsetProfit()
        })
        function omsetProfit() {
            $.ajax({
                url:"{{ route('dashboard.profit') }}",
                type:'POST',
                data:{
                    _token:"{{ csrf_token() }}",
                    tahun:$('#tahun').val(),
                },success:function (s) {
                    if(s){
                        var data=JSON.parse(s)

                        var profit=[]
                        var omset=[]
                        var labels=[];
                        $.each(data,function (k,v) {
                            profit.push(v.profit)
                            omset.push(v.harga)
                            labels.push(k)
                        })
                        var dataFirst = {
                            label: "Profit",
                            data: profit,
                            lineTension: 0.3,
                            backgroundColor:'rgb(0,200,0,0.3)'
                            // Set More Options
                        };
                        var dataSecond = {
                            label: "Omset",
                            data: omset,
                            backgroundColor:'rgb(200,50,0,0.3)'
                            // Set More Options
                        };
                        var Data = {
                            labels: labels,
                            datasets: [dataFirst, dataSecond]
                        };

                        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                        Chart.defaults.global.defaultFontColor = '#292b2c';
                        var ct=document.getElementById('omsetprofit')
                        var Linecht=new Chart(ct,{
                            type:'line',
                            data:Data,
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            // Include a dollar sign in the ticks
                                            callback: function (value, index, values) {
                                                return 'Rp. '+ $.number(value,0,',','.');
                                            },
                                            stepSize:20000000,
                                        }
                                    }]
                                },
                                tooltips: {
                                    callbacks: {
                                        label: function(tooltipItem, data) {
                                            var label = data.datasets[tooltipItem.datasetIndex].label;
                                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                            return ' ' + label + ': Rp. ' + $.number(value,0,',','.') ;

                                        }
                                    }
                                }
                            }
                        })
//                        console.log(dataset1)
                    }
                }
            })
        }
        $(document).ready(function () {
            omsetProfit()
            $.ajax({
                url:"{{ route('dashboard.inventory') }}",
                type:'POST',
                data:{
                    _token:"{{ csrf_token() }}",
                },success:function (e) {
                   if(e){
                       Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                       Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example

                       var ctx = document.getElementById("inventory");
                       var d=JSON.parse(e)
                       var myPieChart = new Chart(ctx, {
                           type: 'pie',
                           responsive:true,
                           data: {
                              // labels: ["Routers", "Chargers & Cables", "USB Storage", "Display Monitors", "CPU", "Speakers", "Mouse & Pointing Devices", "Power Supplies", "Windows Installation", "Linux Installation", "Others"],
                               labels:d.labels,
                               datasets: [{
                                   data: d.datasets.data,
                                   backgroundColor:d.datasets.backgroundColor
                               }],
                           },
                       });

                   }
                }
            })


        })
    </script>
    @endsection