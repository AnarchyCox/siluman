@extends('simpbb.layout')
     
@section('content')

<section class="section">
    <div class="row">
      {{-- <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-md-flex">
              <div class="col-sm-6"><strong class="float-start">Chart Data Peta</strong></div>  
              <div class="col-sm-6"><strong class="float-end"></strong></div>  
          </div>

            <!-- Column Chart -->
            <div id="columnChart"></div>
            {{-- @foreach ($chartwil as $cwil) --}}
            {{-- {{ $x = substr($cwil, 6, 3) }} --}}
              {{-- @foreach($wilayah as $wil)
                @if ((substr($cwil, 6, 3)) == $wil->kode_wilayah)
                {{ $x = $wil->nama_wilayah }}
                @endif
              @endforeach
            @endforeach --}}
            {{-- <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#columnChart"), {
                  series: [{
                    name: 'Belum Update',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                  }, {
                    name: 'Sudah Update',
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                  }, {
                    name: 'Ditolak',
                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                  }],
                  chart: {
                    type: 'bar',
                    height: 350
                  },
                  plotOptions: {
                    bar: {
                      horizontal: false,
                      columnWidth: '75%',
                      endingShape: 'rounded'
                    },
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                  },
                  xaxis: {
                    categories: ['Karangploso', 'Dau', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Jul', 'Aug', 'Sep', 'Oct', 'Jul', 'Aug', 'Sep', 'Oct', 'Jul', 'Aug', 'Sep', 'Oct', 'Jul', 'Aug', 'Sep', 'Oct', 'Jul', 'Aug', 'Sep', 'Oct', 'Jul', 'Aug', 'Sep', 'Oct'],
                  },
                  yaxis: {
                    title: {
                      text: 'Total Data Peta'
                    }
                  },
                  fill: {
                    opacity: 1
                  },
                  tooltip: {
                    y: {
                      formatter: function(val) {
                        return "$ " + val + " thousands"
                      }
                    }
                  }
                }).render();
              });
            </script> --}}
            {{-- <!-- End Column Chart -->

          </div>
        </div>
      </div> --}}
      <div class="col-lg-12">
        <div class="card overflow-auto">
          <div class="card-body">
        <div class="card-title d-md-flex">
            <div class="col-sm-6"><strong class="float-start">Daftar Data Peta</strong></div>  
            <div class="col-sm-6"><strong class="float-end"></strong></div>  
        </div>
         @session('success')
        <div class="alert alert-success" role="alert"> {{ $value }} </div>
    @endsession
        {{-- {{ $jmltoday }} --}}


      </br>
      {{-- {{ $x }} --}}
        {{-- {{ substr($chartwil, 6, 3) }} --}}
              <table id="table" class="table datatable" >
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Nomor Pelayanan</th>
                    <th>NOP</th>
                    <th>Jenis Pengajuan</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Status</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
  
            <tbody>
            @foreach ($simpbb as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->nopel }}</td>
                    <td>{{ $product->nop }}</td>
                    <td>{{ $product->nama_jenis_pengajuan }}</td>
                    <td>
                      @foreach($wilayah as $wil)
                      @if ((substr($product->nop, 6, 3)) == $wil->kode_wilayah)
                      {{ $wil->nama_wilayah }}
                      @endif
                      @endforeach
                    </td>
                    <td>
                      {{-- {{ substr(preg_replace('/[^a-zA-Z0-9]/', '', $qrypeta->nop), 0, 10) }} --}}
                        @foreach($desa as $des)
                        @if ((substr(preg_replace('/[^a-zA-Z0-9]/', '', $product->nop), 0, 10)) == $des->kode_desa)
                        {{ $des->nama_desa }}
                        @endif
                        @endforeach
                      </td>
                    <td>
                      @if ($product->status_peta == 'Approved')
                      <span class="badge bg-success">{{ $product->status_peta }}</span>
                      @elseif ($product->status_peta == 'Pending')
                      <span class="badge bg-secondary">{{ $product->status_peta }}</span>
                      @elseif ($product->status_peta == 'Rejected')
                      <span class="badge bg-danger">{{ $product->status_peta }}</span>
                      @endif
                    </td>
                    <td><a class="btn btn-primary btn-sm" href="ktp/{{ $product->ktp }}" target="popup-example" onClick="javascript:open('ktp/{{ $product->ktp }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=no')"><i class="ri-account-box-line"></i></a>
                        <a class="btn btn-warning btn-sm" href="/berkas/{{ $product->berkas }}#toolbar=0&navpanes=0&scrollbar=0" target="popup-example" onClick="javascript:open('berkas/{{ $product->berkas }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=yes')"><i class="ri-file-4-line"></i></a></td>
                    <td>
                      {{-- {{ route('peta.edit',$product->id) }} --}}
                      
                      <input type="hidden" name="status_peta" id="status_peta" value="Approved">
                      <button type="button" class="btn btn-light btn-sm" data-bs-target="#editModal" data-bs-toggle="modal" onclick="editData({{ $product->id }})" > 
                        <i class="fa-solid fa-pen-to-square"></i> 
                      </button>
                      {{-- <!-- Vertically centered Modal -->
                      <div class="modal fade" id="verticalycentered" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            
                            <div class="modal-header">
                              <h5 class="modal-title">Apakah anda yakin?</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('peta.update',$product->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <input type="hidden" name="id" id="id" value="{{ $product->id }}">
                                  <input type="input" name="id" id="id" value="{{ $product->id }}">
                                <p>Pilih <b> Approve </b> jika selesei update Peta dan <b> Rejected</b> jika ada masalah dengan objek tersebut.</p>
                                <select  
                                    name="status_peta" 
                                    class="form-control @error('status_peta') is-invalid @enderror form-select" 
                                    id="status_peta">
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                           </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal--> --}}
              <!-- Modal -->

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
        {{-- {!! $simpbb->withQueryString()->links('pagination::bootstrap-5') !!} --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel">Apakah anda yakin?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form action="" id="editForm" method="POST">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="id" id="item-id">
                          <div class="form-group">
                            <p>Pilih <b> Approve </b> jika selesei update Peta dan <b> Rejected</b> jika ada masalah dengan objek atau berkas tersebut.</p>
                            <select  
                            name="status_peta" 
                            class="form-control @error('status_peta') is-invalid @enderror form-select" 
                            id="options">
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                       <!-- Input fields that will be shown or hidden -->
                          <div id="Rejected" class="dynamic-input" style="display:none;">
                            <br> <b>Alasan ditolak :</b> 
                            <textarea name="alasan" class="form-control" style="height: 100px"></textarea>
                          </div>
                          </div>
                        </br>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
        </div>
        <script>
          function editData(id) {
              $.get('/peta/' + id + '/edit', function(data) {
                  $('#status_peta').val(data.name);
                  // Isi field lain sesuai kebutuhan
                  $('#editForm').attr('action', '/peta/' + id + '/update');
                  $('#editModal').modal('show');
              });
          }
      </script>
      <script>
        $(document).ready(function() {
            $('#options').change(function() {
                var selectedValue = $(this).val();
                $('.dynamic-input').hide(); // Sembunyikan semua input dinamis

                if (selectedValue) {
                    $('#' + selectedValue).show(); // Tampilkan input sesuai dengan nilai yang dipilih
                }
            });
        });
      </script>
    </div>
</div>
</div>

</div>

</section>
@endsection