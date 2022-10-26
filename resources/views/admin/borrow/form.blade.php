<x-app-layout>

  <x-slot name="title">{{ isset($borrow) ? 'Edit Peminjaman' : 'Peminjaman Baru' }}</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/select2-4.0.13/dist/css/select2.min.css') }}">
   
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
        <h1>{{ isset($borrow) ? 'EDIT PEMINJAMAN' : 'PEMINJAMAN BARU' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('admin.borrow.index') }}">Peminjaman</a></div>
          <div class="breadcrumb-item">{{ isset($borrow) ? 'Edit Peminjaman' : 'Peminjaman Baru' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($borrow))
          <form method="POST" id="formInput" action="{{ route('admin.borrow.update', $borrow->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('admin.borrow.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf

        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-body p-2">
                <div class="m-0 p-4">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label" for="input-name">Kode Buku</label>
                        <select class="form-control selectric js-select2-code-book" name="exemplar_id" id="exemplar_id" required>
                          <option value="">Pilih....</option>
                        </select>
                        <div class="invalid-feedback">
                          Kode Buku wajib diisi.
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label" for="input-date-added">No Anggota</label>
                        <select class="form-control selectric js-select2-no-member" name="member_id" id="member_id" required>  
                          <option value="">Pilih....</option>
                        </select>
                        <div class="invalid-feedback">
                          No Anggota wajib diisi.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-primary" id="btn-store">PINJAM</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h5>DATA BUKU</h5>
        <hr/>
        <div v-if="book" class="row mt-4">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3">
            <div class="card" style="border-radius: 10px;">
              {{-- <div class="card-header">
                <h4>My Picture</h4>
                <div class="card-header-action">
                  <a href="#" class="btn btn-primary">View All</a>
                </div>
              </div> --}}
              <div class="card-body p-3 text-center">
                {{-- <div class="mb-2 text-muted">Click the picture below to see the magic!</div> --}}
                <div class="chocolat-parent">
                  <a :href="book.book.storage_image" class="chocolat-image" title="" target="_blank">
                    <div data-crop-image="285" style="overflow: hidden; position: relative; height: 305px;">
                      <img alt="image" :src="book.book.storage_image" class="img-fluid" style="height: 305px;">
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-9">
            <div class="" style="border-radius: 10px;">
              <div class="card-body">
                <h5 class="card-title">@{{ book.book.title }}</h5>
                <p class="card-text"><a href="#">@{{ book.book.author_name }}</a></p>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Deskripsi Buku</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div v-html="book.book.synopsis"></div>
                  </div>
                </div>
                <h6>Detail</h6>
                <div class="table-responsive">
                  <table class="table table-md">
                    <tbody>
                      <tr>
                        <td class="pl-0" style="width: 33%;">
                          Penerbit
                          <p><a href="#">@{{ book.book.publisher_name }}</a></p>
                        </td>
                        <td style="width: 33%;">
                          ISBN
                          <p>@{{ book.book.isbn }}</p>
                        </td>
                        <td>
                          Tahun Terbit
                          <p>@{{ book.book.year_publication }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td class="pl-0" style="width: 33%;">
                          Lokasi Buku
                          <p>@{{ book.location_name }}</p>
                        </td>
                        <td style="width: 33%;" colspan="2">
                          Posisi
                          <p>@{{ book.position }}</p>
                        </td>
                        {{-- <td>
                          Jumlah
                          <p>xxxxxxx</p>
                        </td> --}}
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h5>DATA ANGGOTA</h5>
        <hr/>
        <div v-if="member" class="row mt-4">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3">
            <div class="card" style="border-radius: 10px;">
              {{-- <div class="card-header">
                <h4>My Picture</h4>
                <div class="card-header-action">
                  <a href="#" class="btn btn-primary">View All</a>
                </div>
              </div> --}}
              <div class="card-body p-3 text-center">
                {{-- <div class="mb-2 text-muted">Click the picture below to see the magic!</div> --}}
                <div class="chocolat-parent">
                  <a :href="member.user.storage_image" class="chocolat-image" title="" target="_blank">
                    <div data-crop-image="285" style="overflow: hidden; position: relative; height: 305px;">
                      <img alt="image" :src="member.user.storage_image" class="img-fluid" style="height: 305px;">
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-9">
            <div class="">
              {{-- <div class="card-header"><h4>Data Anggota</h4></div> --}}
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-md">
                    <tbody>
                      <tr>
                        <td class="pl-0" style="width: 33%;">
                          NIK
                          <p>@{{ member.no_identity }}</p>
                        </td>
                        <td style="width: 33%;">Nama Lengkap
                          <p>@{{ member.name }}</p>
                        </td>
                        <td>
                          Alamat
                          <p>@{{ member.address }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td class="pl-0">
                          Nama Instansi/Sekolah/Universitas
                          <p>@{{ member.agency }}</p>
                        </td>
                        <td>
                          No Telpon
                          <p>@{{ member.no_telp }}</p>
                        </td>
                        <td>
                          Tipe
                          <p>@{{ member.type }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td class="pl-0">
                          Jenis Kelamin
                          <p>@{{ (member.user.gender == 1) ? 'Laki-laki' : 'Perempuan' }}</p>
                        </td>
                        <td>
                          Status
                          <p>@{{ (member.user.status == 1) ? 'Aktif' : 'Nonaktif' }}</p>
                        </td>
                        <td>
                          Email
                          <p>@{{ member.user.email }}</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/select2-4.0.13/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/vuejs/vue.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>

    <script> 

    let dataVue= {
      book : null,
      member : null,
    };

    var app = new Vue({
      el: '#app',
      data: dataVue,
      mounted () {
        //
      },
      methods: {
        getBook: function (id) 
        {
          var url = '{{ route("admin.borrow.get-book", ":id") }}';
          url = url.replace(':id', id);
          $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
              if (data['status'] == true) {
                dataVue.book = data['data'];
                // alert('ok');
              }
            },
            error: function(data, textStatus, jqXHR) {
              alert('Terjadi kesalahan , Proses dibatalkan!');
            },
          });
        },
        getMember: function (id) 
        {
          var url = '{{ route("admin.borrow.get-member", ":id") }}';
          url = url.replace(':id', id);
          $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
              if (data['status'] == true) {
                dataVue.member = data['data'];
              }
              else {
                swal({
                  title: data['msg'], 
                  icon: "warning",
                })
                .then((value) => {
                  window.location = "{{ route('admin.borrow.create') }}";
                });
              }
            },
            error: function(data, textStatus, jqXHR) {
              alert('Terjadi kesalahan , Proses dibatalkan!');
            },
          });
        }
      },
    });

    function formatBook(data) {
      if (data.loading) {
          return data.text;
      }

      var $container = $(
          "<div class='select2-result-repository clearfix'>" +
              "<div class='select2-result-repository__meta'>" +
                  "<div class='select2-result__code_book'></div>" +
                  "<div class='select2-result__description_book'>" +
                      "<div><small>Judul Buku : <span class='select2-result__title_book'></span></small></div>" +
                  "</div>" +
              "</div>" +
          "</div>"
      );

      $container.find(".select2-result__code_book").text(data.text);
      $container.find(".select2-result__title_book").text(data.exemplar.book.title);

      return $container;
    }

    function formatBookSelection (exemplar) {
        return exemplar.text;
    }

    function formatMember(data) {
      if (data.loading) {
          return data.text;
      }

      var $container = $(
          "<div class='select2-result-repository clearfix'>" +
              "<div class='select2-result-repository__meta'>" +
                  "<div class='select2-result__no_member'></div>" +
                  "<div class='select2-result__description'>" +
                      "<div><small>Nama Anggota : <span class='select2-result__name_member'></span></small></div>" +
                  "</div>" +
              "</div>" +
          "</div>"
      );

      $container.find(".select2-result__no_member").text(data.text);
      $container.find(".select2-result__name_member").text(data.exemplar.name);

      return $container;
    }

    function formatMemberSelection (exemplar) {
        return exemplar.text;
    }

    $(function() {

      $('.js-select2-code-book').select2({
          ajax: {
              url: "{{ route('admin.book.ajax-search') }}",
              data: function (params) {
                  var query = {
                    search: params.term,
                  }
                  return query;
              },
              processResults: function (data) {
                  return {
                      results: $.map(data, function (item) {
                          return {
                              id: item.id,
                              text: item.code,
                              exemplar: item
                          }
                      })
                  };
              },
              //cache: true
          },
          placeholder: 'Cari Buku',
          minimumInputLength: 1,
          templateResult: formatBook,
          templateSelection: formatBookSelection,
      });

      $('.js-select2-code-book').on('select2:select', function (e) {
        var data = e.params.data;
        app.getBook(data.id);
      });

      $('.js-select2-no-member').select2({
          ajax: {
              url: "{{ route('admin.member.ajax-search') }}",
              data: function (params) {
                  var query = {
                    search: params.term,
                  }
                  return query;
              },
              processResults: function (data) {
                  return {
                      results: $.map(data, function (item) {
                          return {
                              id: item.id,
                              text: item.no_member,
                              exemplar: item
                          }
                      })
                  };
              },
              //cache: true
          },
          placeholder: 'Cari Anggota',
          minimumInputLength: 1,
          templateResult: formatMember,
          templateSelection: formatMemberSelection,
      });

      $('.js-select2-no-member').on('select2:select', function (e) {
        var data = e.params.data;
        app.getMember(data.id);
      });
      
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
                  title: "Data berhasil disimpan!", 
                  icon: "success",
                })
                .then((value) => {
                  window.location = "{{ route('admin.borrow.create') }}";
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
</x-app-layout>