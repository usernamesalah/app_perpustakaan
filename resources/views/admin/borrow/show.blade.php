<x-app-layout>

  <x-slot name="title">Riwayat Peminjaman</x-slot>

  <x-slot name="extra_css">
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
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
        <h1>RIWAYAT PEMINJAMAN</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Riwayat Peminjaman</div>
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
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Nama Peminjam</th>
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
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/format_number.min.js') }}"></script>
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
              url: "{{ route('admin.borrow.dataTables') }}",
          },
          columns: [
            {data: null},
            {data: 'book_code'},
            {data: 'book_title'},
            {data: 'member_name'},
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
              targets: 5,
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
              targets: 6,
              searchable: false, 
              orderable: false, 
              render: function ( data, type, row ) {
                var url = '{{ route("admin.borrow.show", ":id") }}';
                url = url.replace(':id', row['id']);
                var item = '<a class="dropdown-item" href="'+url+'">Detail</a>';
                item += (row['status'] !== 1)? '<a class="dropdown-item btn-return" href="javascript:void(0);" data-id="'+row['id']+'">Kembalikan</a>' : '';
                item += (row['status'] !== 1 && row['status'] !== 2) ? '<a class="dropdown-item btn-extend" href="javascript:void(0);" data-id="'+row['id']+'">Perpanjang</a>' : '';
                item += '<a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="'+row['id']+'">Hapus</a>';
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

        $('#dataTable tbody').on( 'click', '.btn-return', function () {
          var id = $(this).data('id');
          var url = '{{ route("admin.borrow.return-modal", ":id") }}';
          url = url.replace(':id', id);
          $('#ajax-modal').remove();
          $.ajax({
            url: url,
            dataType: 'html',
            success: function(html) {
              $('body').append('<div id="ajax-modal">' + html + '</div>');	
              $('#returnModal').modal('show');
            }
          });
        });

        $('#dataTable tbody').on( 'click', '.btn-extend', function () {
          var id = $(this).data('id');
          var url = '{{ route("admin.borrow.extend", ":id") }}';
          url = url.replace(':id', id);
          swal({
              title: 'Yakin ingin memperpanjang?',
              text: 'Perpanjangkan maksimal selama {{ $setting->hari_extend }} hari, terhitung dari hari sekarang!',
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                  url: url,
                  data : {_token:'{{ csrf_token() }}'},
                  type : "POST",
                  dataType: "json",
                  cache: true,
                  success: function(response) {
                    dataTable.ajax.reload();
                  }
                });
              }
            });
        });

        $('#dataTable tbody').on( 'click', '.btn-delete', function () {
          var id = $(this).data('id');
          var url = '{{ route("admin.borrow.destroy", ":id") }}';
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