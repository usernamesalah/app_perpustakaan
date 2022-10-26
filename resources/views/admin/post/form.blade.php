<x-app-layout>

  <x-slot name="title">Halaman</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/summernote-0.8.18/summernote-bs4.css') }}">

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
          <a href="{{ route('admin.posts.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Halaman</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Halaman</a></div>
          <div class="breadcrumb-item">Halaman</div>
        </div>
      </div>

      <div class="section-body">
        <!-- <h2 class="section-title">Create New Post</h2>
        <p class="section-lead">
          On this page you can create a new post and fill in all fields.
        </p> -->
        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" novalidate="" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
                <h4>Write Your Post</h4>
              </div> -->
              <div class="card-body pt-5">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{ old('name', isset($post) ? $post->title : '') }}">
                    @if($errors->has('title'))
                      <div class="invalid-feedback">{{$errors->first('title')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                  <div class="col-sm-12 col-md-7">
                    <textarea id="summernote" name="content">{{ old('content', isset($post) ? $post->content : '') }}</textarea>
                    @if($errors->has('content'))
                      <div class="invalid-feedback">{{$errors->first('content')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control selectric" name="status">
                      @foreach ($status as $value)
                        <option value="{{ $value }}" {{ old('status', isset($post) ? $post->status : '') == $value ? "selected" : "" }}>{{ $value }}</option>
                      @endforeach
                      <!-- <option>Publish</option> -->
                      <!-- <option>Draft</option> -->
                      <!-- <option>Pending</option> -->
                    </select>
                    @if($errors->has('status'))
                      <div class="invalid-feedback">{{$errors->first('status')}}</div>
                    @endif
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-7">
                    <button class="btn btn-primary">Simpan</button>
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
    <script src="{{ asset('vendor/summernote-0.8.18/summernote-bs4.js') }}"></script>

    <script> 
    $(function() {

    $('#summernote').summernote({
        dialogsInBody: true,
        minHeight: 250,
        callbacks: {
          onImageUpload: function(image) {
            uploadImage(image[0]);
          }
        }
    });

    function uploadImage(image) {
      var data = new FormData();
      data.append("file", image);
      data.append('_token', '{{ csrf_token() }}');
      $.ajax({
          url: '{{ route("admin.posts.upload") }}',
          cache: false,
          contentType: false,
          processData: false,
          data: data,
          type: "post",
          success: function(data, textStatus, jqXHR) {
              var image = $('<img>').attr('src', data['url']).addClass('img-fluid img-thumbnail');
              $('#summernote').summernote("insertNode", image[0]);
          },
          error: function(data) {
              console.log(data);
          }
      });
    }

    });   
    </script>
  </x-slot>   
</x-app-layout>