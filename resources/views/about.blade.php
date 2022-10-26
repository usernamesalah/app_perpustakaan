<x-guest-layout>

    <x-slot name="title">SELAMAT DATANG</x-slot>

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
              <div class="row mb-4">
                <div class="col-12">
                  <div class="text-center mb-4 mt-4">
                    <h2><i>{{ $post1->title }}</i></h2>
                  </div>
                  <div class="text-justify" style="min-height: 150px;">
                    {!! $post1->content !!}
                  </div>
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
