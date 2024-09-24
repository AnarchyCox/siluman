@extends('simpbb.layout')
     
@section('content')

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
   
            <!-- welcome -->
            <div class="col-12 order-0">
              <div class="card">
                <div class="d-flex align-items-end row">
                  <div class="col-sm-7">
                    <div class="card-body">
                      <h5 class="card-title text-primary">Hello, {{ Auth::user()->name }}! 🎉</h5>
                      <p class="mb-4">
                        {{ $randomquotes->kalimat }} <p><i><span class="fw-bold">- {{ $randomquotes->tokoh }}.</span></i></p>
                      </p>

                    </div>
                  </div>
                  <div class="col-sm-5 text-center text-sm-left">
                    <div id="fotodepan" class="fotodepan card-body pb-0 px-0 px-md-4">
                      <img id="randomImage"
                        src=""
                        height="140"
                        alt="View Badge User"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Update Berkas Badan <span>| Hari ini</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-archive-fill"></i>
                    </div>
                    <div class="ps-3">
                    <h6>{{ $jmlupdatepusat }}</h6>
                      <span class="text-success small pt-1 fw-bold">
                        {{-- @if ($qrycountpusat->count() > $qrycountpusatkmren->count())
                        {{ $qrycountpusat->count() }}
                      @endif  --}}
                      %</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Update Berkas UPT <span>| Hari ini</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-archive-line"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $jmlupdateupt }}</h6>
                      <span class="text-success small pt-1 fw-bold"> 
                        -%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Update Peta <span>| Tahun ini</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-map-2-line"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $jmlupdatepeta }}</h6>
                      <span class="text-danger small pt-1 fw-bold">-%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/7 Hari Terakhir</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Berkas Badan',
                          data: [{{ implode(',', $pusat) }}],
                        }, {
                          name: 'Berkas UPT',
                          data: [{{ implode(',', $upt) }}]
                        }, {
                          name: 'Update Peta',
                          data: [{{ implode(',', $jmlpeta) }}]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'data',
                          categories: ["{{ $dates[0]->format('d/m/Y') }}","{{ $dates[1]->format('d/m/Y') }}","{{ $dates[2]->format('d/m/Y') }}","{{ $dates[3]->format('d/m/Y') }}","{{ $dates[4]->format('d/m/Y') }}","{{ $dates[5]->format('d/m/Y') }}","{{ $dates[6]->format('d/m/Y') }}",]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <h5 class="card-title">Aktifitas update peta <span></span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Pelayanan</th>
                        <th scope="col">Jenis Ajuan</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Desa</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($qrypetas as $qrypeta)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $qrypeta->nopel }}</td>
                            <td>{{ $qrypeta->nama_jenis_pengajuan }}</td>
                            <td>
                                @foreach($wilayah as $wil)
                                @if ((substr($qrypeta->nop, 6, 3)) == $wil->kode_wilayah)
                                {{ $wil->nama_wilayah }}
                                @endif
                                @endforeach
                            </td>
                            <td>
                            {{-- {{ substr(preg_replace('/[^a-zA-Z0-9]/', '', $qrypeta->nop), 0, 10) }} --}}
                              @foreach($desa as $des)
                              @if ((substr(preg_replace('/[^a-zA-Z0-9]/', '', $qrypeta->nop), 0, 10)) == $des->kode_desa)
                              {{ $des->nama_desa }}
                              @endif
                              @endforeach
                            </td>
                            <td>
                              @if ($qrypeta->status_peta == 'Approved')
                              <span class="badge bg-success">{{ $qrypeta->status_peta }}</span>
                              @elseif ($qrypeta->status_peta == 'Pending')
                              <span class="badge bg-secondary">{{ $qrypeta->status_peta }}</span>
                              @elseif ($qrypeta->status_peta == 'Rejected')
                              @foreach ($peta as $p)
                                @if ($p->id_berkas == $qrypeta->id)
                                <span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ $p->alasan }}">{{ $qrypeta->status_peta }}</span>
                                @endif
                                @endforeach
                              @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">Aktifitas Terakhir</h5>

              <div class="activity">

                @foreach ($recentActivities as $aktifitas)
                <div class="activity-item d-flex">
                  <div class="activite-label" style="width: 65px">{{ $aktifitas->formatted_time = Date::parse($aktifitas->jam)->diffForHumans(); }}</div>
                  <i class='activity-badge text-@if($aktifitas->role == 'God') {{ 'text-warning bi bi-star-fill' }} @elseif ($aktifitas->role == 'upt') {{ 'text-success bi-circle-fill' }} @elseif ($aktifitas->role == 'pusat') {{ 'text-info bi-circle-fill' }} @elseif ($aktifitas->role == 'peta') {{ 'text-primary bi-circle-fill' }} @endif align-self-start'></i>
                  <div class="activity-content">
                     <b>{{ $aktifitas->name }}</b> {{ $aktifitas->deskripsi }} <a href="#" class="fw-bold text-dark">{{ $aktifitas->nopel }}</a> untuk ajuan <b>{{ $aktifitas->nama_jenis_pengajuan }}</b>
                  </div>
                </div><!-- End activity item-->
                @endforeach
              </div>

            </div>
          </div><!-- End Recent Activity -->

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Pengajuan Traffic</h5>
  
                <!-- Pie Chart -->
                <div id="pieChart" style="min-height: 400px;" class="echart"></div>
  
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    echarts.init(document.querySelector("#pieChart")).setOption({
                      title: {
                        text: '',
                        subtext: '',
                        left: 'center'
                      },
                      tooltip: {
                        trigger: 'item'
                      },
                      legend: {
                        orient: 'horizontal',
                        top: '1%',
                      left: 'center'
                      },
                      series: [{
                        name: 'Access From',
                        top : '20%',
                        type: 'pie',
                        radius: '70%',
                        data: [{
                          value: {{ $totals->get('1', 0); }},
                          name: 'Mutasi Gabung'
                        },
                        {
                          value: {{ $totals->get('2', 0); }},
                          name: 'Mutasi Pecah'
                        },
                        {
                          value: {{ $totals->get('3', 0); }},
                          name: 'Mutasi Penuh'
                        },
                        {
                          value: {{ $totals->get('4', 0); }},
                          name: 'Pembetulan (Luas)'
                        }
                        ,
                        {
                          value: {{ $totals->get('5', 0); }},
                          name: 'Pendaftaran Baru'
                        },
                        {
                          value: {{ $totals->get('6', 0); }},
                          name: 'Pembatalan'
                        },
                        {
                          value: {{ $totals->get('7', 0); }},
                          name: 'Keberatan'
                        },
                        {
                          value: {{ $totals->get('8', 0); }},
                          name: 'Pengurangan'
                        },
                        {
                          value: {{ $totals->get('9', 0); }},
                          name: 'Pengaktifan NOP'
                        }
                        ],
                        emphasis: {
                          itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                          }
                        }
                      }]
                    });
                  });
                </script>
                <!-- End Pie Chart -->
  
              </div>
            </div>

        </div><!-- End Right side columns -->

      </div>
    </section>

  @endsection