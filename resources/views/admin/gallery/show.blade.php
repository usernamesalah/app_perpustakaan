<x-app-layout>
  
  <x-slot name="title">
    Galeri
  </x-slot>

  <x-slot name="extra_css">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css') }}"> --}}
    <style>
      /* Tambahan */

      .img-thumbnail {
          padding: 4px;
          line-height: 1.42857;
          background-color: #fff;
          border: 1px solid #ddd;
          border-radius: 3px;
          -webkit-transition: all .2s ease-in-out;
          -o-transition: all .2s ease-in-out;
          transition: all .2s ease-in-out;
          display: inline-block;
          max-width: 100%;
          height: auto;
      }

      #file-manager .fa-folder.fa-5x {
          font-size: 7.9em;
      }

      #file-manager label {
          font-size: 14px;
      }

      .thumbnail {
          display: block;
          padding: 5px;
          margin-bottom: 17px;
          line-height: 1.42857;
          background-color: #fff;
          border: 1px solid #ddd;
          border-radius: 3px;
          -webkit-transition: border 0.2s ease-in-out;
          -o-transition: border 0.2s ease-in-out;
          transition: border 0.2s ease-in-out;
      }

      .thumbnail > img, .thumbnail a > img {
          display: block;
          max-width: 100%;
          height: auto;
          margin-left: auto;
          margin-right: auto;
      }
    </style>
  </x-slot>

  <!-- Main Content -->
  <div class="main-content" id="app">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <i class="fa fa-th" aria-hidden="true" style="
              padding: 5px 0px;
              font-size: 18px;
          "></i>
        </div>
        <h1>Galeri</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">Dasbor</a></div>
          <div class="breadcrumb-item">Galeri</div>
        </div>
      </div>

      <div class="section-body">
        <!-- <h2 class="section-title">Users</h2>
        <p class="section-lead">
          We use 'DataTables' made by @SpryMedia. You can check the full documentation <a href="https://datatables.net/">here</a>.
        </p> -->

        <div class="row">
          <div class="col-12">
            <div class="" id="file-manager">
              <!-- <div class="card-header">
                <h4>Basic DataTables</h4>
              </div> -->
              <div class="card-body p-0">
                <div class="row">
                  <div class="col-sm-5 mb-3">
                    <a v-show="!is_directory" href="" @click.prevent="getDirectory()" data-toggle="tooltip" id="button-parent" class="btn btn-secondary" data-placement="top" title="Parent"><i class="fa fa-level-up-alt"></i> Kembali</a> 
                    <a href="" data-toggle="tooltip" id="button-refresh" class="btn btn-success" data-placement="top" title="Refresh"><i class="fa fa-sync-alt" aria-hidden="true"></i> Refresh</a>
                    <button v-show="!is_directory" type="button" id="button-upload" class="btn btn-primary" data-placement="top" title="Upload"><i class="fa fa-upload"></i> Upload</button>
                    {{-- <button v-show="is_directory" type="button" data-toggle="modal" data-target="#folderModal" id="button-folder" class="btn btn-info" data-placement="top" title="New Folder"><i class="fa fa-folder"></i> Folder / Kegiatan</button> --}}
                    <button v-show="!is_directory" type="button" data-toggle="tooltip" id="button-delete" class="btn btn-danger" data-placement="top" title="Delete"><i class="fa fa-trash"></i> Hapus</button>
                    <input type="hidden" id="id_directory" name="id_directory"/>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div v-if="is_directory" v-for="(dir, index) in directory" :key="index" class="col-sm-3 col-xs-6 text-center mb-3">
                    <div class="text-center"><a href="#" @click.prevent="getFiles(dir.id)" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
				            <label>
                      {{-- <input type="checkbox" name="path[]" :value="dir.id" class="flat-red">   --}}
                      @{{ dir.title }}
                    </label>
                  </div>
                  <div v-if="!is_directory" v-for="(file, index) in files" :key="index" class="col-sm-3 col-xs-6 text-center mb-3">
                    <a href="#" class="thumbnail"><img :src="file.storagepath" :alt="file.file_name" :title="file.file_name" style="max-height: 6em;"/></a>
				            <label>
                      <input type="checkbox" name="path[]" :value="file.path" class="flat-red path" /> 
                      @{{ file.file_name.substring(0,15)+"..." }}
                    </label>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  @include('admin.gallery.folder-modal')

  <x-slot name="extra_js">
    <script src="{{ asset('vendor/vuejs/vue.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <script>
    
    // ----- VUE JS ----- //
    let dataVue= {
      is_directory : true,
      id_directory : '',
      directory : [],
      files : [],
    };

    var app = new Vue({
      el: '#app',
      data: dataVue,
      mounted () {
        this.getDirectory();
      },
      methods: {
        doRefresh: function () 
        {
          if (dataVue.is_directory) {
            this.getDirectory();
          }
          else {
            this.getFiles($('#id_directory').val());
          }
        },
        getDirectory: function () 
        {
          dataVue.directory = [];
          $.ajax({
            type: "GET",
            url: '{{ route("admin.gallery.getDirectory") }}',
            data: {},
            processData: false,
            contentType: false,
            dataType: "json",
            async:false,
            success: function(data, textStatus, jqXHR) {
              console.log(data.directory);
              dataVue.directory = data.directory;
              dataVue.is_directory = true;
            },
            error: function(data, textStatus, jqXHR) {
              alert(jqXHR + ' , Proses Dibatalkan!');
            },
          });
        },
        getFiles: function (id_directory = '') 
        {
          dataVue.files = [];
          $('#id_directory').val(id_directory);
          if (id_directory != '') {
            var url = '{{ route("admin.gallery.getFiles", ":id") }}';
            url = url.replace(':id', id_directory);
            $.ajax({
              type: "GET",
              url: url,
              data: {},
              processData: false,
              contentType: false,
              dataType: "json",
              success: function(data, textStatus, jqXHR) {
                console.log(data.files);
                dataVue.files = data.files;
                dataVue.is_directory = false;
              },
              error: function(data, textStatus, jqXHR) {
                alert(jqXHR + ' , Proses Dibatalkan!');
              },
            });
          }
        },
      }
    });

    $(function() {
      
      $('#button-upload').on('click', function() {
        //alert($('#id_directory').val());
        var btn = $(this);
        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" value=""/></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
          if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);
            var formData = new FormData($('#form-upload')[0]);
            formData.append('id_directory', $('#id_directory').val());
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
              url: "{{ route('admin.gallery.upload') }}",
              type: 'post',
              data: formData,
              processData: false,
              contentType: false,
              dataType: "json",
              cache: false,
              beforeSend: function() {
                btn.addClass('btn-progress');
              },
              complete: function() {
                btn.removeClass('btn-progress');
              },
              success: function(json) {
                if (json['error']) {
                  alert(json['error']);
                }
                if (json['success']) {
                  alert(json['success']);
                  app.getFiles($('#id_directory').val());
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
            });
          }
        }, 500);
      });

      // $('#file-manager #button-folder').popover({
      //   html: true,
      //   container: 'body',
      //   placement: 'bottom',
      //   trigger: 'click',
      //   sanitize: false,
      //   title: 'New Folder',
      //   content: function() {
      //     html  = '<div class="input-group">';
      //     html += '  <input type="text" name="folder" value="" placeholder="Folder Name" class="form-control">';
      //     html += '  <div class="input-group-append"><button type="button" title="New Folder" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></div>';
      //     html += '</div>';

      //     return html;
      //   }
      // });

      $("#formFolderModal").submit(function(e){
        e.preventDefault();
        $('#btn-store').addClass('btn-progress')
        var formData = new FormData($(this)[0]);
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
          url: "{{ route('admin.gallery.create-folder') }}",
          type: 'post',
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(data, textStatus, jqXHR) {
            $(".is-invalid").removeClass("is-invalid");
            if (data['status'] == true) {
              app.getDirectory();
              $('#folderModal').modal('hide');
            }
            else {
              printErrorMsg(data.errors);
            }
            $('#btn-store').removeClass('btn-progress');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      });

      $('#file-manager #button-delete').on('click', function(e) {
        if (confirm('Are you sure')) {
          var formData = new FormData();
          var selecteditems = [];
          $('input[name^=\'path\']:checked').each(function (i, ob) { 
            //selecteditems.push($(ob).val());
            formData.append('path[]', $(ob).val());
          });
          
          console.log(selecteditems);
          formData.append('_token', '{{ csrf_token() }}');
          $.ajax({
            url: '{{ route('admin.gallery.delete') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
              $('#button-delete').prop('disabled', true);
            },
            complete: function() {
              $('#button-delete').prop('disabled', false);
            },
            success: function(json) {
              if (json['error']) {
                alert(json['error']);
              }

              if (json['success']) {
                alert(json['success']);
                app.doRefresh();
                //$('#button-refresh').trigger('click');
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
        }
      });

    });
    </script>
  </x-slot>
</x-app-layout>