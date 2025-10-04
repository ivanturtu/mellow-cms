<!DOCTYPE html>
<html>

<head>
  <title>Mellow - Hotel HTML Website Template</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">

  <!--Bootstrap ================================================== -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/css/bootstrap.min.css') }}">

  <!--vendor css ================================================== -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/css/vendor.css') }}">

  <!--Link Swiper's CSS ================================================== -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

  <!--Link AOS's CSS ================================================== -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Style Sheet ================================================== -->
  <link rel="stylesheet" type="text/css" href="{{ asset('mellow/style.css') }}">

  <!-- Google Fonts ================================================== -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&family=Sora:wght@100..800&display=swap"
    rel="stylesheet">
</head>

<body>

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="wifi" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M6.55 12.192c3.017-3.256 7.883-3.256 10.9 0a.75.75 0 1 0 1.1-1.02c-3.61-3.896-9.49-3.896-13.1 0a.75.75 0 1 0 1.1 1.02" />
      <path fill="currentColor"
        d="M8.55 14.35c1.912-2.064 4.987-2.064 6.9 0a.75.75 0 1 0 1.1-1.019c-2.506-2.705-6.594-2.705-9.1 0a.75.75 0 1 0 1.1 1.02" />
      <path fill="currentColor"
        d="M10.55 16.51c.808-.872 2.092-.872 2.9 0a.75.75 0 1 0 1.1-1.02c-1.401-1.513-3.699-1.513-5.1 0a.75.75 0 1 0 1.1 1.02" />
      <path fill="currentColor" fill-rule="evenodd"
        d="M12 1.25c-.708 0-1.351.203-2.05.542c-.674.328-1.454.812-2.427 1.416L5.456 4.491c-.92.572-1.659 1.03-2.227 1.465c-.589.45-1.041.91-1.368 1.507c-.326.595-.472 1.229-.543 1.978c-.068.725-.068 1.613-.068 2.726v1.613c0 1.904 0 3.407.153 4.582c.156 1.205.486 2.178 1.23 2.947c.747.773 1.697 1.119 2.875 1.282c1.14.159 2.598.159 4.434.159h4.116c1.836 0 3.294 0 4.434-.159c1.177-.163 2.128-.509 2.876-1.282c.743-.769 1.073-1.742 1.23-2.947c.152-1.175.152-2.678.152-4.582v-1.613c0-1.113 0-2-.068-2.726c-.07-.75-.217-1.383-.543-1.978c-.327-.597-.78-1.056-1.368-1.507c-.568-.436-1.306-.893-2.227-1.465l-2.067-1.283c-.973-.604-1.753-1.088-2.428-1.416c-.697-.34-1.34-.542-2.049-.542M8.28 4.504c1.015-.63 1.73-1.072 2.327-1.363c.581-.283.993-.391 1.393-.391s.812.108 1.393.391c.598.29 1.312.733 2.327 1.363l2 1.241c.961.597 1.636 1.016 2.14 1.402c.489.375.77.684.963 1.036c.193.353.306.766.365 1.398c.061.648.062 1.465.062 2.623v1.521c0 1.97-.002 3.376-.14 4.443c-.136 1.048-.393 1.656-.82 2.099c-.425.439-1.003.7-2.004.839c-1.026.142-2.379.144-4.286.144h-4c-1.908 0-3.26-.002-4.286-.144c-1.001-.14-1.579-.4-2.003-.84c-.428-.442-.685-1.05-.82-2.098c-.14-1.067-.141-2.472-.141-4.443v-1.521c0-1.158 0-1.975.062-2.623c.059-.632.172-1.045.365-1.398c.193-.352.474-.661.964-1.036c.503-.386 1.178-.805 2.139-1.402z"
        clip-rule="evenodd" />
    </symbol>
    <symbol id="location" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7m0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5" />
    </symbol>
    <symbol id="phone" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24c1.12.37 2.33.57 3.57.57c.55 0 1 .45 1 1V20c0 .55-.45 1-1 1c-9.39 0-17-7.61-17-17c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02l-2.2 2.2z" />
    </symbol>
    <symbol id="email" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5l-8-5V6l8 5l8-5v2z" />
    </symbol>
    <symbol id="calendar" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z" />
    </symbol>
    <symbol id="arrow-right" viewBox="0 0 24 24">
      <path fill="currentColor" d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6l-6 6l-1.41-1.41z" />
    </symbol>
    <symbol id="arrow-left" viewBox="0 0 24 24">
      <path fill="currentColor" d="M15.41 7.41L14 6l-6 6l6 6l1.41-1.41L10.83 12z" />
    </symbol>
    <symbol id="clock" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
    </symbol>
    <symbol id="meditation" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
    </symbol>
    <symbol id="chef-hat" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2M21 9V7L15 1H9L3 7V9H1V11H3V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V11H23V9H21M19 19H5V11H19V19Z" />
    </symbol>
    <symbol id="swimming" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M2 18C4 22 8 22 12 22S20 22 22 18C20 14 16 14 12 14S4 14 2 18M6 18C7 16 9 16 12 16S17 16 18 18C17 20 15 20 12 20S7 20 6 18M9 18C9.5 17 10.5 17 12 17S14.5 17 15 18C14.5 19 13.5 19 12 19S9.5 19 9 18M12 18C12.2 17.8 12.5 17.8 12.8 18C12.5 18.2 12.2 18.2 12 18Z" />
    </symbol>
    <symbol id="spa" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M15.5 6.5C15.5 5.66 17 4 17 4S18.5 5.66 18.5 6.5C18.5 7.33 17.83 8 17 8S15.5 7.33 15.5 6.5M19.5 15.5C20.88 15.5 22 14.38 22 13S20.88 10.5 19.5 10.5S17 11.62 17 13S18.12 15.5 19.5 15.5M13 12.5C13 11.67 12.33 11 11.5 11S10 11.67 10 12.5S10.67 14 11.5 14S13 13.33 13 12.5M6.5 15.5C7.88 15.5 9 14.38 9 13S7.88 10.5 6.5 10.5S4 11.62 4 13S5.12 15.5 6.5 15.5M12 18C13.38 18 14.5 16.88 14.5 15.5S13.38 13 12 13S9.5 14.12 9.5 15.5S10.62 18 12 18M12 22C13.38 22 14.5 20.88 14.5 19.5S13.38 17 12 17S9.5 18.12 9.5 19.5S10.62 22 12 22M6.5 22C7.88 22 9 20.88 9 19.5S7.88 17 6.5 17S4 18.12 4 19.5S5.12 22 6.5 22M19.5 22C20.88 22 22 20.88 22 19.5S20.88 17 19.5 17S17 18.12 17 19.5S18.12 22 19.5 22Z" />
    </symbol>
    <symbol id="concierge" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5l1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
    </symbol>
    <symbol id="business" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
    </symbol>
  </svg>

  <header id="header">
    <nav class="header-top bg-secondary py-1">
      <div class="container-fluid padding-side">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <ul class="info d-flex flex-wrap list-unstyled m-0">
            <li class="location text-capitalize d-flex align-items-center me-4" style="font-size: 14px;">
              <svg class="color me-1" width="15" height="15">
                <use xlink:href="#location"></use>
              </svg>Hotel Mellow & Resort
            </li>
            <li class="text-capitalize ms-4">
              <svg class="color me-1" width="15" height="15">
                <use xlink:href="#phone"></use>
              </svg>+39 123 456 7890
            </li>
            <li class="text-capitalize ms-4">
              <svg class="color me-1" width="15" height="15">
                <use xlink:href="#email"></use>
              </svg>info@hotelmellow.com
            </li>
          </ul>
          <ul class="social d-flex flex-wrap list-unstyled m-0">
            <li class="ms-3">
              <a href="#" class="text-body">
                <svg class="color" width="15" height="15">
                  <use xlink:href="#facebook"></use>
                </svg>
              </a>
            </li>
            <li class="ms-3">
              <a href="#" class="text-body">
                <svg class="color" width="15" height="15">
                  <use xlink:href="#twitter"></use>
                </svg>
              </a>
            </li>
            <li class="ms-3">
              <a href="#" class="text-body">
                <svg class="color" width="15" height="15">
                  <use xlink:href="#instagram"></use>
                </svg>
              </a>
            </li>
            <li class="ms-3">
              <a href="#" class="text-body">
                <svg class="color" width="15" height="15">
                  <use xlink:href="#linkedin"></use>
                </svg>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <nav id="primary-header" class="navbar navbar-expand-lg py-4">
      <div class="container-fluid padding-side">
        <div class="d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('mellow/images/main-logo.png') }}" class="logo img-fluid">
          </a>
          <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="bdNavbarOffcanvasLabel">Menu</h5>
              <button type="button" class="btn-close btn-close-black mt-2" data-bs-dismiss="offcanvas"
                aria-label="Close" data-bs-target="#bdNavbar"></button>
            </div>
            <div class="offcanvas-body align-items-center justify-content-center">
              <div class="search d-block d-lg-none m-5">
                <form class=" position-relative">
                  <input type="text" class="form-control bg-secondary border-0 rounded-5 px-4 py-2"
                    placeholder="Search...">
                  <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y pe-3">
                    <svg class="color" width="20" height="20">
                      <use xlink:href="#search"></use>
                    </svg>
                  </button>
                </form>
              </div>
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#rooms">Camere</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#services">Servizi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#gallery">Gallery</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#blog">Blog</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#contact">Contatti</a>
                </li>
              </ul>
              <div class="d-flex flex-wrap align-items-center justify-content-center mt-4 mt-lg-0">
                <div class="search d-none d-lg-block me-4">
                  <form class="position-relative">
                    <input type="text" class="form-control bg-secondary border-0 rounded-5 px-4 py-2"
                      placeholder="Search...">
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y pe-3">
                      <svg class="color" width="20" height="20">
                        <use xlink:href="#search"></use>
                      </svg>
                    </button>
                  </form>
                </div>
                <div class="booking d-flex flex-wrap align-items-center">
                  <div class="date position-relative bg-transparent me-3" id="select-arrival-date">
                    <a href="#" class="position-absolute top-50 end-0 translate-middle-y pe-2 ">
                      <svg class="text-body" width="25" height="25">
                        <use xlink:href="#calendar"></use>
                      </svg>
                    </a>
                  </div>
                  <div class="date position-relative bg-transparent me-3" id="select-departure-date">
                    <a href="#" class="position-absolute top-50 end-0 translate-middle-y pe-2 ">
                      <svg class="text-body" width="25" height="25">
                        <use xlink:href="#calendar"></use>
                      </svg>
                    </a>
                  </div>
                  <a href="#" class="btn btn-primary rounded-5 px-4 py-2">Book Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>

  @yield('content')

  <!-- Footer Section -->
  <footer id="footer" class="bg-secondary">
    <div class="container-fluid padding-side">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="footer-widget">
            <h4 class="text-white mb-3">Hotel Mellow</h4>
            <p class="text-white-50">Il vostro gateway alla serenità nel cuore della città.</p>
            <div class="social-links mt-3">
              <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
              <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
              <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 mb-4">
          <div class="footer-widget">
            <h5 class="text-white mb-3">Link Utili</h5>
            <ul class="list-unstyled">
              <li><a href="#rooms" class="text-white-50 text-decoration-none">Camere</a></li>
              <li><a href="#services" class="text-white-50 text-decoration-none">Servizi</a></li>
              <li><a href="#gallery" class="text-white-50 text-decoration-none">Gallery</a></li>
              <li><a href="#blog" class="text-white-50 text-decoration-none">Blog</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="footer-widget">
            <h5 class="text-white mb-3">Contatti</h5>
            <ul class="list-unstyled">
              <li class="text-white-50 mb-2">
                <i class="fas fa-map-marker-alt me-2"></i>
                Via della Serenità, 123 - 00100 Roma
              </li>
              <li class="text-white-50 mb-2">
                <i class="fas fa-phone me-2"></i>
                +39 123 456 7890
              </li>
              <li class="text-white-50">
                <i class="fas fa-envelope me-2"></i>
                info@hotelmellow.com
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="footer-widget">
            <h5 class="text-white mb-3">Newsletter</h5>
            <p class="text-white-50">Iscriviti per ricevere le nostre offerte speciali</p>
            <form class="mt-3">
              <div class="input-group">
                <input type="email" class="form-control" placeholder="La tua email">
                <button class="btn btn-primary" type="submit">Iscriviti</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <hr class="text-white-50 my-4">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="text-white-50 mb-0">&copy; 2024 Hotel Mellow. Tutti i diritti riservati.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <a href="#" class="text-white-50 text-decoration-none me-3">Privacy Policy</a>
          <a href="#" class="text-white-50 text-decoration-none">Termini di Servizio</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('mellow/js/jquery-1.11.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('mellow/js/bootstrap.bundle.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('mellow/js/plugins.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script type="text/javascript" src="{{ asset('mellow/js/script.js') }}"></script>

  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>

</html>