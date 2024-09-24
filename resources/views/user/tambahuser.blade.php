@extends('simpbb.layout')
     
@section('content')
<section class="section profile">
  {{-- <div class="container mt-5">
    <h1>Upload Images and Convert to PDF</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('images.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Upload and Convert</button>
    </form>

    <h2>Image Preview:</h2>
    <div id="image-preview"></div>
</div>

<script>
    document.querySelector('input[type="file"]').addEventListener('change', function(event) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-img';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script> --}}
<div class="row">
    <div class="col-xl-4">

        <div class="card">
            <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Tambahkan User</h5>
                  <p class="text-center small">Masukkan data user</p>
                </div>
                @session('tambah')
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  {{ $value }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession
                @session('username')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  {{ $value }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession
                <form class="row g-3 needs-validation" target="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                  @csrf
                  {{-- @method('PUT') --}}
                  <div class="col-12">
                    <label for="yourName" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                    <div class="invalid-feedback">Please, enter username!</div>
                    </div>

                  <div class="col-12">
                    <label for="yourEmail" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>

                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Full Name</label>
                    <div class="input-group has-validation">
                    <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Role User</label>
                    <div class="input-group has-validation">
                  <select class="form-select" name="role" aria-label="Default select example">
                    <option selected="">-- Pilih Role User --</option>
                    <option value="God" @if (Auth::user()->id_user <> '99')
                      {{ 'disabled'; }}
                    @endif>Admin</option>
                    <option value="upt" >UPT</option>
                    <option value="pusat">Pusat</option>
                    <option value="peta">Peta Pusat</option>
                  </select>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Create Account</button>
                  </div>
                </form>

              </div>
        </div>
  
      </div>
    <div class="col-xl-8">

      <div class="row">
          @foreach ($datausers as $datauser)
          <div class="alert-dismissible col-xxl-6 col-md-6" style="padding-right: 10px">
            <div class="card info-card revenue-card align-items-center pt-4">
              <img src="/user-profile/{{ $datauser->foto }}" alt="Profile" class="rounded-circle" style="max-width: 120px">
              <h5 class="card-title">{{ $datauser->username }} <span>| {{ $datauser->role }}</span></h5>
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-secondary small pt-1 fw-bold">Nama </div> <div class="col-8 text-muted small pt-2 ps-1"> : {{ $datauser->name }}</div>
                  <div class="col-4 text-secondary small pt-1 fw-bold">Alamat </div> <div class="col-8 text-muted small pt-2 ps-1"> : {{ $datauser->alamat }}</div>
                  <div class="col-4 text-secondary small pt-1 fw-bold">E-mail </div> <div class="col-8 text-muted small pt-2 ps-1"> : {{ $datauser->email }}</div>
                  <div class="col-4 text-secondary small pt-1 fw-bold">No. Handphone </div> <div class="col-8 text-muted small pt-2 ps-1"> : {{ $datauser->phone }}</div>
                  <form action="{{ route('user.destroy',$datauser->id_user) }}" method="POST">
                   @csrf
                   @method('DELETE')
                  <button type="button" class="btn-close show_confirm" data-toggle="tooltip" data-bs-dismiss="alert" aria-label="Close"></button>
                </form>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->
          @endforeach
        </div>
      </div>
    </div>
        
  </div>
  
@endsection

{{-- <div class="col-lg-6">
  <div class="info-box card">
    <h3>{{ $datauser->name }}</h3>
    <p>{{ $datauser->username }}<br>{{ $datauser->role }}<br>{{ $datauser->email }}<br>{{ $datauser->phone }}</p>
  </div>
</div> --}}
