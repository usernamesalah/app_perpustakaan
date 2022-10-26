<x-app-layout>

  <x-slot name="title">Anggota</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/iziToast/dist/css/iziToast.min.css') }}">
  </x-slot>

  <!-- Main Content -->
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <i class="fa fa-th" aria-hidden="true" style="
              padding: 5px 0px;
              font-size: 18px;
          "></i>
        </div>
        <h1>ANGGOTA</h1>
        <div class="section-header-button">
          <a href="{{ route('admin.member.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> TAMBAH</a>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Anggota</div>
        </div>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="dataTable">
                    <thead class="bg-primary">
                      <tr>
                        <th class="text-center" style="width: 30px;">
                          #
                        </th>
                        <th>No Anggota</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Tgl Daftar</th>
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
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script>
      $(document).ready(function () {
        
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
              url: "{{ route('admin.member.DataTables') }}",
          },
          columns: [
            {data: null},
            {data: 'no_member'},
            {data: 'no_identity'},
            {data: 'name'},
            {data: 'address'},
            {data: 'tgl_daftar'},
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
              targets: 6,
              searchable: false, 
              orderable: false, 
              render: function ( data, type, row ) {
                var url = '{{ route("admin.member.edit", ":id") }}';
                url = url.replace(':id', row['id']);
                var item = 
                  '<a class="dropdown-item" href="'+url+'" target="_blank">Kartu Anggota</a>'+
                  '<a class="dropdown-item" href="'+url+'">Edit</a>'+
                  '<a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="'+row['id']+'">Hapus</a>';
                btn = 
                  '<div class="dropdown">' +
                    '<button class="btn btn-outline-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>'+
                    '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'+
                      item
                    '</div>'+
                  '</div>';

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
        
        $('#btn-create').click(function () {
          var url = '{{ route("admin.category.store", ":id") }}';
          $("#formModal form").attr('action', url);
          $('#formModal .modal-title').text('Tambah');
          $('[name="_method"]').val('POST');
          $('#formModal').modal('show');
        });

        $("#formModal form").submit(function(e){
          e.preventDefault();
          var btn = $('#btn-create');
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
                  dataTable.ajax.reload();
                  $('#formModal').modal('hide');
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

        $('#dataTable tbody').on( 'click', '.btn-edit', function () {
          var idx = $(this).parents('tr');
          var data = dataTable.row(idx).data();
          populateForm($('#formModal form'), data);
          $('#formModal .modal-title').text('Ubah');
          $('#formModal').modal('show')
          var url = '{{ route("admin.category.update", ":id") }}';
          url = url.replace(':id', data['id']);
          $("#formModal form").attr('action', url);
          $('[name="_method"]').val('PATCH');
        });

        $('#dataTable tbody').on( 'click', '.btn-delete', function () {
          var id = $(this).data('id');
          var url = '{{ route("admin.member.destroy", ":id") }}';
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
                    dataTable.ajax.reload();
                  }
                });
              }
            });
        });

        $('#formModal').on('hidden.bs.modal', function (event) {
          $(".was-validated").removeClass("was-validated");
          $('#formModal form').trigger("reset");
        });
      
      });
    </script>
  </x-slot>

</x-app-layout>