@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item active">Retail Dashboard</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-primary text-white">
                        <h1>Revenue</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-money text-white"></i>
                        </div>
                        <div class="card-text text-center">
                            <span class="display-3"><strong>13.2</strong>k</span>
                            <small class="text-danger"> <strong>6%<i class="fa fa-arrow-down"></i> </strong></small>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="revenue.html">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-warning text-white">
                        <h1>Sales Count</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-flash"></i>
                        </div>
                        <div class="card-text text-center">
                            <span class="display-3"><strong>17</strong></span>
                            <small class="text-primary"> <strong>26%<i class="fa fa-arrow-up"></i> </strong></small>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="sales-count.html">
                        <span class="float-left">View Details</span>
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
                        <h1>Gross Profit</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="card-text text-center">
                            <span class="display-3"><strong>8.2</strong>k</span>
                            <small class="text-danger"> <strong>3%<i class="fa fa-arrow-down"></i> </strong></small>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="gross-profit.html">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                          </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-6 col-sm-12 mb-3">
                <div class="card o-hidden h-100">
                    <div class="card-header bg-dark text-white">
                        <h1>Account</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-body-icon text-white">
                            <i class="fa fa-fw fa-dollar"></i>
                        </div>
                        <div class="card-text text-center">
                            <span class="display-3"><strong>27.5</strong>k</span>
                            <small class="text-primary"> <strong>52%<i class="fa fa-arrow-up"></i> </strong></small>
                        </div>
                    </div>
                    <a class="card-footer clearfix small z-1" href="accounts.html">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                          </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-table"></i>
                Recorded Sales
                <a href="#" class="text-white" data-toggle="modal" data-target="#addSaleModal">
                <span class="float-right">
                  <i class="fa fa-plus"></i>
                  Add New Entry
                </span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>INVOICE-ID</th>
                            <th>Product</th>
                            <th>In-Stock</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Profit</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>INVOICE-ID</th>
                            <th>Product</th>
                            <th>In-Stock</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Profit</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#451188</td>
                            <td>USB Audio Controller</td>
                            <td class="text-primary">12</td>
                            <td>Rs200</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs25</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        <tr>
                            <td>#456488</td>
                            <td>Audionic MIC AM-20</td>
                            <td class="text-danger">03</td>
                            <td>Rs2100</td>
                            <td>04/10/2018</td>
                            <td class="text-primary">Rs80</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
    </div>
    @endsection