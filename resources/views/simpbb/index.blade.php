@extends('simpbb.layout')
     
@section('content')

<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card recent-sales overflow-auto">
          <div class="card-body">

        <div class="card-title d-md-flex">
            <div class="col-sm-6"><strong class="float-start">Daftar Berkas</strong></div>  
            <div class="col-sm-6"><strong class="float-end"><a class="btn btn-success btn-sm" href="{{ url('/add') }}"> <i class="fa fa-plus"></i> Input Berkas Baru</a></strong></div>  
        </div>
         @session('success')
        <div class="alert alert-success" role="alert"> {{ $value }} </div>
    @endsession
    @session('alert')
        <div class="alert alert-danger" role="alert"> {{ $value }} </div>
    @endsession
        {{-- {{ $jmltoday }} --}}
              <table id="table" class="table datatable" >
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Nomor Pelayanan</th>
                    <th>NOP</th>
                    <th>Jenis Pengajuan</th>
                    <th>Tanggal Input</th>
                    <th>Berkas</th>
                    <th width="250px">Aksi</th>
                </tr>
            </thead>
  
            <tbody>
            @foreach ($simpbb as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->nopel }}</td>
                    <td>{{ $product->nop }}</td>
                    <td>{{ $product->nama_jenis_pengajuan }}</td>
                    <td>{{ $product->created_at->format('m/d/Y') }}</td>
                    <td><a class="btn btn-primary btn-sm" href="ktp/{{ $product->ktp }}" target="popup-example" onClick="javascript:open('ktp/{{ $product->ktp }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=no')"><i class="ri-account-box-line"></i></a>
                        <a class="btn btn-warning btn-sm" href="/berkas/{{ $product->berkas }}#toolbar=1&navpanes=0&scrollbar=0" target="popup-example" onClick="javascript:open('berkas/{{ $product->berkas }}', 'popup-example', 'height='+window.innerheight+',width='+window.innerwidth+'resizable=yes')"><i class="ri-file-4-line"></i></a></td>
                    <td>
                                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                  <span class="d-md-block dropdown-toggle ps-2"><i class=" ri-align-justify"> </i>Manage
                                </span>
                                </a><!-- End Profile Iamge Icon -->
                      
                                <ul class="dropdown-menu dropdow-menu-right dropdown-menu-arrow">
                                <form action="{{ route('simpbb.destroy',$product->id) }}" method="POST">
                                  <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('simpbb.show',$product->id) }}">
                                      <i class="fa-solid fa-eye"></i>
                                      <span>Show</span>
                                    </a>
                                  </li>
                                  @if ($product->username == Auth::user()->username || Auth::user()->role == 'God'|| Auth::user()->id_user == '104')
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>
                                  <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('simpbb.edit',$product->id) }}">
                                      <i class="fa-solid fa-pen-to-square"></i>
                                      <span>Edit</span>
                                    </a>
                                  </li>
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>
                                  <li>
                                    @csrf
                                    @method('DELETE')
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="dropdown-item d-flex align-items-center show_confirm" data-toggle="tooltip" title='Delete'>
                                      <i class="fa-solid fa-trash"></i>
                                      <span>Hapus</span>
                                    </button>
                                  </li>
                                  @endif
                                </ul><!-- End Profile Dropdown Items -->
                        </form>

                        <script type="text/javascript">

                      </script>
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