<div class="navbar-bg bg-dark"></div>
<nav class="navbar navbar-expand-lg main-navbar bg-dark">
<a href="{{ url('') }}" class="navbar-brand d-none d-md-none">APLIKASI E-LIBRARY</a>
<a class="navbar-brand d-none d-md-block" href="{{ url('') }}">
    <img src="{{ asset('img/stisla-light.svg') }}" class="d-inline-block" alt="" style="height: 50px;"> APLIKASI E-LIBRARY
</a>
<div class="navbar-nav">
    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
</div>

<form class="form-inline ml-auto">
    <ul class="navbar-nav">
    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
    <div class="search-element">
    <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    <div class="search-backdrop"></div>
    </div>
</form>
<ul class="navbar-nav navbar-right">
@auth
<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user text-white">
    <img alt="image" src="{{ asset((Auth::User()->foto != null) ? Auth::User()->foto : 'img/avatar/avatar-5.png') }}" class="rounded-circle mr-1">
    <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::User()->name }}</div></a>
    <div class="dropdown-menu dropdown-menu-right">
    @role('Admin')
    <a href="{{ url('/admin/profile') }}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profil
    </a>
    <a href="{{ route('admin.dashboard') }}" class="dropdown-item has-icon"><i class="fas fa-home"></i> Dasbor</a>
    @else
    <a href="{{ url('/profile') }}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profil
    </a>
    <a href="{{ route('dashboard') }}" class="dropdown-item has-icon"><i class="fas fa-home"></i> Dasbor</a>
    @endrole
    <div class="dropdown-divider"></div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="route('logout')" class="dropdown-item has-icon text-danger"
            onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="fas fa-sign-out-alt"></i> {{ __('Log out') }}
        </a>
    </form>
    </div>
</li>
@endauth
</li>
</ul>
</nav>
