<x-auth-layout>

  <x-slot name="title">Lupa Password</x-slot>

  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand mb-4">
            <a href="{{ url('') }}">
                <img src="{{ asset('img/stisla-transparent.svg') }}" alt="logo" width="100">
            </a>
          </div>

          <div class="card">
            {{-- <div class="card-header"><h4>Lupa Password</h4></div> --}}

            <div class="card-body">

              <!-- Session Status -->
              <x-auth-session-status class="mb-4" :status="session('status')" />

              <!-- Validation Errors -->
              <x-auth-validation-errors class="mb-4" :errors="$errors" />

              <p>Kami akan mengirimkan tautan ke Email anda untuk mengatur ulang Password</p>
              <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                @csrf
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" tabindex="1" required autofocus>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                    Lupa Password
                  </button>
                </div>
              </form>
            </div>
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
