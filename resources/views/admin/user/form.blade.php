<x-app-layout>

  <x-slot name="title">{{ isset($user) ? 'EDIT ADMIN' : 'TAMBAH ADMIN' }}</x-slot>

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
          <a href="{{ route('admin.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ isset($user) ? 'EDIT ADMIN / PETUGAS' : 'TAMBAH ADMIN / PETUGAS' }}</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
          <div class="breadcrumb-item">{{ isset($user) ? 'Edit Admin' : 'Tambah Admin' }}</div>
        </div>
      </div>

      <div class="section-body">
        <!-- <h2 class="section-title">Create New Post</h2>
        <p class="section-lead">
          On this page you can create a new post and fill in all fields.
        </p> -->
        @if(isset($user))
          <form method="POST" action="{{ route('admin.users.update', $user->id) }}" novalidate="" enctype="multipart/form-data">
          @method('PATCH')
        @else
          <form method="POST" action="{{ route('admin.users.store') }}" novalidate="" enctype="multipart/form-data">
        @endif
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
                <h4>Write Your Post</h4>
              </div> -->
              <div class="card-body pt-5">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}">
                    @if($errors->has('name'))
                      <div class="invalid-feedback">{{$errors->first('name')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Username</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif" name="username" value="{{ old('username', isset($user) ? $user->username : '') }}" autocomplete="off">
                    @if($errors->has('username'))
                      <div class="invalid-feedback">{{$errors->first('username')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" autocomplete="off">
                    @if($errors->has('password'))
                      <div class="invalid-feedback">{{$errors->first('password')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Confirmation</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation">
                    @if($errors->has('password_confirmation'))
                      <div class="invalid-feedback">{{$errors->first('password_confirmation')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Role</label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control" id="id_role" name="id_role">
                      @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('id_role', isset($roleName) ? $roleName : '') == $role->name ? "selected" : "" }}>{{ $role->name.' '.$role->keterangan }}</option>
                      @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group row mb-4" id="form-location" style="display:none;">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi</label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control selectric @if($errors->has('location_id')) is-invalid @endif" name="location_id" id="location_id">
                      <option value="">Pilih....</option>
                      @foreach ($location as $key => $value)
                          <option value="{{ $value->id }}" {{ old('location_id', isset($user) ? $user->location_id : '') == $value->id ? "selected" : "" }}>{{ $value->name }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('location_id'))
                      <div class="invalid-feedback">{{$errors->first('location_id')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4" id="form-foto">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                  <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview" style="background-image: url('{{ isset($user) ? ($user->image != '') ? url(Storage::url($user->image)) : asset('img/no_img.jpg') : asset('img/no_img.jpg') }}'); background-size: cover; background-position: center center;">
                      <label for="image-upload" id="image-label">Choose File</label>
                      <input type="file" name="image" id="image-upload">
                    </div>
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-7">
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
    <script src="{{ asset('js/plugin.js') }}"></script>

    <script> 
    $(function() {
      
      $('#id_role').on('change', function () {
        var role_id = $(this).val();
        if (role_id == 'Petugas') {
          $('#form-location').show();
          $('#location_id').prop('required', true);
        }
        else {
          $('#form-location').hide();
          $('#location_id').prop('required', false);
        }
      });

      $('#id_role').change();
      
      $.uploadPreview({
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Choose File",   // Default: Choose File
        label_selected: "Change File",  // Default: Change File
        no_label: false,                // Default: false
        success_callback: null          // Default: null
      });
    
    }); 
    </script>
  </x-slot>
</x-app-layout>