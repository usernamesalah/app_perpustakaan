<x-guest-layout>

    <x-slot name="title">SELAMAT DATANG</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/chocolat/dist/css/chocolat.css') }}">
      <link href="{{ asset('vendor/summernote-0.8.18/summernote-bs4.min.css') }}" rel="stylesheet">
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
            {{-- <div class="section-header">
              <div class="section-header-back">
                <i class="fas fa-envelope" aria-hidden="true" style="
                    padding: 5px 0px;
                    font-size: 18px;
                "></i>
              </div>
              <h1>KONTAK</h1>
            </div> --}}
            <div class="section-body">
              <div class="row mb-4 mt-4">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                  {{-- <div id="googleMap" style="width:100%;height:380px;"></div> --}}
                  <form method="POST" id="formInput" action="{{ route('contact.store') }}" class="needs-validation" novalidate>
                    @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="no_identity">Nama Lengkap</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ @$user->name }}" required autofocus>
                                <div class="invalid-feedback">  
                                  Nama Lengkap wajib diisi.
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Email</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ @$user->email }}" required>
                                <div class="invalid-feedback">
                                    Email wajib diisi.
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="name">No Telp / Hp</label>
                              <input id="no_telp" type="text" class="form-control" name="no_telp" value="{{ @$user->member->no_telp }}" required>
                              <div class="invalid-feedback">
                                  No Telp wajib diisi.
                              </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>Subjek</label>
                            <select id="subject" class="form-control selectric" name="subject" required>
                              <option value="">Pilih...</option>
                              <option value="Request Buku">Request Buku</option>
                              <option value="Kritik Dan Saran">Kritik Dan Saran</option>
                            </select>
                            <div class="invalid-feedback">
                              Subjek wajib diisi.
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label>Pesan</label>
                            <textarea id="message" class="form-control summernote-simple" name="message" required></textarea>
                            <div class="invalid-feedback">
                              Pesan wajib diisi.
                            </div>
                          </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-store">
                                KIRIM
                            </button>
                        </div>
                  </form>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="{{ asset('vendor/summernote-0.8.18/summernote-bs4.min.js') }}"></script>
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      {{-- <script src="http://maps.googleapis.com/maps/api/js"></script> --}}
      {{-- <script src="{{ asset('vendor/gmaps/gmaps.js') }}"></script> --}}
      <script>
      $(document).ready(function () {
        $("#formInput").submit(function(e){
          e.preventDefault();
          var btn = $('#btn-store');
          btn.addClass('btn-progress');
          var formData = new FormData($(this)[0]);
          formData.append('_token', '{{ csrf_token() }}');
          $.ajax({
              type: "POST",
              url: $(this).attr('action'),
              data: formData,
              processData: false,
              contentType: false,
              dataType: "json",
              success: function(data, textStatus, jqXHR) {
                $(".is-invalid").removeClass("is-invalid");
                if (data['status'] == true) {
                  swal({
                    title: "Pesan berhasil dikirim!", 
                    icon: "success",
                  })
                  .then((value) => {
                    window.location = "{{ route('contact.index') }}";
                  });
                }
                else {
                  printErrorMsg(data.errors);
                }
                btn.removeClass('btn-progress');
              },
              error: function(data, textStatus, jqXHR) {
                alert('Terjadi kesalahan , Proses dibatalkan!');
              },
          });
        });
      });
      </script>
    </x-slot>
</x-guest-layout>  
