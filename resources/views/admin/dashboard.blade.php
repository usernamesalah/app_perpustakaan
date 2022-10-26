<x-app-layout>

    <x-slot name="title">Dasbor</x-slot>
  
    <x-slot name="extra_css">
      <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/DataTables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}">
    </x-slot>
    
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <i class="fa fa-home" aria-hidden="true" style="
                  padding: 5px 0px;
                  font-size: 18px;
              "></i>
            </div>
            <h1>DASBOR</h1>
          </div>
  
          <div class="section-body">
            <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-light">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Anggota</h4>
                    </div>
                    <div class="card-body">
                      {{ $tot_members }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Judul Buku</h4>
                    </div>
                    <div class="card-body">
                      {{ $tot_title }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="far fa-newspaper"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Eksemplar</h4>
                    </div>
                    <div class="card-body">
                      {{ $tot_exemplar }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning text-white">
                    <i class="fa fa-shopping-cart"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Peminjaman</h4>
                    </div>
                    <div class="card-body">
                      {{ $tot_borrow }}
                    </div>
                  </div>
                </div>
              </div>          
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Statistik Pengunjung 6 Bulan Terakhir</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="myChart" height="100"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-12 col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Statistik Anggota Berdasarkan Status</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="myChart2" height="100"></canvas>
                  </div>
                </div>
              </div>
          </div>
        </section>
    </div>
  
    <x-slot name="extra_js">
      <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>
      <script>
      $(function() {
        
        var chart = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(chart, {
          type: 'bar',
          data: {
            labels: @json($chart1["label_all"]),
            datasets: [{
              label: 'Statistics',
              data: @json($chart1["total"]),
              borderWidth: 5,
              borderColor: '#6777ef',
              backgroundColor: 'transparent',
              pointBackgroundColor: '#fff',
              pointBorderColor: '#6777ef',
              pointRadius: 4
            }]
          },
          options: {
            legend: {
              display: false
            },
            scales: {
              yAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false,
                },
                ticks: {
                  //stepSize: 5
                }
              }],
              xAxes: [{
                gridLines: {
                  color: '#fbfbfb',
                  lineWidth: 2
                }
              }]
            },
          }
        });

        var chart = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(chart, {
          type: 'bar',
          data: {
            labels: @json($chart2["label_all"]),
            datasets: [{
              label: 'Statistics',
              data: @json($chart2["total"]),
              borderWidth: 5,
              borderColor: '#fc544b',
              backgroundColor: 'transparent',
              pointBackgroundColor: '#fff',
              pointBorderColor: '#fc544b',
              pointRadius: 4
            }]
          },
          options: {
            legend: {
              display: false
            },
            scales: {
              yAxes: [{
                gridLines: {
                  display: false,
                  drawBorder: false,
                },
                ticks: {
                  //stepSize: 5
                }
              }],
              xAxes: [{
                gridLines: {
                  color: '#fbfbfb',
                  lineWidth: 2
                }
              }]
            },
          }
        });

      }); 
      </script>
    </x-slot>
</x-app-layout>  
