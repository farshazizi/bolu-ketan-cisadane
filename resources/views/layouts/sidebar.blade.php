<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('/') }}">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('/') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Master</li>

                <li class="sidebar-item {{ request()->is('ingredients*') ? 'active' : '' }}">
                    <a href="{{ route('ingredients.index') }}" class='sidebar-link'>
                        <i class="bi bi-bootstrap-fill"></i>
                        <span>Bahan</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('categories*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class='sidebar-link'>
                        <i class="bi bi-collection-fill"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('uoms*') ? 'active' : '' }}">
                    <a href="{{ route('uoms.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-plus-fill"></i>
                        <span>Satuan</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('inventory-stocks*') ? 'active' : '' }}">
                    <a href="{{ route('inventory_stocks.index') }}" class='sidebar-link'>
                        <i class="bi bi-bucket-fill"></i>
                        <span>Stok</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('stocks*') ? 'active' : '' }}">
                    <a href="{{ route('stocks.index') }}" class='sidebar-link'>
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Stok Masuk/Keluar</span>
                    </a>
                </li>

                <li class="sidebar-title">Transaksi</li>

                <li class="sidebar-item {{ request()->is('purchases*') ? 'active' : '' }}">
                    <a href="{{ route('purchases.index') }}" class='sidebar-link'>
                        <i class="bi bi-bag-fill"></i>
                        <span>Pembelian</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('sales*') ? 'active' : '' }}">
                    <a href="{{ route('sales.index') }}" class='sidebar-link'>
                        <i class="bi bi-basket3-fill"></i>
                        <span>Penjualan</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
