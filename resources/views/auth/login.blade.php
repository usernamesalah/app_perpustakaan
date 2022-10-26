<x-auth-layout>

    <x-slot name="title">Masuk</x-slot>

    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand mb-4">
                <a href="{{ url('') }}">
                    <img src="{{ asset('img/stisla-transparent.svg') }}" alt="logo" width="100" class="mb-1">
                </a>

                <h6 class="text-muted">APLIKASI E-LIBRARY</h6>
                <!-- <h6 class="text-muted">MANAGEMEN PERPUSTAKAAN</h6>
                <h6 class="text-muted">DAERAH</h6> -->

            </div>

            <div class="card card-grey mb-0">
              {{-- <div class="card-header"><h4>Masuk</h4></div> --}}

              <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        Login gagal, Akun tidak ditemukan....
                      </div>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                  @csrf
                  <div class="form-group">
                    <label for="email">Email / Username</label>
                    <input id="email" type="text" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Email / Username wajib diisi.
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                        <div class="float-right">
                        <a href="{{ route('password.request') }}" class="text-small">
                          Lupa Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Password wajib diisi.
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                      Masuk
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="mt-2 text-muted text-center">
              Belum memiliki akun? <a href="{{ route('register') }}">Daftar</a>
            </div>
            <div class="simple-footer text-muted">
              Copyright &copy; 2022 All rights reserved | e-library
            </div>
          </div>
        </div>
      </div>
    </section>

    <x-slot name="extra_css">
      <style>
        .card {
          /* box-shadow: none;
          background-color: transparent; */
        }
        #app {
          background-image: url(img/bg.svg);
          background-position: top;
          background-repeat: no-repeat;
        }
      </style>
    </x-slot>

</x-auth-layout>
