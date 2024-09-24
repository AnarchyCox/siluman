@extends('simpbb.layout')
     
@section('content')

<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card recent-sales overflow-auto">
        <div class="card-body" style="padding-bottom: 0">

        <div class="card-title d-md-flex">
            <div class="col-sm-4"><strong class="float-start">Laporan Berkas Arsip</strong></div>  
            <div class="row col-sm-8 btn-group">
                    <form action="{{ route('filber') }}" method="POST">
                        @csrf
                        <span class="float-end mxcontent">
                            <input type="date" name="start_date" id="end_date" class="form-control-sm" style="border: 1px solid rgb(211, 211, 211);" value="{{  $startDate }}">
                            s/d
                            <input type="date" name="end_date" id="start_date" class="form-control-sm" style="border: 1px solid rgb(211, 211, 211);" value="{{  $endDate }}"> 
                            <button type="submit" name="action" class="btn btn-primary btn-sm" value="filter"><i class="ri-search-2-line"></i> Pilih</Button>
                            <button type="submit" name="action" class="btn btn-outline-success btn-sm" value="export-excell"> <i class="ri-file-excel-2-fill"></i></button>
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
                    <th>Tanggal Input</th>
                    <th>Nomor Pelayanan</th>
                    <th>NOP</th>
                    <th>Jenis Pengajuan</th>
                    <th>Nama Penginput</th>
                </tr>
            </thead>
  
            <tbody>
            @foreach ($simpbb as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->created_at->format('d-m-Y') }}</td>
                    <td>{{ $product->nopel }}</td>
                    <td>{{ $product->nop }}</td>
                    <td>{{ $product->nama_jenis_pengajuan }}</td>
                    <td>{{ $product->name }}</td>
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