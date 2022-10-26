<x-app-layout>
  
  <x-slot name="title">
    IMPORT
  </x-slot>

  <x-slot name="extra_css"></x-slot>

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
        <h1>IMPORT DATA</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dasbor</a></div>
          <div class="breadcrumb-item">Import Data</div>
        </div>
      </div>

      <div class="section-body">
        <form id="form-import" method="POST" action="" target="_blank">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body p-4">
                  <ul class="nav nav-tabs" id="myTab5" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="rtlh-baru-tab" data-toggle="tab" href="#rtlh-baru" role="tab" aria-controls="rtlh-baru" aria-selected="false">
                        Excel Buku</a>
                    </li>
                  </ul>
                  <div class="tab-content tab-bordered" id="myTabContent6">
                    <div class="tab-pane fade show active" id="rtlh-baru" role="tabpanel" aria-labelledby="rtlh-baru-tab">
                      <div class="jumbotron m-0 p-4">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label" for="input-name">File</label>
                              <input type="file" class="form-control" name="file_excel2">
                              <a href="{{ asset('SAMPEL_DATABASE_BUKU.xlsx') }}" target="_blank">Download Format Import.xls</a>
                            </div>
                            <button type="submit" target="_blank" name="type" value="rtlh" id="button-excel" class="btn btn-success pull-right mr-2 btn-simpan"><i class="fa fa-file-excel"></i> Import Excel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>

  <x-slot name="extra_js">
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script>
    $(function() {

      $("form#form-import").submit(function(e){
        e.preventDefault();
        var btn = $('.btn-simpan');
        btn.addClass('btn-progress');
        var formData = new FormData($(this)[0]);
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
            type: "POST",
            url: "{{ route('admin.import.upload') }}",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data, textStatus, jqXHR) {
              $(".is-invalid").removeClass("is-invalid");
              if (data['status'] == true) {
                swal({
                  title: "Import Data selesai!", 
                  icon: "success",
                });
              }
              else {
                printErrorMsg(data.errors);
              }
              btn.removeClass('btn-progress');
            },
            error: function(data, textStatus, jqXHR) {
              alert(jqXHR + ' , Proses Dibatalkan!');
            },
        });
      });

    });
    </script>
  </x-slot>
</x-app-layout>