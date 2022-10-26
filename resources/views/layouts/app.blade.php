<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@isset($title){{ $title }}@endisset - E-PERPUS</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Extra CSS -->
  @isset($extra_css)
    {{ $extra_css }}
  @endisset

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg bg-transparent"></div>
      <nav class="navbar navbar-expand-lg main-navbar position-fixed bg-primary">
      <div class="container">
        <a href="{{ url('') }}" class="navbar-brand d-none d-md-none">e-Library</a>
        <a class="navbar-brand d-none d-md-block" href="{{ url('') }}">
          <img src="{{ asset('img/stisla-light.svg') }}" class="d-inline-block" alt="" style="height: 50px;"> APLIKASI E-LIBRARY
        </a>
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        </div>
        <form class="form-inline ml-auto">
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Pesan
              </div>
              <div class="dropdown-list-content dropdown-list-icons" id="notification">
              </div>
              <div class="dropdown-footer text-center">
                <a href="{{ route('admin.messages.index') }}">Lihat Semua <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset((Auth::User()->foto != null) ? Storage::url('avatars/'.Auth::User()->foto) : 'img/avatar/avatar-5.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::User()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Log out') }}
                </a>
              </form>
            </div>
          </li>
        </ul>
      </div>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg position-fixed">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-home"></i><span>Dasbor</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fa fa-tags"></i><span>Katalog</span></a>
                <ul class="dropdown-menu">
                  @unlessrole('Petugas')
                  <li class="nav-item"><a href="{{ route('admin.category.index') }}" class="nav-link">Kategori</a></li>
                  <li class="nav-item"><a href="{{ route('admin.location.index') }}" class="nav-link">Lokasi</a></li>
                  @endunlessrole
                  <li class="nav-item"><a href="{{ route('admin.author.index') }}" class="nav-link">Pengarang</a></li>
                  <li class="nav-item"><a href="{{ route('admin.publisher.index') }}" class="nav-link">Penerbit</a></li>
                  <li class="nav-item"><a href="{{ route('admin.book.index') }}" class="nav-link">Buku</a></li>
                  <li class="nav-item"><a href="{{ route('admin.import.index') }}" class="nav-link">Import Buku</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="far fa-user"></i><span>Pendaftaran</span></a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a href="{{ route('admin.member.index') }}" class="nav-link">Anggota</a></li>
              </ul>
          </li>
            <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span>Peminjaman</span></a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a href="{{ route('admin.borrow.create') }}" class="nav-link">Peminjaman Baru</a></li>
                  {{-- <li class="nav-item"><a href="#" class="nav-link">Pengembalian Buku</a></li> --}}
                  <li class="nav-item"><a href="{{ route('admin.borrow.index') }}" class="nav-link">Riwayat Peminjaman</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="{{ route('admin.reports.index') }}" class="nav-link"><i class="fa fa-chart-area"></i></i><span>Laporan</span></a>
            </li>
            @unlessrole('Petugas')
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown" aria-expanded="false"><i class="fa fa-cog"></i><span>Lainnya</span></a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a href="{{ route('admin.gallery.index') }}" class="nav-link">Galeri</a></li>
                <li class="nav-item"><a href="{{ route('admin.posts.index') }}" class="nav-link">Tentang</a></li>
                <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link">Admin / Petugas</a></li>
                <li class="nav-item"><a href="{{ route('admin.setting.index') }}" class="nav-link">Pengaturan</a></li>
              </ul>
            </li>
            @endunlessrole
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      {{ $slot }}

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022 All rights reserved | e-library
          <!-- <div class="bullet"></div>  -->
          <!-- Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a> -->
        </div>
        <!-- <div class="footer-right">
          1.0.0
        </div> -->
      </footer>

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('js/stisla.js') }}"></script>

  <script>
    function getNotification() {
      $.ajax({
          type: "GET",
          url: "{{ route('notification') }}",
          data: {},
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(res, textStatus, jqXHR) {
            $('#notification').html('');
            $.each(res.data, function (key, value) {
              var html =
                '<a href="{{ route('admin.messages.index') }}" class="dropdown-item">'+
                    '<div class="dropdown-item-icon bg-info text-white">'+
                      '<i class="fas fa-bell"></i>'+
                    '</div>'+
                    '<div class="dropdown-item-desc">'+
                      '<div><b>'+value['name']+'</b></div>'+
                      '<div><b>'+value['subject']+'</b></div>'+
                      value['short_message'] +
                      '<div class="time">'+value['tgl_notif']+'</div>'+
                    '</div>'+
                '</a>';
                $('#notification').append(html);
            });
          },
          error: function(data, textStatus, jqXHR) {
            console.log(jqXHR + ' , Proses Dibatalkan!');
          },
      });
    }

    getNotification();
  </script>

  <!-- Extra Js -->
  @isset($extra_js)
    {{ $extra_js }}
  @endisset

  <!-- Template JS File -->
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
