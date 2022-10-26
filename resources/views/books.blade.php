<x-guest-layout>

    <x-slot name="title">KATALOG BUKU</x-slot>
  
    <x-slot name="extra_css">
      <style>
          .section .section-lead {
            margin-left: 0px!important;
          }
          .main-wrapper.container {
            width: 100%;
            max-width: 100%;
            padding: 0px;
          }
          .article .article-header .article-image {
            background-color: #ffffff;
            background-position: center;
            background-size: contain!important;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            z-index: -1;
            border: 1px solid #e7e4e4;
            border-radius: 10px;
          }
      </style>
    </x-slot>
    
    <!-- Main Content -->
    <div class="container">
      <div class="main-content">
          <section class="section">
            <div class="section-body">
              <div class="row">
                <div class="col-12 col-md-3">
                  <form action="{{ route('categories', isset($slug) ? $slug : 'semua-buku') }}" method="GET">
                    <div class="mb-4">
                      <h5 class="mb-4">Filter</h5>
                      <div class="form-group">
                        <label>Filter berdasarkan</label>
                        <select class="form-control selectric" name="filter_by">
                          <option value="judul">JUDUL</option>
                          <option value="pengarang">PENGARANG</option>
                          <option value="penerbit">PENERBIT</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Cari</label>
                        <input type="text" class="form-control" name="keyword" value="" placeholder="Cari.....">
                      </div>
                      <button type="submit" id="btn-filter" class="btn btn-warning btn-lg btn-block">TERAPKAN</button>
                    </div>
                  </form>
                </div>
                <div class="col-12 col-md-9">
                  <div class="row">
                    <div class="col-md-9">
                      <p class="section-lead">
                      @if ($books->total() > 0)
                        <b>{{ $books->firstItem() }}-{{ $books->lastItem() }}</b> dari 
                      @endif
                      <b>{{ $books->total() }}</b> hasil pencarian buku dengan kata kunci <b>"{{ ucwords($search) }}"</b></p>
                    </div>
                    <div class="col-md-3 text-right mb-2">
                      <a href="javascript:void(0);" @click="changeView()" class="btn btn-icon btn-outline-dark">
                        <template v-if="view === 'grid'">
                          <i class="fas fa-table"></i>
                        </template>
                        <template v-else>
                          <i class="fas fa-align-justify"></i>
                        </template>
                      </a>
                    </div>
                  </div>
                  <div class="row">
                    <template v-if="view === 'grid'">
                      @foreach ($books as $book)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                          <a href="{{ route('books', $book->slug) }}" class="text-decoration-none">
                            <article class="article">
                              <div class="article-header py-2 px-3">
                                <div class="article-image" style="background-image: url(&quot;{{ $book->storage_image }}&quot;);"></div>
                              </div>
                              <div class="article-details pt-0">
                                <p class="line-clamp-1">{{ $book->author_name }}</p>
                                <div class="line-clamp-2">{{ $book->title }}</div>
                              </div>
                            </article>
                          </a>
                        </div>
                      @endforeach
                    </template>
                    <template v-else>
                      @foreach ($books as $book)
                        <div class="col-12">
                          <div class="card">
                            <div class="card-body">
                              <div class="media">
                                <a href="{{ route('books', $book->slug) }}" class="text-decoration-none"><img class="img-thumbnail mr-3" width="100" src="{{ $book->storage_image }}" alt="Generic placeholder image"></a>
                                <div class="media-body">
                                  <h5 class="mt-0"><a href="{{ route('books', $book->slug) }}" class="line-clamp-2 text-decoration-none">{{ $book->title }}</a></h5>
                                  <p class="card-text"><a class="line-clamp-1 text-decoration-none card-text" href="{{ route('categories', 'semua-buku') }}?filter_by=pengarang&keyword={{ $book->author_name }}">{{ $book->author_name }}</a></p>
                                  <p class="mb-0 line-clamp-3">{{ $book->short_synopsis }}</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </template>
                  </div>
                  
                  {!! $books->links() !!}
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/vuejs/vue.min.js') }}"></script>
      <script>

        let dataVue= {
          view  : null,
        };

        var app = new Vue({
          el: '#app',
          data: dataVue,
          mounted () {
            let view = window.localStorage.getItem('view') === 'list' ? 'list' : 'grid';
            dataVue.view = view;
          },
          methods: {
            changeView: function () 
            {
              let view = (dataVue.view === 'grid') ? 'list' : 'grid';
              dataVue.view = view;
              window.localStorage.setItem('view', view);
            },
          },
        });

      $(function() {
        
      }); 
      </script>
    </x-slot>
</x-guest-layout>  
