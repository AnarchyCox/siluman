@extends('simpbb.layout')
     
@section('content')

<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card recent-sales overflow-auto">
        <div class="card-body" style="padding-bottom: 0">

        <div class="card-title d-md-flex">
            <div class="col-sm-4"><strong class="float-start">Laporan Peta</strong></div>  
            <div class="row col-sm-8 btn-group">
                    <form action="{{ route('filpet') }}" method="POST">
                        @csrf
                        <span class="float-end">
                            <input type="date" name="start_date" id="end_date" class="form-control-sm" style="border: 1px solid rgb(211, 211, 211);" value="{{  $startDate }}">
                            s/d
                            <input type="date" name="end_date" id="start_date" class="form-control-sm" style="border: 1px solid rgb(211, 211, 211);" value="{{  $endDate }}"> 
                            <button type="submit" name="action" class="btn btn-primary btn-sm" value="filter"><i class="ri-search-2-line"></i> Pilih</Button>
                            <button type="submit" name="action" class="btn btn-outline-success btn-sm" value="export-excell-peta"> <i class="ri-file-excel-2-fill"></i></button>
                                  </div>
                                </span>
                    </form>
                    {{-- </form> --}}
            </div>
        @session('success')
        <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
    
        {{-- {{ $jmltoday }} --}}
        <table id="table" class="table datatable" >
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Nomor Pelayanan</th>
                    <th>NOP</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Jenis Pengajuan</th>
                    <th>Verifikator</th>
                    <th>Status Peta</th>
                </tr>
            </thead>
  
            <tbody>
            @foreach ($simpbb as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->nopel }}</td>
                    <td>{{ $product->nop }}</td>
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
                    <td>{{ $product->nama_jenis_pengajuan }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if ($product->status_peta == 'Approved')
                        <span class="badge bg-success">{{ $product->status_peta }}</span>
                        @elseif ($product->status_peta == 'Pending')
                        <span class="badge bg-secondary">{{ $product->status_peta }}</span>
                        @elseif ($product->status_peta == 'Rejected')
                        <span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ $product->alasan }}">{{ $product->status_peta }}</span>
                        @endif
                      </td>
                </tr>
            @endforeach
            
            </tbody>
  
        </table>
        
        {{-- {!! $simpbb->withQueryString()->links('pagination::bootstrap-5') !!} --}}

    </div>
</div>
</div>

</div>
</section>
@endsection