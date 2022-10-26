<x-auth-layout>

    <x-slot name="title">Daftar</x-slot>

    <section class="section">
        <div class="container mt-5">
          <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
              <div class="login-brand mb-4">
                <a href="{{ url('') }}">
                  <img src="{{ asset('img/stisla-transparent.svg') }}" alt="logo" width="100" class="mb-1">
                </a>
                <h6 class="text-muted">PENDAFTARAAN</h6>
                <h6 class="text-muted">ANGGOTA PERPUSTAKAAN</h6>
              </div>
              <div class="card">
                <div class="card-body pt-4">
                  <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                  @csrf
                    <div class="form-group row mb-4 mt-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIK</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control @if ($errors->has('no_identity')) is-invalid @endif" name="no_identity" value="{{ old('no_identity') }}" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('no_identity'))
                            {{ $errors->first('no_identity') }}
                          @else
                            NIK wajib diisi.
                          @endif
                          </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name') }}" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('name'))
                              {{ $errors->first('name') }}
                          @else
                              Nama wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('email'))
                              {{ $errors->first('email') }}
                          @else
                              Email wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" name="password" value="" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('password'))
                              {{ $errors->first('password') }}
                          @else
                              Password wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konfirmasi Password</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="password" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" value="" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('password_confirmation'))
                              {{ $errors->first('password_confirmation') }}
                          @else
                              Konfirmasi Password wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control @if ($errors->has('address')) is-invalid @endif" name="address" value="{{ old('address') }}" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('address'))
                              {{ $errors->first('address') }}
                          @else
                              Alamat wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipe</label>
                      <div class="col-sm-12 col-md-8">
                        <select class="form-control selectric @if ($errors->has('type')) is-invalid @endif" name="type" required>
                          <option value="">Pilih...</option>
                          @foreach ($type as $value)
                            <option value="{{ $value->id }}" {{ old('type') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          @if ($errors->has('type'))
                              {{ $errors->first('type') }}
                          @else
                              Tipe wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Instansi / Sekolah / Universitas</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control @if ($errors->has('agency')) is-invalid @endif" name="agency" value="{{ old('agency') }}" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('agency'))
                              {{ $errors->first('agency') }}
                          @else
                              Nama Instansi / Sekolah / Universitas wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telpon / Hp</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control @if ($errors->has('no_telp')) is-invalid @endif" name="no_telp" value="{{ old('no_telp') }}" required>
                        <div class="invalid-feedback">
                          @if ($errors->has('no_telp'))
                              {{ $errors->first('no_telp') }}
                          @else
                              No Telpon wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                      <div class="col-sm-12 col-md-8">
                        <select class="form-control selectric @if ($errors->has('gender')) is-invalid @endif" name="gender" required>
                          <option value="">Pilih...</option>
                          @foreach ($gender as $value)
                            <option value="{{ $value->id }}" {{ old('gender') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                          @endforeach
                        </select>
                        <div class="invalid-feedback">
                          @if ($errors->has('gender'))
                              {{ $errors->first('gender') }}
                          @else
                              Jenis Kelamin wajib diisi.
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4" id="form-foto">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                      <div class="col-sm-12 col-md-8">
                        <div id="image-preview" class="image-preview @if ($errors->has('image')) is-invalid @endif" style="background-image: url(''); background-size: cover; background-position: center center;">
                          <label for="image-upload" id="image-label">Choose File</label>
                          <input type="file" name="image" id="image-upload">
                        </div>
                        @if ($errors->has('image'))
                          <div class="text-danger">
                            {{ $errors->first('image') }}
                          </div>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row mt-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-8">
                        <button type="submit" class="btn btn-warning btn-lg">
                            Daftar
                        </button>
                      </div>
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

    <x-slot name="extra_js">
        <script src="{{ asset('vendor/jquery_upload_preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
        <script src="{{ asset('js/plugin.js') }}"></script>
    
        <script> 
        $(function() {
          $.uploadPreview({
            input_field: "#image-upload",   // Default: .image-upload
            preview_box: "#image-preview",  // Default: .image-preview
            label_field: "#image-label",    // Default: .image-label
            label_default: "Choose File",   // Default: Choose File
            label_selected: "Change File",  // Default: Change File
            no_label: false,                // Default: false
            success_callback: null          // Default: null
          });

          $('[name="type"]').on('change',  function() {
            let value = $(this).val();
            if (value == 1) {
              $('[name="agency"]').prop('required', false);
            } else {
              $('[name="agency"]').prop('required', true);
            }
          });
        }); 
        </script>
    </x-slot>

</x-auth-layout>
