<x-app-layout>

  <x-slot name="title">{{ isset($book) ? 'Edit Buku' : 'Tambah Buku' }}</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/select.bootstrap4.min.css') }}">
    <link href="{{ asset('vendor/summernote-0.8.18/summernote-bs4.min.css') }}" rel="stylesheet">
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
          <a href="{{ route('admin.book.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($book) ? 'EDIT BUKU' : 'TAMBAH BUKU' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('admin.book.index') }}">Buku</a></div>
          <div class="breadcrumb-item">{{ isset($book) ? 'Edit Buku' : 'Tambah Buku' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($book))
          <form method="POST" id="formInput" action="{{ route('admin.book.update', $book->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('admin.book.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header"><h4>Data Buku</h4></div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-group">
                          <label for="isbn">Kode ISBN</label>
                          <div class="input-group">
                            <input id="isbn" type="text" class="form-control numeric" onChange="cek_isbn(this);" name="isbn" value="{{ @$book->isbn }}" required>
                            <div class="input-group-append" id="lihat-buku" style="display:none">
                              <a href="#" class="btn btn-outline-danger" target="_blank">Lihat</a>
                            </div>
                            <div class="invalid-feedback feedback-isbn">
                              ISBN wajib diisi.
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Judul Buku</label>
                            <input id="title" type="text" class="form-control" name="title" value="{{ @$book->title }}" required autofocus>
                            <div class="invalid-feedback">
                              Judul Buku wajib diisi.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="synopsis">Sinopsis</label>
                            <textarea id="synopsis" class="form-control summernote-simple" name="synopsis">{{ @$book->synopsis }}</textarea>
                            <div class="invalid-feedback">
                              Sinopsis wajib diisi.
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="title">Nama Pengarang</label>
                          <div class="input-group">
                            <input type="hidden" name="author_id" value="{{ @$book->author_id }}">
                            <input id="author" type="text" class="form-control" name="author" value="{{ @$book->author->name }}" readonly required>
                            <div class="input-group-append">
                              <button type="button" class="btn btn-success" id="search-author"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="invalid-feedback feedback-nama_tim"></div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control selectric" id="category" name="category_id" required>
                              <option value="">Pilih Kategori....</option>
                              @foreach ($category as $key => $value)
                                <option value="{{ $value->id }}" {{ isset($book) ? (($book->category_id == $value->id) ? "selected" : "") : "" }}>{{ $value->name }}</option>
                              @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Kategori wajib diisi.
                            </div>
                        </div> 
                        <div class="form-group">
                          <label for="title">Nama Penerbit</label>
                          <div class="input-group">
                            <input type="hidden" name="publisher_id" value="{{ @$book->publisher_id }}">
                            <input id="publisher" type="text" class="form-control" name="publisher" value="{{ @$book->publisher->name }}" readonly required>
                            <div class="input-group-append">
                              <button type="button" class="btn btn-success" id="search-publisher"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="invalid-feedback"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="isbn">Tahun Terbit</label>
                          <input id="isbn" type="text" class="form-control numeric" name="year_publication" value="{{ @$book->year_publication }}" required>
                          <div class="invalid-feedback">
                            Tahun Terbit wajib diisi.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="jumlah-halaman">Jumlah Halaman</label>
                          <input id="jumlah-halaman" type="text" class="form-control" name="jumlah_halaman" value="{{ @$book->jumlah_halaman }}" required>
                          <div class="invalid-feedback">
                            Jumlah Halaman wajib diisi.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="panjang">Panjang (cm)</label>
                          <input id="panjang" type="text" class="form-control numeric" name="panjang" value="{{ @$book->panjang }}" required>
                          <div class="invalid-feedback">
                            Panjang wajib diisi.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="lebar">Lebar (cm)</label>
                          <input id="lebar" type="text" class="form-control numeric" name="lebar" value="{{ @$book->lebar }}" required>
                          <div class="invalid-feedback">
                            Lebar wajib diisi.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="berat">Berat (kg)</label>
                          <input id="berat" type="text" placeholder="Contoh : 1.5" class="form-control numeric" name="berat" value="{{ @$book->berat }}">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <img src="{{ isset($book) ? ($book->book_main_image != '') ? url(Storage::url($book->book_main_image)) : asset('img/no_img.jpg') : asset('img/no_img.jpg') }}" alt="" id="book_main_image_preview" class="img-thumbnail mb-3" style="width:100%">
                        <div><label>Cover Buku</label></div>
                        <div class="custom-file">
                            {!! Form::file('book_main_image', ["class" => "custom-file-input", "accept" => "image/*", 'id' => 'book_main_image']) !!}
                            <label class="custom-file-label" for="customFile" id="book-main-image">Choose file</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header"><h4>Eksemplar</h4> 
                    <span class="badge badge-info">@{{ exemplars.length }}</span>
                  </div>
                  <div class="card-body pb-0">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="pr-1 pl-0 text-center">Lokasi Buku</th>
                            <th class="px-1 text-center">Posisi Rak</th>
                            <th class="px-1 text-center">Sumber Buku</th>
                            <th class="px-1 text-center">Harga</th>
                            <th class="px-1 text-center">Status</th>
                            <th class="px-1 text-center">Barcode</th>
                            <th class="text-center">#</th>
                          </tr>
                        </thead>
                        <tbody>
                          <template v-for="(exemplar, index) in exemplars">
                          <tr :key="index">
                            <td class="pr-1 pl-0">
                              <select class="form-control selectric" :name="'details[' + index + '][location]'" v-model="exemplar.location_id" required>
                                <option value="">Lokasi....</option>
                                @foreach ($location as $key => $value)
                                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td class="px-1">
                              <input type="text" :name="'details[' + index + '][position]'" class="form-control" v-model="exemplar.position" placeholder="Posisi Rak..." required>
                            </td>
                            <td class="px-1">
                              <select class="form-control selectric" :name="'details[' + index + '][source]'" v-model="exemplar.source_id" required>
                                <option value="">Sumber Buku....</option>
                                @foreach ($source as $key => $value)
                                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td class="px-1">
                              <input type="text" :name="'details[' + index + '][price]'" class="form-control currency" v-model="exemplar.price" placeholder="Harga..." required>
                            </td>
                            <td class="px-1">
                              <select class="form-control selectric" :name="'details[' + index + '][status]'" v-model="exemplar.status_id" required>
                                <option value="">Status....</option>
                                @foreach ($status as $key => $value)
                                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td class="px-1">
                              <input type="text" :name="'details[' + index + '][code]'" class="form-control" v-model="exemplar.code" placeholder="Barcode..." required>
                            </td>
                            <td class="text-center">
                              <div class="buttons">
                                <input type="hidden" :name="'details[' + index + '][id]'" v-model="exemplar.id">
                                <a href="javascript:void(0);" class="text-danger" @click="deleteExemplar(index)"><i class="fas fa-times"></i></a></div></td>
                          </tr>
                          </template>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pt-0">
                    <button type="button" class="btn btn-primary" @click="addExemplar()"><i class="fas fa-plus"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <input type="hidden" name="id" value="{{ @$book->id }}"/>
            <button type="submit" id="btn-store" class="btn btn-success">SIMPAN</button>
          </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote-0.8.18/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/vuejs/vue.min.js') }}"></script>
    <script src="{{ asset('js/format_number.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script> 

    function cek_isbn(obj) {
      console.log('ok');
      var url = '{{ route("admin.book.cek-isbn", ":isbn") }}';
      var value = $(obj).val();
      url = url.replace(':isbn', value);
      $(".is-invalid").removeClass("is-invalid");
      $('#lihat-buku').hide();
      $.getJSON(url, function(result){ 
        if (result.status == true) {
          $('[name="isbn"]').addClass('is-invalid');
          $('#lihat-buku').show();
          var url2   = '{{ route("admin.book.edit", ":id") }}';
          var value2 = result['data']['id'];
          url2 = url2.replace(':id', value2);
          $('#lihat-buku a').attr("href", url2);
          $('.feedback-isbn').text('Kode ISBN sudah ada di Mater Data Buku, Untuk menambahkan eksemplar silahkan klik tombol Lihat');
        }
      });
    }

    // ----- VUE JS ----- //
    @if (isset($book))
      let action = "{{ route('admin.book.update', $book->id) }}";
      let method = "POST";
      
      let dataVue= {
        exemplars : @json($exemplars),
      };
    
    @else
      let action = "{{ route('admin.book.store') }}";
      let method = "POST";

      let dataVue= {
        exemplars : [],
      };
    
    @endif

    var app = new Vue({
      el: '#app',
      data: dataVue,
      mounted () {
        
      },
      methods: {
        showModal: function (index = null) 
        {
          this.exemplar = [];
          $('#formModal').modal('show');
        },
        addExemplar: function () 
        {
          this.exemplars.push({
            id          : '', 
            location_id : '{{ Auth::user()->location_id }}',
            position    : '',
            source_id   : '',
            price       : 0,
            status_id   : '',
          });
        },
        deleteExemplar: function (index) 
        {
          this.exemplars.splice(index, 1);
        },
      },
    });

    // jquery
    $(document).ready(function () {

      $("#book_main_image").on('change', (e) => {
        let fileData = e.target.files[0];
        $("#book-main-image").text(fileData.name);
        var oFReader = new FileReader();
            oFReader.readAsDataURL(fileData);
        oFReader.onload = function(oFREvent) {
            document.getElementById("book_main_image_preview").src = oFREvent.target.result;
        };
      });

      $('#search-author').on('click', function (e) {
        e.preventDefault();
        var btn = $(this);
        $('#ajax-modal').remove();
        $.ajax({
            url: '{{ route("admin.author.ajax-modal") }}',
            dataType: 'html',
            beforeSend: function() {
              btn.addClass('btn-progress');
            },
            complete: function() {
              btn.removeClass('btn-progress');
            },
            success: function(html) {
                $('body').append('<div id="ajax-modal">' + html + '</div>');	
                $('#popupModal').modal('show');
            }
        });
      });

      $('#search-publisher').on('click', function (e) {
        e.preventDefault();
        var btn = $(this);
        $('#ajax-modal').remove();
        $.ajax({
            url: '{{ route("admin.publisher.ajax-modal") }}',
            dataType: 'html',
            beforeSend: function() {
              btn.addClass('btn-progress');
            },
            complete: function() {
              btn.removeClass('btn-progress');
            },
            success: function(html) {
                $('body').append('<div id="ajax-modal">' + html + '</div>');	
                $('#popupModal').modal('show');
            }
        });
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
                  window.location = "{{ route('admin.book.index') }}";
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