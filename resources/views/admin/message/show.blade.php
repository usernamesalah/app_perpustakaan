<x-app-layout>

  <x-slot name="title">Pesan Masuk</x-slot>

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
        <h1>PESAN</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Pesan</div>
        </div>
      </div>

      <div class="section-body">
        <!-- <h2 class="section-title">Users</h2>
        <p class="section-lead">
          We use 'DataTables' made by @SpryMedia. You can check the full documentation <a href="https://datatables.net/">here</a>.
        </p> -->

        <div class="row">
          <div class="col-md-3 mb-4">
            <div class="list-group" id="subject-tab">
              <button type="button" data-subject="all" class="list-group-item list-group-item-action active" aria-current="true">Semua</button>
              <button type="button" data-subject="Request Buku" class="list-group-item list-group-item-action">Request Buku</button>
              <button type="button" data-subject="Kritik Dan Saran" class="list-group-item list-group-item-action">Kritik Dan Saran</button>
            </div>
            <input type="hidden" name="subject" id="subject" value="all">
          </div>
          <div v-show="view=='dataTable'" class="col-md-9">
            <div class="card card-primary">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="dataTable">
                    <thead class="bg-primary">
                      <tr>
                        <th>Dari</th>
                        <th>Subjek</th>
                        <th>Pesan</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div v-show="view=='detail'" class="col-md-9">
            <div class="card card-primary">
              <div class="card-header">
                <a href="javascript:void(0);" class="btn btn-icon" id="btn-back"><i class="fas fa-arrow-left"></i></a>
              </div>
              <div class="card-body">
                <div class="mailbox-read-info border-bottom pb-4">
                  <h5>@{{ contact.subject }}</h5>
                  <small>Nama Lengkap : @{{ contact.name }}</small><br>
                  <small>Email : @{{ contact.email }}</small><br>
                  <small>No Telp / Hp : @{{ contact.no_telp }}</small><br>
                  {{-- <span class="mailbox-read-time float-right">15 Feb. 2015 11:03 PM</span></h6> --}}
                </div>
                <div class="mailbox-read-message mt-4">
                  <div v-html="contact.message"></div>
                </div>
              </div>
              <div class="card-footer">
                <div class="float-right">
                  <a href="javascript:void(0);" class="btn btn-outline-primary" id="btn-realisasi">REALISASI</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  @include('admin.message.modal')

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/iziToast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('vendor/vuejs/vue.min.js') }}"></script>
    <script>
      
    let dataVue= {
      view    : 'dataTable',  // dataTable, Detail
      contact : [],
    };

    var app = new Vue({
      el: '#app',
      data: dataVue,
      mounted () {
        //
      },
      methods: {
        getContact: function (id) 
        {
          var url = '{{ route("admin.messages.get-contact", ":id") }}';
          url = url.replace(':id', id);
          $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
              if (data['status'] == true) {
                dataVue.contact = data['data'];
                // alert('ok');
              }
            },
            error: function(data, textStatus, jqXHR) {
              alert('Terjadi kesalahan , Proses dibatalkan!');
            },
          });
        },
      },
    });

    $(function() {

      var dataTable = $('#dataTable').DataTable({
        processing: true,
        //ordering: false,
        ajax: {
          url: '{{ route('admin.messages.getDataTables') }}',
          data: function (d) {
            d.subject = $('input[name=subject]').val();
          }
        },
        columns: [
          {data: 'name'},
          {data: 'subject'},
          {data: 'short_message'},
          {data: 'status'},
        ],
        columnDefs  : [
          {
            targets: 0,
            render: function ( data, type, row ) {
              var url = '{{ route("admin.messages.show", ":id") }}';
              url = url.replace(':id', row['id']);
              return '<a href="javascript:void(0);" class="btn-detail">'+ row['name'] +'</a>';
            },
          },
          {
            targets: 3,
            render: function ( data, type, row ) {
              var status = '';
              switch(row['status']) {
                case 1:
                  status = '<span class="badge badge-info">Direalisasi</span>';
                  break;
                case 0:
                  status = '<span class="badge badge-danger">Ditolak</span>';
                  break;
                default:
                  status = '<span class="badge badge-warning">Belum Direalisasi</span>';
              }
              return status;
            },
          },
        ]
      });

      $('#btn-back').on('click', function () {
        dataVue.contact = [];
        dataVue.view = 'dataTable';
      });

      $('#dataTable tbody').on('click', '.btn-detail', function () {
        var idx = $(this).parents('tr');
        var data = dataTable.row(idx).data();
        app.getContact(data.id);
        dataVue.view = 'detail';
      });

      $('#subject-tab button').on('click', function (e) {
        e.preventDefault();
        $('#subject').val($(this).data('subject'));
        $('#subject-tab button').removeClass('active');
        $(this).addClass('active');
        dataTable.ajax.reload();
        dataVue.view = 'dataTable';
      });

      $('#btn-realisasi').click(function () {
        var url = '{{ route("admin.messages.update", ":id") }}';
        url = url.replace(':id', dataVue.contact.id);
        $("#formWrapperModal").attr('action', url);
        $('#formModal .modal-title').text('Realisasi');
        $('[name="_method"]').val('PATCH');
        $('#formModal').modal('show');
      });

      $("#formWrapperModal").submit(function(e){
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
                dataTable.ajax.reload();
                dataVue.view = 'dataTable';
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

    });
    </script>
  </x-slot>

</x-app-layout>