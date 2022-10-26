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
  
              <div class="card-body">
  
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Terima kasih telah mendaftar! Sebelum memulai, verifikasi alamat email Anda dengan mengeklik tautan yang telah kami kirimkan melalui email kepada Anda? Jika Anda tidak menerima email tersebut, klik tautan dibawah untuk mengirim ulang.') }}
                </div>
        
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
                    </div>
                @endif
        
                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
        
                        <div class="mb-2">
                            <button type="submit" class="btn btn-warning btn-lg btn-block">
                                {{ __('Kirim Ulang Email untuk Verifikasi') }}
                            </button>
                        </div>
                    </form>
        
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
        
                        <button type="submit" class="btn btn-dark btn-lg btn-block">
                            {{ __('Keluar') }}
                        </button>
                    </form>
                </div>

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
