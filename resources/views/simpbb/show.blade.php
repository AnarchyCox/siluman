@extends('simpbb.layout')
   
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">

<div class="card-title d-md-flex">
    <div class="col-sm-6"><strong class="float-start">Details Berkas</strong></div>  
    <div class="col-sm-6"><strong class="float-end">
        <a class="btn btn-primary btn-sm" href="{{ route('simpbb.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </strong></div>  
</div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nomor Pelayanan:</strong> <br/>
                {{ $simpbb->nopel }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>NOP:</strong> <br/>
                {{ $simpbb->nop }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Jenis Pengajuan:</strong> <br/>
                {{ $idjenispengajuan->nama_jenis_pengajuan }}
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-lg-4">
    <div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>KTP:</strong><br/>
                <img src="/ktp/{{ $simpbb->ktp }}" class="d-block w-100">     
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="col-lg-8">

<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Berkas:</strong><br/>
                <embed
                    src="/berkas/{{ $simpbb->berkas }}#toolbar=1&navpanes=0&scrollbar=0"
                    type="application/pdf"
                    frameBorder="0"
                    scrolling="auto"
                    height="700"
                    width="100%">
                </embed>            
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

</div>
</div>
</section>
@endsection