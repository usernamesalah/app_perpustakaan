<x-app-layout>

  <x-slot name="title">Laporan</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
   
    <style>
      .file {
        visibility: hidden;
        position: absolute;
      }
    </style>
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{ route('admin.borrow.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>LAPORAN</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Laporan</div>
        </div>
      </div>

      <div class="section-body">
        <form method="GET" target="_blank" action="{{ route('admin.reports.members.export') }}" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Laporan Anggota Berdasarkan Jenis Keanggotaan</h4>
                </div>
                <div class="card-body">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Tanggal Awal</label>
                          <input type="text" name="tgl_awal" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Awal wajib diisi.
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-date-added">Tanggal Akhir</label>
                          <input type="text" name="tgl_akhir" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Akhir wajib diisi.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <input type="hidden" name="type" value="Laporan Anggota Berdasarkan Jenis Keanggotaan"/>
                        <button type="submit" target="_blank" name="extension" value="excel" id="button-excel" class="btn btn-success pull-right mr-2 mb-2"><i class="fa fa-file-excel"></i> Export Excel</button>
                        <button type="submit" target="_blank" name="extension" value="pdf" id="button-pdf" class="btn btn-dark pull-right mr-2 mb-2"><i class="fa fa-file-pdf"></i> Export PDF</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <form method="GET" target="_blank" action="{{ route('admin.reports.members.export') }}" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Laporan Anggota Berdasar Jenis Kelamin</h4>
                </div>
                <div class="card-body">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Tanggal Awal</label>
                          <input type="text" name="tgl_awal" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Awal wajib diisi.
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-date-added">Tanggal Akhir</label>
                          <input type="text" name="tgl_akhir" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Akhir wajib diisi.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <input type="hidden" name="type" value="Laporan Anggota Berdasar Jenis Kelamin"/>
                        <button type="submit" target="_blank" name="extension" value="excel" id="button-excel" class="btn btn-success pull-right mr-2 mb-2"><i class="fa fa-file-excel"></i> Export Excel</button>
                        <button type="submit" target="_blank" name="extension" value="pdf" id="button-pdf" class="btn btn-dark pull-right mr-2 mb-2"><i class="fa fa-file-pdf"></i> Export PDF</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <form method="GET" target="_blank" action="{{ route('admin.reports.books.export') }}" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Laporan Buku Berdasar Sumber Perolehan</h4>
                </div>
                <div class="card-body">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Tanggal Awal</label>
                          <input type="text" name="tgl_awal" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Awal wajib diisi.
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-date-added">Tanggal Akhir</label>
                          <input type="text" name="tgl_akhir" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Akhir wajib diisi.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <input type="hidden" name="type" value="Laporan Buku Berdasar Sumber Perolehan"/>
                        <button type="submit" target="_blank" name="extension" value="excel" id="button-excel" class="btn btn-success pull-right mr-2 mb-2"><i class="fa fa-file-excel"></i> Export Excel</button>
                        <button type="submit" target="_blank" name="extension" value="pdf" id="button-pdf" class="btn btn-dark pull-right mr-2 mb-2"><i class="fa fa-file-pdf"></i> Export PDF</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <form method="GET" target="_blank" action="{{ route('admin.reports.books.export') }}" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Laporan Buku Berdasar Klasifikasi</h4>
                </div>
                <div class="card-body">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Tanggal Awal</label>
                          <input type="text" name="tgl_awal" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Awal wajib diisi.
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-date-added">Tanggal Akhir</label>
                          <input type="text" name="tgl_akhir" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Akhir wajib diisi.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <input type="hidden" name="type" value="Laporan Buku Berdasar Klasifikasi"/>
                        <button type="submit" target="_blank" name="extension" value="excel" id="button-excel" class="btn btn-success pull-right mr-2 mb-2"><i class="fa fa-file-excel"></i> Export Excel</button>
                        <button type="submit" target="_blank" name="extension" value="pdf" id="button-pdf" class="btn btn-dark pull-right mr-2 mb-2"><i class="fa fa-file-pdf"></i> Export PDF</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <form method="GET" target="_blank" action="{{ route('admin.reports.book-induk.export') }}" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Laporan Buku Induk</h4>
                </div>
                <div class="card-body">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-name">Tanggal Awal</label>
                          <input type="text" name="tgl_awal" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Awal wajib diisi.
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="control-label" for="input-date-added">Tanggal Akhir</label>
                          <input type="text" name="tgl_akhir" class="form-control datepicker" value="" required>
                          <div class="invalid-feedback">
                            Tanggal Akhir wajib diisi.
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <input type="hidden" name="type" value="Laporan Detail Data Buku Induk"/>
                        <button type="submit" target="_blank" name="extension" value="excel" id="button-excel" class="btn btn-success pull-right mr-2 mb-2"><i class="fa fa-file-excel"></i> Export Excel</button>
                        {{-- <button type="submit" target="_blank" name="extension" value="pdf" id="button-pdf" class="btn btn-dark pull-right mr-2 mb-2"><i class="fa fa-file-pdf"></i> Export PDF</button> --}}
                      </div>
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
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script> 

    $(function() {

      

    }); 
    </script>
  </x-slot>
</x-app-layout>