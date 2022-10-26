<x-guest-layout>

    <x-slot name="title">SELAMAT DATANG</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/chocolat/dist/css/chocolat.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
      <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
      <style>
          .section .section-lead {
              margin-left: 0px!important;
          }
          .main-wrapper.container {
              width: 100%;
              max-width: 100%;
              padding: 0px;
          }
          .card-member {
            width: 394px;
            height: 239px;
            /* border: 1px solid #555; */
            color: #000;
            line-height: 1.5!important;
          }
          .card-member td {
            vertical-align: top;
          }
          .bg-image {
            background-image: url(img/card-member2.png);
            background-position: left;
          }
      </style>
    </x-slot>
    
    <!-- Main Content -->
    <div class="container">
      <div class="main-content">
          <section class="section">
            <div class="section-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-header">
                      <h4>Profil</h4>
                    </div>
                    <div class="card-body">
                      <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                          <a class="nav-link active" id="utama-tab" data-toggle="tab" href="#utama" role="tab" aria-controls="utama" aria-selected="true">Utama</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="pass-tab" data-toggle="tab" href="#pass" role="tab" aria-controls="pass" aria-selected="false">Ganti Password</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="cetak-tab" data-toggle="tab" href="#cetak" role="tab" aria-controls="cetak" aria-selected="false">Cetak Kartu Anggota</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="riwayat-tab" data-toggle="tab" href="#riwayat" role="tab" aria-controls="cetak" aria-selected="false">Riwayat Peminjaman Buku</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card">
                    <!-- <div class="card-header">
                      <h4>Write Your Post</h4>
                    </div> -->
                    <div class="card-body pt-5">
                      
                      <div class="tab-content no-padding" id="tabContent">
                        
                        <div class="tab-pane fade show active" id="utama" role="tabpanel" aria-labelledby="utama-tab">
                          <form id="updateProfileInformation" method="POST" action="{{ route('profile.updateProfileInformation') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                          @csrf
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIK</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="no_identity" value="{{ $profile->no_identity }}" required>
                              <div class="invalid-feedback">NIK wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="name" value="{{ $profile->name }}" required>
                              <div class="invalid-feedback">Nama wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="email" class="form-control" name="email" value="{{ $profile->user->email }}" readonly>
                              <div class="invalid-feedback">Email wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="address" value="{{ $profile->address }}" required>
                              <div class="invalid-feedback">Alamat wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Instansi / Sekolah / Universitas</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="agency" value="{{ $profile->agency }}" required>
                              <div class="invalid-feedback">Nama Instansi / Sekolah / Universitas wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telpon</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="text" class="form-control" name="no_telp" value="{{ $profile->no_telp }}" required>
                              <div class="invalid-feedback">No Telpon wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipe</label>
                            <div class="col-sm-12 col-md-8">
                              <select class="form-control selectric" name="type" required>
                                <option value="">Pilih...</option>
                                @foreach ($type as $value)
                                  <option value="{{ $value->id }}" {{ $profile->type == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                              </select>
                              <div class="invalid-feedback">
                                  Tipe wajib diisi.
                              </div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                            <div class="col-sm-12 col-md-8">
                              <select class="form-control selectric" name="gender" required>
                                <option value="">Pilih...</option>
                                @foreach ($gender as $value)
                                  <option value="{{ $value->id }}" {{ $profile->gender == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                              </select>
                              <div class="invalid-feedback">
                                  Jenis Kelamin wajib diisi.
                              </div>
                            </div>
                          </div>
                          <div class="form-group row mb-4" id="form-foto">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                            <div class="col-sm-12 col-md-8">
                              <div id="image-preview" class="image-preview" style="background-image: url('{{ ($profile->user->image != '') ? url(Storage::url($profile->user->image)) : asset('img/no_img.jpg') }}'); background-size: cover; background-position: center center;">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-8">
                              <button class="btn btn-dark btn-lg">SIMPAN</button>
                            </div>
                          </div>
                          </form>
                        </div>
      
                        <div class="tab-pane fade" id="pass" role="tabpanel" aria-labelledby="pass-tab">
                          <form method="POST" id="updatePassword" action="{{ route('profile.updatePassword') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                          @csrf
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Sekarang</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="password" class="form-control" name="current_password" value="" required>
                              <div class="invalid-feedback">Password Sekarang wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Baru</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="password" class="form-control" name="password" value="" required>
                              <div class="invalid-feedback">Password wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konfirmasi Password</label>
                            <div class="col-sm-12 col-md-8">
                              <input type="password" class="form-control" name="password_confirmation" value="" required>
                              <div class="invalid-feedback">Konfirmasi Password wajib diisi.</div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-8">
                              <button class="btn btn-dark btn-lg">SIMPAN</button>
                            </div>
                          </div>
                          </form>
                        </div>

                        <div class="tab-pane fade" id="cetak" role="tabpanel" aria-labelledby="cetak-tab">
                          <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                          @csrf
                          <div style="">
                            <div id="card-member" class="card-member p-2 m-1 bg-image">
                              {{-- <div class="card-member-header text-center">
                                <img class="mr-1" src="{{ asset('img/ARSIPUSDA.png') }}" alt="" style="float: left;height: 50px;"> 
                                <div class="pt-2"><b>DINAS PERPUSTAKAAN DAN ARSIP DAERAH <br>Kota Wakanda</b></div>
                              </div> --}}
                              {{-- <hr class="my-2"> --}}
                              <div class="card-member-body mt-1">
                                <div class="rounded-circle mr-2" style="position:relative;top:42px;left:34px;height:110px;width:110px;background-image:url('{{ ($profile->user->image != '') ? url(Storage::url($profile->user->image)) : asset('img/no_img.jpg') }}');background-size: 110px;background-position: top;"></div>
                                <div>
                                  <div style="position:relative;left:180px;bottom:{{ (strlen($profile->name) > 20) ? '70px;' : '50px;' }}width:215px;">
                                    <p class="m-0" style="line-height:1;font-size:18px;font-weight:700;color:#ffc107;">{{ $profile->name }}</p>
                                    <div style="font-size: 12px;color: #ffc107;"><b>{{ $profile->no_member }}</b></div>
                                  </div>
                                  <table style="font-size: 12px;color: #fff;position: relative;left: 180px;top:{{ (strlen($profile->name) > 20) ? '-55px;' : '-40px;' }}width:215px;">
                                    <tr>
                                      <td>
                                        <span style="font-size: 10px;color: #d9d9d9;">Jenis Kelamin</span><br>
                                        {{ ($profile->gender == 1) ? 'Laki-laki' : 'Perempuan' }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <span style="font-size: 10px;color: #d9d9d9;">Alamat</span><br>
                                        {{ $profile->address }}
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <div style="position: relative;left: 10px;bottom: {{ (strlen($profile->name) > 20) ? '80px;' : '60px;' }}">
                                  <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($profile->no_member, 'I25', 2, 33, array(1,1,1), true) !!}" alt="barcode"/>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row mt-4 mb-0">
                            <div class="col-sm-12 col-md-12">
                              <a class="btn btn-dark btn-lg" id="card-download">DOWNLOAD KARTU ANGGOTA</a>
                            </div>
                          </div>
                          </form>
                        </div>

                        <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                          <div class="table-responsive">
                            <table class="table table-striped" id="dataTable" style="width:100%;">
                              <thead class="bg-primary">
                                <tr>
                                  <th class="text-center" style="width: 30px;">
                                    #
                                  </th>
                                  <th>Kode Buku</th>
                                  <th>Judul Buku</th>
                                  <th>Tgl Jatuh Tempo</th>
                                  <th>Status</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
      <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('js/html2canvas.js') }}"></script>
      <script src="{{ asset('vendor/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="{{ asset('vendor/jquery_upload_preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      <script>

      $(function() {

        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
        {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
        };
        var dataTable = $('#dataTable').DataTable({
          processing: true,
          ajax: {
              url: "{{ route('profile.borrow.dataTables') }}",
          },
          columns: [
            {data: null},
            {data: 'book_code'},
            {data: 'book_title'},
            {data: 'due_date'},
            {data: null},
            {data: null},
          ],
          columnDefs : [
            { 
              targets: 0, 
              searchable: false, 
              orderable: false, 
              className: "text-center"
            },
            {
              targets: 4,
              render: function ( data, type, row ) {
                var status = '';
                switch(row['status']) {
                  case 1:
                    status = '<span class="badge badge-info">Sudah dikembalikan</span>';
                    break;
                  case 2:
                    status = '<span class="badge badge-danger">Melebihi batas waktu</span>';
                    break;
                  default:
                    status = '<span class="badge badge-warning">Sedang dipinjam</span>';
                }
                return status;
              },
            },
            {
              targets: 5,
              searchable: false, 
              orderable: false, 
              render: function ( data, type, row ) {
                var url = '{{ route("books", ":slug") }}';
                url = url.replace(':slug', row['slug']);
                var btn = '<a href="'+ url +'" class="btn btn-sm btn-outline-primary btn-icon"><i class="fas fa-eye"></i></a>';
                return btn;
              },
            },
          ],
          order: [[ 1, "asc" ]],
          rowCallback : function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
          }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
          var container = document.getElementById("card-member"); //specific element on page
          // var container = document.body; // full page 
          html2canvas(container).then(function(canvas) {
              var link = document.getElementById("card-download"); //specific element on page
              //document.body.appendChild(link);
              link.download = "member_card.png";
              link.href = canvas.toDataURL("image/png");
              link.target = '_blank';
              //link.click();
          });
        });
        
        $.uploadPreview({
          input_field: "#image-upload",   // Default: .image-upload
          preview_box: "#image-preview",  // Default: .image-preview
          label_field: "#image-label",    // Default: .image-label
          label_default: "Choose File",   // Default: Choose File
          label_selected: "Change File",  // Default: Change File
          no_label: false,                // Default: false
          success_callback: null          // Default: null
        });

        $("#updateProfileInformation").submit(function(e){
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
                    title: "Data berhasil disimpan!", 
                    icon: "success",
                  })
                  .then((value) => {
                    //window.location = "{{ route('admin.member.index') }}";
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

        $("#updatePassword").submit(function(e){
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
                    title: "Data berhasil disimpan!", 
                    icon: "success",
                  })
                  .then((value) => {
                    //window.location = "{{ route('admin.member.index') }}";
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
