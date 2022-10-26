<!-- Modal -->
<form id="formWrapperModalBook" method="POST" action="" class="needs-validation" novalidate>
  <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bookModalLabel">Data Eksemplar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table-popup" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center" style="width: 30px;">#</th>
                  <th>Lokasi</th>
                  <th>Posisi</th>
                  <th>Sumber</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Barcode</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($exemplars as $exemplar)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $exemplar->location_name }}</td>
                      <td>{{ $exemplar->position }}</td>
                      <td>{{ $exemplar->source_name }}</td>
                      <td>{{ $exemplar->price }}</td>
                      <td>{{ $exemplar->status_name }}</td>
                      <td>{{ $exemplar->code }}</td>
                      <td><a href="{{ route('admin.book.barcode', $exemplar->id) }}" target="_blank" data-id="{{ $exemplar->id }}" class="btn btn-icon btn-sm btn-secondary btn-barcode-print" style="width: 29px;"><i class="fa fa-print"></i></a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>