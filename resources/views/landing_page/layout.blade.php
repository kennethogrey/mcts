<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <base href="{{ URL::to('/') }}">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('landings/assets/img/mctslogo.png')}}" rel="icon">
  <link href="{{asset('landings/assets/img/favicon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('landings/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('landings/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('landings/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('landings/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('landings/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('landings/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('landings/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('landings/assets/css/style.css')}}" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <a href="/"><img src="landings/assets/img/mctslogo.png" alt="logo" class="img-fluid"></a>
        </div>

        <nav id="navbar" class="navbar">
            <ul>
            <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
            <li><a class="nav-link scrollto" href="#about">About</a></li>
            <li><a class="nav-link scrollto" href="#features">Features</a></li>
            <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
            <li><a class="nav-link scrollto" href="#team">Team</a></li>
            <li><a class="nav-link scrollto" href="#order">Order</a></li>
            <li><a class="nav-link scrollto" href="https://bse23-10-blog.owekisa.org/" target="_blank">Blog</a></li>
            <li><a class="nav-link scrollto" href="{{route('login')}}">Login</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  @yield('content')


  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h6><a href="/"><img src="landings/assets/img/mctslogo.png" alt="" class="img-fluid"></a></h6>
              <p class="pb-3"><em>Miniature Child Tracking System</em></p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <h4>Our Contacts</h4>
                <strong>Phone:</strong> +256 772 651432<br>
                <strong>Email:</strong> miniaturetracking@gmail.com<br>              
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <h4>Our Location</h4>
            <p>
                College of Computing and Information Technology <br>
                Makerere University, Uganda<br><br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        Copyright  &copy;2022-{{ date('Y') }} <strong><span>BSE23-10</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{asset('landings/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('landings/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('landings/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('landings/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('landings/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('landings/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('landings/assets/js/main.js')}}"></script>

</body>

</html>