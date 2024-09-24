@extends('simpbb.layout')
  
@section('content')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card recent-sales overflow-auto">
          <div class="card-body">

<div class="card-title d-md-flex overflow-auto">
    <div class="col-sm-6"><strong class="float-start">Form Cari Nomor Pelayanan</strong></div>  
    <div class="col-sm-6 overflow-auto"><strong class="float-end">
        <a class="btn btn-primary btn-sm" href="{{ url('/') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </strong></div>  
</div>
  <div class="card-body">
    <div class="row overflow-auto">
    <form action="{{ route('show2') }}" method="GET" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="inputNopel" class="form-label"><strong>NOMOR PELAYANAN:</strong></label>
            <input 
                type="text" 
                name="nomor_layanan" 
                class="form-control @error('nomor_layanan') is-invalid @enderror" 
                id="nomor_layanan" 
                placeholder="Nomor Pelayanan">
            @error('nomor_layanan')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="inputjenis_layanan" class="form-label"><strong>JENIS PENGAJUAN:</strong></label>
            <select type="" name="jenis_layanan" class="form-control  form-select" id="jenis_layanan">
                <option value="">-- Pilih Jenis Pengajuan --</option>
                <option value="Mutasi Pecah">Mutasi Pecah</option>
                <option value="Mutasi Gabung">Mutasi Gabung</option>
                <option value="Mutasi Penuh">Mutasi Penuh</option>
                <option value="Pembetulan (Luas)">Pembetulan (Luas)</option>
                <option value="Pengaktifan NOP">Pengaktifan NOP</option>
                <option value="Pendaftaran baru">Pendaftaran Baru</option>
                <option value="Pembatalan">Pembatalan</option>
                <option value="Pengurangan">Pengurangan</option>
                <option value="Keberatan">Keberatan</option>
                <option value="Pembetulan Data WP (online)">Pembetulan Data WP (online)</option>
            </select>
            @error('jenis_layanan')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="inputTahun" class="form-label"><strong>TAHUN:</strong></label>
            <select type="" name="tahun" class="form-control  form-select" id="jenis_layanan">
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
            </select>
            @error('tahun')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success"><i class="ri-search-eye-line"></i> Cari</button>
    </form>
    </div>
@isset($mergedData)
<hr>
<table id="table" class="table table-borderless datatable" >
        <thead>
            <tr>
                <th>#</th>
                <th>Nomor Pelayanan</th>
                <th>NOP</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Jenis Pengajuan</th>
                <th>Berkas</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($mergedData as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data['nomor_layanan'] }}</td>
            <td>{{ preg_replace("/(\d{2})(\d{2})(\d{3})(\d{3})(\d{3})(\d{4})(\d{1})/","$1.$2.$3.$4.$5-$6.$7", $data['nop_proses']) }}</td>
            <td>@foreach($kecamatan as $kec)
                @if ((substr($data['nop_proses'], 4, 3)) == $kec->kode_wilayah)
                {{ $kec->nama_wilayah }}
                @endif
                @endforeach
            </td>
            <td>@foreach($desa as $des)
                @if ((substr(preg_replace('/[^a-zA-Z0-9]/', '', $data['nop_proses']), 0, 10)) == $des->kode_desa)
                {{ $des->nama_desa }}
                @endif
                @endforeach
            </td>
            <td>{{ $data['jenis_layanan_nama'] }}</td>
            <td>
                @if (isset($data['ktp'] , $data['berkas']) <> null) 
                <a class="btn btn-primary btn-sm" href="ktp/{{ $data['ktp'] }}" target="popup-example" onClick="javascript:open('ktp/{{ $data['ktp'] }}', 'popup-example',  'height='+window.innerheight+',width='+window.innerwidth+'resizable=no')"><i class="ri-account-box-line"></i></a>
                <a class="btn btn-warning btn-sm" href="berkas/{{ $data['berkas'] }}#toolbar=1&navpanes=0&scrollbar=0" target="popup-example" onClick="javascript:open('berkas/{{ $data['berkas'] }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=yes')"><i class="ri-file-4-line"></i></a>
                @else
                <form action="{{ route('add2') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                <input type="hidden" name="nopel" value="{{ $data['nomor_layanan'] }}"> 
                <input type="hidden" name="nop" value="{{ $data['nop_proses'] }}"> 
                <input type="hidden" name="jela" value="{{ $data['jenis_layanan_nama'] }}"> 
                <button type="submit" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i></button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

    </table>
    @endisset
{{--     
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script> --}}

</div>
</div>
</div>
</div>
</section>

@endsection