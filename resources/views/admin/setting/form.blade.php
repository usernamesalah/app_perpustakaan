<x-app-layout>

  <x-slot name="title">Pengaturan</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('admin.setting.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Pengaturan</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">{{ 'Pengaturan' }}</div>
        </div>
      </div>

      <div class="section-body">
        <!-- <h2 class="section-title">Create New Post</h2>
        <p class="section-lead">
          On this page you can create a new post and fill in all fields.
        </p> -->
        <form method="POST" action="{{ route('admin.setting.update', $setting->id) }}" class="needs-validation" novalidate="" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h4>Pengaturan</h4>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link active" id="utama-tab" data-toggle="tab" href="#utama" role="tab" aria-controls="utama" aria-selected="true">Utama</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="medsos-tab" data-toggle="tab" href="#medsos" role="tab" aria-controls="medsos" aria-selected="false">Media Sosial</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="lainnya-tab" data-toggle="tab" href="#lainnya" role="tab" aria-controls="lainnya" aria-selected="false">Lainnya</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <!-- <div class="card-header">
                <h4>Write Your Post</h4>
              </div> -->
              <div class="card-body pt-5">
                
                <div class="tab-content no-padding" id="tabContent">
                  <div class="tab-pane fade show active" id="utama" role="tabpanel" aria-labelledby="utama-tab">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                      <div class="col-sm-12 col-md-8">
                        {{-- <input type="text" class="form-control" name="alamat" value="{{ $setting->alamat }}" required> --}}
                        <textarea name="alamat" class="form-control" rows="5" required style="min-height: 80px;">{{ $setting->alamat }}</textarea>
                        <div class="invalid-feedback">Alamat Dinas wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telpon</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="telpon" value="{{ $setting->telpon }}" required>
                        <div class="invalid-feedback">No Telpon wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ $setting->email }}" required>
                        <div class="invalid-feedback">Email wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hari Kerja</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="hari_kerja" value="{{ $setting->hari_kerja }}" required>
                        <div class="invalid-feedback">Hari Kerja wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam Kerja</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="jam_kerja" value="{{ $setting->jam_kerja }}" required>
                        <div class="invalid-feedback">Jam Kerja wajib diisi.</div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="medsos" role="tabpanel" aria-labelledby="medsos-tab">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Facebook</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="facebook" value="{{ $setting->facebook }}" required>
                        <div class="invalid-feedback">Facebook wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Twitter</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="twitter" value="{{ $setting->twitter }}" required>
                        <div class="invalid-feedback">Twitter wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Instagram</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="instagram" value="{{ $setting->instagram }}" required>
                        <div class="invalid-feedback">Instagram wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Youtube</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="youtube" value="{{ $setting->youtube }}" required>
                        <div class="invalid-feedback">Youtube wajib diisi.</div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="lainnya" role="tabpanel" aria-labelledby="lainnya-tab">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Denda</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control currency" name="denda" value="{{ $setting->denda }}" required>
                        <div class="invalid-feedback">Denda wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lama Hari Pinjam</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="hari_pinjam" value="{{ $setting->hari_pinjam }}" required>
                        <div class="invalid-feedback">Lama Hari Pinjam wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Maksimal Buku Pinjam</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="max_pinjam" value="{{ $setting->max_pinjam }}" required>
                        <div class="invalid-feedback">Maksimal Buku Pinjam wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lama Tambahan Waktu Peminjaman</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="hari_extend" value="{{ $setting->hari_extend }}" required>
                        <div class="invalid-feedback">Lama Tambahan Waktu Peminjaman wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pemangku</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="pemangku" value="{{ $setting->pemangku }}" required>
                        <div class="invalid-feedback">Pemangku wajib diisi.</div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIP Pemangku</label>
                      <div class="col-sm-12 col-md-8">
                        <input type="text" class="form-control" name="nip_pemangku" value="{{ $setting->nip_pemangku }}" required>
                        <div class="invalid-feedback">NIP Pemangku wajib diisi.</div>
                      </div>
                    </div>
                    {{-- <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-8">
                        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div> --}}
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-8">
                    <button class="btn btn-primary">SIMPAN</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/jquery_upload_preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/format_number.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>

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
</x-app-layout>