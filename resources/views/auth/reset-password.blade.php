<x-auth-layout>

    <x-slot name="title">Reset Password</x-slot>

    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand mb-4">
                <a href="{{ url('') }}">
                    <img src="{{ asset('img/stisla-transparent.svg') }}" alt="logo" width="100" class="mb-1">
                </a>

                <h6>RESET PASSWORD</h6>

            </div>

            <div class="card card-grey mb-0">
                
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                {{-- <div class="card-header"><h4>Masuk</h4></div> --}}

                <div class="card-body">
                
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="text" class="form-control" name="email" tabindex="1" value="{{ old('email', $request->email) }}" required autofocus>
                            <div class="invalid-feedback">
                            Email wajib diisi.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                            <div class="invalid-feedback">
                                Password wajib diisi.
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="password_confirmation" class="d-block">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            <div class="invalid-feedback">
                                Konfirmasi Password wajib diisi.
                            </div>
                        </div> 

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                            Reset Password
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
