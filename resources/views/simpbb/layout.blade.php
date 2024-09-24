<!DOCTYPE html>
<html>
<head>
    <title>SiluMan - Sistem Alur Manajemen</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="//cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Favicons -->
    <link href="{{asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{asset('assets/img/favicon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/style.css') }}" rel="stylesheet">

    <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" ></script> 
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
  </head>

  <body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
  
      <div class="d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
          <img src="{{asset('assets/img/logo.png') }}" alt="">
          <span class="d-none d-lg-block">SiluMan</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->
  
      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
  
          <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
              <i class="bi bi-search"></i>
            </a>
          </li><!-- End Search Icon-->
          <li class="nav-item dropdown">

            <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-bell"></i>
              <span class="badge bg-danger badge-number">0</span>
            </a><!-- End Notification Icon -->
  
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="">
              <li class="dropdown-header">
                Tidak ada pesan notifikasi
                <a href="#" class="d-none"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
  
            </ul><!-- End Notification Dropdown Items -->
  
          </li>
           <li class="nav-item dropdown pe-3">
  
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <img src="/user-profile/{{ Auth::user()->foto }}" alt="Profile" class="rounded-circle">
              <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name; }}</span>
            </a><!-- End Profile Iamge Icon -->
  
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                <h6>{{ Auth::user()->name }}</h6>
                <span>
                  @if (Auth::user()->id_user == '99')
                    {{ 'Progammer & Designer' }}
                    @else
                    {{ Auth::user()->role }}
                  @endif
                  
                </span>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
  
              <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/user') }}">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/logout') }}">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </li>
  
            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->
  
        </ul>
      </nav><!-- End Icons Navigation -->
  
    </header><!-- End Header -->
  
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
  
      <ul class="sidebar-nav" id="sidebar-nav">
  
        <li class="nav-item" >
          <a class="nav-link {{ Request::is('/') ? 'active' : 'collapsed' }}" href="{{ url('/') }}" >
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->
       
        
        @if (Auth::user()->role == 'God' || Auth::user()->role == 'upt'|| Auth::user()->role == 'pusat')
          
        <li class="nav-item">
          <a class="nav-link {{ Request::is('add','add2','simpbb') ? '' : 'collapsed' }}" data-bs-target="#components-nav-0" data-bs-toggle="collapse" aria-expanded="{{ Request::is('simpbb/create','simpbb') ? 'true' : 'false' }}" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Data Berkas</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav-0" class="nav-content {{ Request::is('add','add2','simpbb') ? 'collapsed' : 'collapse' }}" data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{ url('add') }}" class="nav-link {{ Request::is('add','add2') ? 'active' : 'collapsed' }}">
                <i class="bi bi-circle" ></i><span>Input Berkas</span>
              </a>
            </li>
            <li>
              <a href="{{ url('/simpbb') }}" class="nav-link {{ Request::is('simpbb') ? 'active' : 'collapsed' }}">
                <i class="bi bi-circle" ></i><span>Daftar Berkas</span>
              </a>
            </li>
          </ul>
        </li><!-- End Components Nav -->
        @endif
        @if (Auth::user()->role == 'God' || Auth::user()->role == 'peta')
        <li class="nav-item">
          <a class="nav-link {{ Request::is('peta','tolakpeta') ? '' : 'collapsed' }}" data-bs-target="#components-nav-1" data-bs-toggle="collapse" href="#" aria-expanded="{{ Request::is('peta','tolakpeta') ? 'true' : 'false' }}">
            <i class="ri-map-2-fill"></i><span>Data Peta</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav-1" class="nav-content {{ Request::is('peta','tolakpeta') ? 'collapsed' : 'collapse' }}" data-bs-parent="#sidebar-nav">
            <li class="nav-item">
              <a class="nav-link {{ Request::is('peta') ? 'active' : 'collapsed' }}" href="{{ url('/peta') }}">
                <i class="bi bi-circle"></i>
                <span>Daftar Peta</span>
              </a>
            </li>
            <li>
              <a href="{{ url('/tolakpeta') }}" class="nav-link {{ Request::is('tolakpeta') ? 'active' : 'collapsed' }}">
                <i class="bi bi-circle" ></i><span>Daftar Tolak Peta</span>
              </a>
            </li>
          </ul>
        </li>
        @endif
        
        <li class="nav-item">
          <a class="nav-link {{ Request::is('lapberkas','filber','lappeta') ? '' : 'collapsed' }}" data-bs-target="#components-nav-2" data-bs-toggle="collapse" aria-expanded="{{ Request::is('lapberkas') ? 'true' : 'false' }}" href="#">
            <i class="bx bx-book-content"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav-2" class="nav-content {{ Request::is('lapberkas','filber','lappeta') ? 'collapsed' : 'collapse' }}" data-bs-parent="#sidebar-nav">
            @if (Auth::user()->role == 'God'|| Auth::user()->role == 'pusat' || Auth::user()->role == 'upt')
            <li>
              <a href="{{ url('lapberkas') }}" class="nav-link {{ Request::is('lapberkas','filber') ? 'active' : 'collapsed' }}">
                <i class="bi bi-circle" ></i><span>Laporan Berkas Arsip</span>
              </a>
            </li>
            @endif
             @if (Auth::user()->role == 'God'|| Auth::user()->role == 'peta')
            <li>
              <a href="{{ url('lappeta') }}" class="nav-link {{ Request::is('lappeta','filpet') ? 'active' : 'collapsed' }}">
                <i class="bi bi-circle" ></i><span>Laporan Peta</span>
              </a>
            </li>
            @endif
          </ul>
        </li><!-- End Components Nav -->
        @if (Auth::user()->role == 'God')
        <li class="nav-item">
          <a class="nav-link {{ Request::is('manageuser') ? 'active' : 'collapsed' }}" href="{{ url('/manageuser') }}">
            <i class="bx bxs-user-account"></i>
            <span>Data User</span>
          </a>
        </li><!-- End Tables Nav -->
        @endif
        <li class="nav-item" >
          <a class="nav-link {{ Request::is('user') ? 'active' : 'collapsed' }}" href="{{ url('/user') }}" >
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
          </a>
        </li><!-- End Logout Nav -->
        
      </ul>
      
    </aside><!-- End Sidebar-->
    
    <main id="main" class="main">

                <!-- Table with stripped rows -->
                @yield('content')
                <!-- End Table with stripped rows -->
  
    </main><!-- End #main -->
  
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>SiluMan</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="#">AnarchyCox</a>
      </div>
    </footer><!-- End Footer -->  
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script>
      $(document).ready(function() {
      // Array yang berisi URL gambar-gambar yang akan ditampilkan
      var images = [
          'assets/img/sitting-girl-with-laptop-light.png',
          'assets/img/man-with-laptop-light.png',
          'assets/img/man-with-laptop-light-2.png'
      ];

      // Fungsi untuk memilih gambar secara acak
      function getRandomImage() {
          var randomIndex = Math.floor(Math.random() * images.length);
          return images[randomIndex];
      }
      $('.show_confirm').click(function(event) {
                                 var form = $(this).closest("form");
                                 var name = $(this).data("name");
                                  event.preventDefault();
                                 swal({
                                     title: "Apakah yakin menghapus ini?",
                                     text: "Jika anda menghapus ini, data akan hilang permanen",
                                     icon: "warning",
                                     buttons: true,
                                     dangerMode: true,
                                 })
                                 .then((willDelete) => {
                                   if (willDelete) {
                                     form.submit();
                                   }
                                 });
                             });
      // Menetapkan URL gambar yang dipilih secara acak ke elemen gambar dalam elemen dengan ID gallery
      $('#fotodepan #randomImage').attr('src', getRandomImage());
      });

      $(document).ready(function () {
          $('#nop').on('input', function () {
          let value = $(this).val();
          
          // Hapus semua titik terlebih dahulu
          value = value.replace(/[.-]/g, '');
  
          // Sisipkan titik pada posisi ke-2 dan ke-6
          if (value.length > 2) {
              value = value.slice(0, 2) + '.' + value.slice(2);
          }
          if (value.length > 5) {
              value = value.slice(0, 5) + '.' + value.slice(5);
          }
          if (value.length > 9) {
              value = value.slice(0, 9) + '.' + value.slice(9);
          }
          if (value.length > 13) {
              value = value.slice(0, 13) + '.' + value.slice(13);
          }
          if (value.length > 17) {
              value = value.slice(0, 17) + '-' + value.slice(17);
          }
          if (value.length > 22) {
              value = value.slice(0, 22) + '.' + value.slice(22);
          }
          // Perbarui nilai input field
          $(this).val(value);
            });
      });
      $(document).ready(function () {
          $('#Phone').on('input', function () {
          let value = $(this).val();
          
          // Hapus semua titik terlebih dahulu
          value = value.replace(/[-]/g, '');
  
          // Sisipkan titik pada posisi ke-2 dan ke-6
          if (value.length > 3) {
              value = value.slice(0, 3) + '-' + value.slice(3);
          }      
          if (value.length > 7) {
              value = value.slice(0, 7) + '-' + value.slice(7);
          }
          if (value.length > 12) {
              value = value.slice(0, 12) + '-' + value.slice(12);
          }
          // Perbarui nilai input field
          $(this).val(value);
          });
      });
      
  </script>

<!-- Vendor JS Files -->
<script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{asset('assets/vendor/quill/quill.js') }}"></script>
<script src="{{asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/vendor/php-email-form/validate.js') }}"></script>
{{-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> --}}
<script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{asset('assets/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Template Main JS File -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script>
  // Initialize all tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
 </body>
  
  </html>
      