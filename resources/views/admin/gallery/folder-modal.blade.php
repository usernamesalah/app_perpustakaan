<form id="formFolderModal" method="POST" action="" class="needs-validation" novalidate>
<div class="modal fade" id="folderModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="folderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="folderModalLabel">Tambah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="title">Nama Folder / Kegiatan</label>
          <input type="text" name="title" class="form-control" id="form-title" placeholder="Nama..." required>
          <div class="invalid-feedback">Nama Folder / Kegiatan wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="title">Keterangan</label>
          <textarea name="description" rows="5" class="form-control" id="form-description" placeholder="Description..." required style="
          min-height: 100px;
      "></textarea>
          <div class="invalid-feedback">Description wajib diisi.</div>
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