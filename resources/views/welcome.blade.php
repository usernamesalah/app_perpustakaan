<x-guest-layout>

    <x-slot name="title">SELAMAT DATANG</x-slot>

    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
      <style>
          body.layout-3 .main-content {
            padding-top: 148px!important;
          }
          .main-wrapper.container {
              width: 100%;
              max-width: 100%;
              padding: 0px;
          }
          .carousel-item img {
              height: 650px;
              background-repeat: no-repeat;
              background-size: cover;
              /* background-position: top; */
              background-position: center;
          }
          .carousel-caption {
              bottom: 40%;
          }
          .text-1 {
            font-weight: 800;
            text-shadow: -1px 0 #111, 0 0px #111, 5px 0 #111, 0 -1px #111;
          }
          .text-2 {
            color: #ffeb3b;
            font-weight: 800;
            text-shadow: -1px 0 #111, 0 0px #111, 5px 0 #111, 0 -1px #111;
          }
          .background-image {
            background-image: url(img/bg.svg);
            background-position: top;
            background-repeat: no-repeat;
          }
          @media (max-width: 1024px){
            .main-content.index {
                padding-left: 0px;
                padding-right: 0px;
                width: 100% !important;
                padding-top: 76px;
                min-height: 500px!important;
            }
            .carousel-item img {
                height: 450px;
            }
            .carousel-caption h1 {
              font-size: 1.5rem
            }
            .carousel-caption {
              bottom: 30%;
            }
            .main-footer {
              padding: 0px!important;
            }
          }
      </style>
    </x-slot>

    <!-- Main Content -->
    <div class="main-content index">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators2" data-slide-to="" class="active"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('img/transparent.png') }}" data-background="{{ asset('img/utama.jpg') }}" alt="#">
                    <div class="carousel-caption d-md-block">
                        <h1 class="text-1">Selamat Datang di Website</h1>
                        <h1 class="text-2">Sistem Informasi Perpustakaan</h1>
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
              </div>
            </div>
            <div class="row justify-content-md-center my-0 p-4 background-image" style="background-color: #fff;">
              <div class="col-12 col-md-6 ">
                  <div class="card my-4">
                      <div class="card-header">
                          <h4 class="text-warning">Pendapat anda tentang Aplikasi e-Library?</h4>
                      </div>
                      <div class="card-body">
                          <form id="form-polling" action="{{ route('polling') }}" method="POST" style="">
                              @csrf
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="polling" id="exampleRadios1" value="1" checked="">
                                  <label class="form-check-label" for="exampleRadios1">
                                      Sangat Baik
                                  </label>
                                  <div class="progress mb-3">
                                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $polling['sangatbaik'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $polling['sangatbaik'] }}%;">{{ $polling['sangatbaik'] }}%</div>
                                  </div>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="polling" id="exampleRadios2" value="2">
                                  <label class="form-check-label" for="exampleRadios2">
                                      Baik
                                  </label>
                                  <div class="progress mb-3">
                                      <div class="progress-bar bg-primary" role="progressbar" data-width="{{ $polling['baik'] }}%" aria-valuenow="{{ $polling['baik'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $polling['baik'] }}%;">{{ $polling['baik'] }}%</div>
                                  </div>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="polling" id="exampleRadios3" value="3">
                                  <label class="form-check-label" for="exampleRadios3">
                                      Cukup
                                  </label>
                                  <div class="progress mb-3">
                                      <div class="progress-bar bg-warning" role="progressbar" data-width="{{ $polling['cukup'] }}%" aria-valuenow="{{ $polling['cukup'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $polling['cukup'] }}%;">{{ $polling['cukup'] }}%</div>
                                  </div>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="polling" id="exampleRadios4" value="4">
                                  <label class="form-check-label" for="exampleRadios4">
                                      Kurang
                                  </label>
                                  <div class="progress mb-3">
                                      <div class="progress-bar bg-danger" role="progressbar" data-width="{{ $polling['kurang'] }}%" aria-valuenow="{{ $polling['kurang'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $polling['kurang'] }}%;">{{ $polling['kurang'] }}%</div>
                                  </div>
                              </div>
                              @if (session('polling') != true )
                              <div align="center" class="mt-3 mb-3">
                                  <button id="btn-simpan" class="btn btn-primary" name="vote">Kirim</button>
                              </div>
                              @endif
                          </form>
                      </div>
                  </div>
              </div>
          </div>
          </div>
        </section>
    </div>

    <x-slot name="extra_js">
      <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
      <script>
      $(function() {
        @if (session('success'))
          iziToast.success({
            title: 'Success!',
            message: '{{ session('success') }}',
            position: 'topRight'
          });
        @endif
      });
      </script>
    </x-slot>
</x-guest-layout>
