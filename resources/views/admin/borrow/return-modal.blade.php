<form id="formWrapperModal" method="POST" action="{{ route('admin.borrow.return', $borrow->id) }}" class="needs-validation" novalidate>
<div class="modal fade" id="returnModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="returnModalLabel">Pengembalian Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="title">Tgl Peminjaman</label>
          <input type="text" name="date_borrow" class="form-control" value="{{ $borrow->date_borrow }}" readonly>
        </div>
        <div class="form-group">
          <label for="title">Tgl Pengembalian</label>
          <input type="text" name="date_return" class="form-control datepicker" id="form-date-return" readonly required>
          <div class="invalid-feedback">Tgl Pengembalian wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Denda</label>
          <input type="text" name="denda" class="form-control currency" id="form-denda" value="{{ $denda }}" required>
          <div class="invalid-feedback">Denda wajib diisi.</div>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" id="btn-store" class="btn btn-dark"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>
  // $(function() {
    $('.datepicker').daterangepicker({
      autoApply: true,
      locale: {format: 'YYYY-MM-DD'},
      singleDatePicker: true,
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
              $('#dataTable').DataTable().ajax.reload();
              $('#returnModal').modal('hide');
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

  // });
</script>