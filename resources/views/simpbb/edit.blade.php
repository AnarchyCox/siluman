@extends('simpbb.layout')
     
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">

    <div class="card-title d-md-flex">
        <div class="col-sm-6"><strong class="float-start">Edit Berkas</strong></div>  
        <div class="col-sm-6"><strong class="float-end">
            <a class="btn btn-primary btn-sm" href="{{ route('simpbb.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </strong></div>  
    </div>
    <form action="{{ route('simpbb.update',$simpbb->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
  
        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Nomor Pelayanan:</strong></label>
            <input 
                type="text" 
                name="nopel" 
                value="{{ $simpbb->nopel }}"
                class="form-control @error('nopel') is-invalid @enderror" 
                id="inputName" 
                placeholder="nopel" disabled>
            @error('nopel')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
  
        <div class="mb-3">
            <label for="inputDetail" class="form-label"><strong>NOP:</strong></label>
            <input
                type="text" 
                class="form-control @error('nop') is-invalid @enderror" 
                name="nop" 
                id="nop" 
                value="{{ $simpbb->nop }}"
                placeholder="nop" maxlength="24" disabled>
            @error('nop')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputJenisPelayanan" class="form-label"><strong>Jenis Pelayanan:</strong></label>
            <select  
                type="" 
                name="id_jenis_pengajuan" 
                class="form-control @error('jenis') is-invalid @enderror form-select" 
                id="inputJenisPengajuan" disabled>
                <option value="{{ $idjenispengajuan->id_jenis_pengajuan }}">{{ $idjenispengajuan->nama_jenis_pengajuan }}</option>
                @foreach ($jenis_pengajuan as $jenispengajuan)
                    @if ($jenispengajuan->id_jenis_pengajuan <> $idjenispengajuan->id_jenis_pengajuan)
                        <option value="{{ $jenispengajuan->id_jenis_pengajuan }}">{{ $jenispengajuan->nama_jenis_pengajuan }}</option>
                    @endif
                @endforeach
            </select>
            @error('id_jenis_pengajuan')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputktp" class="form-label"><strong>KTP:</strong></label>
            <input 
                type="file" 
                name="ktp" 
                class="form-control @error('ktp') is-invalid @enderror" 
                id="inputktp">
                <a href="{{asset('ktp/')}}/{{ $simpbb->ktp }}" target="popup-example" onClick="javascript:open('ktp/{{ $simpbb->ktp }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=no')">{{ $simpbb->ktp }}</a>
                @error('ktp')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputBerkas" class="form-label"><strong>Berkas:</strong></label>
            <input 
                type="file" 
                name="berkas" 
                class="form-control @error('berkas') is-invalid @enderror" 
                id="inputBerkas">
            <a href="{{asset('berkas/')}}/{{ $simpbb->berkas }}#toolbar=0&navpanes=0&scrollbar=0" target="popup-example" onClick="javascript:open('berkas/{{ $simpbb->berkas }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=yes')">{{ $simpbb->berkas }}</a>
            @error('berkas')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="nop" value="{{ $simpbb->nop }}">
        <input type="hidden" name="nopel" value="{{ $simpbb->nopel }}">
        <input type="hidden" name="id_jenis_pengajuan" value="{{ $idjenispengajuan->id_jenis_pengajuan }}">
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
    </form>
</div>
</div>

</div>
</div>
</section>
@endsection