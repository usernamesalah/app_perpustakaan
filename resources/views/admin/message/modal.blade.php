<form id="formWrapperModal" method="POST" action="" class="needs-validation" novalidate>
@method('PATCH')
<div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="formModalLabel">Tambah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleFormControlSelect1">Status Realisasi</label>
          <select class="form-control" name="stts_realisasi" id="stts_realisasi">
            <option value="1">Realisasi</option>
            <option value="0">Tolak</option>
          </select>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex">
        <input type="hidden" name="id" id="id_contact" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-dark">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>