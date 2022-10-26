<!-- Modal -->
<form id="formWrapperModalPublisher" method="POST" action="{{ route('admin.publisher.store') }}" class="needs-validation" novalidate>
  <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="publisherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="publisherModalLabel">Data Penerbit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body modal-body-dataTable">
          <div class="table-responsive mb-2">
            <table class="table table-hover table-bordered" id="table-popup" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" style="width: 30px;">#</th>
                  <th>Nama</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <button type="button" id="btn-modal-add" class="btn btn-primary"><i class="fa fa-plus"></i> TAMBAH</button>
        </div>
        <div class="modal-body modal-body-form" style="display: none;">
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" placeholder="Nama..." required>
            <div class="invalid-feedback"></div>
          </div>
          <div class="text-right">
          <button type="button" id="btn-modal-back" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i> KEMBALI</button>
          <button type="submit" id="btn-modal-store" class="btn btn-success"><i class="fa fa-save"></i> SIMPAN</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script> 

$(function() {
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
  var dataSet = @json($dataSet);
  var popupDatatables = $('#table-popup').DataTable({
    pageLength: 5,
    //responsive: false,
    ordering: false,
    select: {
      style: 'single'
    },
    data: dataSet,
    columns: [
      { data: "id"},
      { data: "name"}
    ],
    //order: [[ 1, "asc" ]],
    rowCallback : function (row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $('td:eq(0)', row).html(index);
    }
  });

  popupDatatables
    .on( 'select', function ( e, dt, type, indexes ) {
      var rowData = popupDatatables.row( indexes ).data();
      console.log(rowData );
      $('[name="publisher_id"]').val(rowData['id']);
      $('[name="publisher"]').val(rowData['name']);
      $('#popupModal').modal('hide');
    });

  $('#btn-modal-add').on('click', function () {
    $('.modal-body-dataTable').hide();
    $('.modal-body-form').show();
  });

  $('#btn-modal-back').on('click', function () {
    $('.modal-body-dataTable').show();
    $('.modal-body-form').hide();
  });

  $("#formWrapperModalPublisher").submit(function(e){
    e.preventDefault();
    var btn = $('#btn-modal-store');
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
          if (data['status'] == true) {
            $('[name="publisher_id"]').val(data['data']['id']);
            $('[name="publisher"]').val(data['data']['name']);
            $('#popupModal').modal('hide');
          }
          else {
            printErrorMsg(data.errors, '#formWrapperModalPublisher');
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