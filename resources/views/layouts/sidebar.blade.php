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

                <li class="sidebar-item {{ request()->is('categories*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class='sidebar-link'>
                        <i class="bi bi-hexagon-fill"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('uoms*') ? 'active' : '' }}">
                    <a href="{{ route('uoms.index') }}" class='sidebar-link'>
                        <i class="bi bi-hexagon-fill"></i>
                        <span>Uom</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
