<x-guest-layout>

    <x-slot name="title">BOOKMARK</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('vendor/chocolat/dist/css/chocolat.css') }}">
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
            <div class="section-body">
              <div class="row">
                <div class="col-12">
                    <h4>Bookmark</h4>
                    <div class="card-body">
                      <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                        @foreach ($cart as $crt)
                          <li class="media" id="cart-{{ $crt->id }}">
                            <img alt="image" class="img-thumbnail mr-3" width="50" src="{{ ($crt->book->book_main_image != '') ? url(Storage::url($crt->book->book_main_image)) : asset('img/no_img.jpg') }}">
                            <div class="media-body">
                              <div class="media-title">{{ $crt->book->title }}</div>
                              <div class="text-job text-muted">{{ $crt->book->author_name }}</div>
                            </div>
                            <div class="media-cta">
                              <a href="{{ route('books', $crt->book->slug) }}" class="btn btn-outline-primary">Detail</a>
                              <button type="button" data-id="{{ $crt->id }}" class="btn btn-outline-danger btn-delete">Hapus</button>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  {{-- </div> --}}
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
      <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script>
      $(function() {
        $('.btn-delete').on('click', function (e) {
          var id = $(this).data('id');
          var url = '{{ route("cart.destroy", ":id") }}';
          url = url.replace(':id', id);
          swal({
              title: 'Yakin ingin menghapus?',
              icon: 'warning',
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                  url: url,
                  data : {_token:'{{ csrf_token() }}'},
                  type : "DELETE",
                  dataType: "json",
                  cache: true,
                  success: function(response) {
                    $('#cart-'+ id).remove();
                    // alert('ok');
                  }
                });
              }
            });
        });
      }); 
      </script>
    </x-slot>
</x-guest-layout>  
