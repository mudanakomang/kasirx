<ul class="sidebar navbar-nav">
    @if(Auth::user()->hasRole('admin'))
    <li class="nav-item ">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fa fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/jenisbarang') }}">
                <i class="fa fa-fw fa-tags"></i>
                <span>Jenis Barang</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/inventory') }}">
            <i class="fa fa-fw fa-tag"></i>
            <span>Inventory</span></a>
    </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/paket') }}">
                <i class="fa fa-fw fa-gift"></i>
                <span>Paket Treatment</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('transaksi') }}">
                <i class="fa fa-fw fa-print"></i>
                <span>Transaksi</span></a>
        </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/pegawai') }}">
             <i class="fa fa-fw fa-users"></i>
        <span>Pegawai & Kasir</span></a>
    </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/konfig') }}">
                <i class="fa fa-fw fa-cogs"></i>
                <span>Konfigurasi</span></a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ url('transaksi') }}">
                <i class="fa fa-fw fa-print"></i>
                <span>Transaksi</span></a>
        </li>
    @endif

</ul>