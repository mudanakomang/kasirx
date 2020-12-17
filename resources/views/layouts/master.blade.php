<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RC-POS - Retail Dashboard</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="index.html">Acix Sales Pro</a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-plus fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSaleModal"> <i class="fa fa-money"></i> New Sale</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addProductModal"> <i class="fa fa-tag"></i> New Product</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addProductTypeModal"> <i class="fa fa-tags"></i> New Product Type</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addProductVendorModal"> <i class="fa fa-user"></i> New Product Vendor</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addProductBrandModal"> <i class="fa fa-industry"></i> New Product Brand</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addExpenseAccountModal"> <i class="fa fa-dollar"></i> New Expense Account</a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-flash fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                <a class="dropdown-item" href="products.html"> <i class="fa fa-tag"></i> All Products</a>
                <a class="dropdown-item" href="product-types.html"> <i class="fa fa-tags"></i> Product Types</a>
                <a class="dropdown-item" href="product-vendors.html"> <i class="fa fa-user"></i> Product Vendors</a>
                <a class="dropdown-item" href="product-brands.html"> <i class="fa fa-industry"></i> Product Brands</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="revenue.html"> <i class="fa fa-money"></i> Revenue</a>
                <a class="dropdown-item" href="improvements.html"> <i class="fa fa-rocket"></i> Improvements</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="accounts.html"> <i class="fa fa-dollar"></i> Accounts</a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow ml-3">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-warning">9+</span>
                <i class="fa fa-fw fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                <a class="dropdown-item text-danger no-text-decorations" href="#"> <i class="fa fa-info-circle"></i> You've few blocked products</a>
                <a class="dropdown-item text-danger no-text-decorations" href="#"> <i class="fa fa-info-circle"></i> Another new notification</a>
                <a class="dropdown-item text-danger no-text-decorations" href="#"> <i class="fa fa-info-circle"></i> Another new notification</a>
                <a class="dropdown-item text-danger no-text-decorations" href="#"> <i class="fa fa-info-circle"></i> Another new notification</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="notifications.html">See more notifications</a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow ml-3">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <div class="dropdown-header">Rao Ahmed</div>
                <a class="dropdown-item" href="profile.html"> <i class="fa fa-user"></i> Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"> <i class="fa fa-cog"></i> Settings</a>
                <a class="dropdown-item" href="history.html"> <i class="fa fa-line-chart"></i> Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"> <i class="fa fa-power-off"></i> Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="wrapper">
    <!-- Sidebar -->
    @include('layouts._sidebar')
    <div id="content-wrapper">
       @yield('content')
        <br><br><br>
        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto ">
                    <br><br><br>
                    <small class="text-muted">
                        You're using  v1.0 of this software. <a href="#"> <i class="fa fa-external-link"></i> Check for Updates</a>. In order to report a bug, please create an issue <a href="https://github.com/vruqa/rc-pos/issues">here.</a>
                        <br><br><br>
                        <a href="#">Legal</a> | <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a> | <a href="#">Advertisements</a>
                    </small>
                    <br><br><br>
                    <span>Copyright &copy; 2013-2018 <a href="#">Blackrock Digital, LLC.</a>, 2018 <a href="https://vruqa.github.io">Vruqa Designs</a>, 2018 <a href="https://appzaib.github.io">Appzaib</a>. All rights reserved.</span>
                    <br><br><br>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>
<!-- Modals -->
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Add Sale Modal-->
<div class="modal fade" id="addSaleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-money"></i>
                    Add New Sale
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Product</label>
                        <select class="form-control text-primary" required>
                            <option disabled selected><sub>Please select a product</sub></option>
                            <option disabled><sub>Speakers &amp; MICs</sub></option>
                            <option>Audionic MIC AM-20</option>
                            <option>USB Sound Card</option>
                            <option>Audionic Headphones AHT-11</option>
                            <option disabled><sub>Mice &amp; Accessories</sub></option>
                            <option>Razer Mousepad</option>
                            <option>Blue Mousepad</option>
                            <option>Apple Mouse Wireless A11</option>
                            <option>DELL Mouse Wireless D232</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option disabled><sub>Mice &amp; Accessories</sub></option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option disabled><sub>Mice &amp; Accessories</sub></option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                            <option>Razer Mousepad</option>
                        </select>
                        <small class="float-right">Product not listed here? <a href="#" data-toggle="modal" data-target="#addProductModal">Add new</a> </small>
                    </div>
                    <div class="form-group">
                        <label for="">Product Price</label>
                        <input type="number" class="form-control" name="" value="" placeholder="Enter product price here..." required>
                    </div>
                    <div class="form-group">
                        <label for="">Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="name" class="form-control" rows="8" cols="80" placeholder="Add some note or description about this sale..."></textarea>
                    </div>
                    <small class="text-muted"><em>Please double check information before submitting.</em></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Add Sale">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Product Modal-->
<!-- Add Product Type-->
<div class="modal fade" id="addProductTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-tags"></i>
                    Add Product Type
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Product Type</label>
                        <input type="text" class="form-control" name="" value="" placeholder="Enter product type..." required>
                        <small class="text-muted">Example: Mousepads, Headphones or Keyboards etc</small>
                    </div>
                    <div class="form-group">
                        <label for="">Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="name" class="form-control" rows="8" cols="80" placeholder="Add some note or description about this product type..."></textarea>
                    </div>
                    <small class="text-muted"><em>Please double check information before submitting.</em></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Add Product Type">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Product Brand-->
<div class="modal fade" id="addProductBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-industry"></i>
                    Add Product Brand
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Product Brand</label>
                        <input type="text" class="form-control" name="" value="" placeholder="Enter brand name here..." required>
                        <small class="text-muted">Example: Nokia, AMB or MSI etc</small>
                    </div>
                    <div class="form-group">
                        <label for="">Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="name" class="form-control" rows="8" cols="80" placeholder="Add some note or description about this vendor..."></textarea>
                    </div>
                    <small class="text-muted"><em>Please double check information before submitting.</em></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Add Brand">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Product Vendor -->
<div class="modal fade" id="addProductVendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-user"></i>
                    Add Products Vendor
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Vendor Name</label>
                        <input type="text" class="form-control" name="" value="" placeholder="Enter vendor's name here..." required>
                        <small class="text-muted">Example: Anees Ahmad, Faisal Hayat or Shahzaib Khan etc</small>
                    </div>
                    <div class="form-group">
                        <label for="">Phone Number</label>
                        <input type="text" class="form-control" name="" value="" placeholder="Enter vendor's phone number here...">
                        <small class="text-muted">Example: 555-665-123</small>
                    </div>
                    <div class="form-group">
                        <label for="">Email Address</label>
                        <input type="email" class="form-control" name="" value="" placeholder="Enter vendor's email here...">
                        <small class="text-muted">Example: ahmadanees02@gmail.com</small>
                    </div>
                    <div class="form-group">
                        <label for="">Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="name" class="form-control" rows="8" cols="80" placeholder="Add some note or description about this vendor..."></textarea>
                    </div>
                    <small class="text-muted"><em>Please double check information before submitting.</em></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Add Vendor">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Expense Account Modal -->
<div class="modal fade" id="addExpenseAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa fa-dollar"></i>
                    Add Expense Account
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Account Title</label>
                        <input type="text" class="form-control" name="" value="" placeholder="Enter account title here..." required>
                        <small class="text-muted">Example: Akhtar Hotel, Mian Tea Stall or My Personal Account etc</small>
                    </div>
                    <div class="form-group">
                        <label for="">How much are you depositing?</label>
                        <input type="email" class="form-control" name="" value="" placeholder="Enter the amount you are despositing...">
                    </div>
                    <div class="form-group">
                        <label for="">Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="name" class="form-control" cols="80" placeholder="Add some note or description about this vendor..."></textarea>
                    </div>
                    <small class="text-muted"><em>Please double check information before submitting.</em></small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Add Account">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('js/rc-pos.min.js') }}"></script>
<script src="{{ asset('js/datatables-demo.js') }}"></script>
<script src="{{ asset('js/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        var url = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        $('li.nav-item').each(function (k,v) {
         var par=$(v)
            var link=par.find('a').attr('href')
            var childurl=link.substring(link.lastIndexOf('/') + 1)
           if(url===childurl){
             par.addClass('active')
           }
        })
    })
</script>
@yield('script')
</body>
</html>
