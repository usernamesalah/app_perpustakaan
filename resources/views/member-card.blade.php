<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@isset($title){{ $title }}@endisset - APLIKASI E-LIBRARY</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">

  <!-- Extra CSS -->
  @isset($extra_css)
    {{ $extra_css }}
  @endisset

  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <style>
    .card-member {
      width: 394px;
      height: 239px;
      border: 1px solid #555;
      color: #000;
    }
    td {
      vertical-align: top;
    }
    .bg-image {
      background-image: url(img/card-member2.png);
      background-position: left;
    }
  </style>
</head>

<body>
  <div id="app">
    <div class="card-member p-2 m-1 bg-image">
      <div class="card-member-header text-center">
        <img class="mr-1" src="{{ asset('img/ARSIPUSDA.png') }}" alt="" style="float: left;height: 50px;">
        <div class="pt-2"><b>DINAS PERPUSTAKAAN DAN ARSIP DAERAH <br>Kota Wakanda</b></div>
      </div>
      <hr class="my-2">
      <div class="card-member-body mt-1">
        <img class="img-thumbnail mr-2" src="{{ asset('img/ARSIPUSDA.png') }}" alt="" style="float: left;height: 80px;width:70px;">
        <div class="pt-0">
          <table style="font-size: 12px;font-weight: 700;">
            <tr>
              <td style="width: 85px;">No Anggota</td>
              <td style="width: 10px;">:</td>
              <td>202010123</td>
            </tr>
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td>HANAFIAH</td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td>
              <td>:</td>
              <td>Laki-laki</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>:</td>
              <td>Desa Sungai Limas Rt.3 No.11. Kec.Haur Gading</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
