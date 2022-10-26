<x-guest-layout>

    <x-slot name="title">SELAMAT DATANG</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/chocolat/dist/css/chocolat.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
      <style>
          .section .section-lead {
              margin-left: 0px!important;
          }
          .main-wrapper.container {
              width: 100%;
              max-width: 100%;
              padding: 0px;
          }
      </style>
    </x-slot>
    
    <!-- Main Content -->
    <div class="container">
      <div class="main-content">
          <section class="section">
            <div class="section-body">
              <div class="row">
                <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                  <div class="card" style="border-radius: 10px;">
                    <div class="card-body p-3">
                      <div class="chocolat-parent">
                        <a href="{{ ($book->book_main_image != '') ? url(Storage::url($book->book_main_image)) : asset('img/no_img.jpg') }}" class="chocolat-image" title="{{ $book->title }}">
                          <div data-crop-image="285" style="overflow: hidden;position: relative;height: 285px;text-align: center;">
                            <img alt="image" src="{{ ($book->book_main_image != '') ? url(Storage::url($book->book_main_image)) : asset('img/no_img.jpg') }}" class="img-fluid" style="height: 305px;">
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-6">
                  <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text"><a href="{{ route('categories', 'semua-buku') }}?filter_by=pengarang&keyword={{ $book->author_name }}">{{ $book->author_name }}</a></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Deskripsi Buku</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        {!! $book->synopsis !!}
                      </div>
                    </div>
                    <h6>Detail</h6>
                    <table class="table table-md">
                      <tbody>
                        <tr>
                          <td class="pl-0" style="width: 50%;">
                            Penerbit
                            <p><a href="{{ route('categories', 'semua-buku') }}?filter_by=penerbit&keyword={{ $book->publisher_name }}">{{ $book->publisher_name }}</a></p>
                          </td>
                          <td style="width: 50%;">
                            ISBN
                            <p>{{ $book->isbn }}</p>
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-0" style="width: 50%;">
                            Tahun Terbit
                            <p>{{ $book->year_publication }}</p>
                          </td>
                          <td style="width: 50%;">
                            Jumlah Halaman
                            <p>{{ $book->jumlah_halaman }}</p>
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-0" style="width: 50%;">
                            Panjang (cm)
                            <p>{{ $book->panjang }}</p>
                          </td>
                          <td style="width: 50%;">
                            Lebar (cm)
                            <p>{{ $book->lebar }}</p>
                          </td>
                        </tr>
                        <tr>
                          <td class="pl-0" colspan="2">
                            Berat (kg)
                            <p>{{ $book->berat ?? 0 }}</p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <h6>Eksemplar</h6>
                    <table class="table table-md">
                      <tbody>
                        @foreach ($exemplars as $exemplar)
                          <tr @if (!$loop->last) class="border-bottom" @endif>
                            <td class="pl-0" style="width: 50%;">
                              <b>Lokasi Buku</b>
                              <p>{{ $exemplar->location_name }}</p>
                            </td>
                            <td style="width: 50%;">
                              <b>Posisi</b>
                              <p>{{ $exemplar->position }}</p>
                            </td>
                            <td style="width: 50%;">
                              <b>Jumlah</b>
                              <p>{{ $exemplar->total }}</p>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                  <div class="card">
                    <div class="card-body">
                      <h6>Jumlah buku yang tersedia?</h6>
                      <p class="card-text">{{ $totals }}</p>
                      <hr>
                      <a href="#" id="btn-cart" class="btn btn-outline-primary btn-block
                        {{ $disabled }}
                      "><i class="far fa-star"></i> Bookmark</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                  <div class="card" style="border-radius: 10px;">
                    <div class="card-body">
                      <h6>Review Buku</h6>
                      <div class="border-top border-bottom">
                        <iframe sandbox="" id="the_iframe" src="https://www.goodreads.com/api/reviews_widget_iframe?did=DEVELOPER_ID&amp;format=html&amp;isbn={{ $book->isbn }}&amp;links=660&amp;min_rating=&amp;review_back=fff&amp;stars=000&amp;text=000" width="100%" height="400" frameborder="0"></iframe>
                      </div>
                      <div class="text-right mt-2">Reviews from Goodreads.com</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
      <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
      <script>
      $(function() {
        $('#btn-cart').on('click', function (e) {
          e.preventDefault();
          var btn = $(this);
          var formData = new FormData();
          formData.append('_token', '{{ csrf_token() }}');
          formData.append('book_id', '{{ $book->id }}');
          $.ajax({
            type: "POST",
            url: '{{ route("cart.store") }}',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
              btn.addClass('btn-progress');
            },
            complete: function() {
              btn.removeClass('btn-progress');
            },
            success: function(html) {
              btn.addClass('disabled');
              //alert('ok');
            }
          });
        });
      }); 
      </script>
    </x-slot>
</x-guest-layout>  
