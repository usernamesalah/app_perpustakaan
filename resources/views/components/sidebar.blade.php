<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand sidebar-gone-show"><a href="{{ url('') }}">APLIKASI E-LIBRARY</a></div>
        <ul class="sidebar-menu">
            <li class="menu-header">SELAMAT DATANG</li>
            <li class="nav-item {{ (request()->routeIs('admin.dashboard')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active"><i class="fas fa-home"></i><span>BERANDA</span></a>
            </li>
            <li class="menu-header">KATALOG BUKU</li>
            <li class="nav-item dropdown show">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i> <span>KATEGORI</span></a>
            <ul class="dropdown-menu show">
                @foreach ($category as $setup)
                    <li><a class="nav-link" href="">{{ $setup->name }}</a></li>
                @endforeach
            </ul>
        </ul>
    </aside>
</div>
