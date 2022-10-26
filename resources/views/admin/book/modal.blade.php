<form id="formWrapperModal" method="POST" action="" class="needs-validation" novalidate>
@method('PATCH')
<div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="formModalLabel">Tambah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="location">Lokasi</label>
          <select class="form-control selectric" id="location" name="location" v-model="exemplar.location" required>
            <option value="">Pilih Kategori....</option>
            @foreach ($location as $key => $value)
              <option value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback">Lokasi wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="position">Posisi Rak</label>
          <input type="text" name="position" class="form-control" v-model="exemplar.position" placeholder="Posisi Rak..." required>
          <div class="invalid-feedback">Posisi Rak wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="quantity">Jumlah</label>
          <input type="text" name="quantity" class="form-control" v-model="exemplar.jumlah" placeholder="Jumlah..." required>
          <div class="invalid-feedback">Jumlah wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="source">Sumber Buku</label>
          <input type="text" name="source" class="form-control" v-model="exemplar.source" placeholder="Jumlah..." required>
          <div class="invalid-feedback">Sumber Buku wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="price">Harga</label>
          <input type="text" name="price" class="form-control" v-model="exemplar.price" placeholder="Jumlah..." required>
          <div class="invalid-feedback">Jumlah wajib diisi.</div>
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control selectric" id="status" name="status" v-model="exemplar.status" required>
            <option value="">Pilih Status....</option>
            @foreach ($status as $key => $value)
              <option value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback">Jumlah wajib diisi.</div>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-flex">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-dark"><i class="fas fa-plus"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>