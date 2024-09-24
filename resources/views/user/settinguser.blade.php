@extends('simpbb.layout')
     
@section('content')
<section class="section profile">
    <div class="row">
      @if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
      @endif
        <div class="col-xl-4">

            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
  
                <img src="/user-profile/{{ $userinfo->foto }}" alt="Profile" class="rounded-circle">
                <h2>{{ $userinfo->name }}</h2>
                <h3>{{ $userinfo->role }}</h3>
                <div class="social-links mt-2">
                  <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                  <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              
            </div>
  
          </div>
  
          <div class="col-xl-8">
  
            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
  
                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>
  
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                  </li>
  
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings Role</button>
                  </li>
  
                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                  </li>
  
                </ul>
                <div class="tab-content pt-2">
                    
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">

                    <h5 class="card-title">About</h5>
                    <p class="small fst-italic">{{ $userinfo->about }}</p>
                    
                    <h5 class="card-title">Profile Details</h5>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8">{{ $userinfo->name }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Username</div>
                      <div class="col-lg-9 col-md-8">{{ $userinfo->username }}</div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Role</div>
                      <div class="col-lg-9 col-md-8">{{ $userinfo->role }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Alamat</div>
                      <div class="col-lg-9 col-md-8">{{ $userinfo->alamat }}</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">No. Handphone</div>
                      <div class="col-lg-9 col-md-8">{{ $userinfo->phone }}</div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8">{{ $userinfo->email }}</div>
                    </div>
  
                  </div>
  
                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
  
                    <!-- Profile Edit Form -->
                    <form action="{{ route('user.update',$userinfo->id_user) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                          <img src="/user-profile/{{ $userinfo->foto }}" id="preview" alt="Profile">
                          <p class="font-monospace text-danger small pt-1 fw-italic fst-italic">*File Foto dalam bentuk foto/gambar (jpeg,png,jpg) max ukuran 2Mb.</p>
                          <div class="pt-2">
                            
                            <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" id="changeToFileInput"><i class="bi bi-upload"></i></a>

                            <input type="file" name="foto" id="fileInput" class="d-none" onchange="previewImage(event)">
                            <button type="button" href="#" class="btn btn-danger btn-sm" id="clear-preview" title="Remove my profile image" style="" onclick="HapusPreview()"><i class="bi bi-trash"></i></a>
                            <script>
                                document.getElementById('changeToFileInput').addEventListener('click', function(event) {
                                    event.preventDefault(); // Mencegah aksi default tautan
                                    document.getElementById('fileInput').click(); // Memicu klik pada input file
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
                                      output.src = '/user-profile/{{ $userinfo->foto }}';
                                  };
                                  
                            </script>
                          </div>
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="name" type="text" class="form-control" id="fullName" value="{{ $userinfo->name }}" required>
                          <div class="invalid-feedback">Please, masukkan nama lengkap anda!</div>
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                        <div class="col-md-8 col-lg-9">
                          <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $userinfo->about }}</textarea>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Username</label>
                        <div class="col-md-8 col-lg-9">
                          <input  type="text" class="form-control " id="Job" value="{{ $userinfo->username }}" disabled>
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="alamat" type="text" class="form-control" id="Address" value="{{ $userinfo->alamat }}" required>
                          <div class="invalid-feedback">Please, masukkan alamat anda!</div>
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">No. Handphone</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="phone" type="text" maxlength="18" class="form-control" id="Phone" value="{{ $userinfo->phone }}" required>
                          <div class="invalid-feedback">Please, masukkan nomor telepon anda!</div>
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label" required>Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="email" type="email" class="form-control" id="Email" value="{{ $userinfo->email }}" required>
                          <div class="invalid-feedback">Please, masukkan email anda!</div>
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="basic-url" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="facebook" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="instagram" type="text" class="form-control" id="Instagram" value="{{ $userinfo->instagram }}">
                        </div>
                      </div>
  
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End Profile Edit Form -->
  
                  </div>
  
                  <div class="tab-pane fade pt-3" id="profile-settings">
  
                    <!-- Settings Form -->
                    <form>
  
                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Role User</label>
                        <div class="col-md-8 col-lg-9">
                          
                          <select class="form-select" name="role" aria-label="Default select example" @if (Auth::user()->role <> 'God') disabled  @endif>
                            <option selected>-- Pilih Role User --</option>
                            <option value="God" disabled @if (Auth::user()->role == 'God') selected  @endif>Admin</option>
                            <option value="upt"  @if (Auth::user()->role == 'UPT') selected  @endif>UPT</option>
                            <option value="pusat" @if (Auth::user()->role == 'Pusat') selected  @endif>Pusat</option>
                            <option value="peta" @if (Auth::user()->role =='Peta Pusat') selected  @endif>Peta Pusat</option>
                          </select>
                        </div>
                      </div>
  
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End settings Form -->
  
                  </div>
  
                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form method="POST" action="{{ route('password.update') }}">
                      @csrf
  
                      <div class="row mb-3">
                        <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="current_password" type="password" class="form-control" id="current_password">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="new_password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="new_password" type="password" class="form-control" id="new_password">
                        </div>
                      </div>
  
                      <div class="row mb-3">
                        <label for="new_password_confirmation" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="new_password_confirmation" type="password" class="form-control" id="new_password_confirmation">
                        </div>
                      </div>
  
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                      </div>
                    </form><!-- End Change Password Form -->
  
                  </div>
  
                </div><!-- End Bordered Tabs -->
  
              </div>
            </div>
  
          </div>
        <script>
          $(document).ready(function() {
            $('#Phone').on('input', function() {
            // Ambil nilai input
            let inputValue = this.value;
            // Ganti huruf A atau B di awal kata dengan titik
            this.value = inputValue
                .split(' ')
                .map(word => {
                    if (word.startsWith('08') || word.startsWith('628')) {
                        return '+628' + word.slice(3);
                    }
                    return word;
                })
                .join(' ');
            });
        });
        </script>
</div>
</section>
@endsection