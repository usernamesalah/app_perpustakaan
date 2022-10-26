<x-app-layout>

  <x-slot name="title">{{ isset($member) ? 'Edit Anggota' : 'Tambah Anggota' }}</x-slot>

  <x-slot name="extra_css">
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
          <a href="{{ route('admin.member.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($member) ? 'EDIT ANGGOTA' : 'TAMBAH ANGGOTA' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('admin.member.index') }}">Anggota</a></div>
          <div class="breadcrumb-item">{{ isset($member) ? 'Edit Anggota' : 'Tambah Anggota' }}</div>
        </div>
      </div>

      <div class="section-body">
        @if(isset($member))
          <form method="POST" id="formInput" action="{{ route('admin.member.update', $member->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" id="formInput" action="{{ route('admin.member.store') }}" class="needs-validation" novalidate enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header"><h4>Data Anggota</h4></div>
              <div class="card-body">
                <div class="form-group">
                  <label for="no_member">No Anggota [Auto Number]</label>
                  <input id="no_member" type="text" class="form-control" name="no_member" value="{{ isset($member) ? $member->no_member : $no_member }}" readonly required>
                  <div class="invalid-feedback">
                      No Member wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                    <label for="no_identity">NIK</label>
                    <input id="no_identity" type="text" class="form-control" name="no_identity" value="{{ old('no_identity', @$member->no_identity) }}" required autofocus>
                    <div class="invalid-feedback">
                        NIK wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', @$member->name) }}" required>
                    <div class="invalid-feedback">
                        Nama Lengkap wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input id="address" type="text" class="form-control" name="address" value="{{ old('address', @$member->address) }}" required>
                    <div class="invalid-feedback">
                        Alamat wajib diisi.
                    </div>
                </div> 
                <div class="form-group">
                  <label>Tipe</label>
                  <select class="form-control selectric" name="type" required>
                      <option value="">Pilih...</option>
                      @foreach ($type as $value)
                          <option value="{{ $value->id }}" {{ old('type', @$member->type) == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                      @endforeach
                  </select>
                  <div class="invalid-feedback">
                      Tipe wajib diisi.
                  </div>
                </div>
                <div class="form-group">
                    <label for="agency">Nama Instansi/Sekolah/Universitas</label>
                    <input id="agency" type="text" class="form-control" name="agency" value="{{ old('agency', @$member->agency) }}">
                    <div class="invalid-feedback">
                        Nama Instansi/Sekolah/Universitas wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telpon</label>
                    <input id="no_telp" type="text" class="form-control" name="no_telp" value="{{ old('no_telp', @$member->no_telp) }}" required>
                    <div class="invalid-feedback">
                        No Telpon wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select class="form-control selectric" name="gender" required>
                        <option value="">Pilih...</option>
                        @foreach ($gender as $value)
                            <option value="{{ $value->id }}" {{ old('gender', @$member->gender) == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Jenis Kelamin wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control selectric" name="status" required>
                      <option value="">Pilih...</option>
                      <option value="1" {{ @$member->user->status === 1 ? 'selected' : '' }}>Aktif</option>
                      <option value="0" {{ @$member->user->status === 0 ? 'selected' : '' }}>Nonaktif</option>
                  </select>
                  <div class="invalid-feedback">
                      Status wajib diisi.
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header"><h4>Akun Anggota</h4></div>
              <div class="card-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', @$member->user->email) }}" required>
                    <div class="invalid-feedback">
                        Email wajib diisi.
                    </div>
                </div>  
                <div class="form-group">
                    <label for="password" class="d-block">Password</label>
                    <input id="password" type="password" class="form-control pwstrength" name="password" {{ isset($member) ? '' : 'required' }}>
                    <div class="invalid-feedback">
                        Password wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="d-block">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" {{ isset($member) ? '' : 'required' }}>
                    <div class="invalid-feedback">
                        Konfirmasi Password wajib diisi.
                    </div>
                </div>
                <div class="form-group">
                  <img src="{{ isset($member) ? ($member->user->image != '') ? url(Storage::url($member->user->image)) : asset('img/no_img.jpg') : asset('img/no_img.jpg') }}" alt="" id="image_preview" class="img-thumbnail mb-3" style="max-width:250px">
                  <div><label>Foto</label></div>
                  <div class="custom-file">
                      {!! Form::file('image', ["class" => "custom-file-input", "accept" => "image/*", 'id' => 'image']) !!}
                      <label class="custom-file-label" for="customFile" id="image-label">Choose file</label>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="id" value="{{ @$member->id }}"/>
            <button type="submit" id="btn-store" class="btn btn-success btn-lg btn-block">SIMPAN</button>
          </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>

    <script> 
    $(function() {

      $("#image").on('change', (e) => {
        let fileData = e.target.files[0];
        $("#image-label").text(fileData.name);
        var oFReader = new FileReader();
            oFReader.readAsDataURL(fileData);
        oFReader.onload = function(oFREvent) {
            document.getElementById("image_preview").src = oFREvent.target.result;
        };
      });

      $('[name="type"]').on('change',  function() {
        let value = $(this).val();
        if (value == 1) {
          $('[name="agency"]').prop('required', false);
        } else {
          $('[name="agency"]').prop('required', true);
        }
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
                  window.location = "{{ route('admin.member.index') }}";
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