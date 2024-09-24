@extends('simpbb.layout')
  
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">

<div class="card-title d-md-flex">
    <div class="col-sm-6"><strong class="float-start">Input Berkas Baru</strong></div>  
    <div class="col-sm-6"><strong class="float-end">
        <a class="btn btn-primary btn-sm" href="{{ route('show2') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </strong></div>  
</div>
  <div class="card-body">

    <form action="{{ route('berkas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="inputNopel" class="form-label"><strong>NOMOR PELAYANAN:</strong></label>
            <input 
                type="text" 
                class="form-control @error('nopel') is-invalid @enderror" 
                id="nopel" 
                value="{{ $nopel }}"
                placeholder="Nomor Pelayanan" disabled>
            </div>
            <script>
            function hanyaAngkaDanTitik(event) {
                const charCode = (event.which) ? event.which : event.keyCode;
                // Mengizinkan angka (48-57) dan titik (46)
                if (charCode !== 46 && (charCode < 48 || charCode > 57)) {
                    event.preventDefault();
                }
            }
            </script>
        <div class="mb-3">
            <label for="inputNop" class="form-label"><strong>NOP:</strong></label>
            <input 
            class="form-control @error('nop') is-invalid @enderror" 
            id="nop" 
            value="{{ $nop }}"
                placeholder="Nomor Objek Pajak" maxlength="24" onkeypress="hanyaAngkaDanTitik(event)" disabled>
        </div>

        <div class="mb-3">
            <label for="inputJenisPengajuan" class="form-label"><strong>JENIS PENGAJUAN:</strong></label>
            <select  
                type="" 
                class="form-control @error('jenis') is-invalid @enderror form-select" 
                id="inputJenisPengajuan" disabled>
                <option value="">-- Pilih Jenis Pengajuan --</option>
                @foreach ($jenis_pengajuan as $jenispengajuan)
                <option value="{{ $jenispengajuan->id_jenis_pengajuan }}"
                    @if ($jl == $jenispengajuan->nama_jenis_pengajuan) 
                    selected
                    @endif>{{ $jenispengajuan->nama_jenis_pengajuan }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="inputktp" class="form-label"><strong>KTP:</strong></label>
            <img src="{{ url('ktp/no-image-ktp.png') }}" id="preview" alt="Profile" class="img-thumbnail img-fluid" style="display: block; max-width:250px">
            <p class="font-monospace text-danger small pt-1 fw-italic fst-italic">*File KTP dalam bentuk foto/gambar (jpeg,png,jpg) max ukuran 2Mb.</p>
            <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" id="changeToFileInput">
                <i class="bi bi-upload"></i></a>
            <input type="file" name="ktp" id="ktp" class="form-control d-none @error('ktp') is-invalid @enderror"  onchange="previewImage(event)">
            <button type="button" href="#" class="btn btn-danger btn-sm" id="clear-preview" title="Remove my profile image" style="" onclick="HapusPreview()"><i class="bi bi-trash"></i></button> 
                            <script>
                                document.getElementById('changeToFileInput').addEventListener('click', function(event) {
                                    event.preventDefault(); // Mencegah aksi default tautan
                                    document.getElementById('ktp').click(); // Memicu klik pada input file
                                });
                                function previewImage(event) {
                                  var reader = new FileReader();
                                  reader.onload = function(){
                                      var output = document.getElementById('preview');
                                      output.src = reader.result;
                                      output.style.display = 'block';
                                  };
                                  reader.readAsDataURL(event.target.files[0]);
                              }function HapusPreview() {
                                  // var reader = new FileReader();
                                      var output = document.getElementById('preview');
                                      output.src = '{{ url('ktp/no-image-ktp.png') }}';
                                  };
                            </script>
                            @error('ktp')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
        </div>
        <div class="mb-3">
            <label for="inputBerkas" class="form-label"><strong>BERKAS:</strong></label>
            <input 
                type="file" 
                name="berkas" 
                class="form-control @error('berkas') is-invalid @enderror" 
                id="inputBerkas">
                <p class="font-monospace text-danger small pt-1 fw-italic fst-italic">*File berkas dalam bentuk dokumen pdf max ukuran 2Mb.</p>
            @error('berkas')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="nop" value="{{ $nop }}">
        <input type="hidden" name="nopel" value="{{ $nopel }}">
        <input type="hidden" name="id_jenis_pengajuan" value="
        @foreach ($jenis_pengajuan as $jenispengajuan)
        @if ($jl == $jenispengajuan->nama_jenis_pengajuan) 
        {{ $jenispengajuan->id_jenis_pengajuan }}
        @endif
        @endforeach
        ">
        <input type="hidden" name="status_peta" value="Pending">
        <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
    </form>
    <div class="card">

  
  </div>
</div>
</div>

</div>
</div>
</section>

@endsection