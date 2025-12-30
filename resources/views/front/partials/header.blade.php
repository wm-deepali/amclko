<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Academy of Mass Communication</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font-awesome-4.6.3/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/marquee.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/example.css') }}">
  <link rel="stylesheet" href="{{ asset('owl-carousel/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('owl-carousel/owl.theme.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lightbox.min.css') }}">

  <script src="https://www.youtube.com/player_api"></script>

  {{-- SAME INLINE CSS – NO CHANGE --}}
  <style>
    #owl-demo .item,
    #owl-demo1 .item,
    #owl-demo2 .item {
      display: block;

      margin: 0px 10px;
      color: #FFF;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
      text-align: center;
    }

    .owl-theme .owl-controls .owl-buttons div {
      padding: 10px 11px;
    }

    .owl-theme .owl-buttons i {
      margin-top: 2px;
    }

    /*To move navigation buttons outside use these settings:*/

    .owl-theme .owl-controls .owl-buttons div {
      position: absolute;
    }

    .owl-theme .owl-controls .owl-buttons .owl-prev {
      left: 0;
      top: 50%;
    }

    .owl-theme .owl-controls .owl-buttons .owl-next {
      right: 0px;
      top: 50%;
    }

    .owl-pagination {
      display: none;
    }

    .header-right-buttons {
      padding: 10px 0;
    }

    .header-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 20px;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 5px;
      transition: all 0.3s ease;
      white-space: nowrap;
    }

    .header-btn i {
      font-size: 16px;
    }

    /* Outline Button Style (Contact & Career) */
    .header-btn-outline {
      background: transparent;
      color: #1a237e;
      border: 1px solid #1a237e;
    }

    .header-btn-outline:hover {
      background: #1a237e;
      color: white !important;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(26, 35, 126, 0.3);
    }

    /* Primary Button (Send Enquiry) */
    .header-btn-primary {
      background: linear-gradient(135deg, #ff6b6b, #ee5a52);
      color: white;
      border: none;
      box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
    }

    .header-btn-primary:hover {
      background: linear-gradient(135deg, #ff5252, #d32f2f);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(255, 82, 82, 0.5);
      color: white !important;
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
      .header-right-buttons {
        justify-content: center;
        margin-top: 15px;
        flex-wrap: wrap;
      }

      .header-btn {
        font-size: 14px;
        padding: 5px 16px;
      }
    }

    /* ===== AMC NAVBAR - FULLY OVERRIDE-PROOF ===== */
    .amc-navbar-container {
      background: linear-gradient(135deg, #0A1D56 0%, #1e3a8a 100%) !important;
      margin: 0 !important;
      padding: 0 !important;
      border-bottom: 4px solid #FF6B35;
    }

    .amc-navbar-main {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      margin-bottom: 0 !important;
    }

    .amc-navbar-center {
      float: none !important;
      display: table !important;
      margin: 0 auto !important;
      text-align: center !important;
    }

    .amc-menu-link {
      color: #ffffff !important;
      font-weight: 600 !important;
      font-size: 15px !important;
      padding: 18px 15px !important;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      position: relative !important;
      transition: all 0.35s ease !important;
    }

    .amc-menu-link:hover,
    .amc-menu-link:focus,
    .amc-menu-link.active {
      color: #FF6B35 !important;
      background: transparent !important;
    }

    /* Orange Underline Hover Effect */
    .amc-menu-link::after {
      content: '';
      position: absolute;
      bottom: 10px;
      left: 50%;
      width: 0;
      height: 3px;
      background: #FF6B35;
      transition: all 0.4s ease;
      transform: translateX(-50%);
    }

    .amc-menu-link:hover::after {
      width: 70% !important;
    }

    /* Custom Caret */
    .amc-caret {
      display: inline-block;
      width: 0;
      height: 0;
      margin-left: 8px;
      vertical-align: middle;
      border-top: 6px solid #FF6B35;
      border-right: 5px solid transparent;
      border-left: 5px solid transparent;
    }

    /* Dropdown Menu - No White Background! */
    .amc-dropdown {
      background: #0A1D56 !important;
      border: none !important;
      border-radius: 0 0 12px 12px !important;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5) !important;
      margin-top: 0 !important;
      padding: 10px 0 !important;
      min-width: 220px !important;
    }

    .amc-dropdown>li>a {
      color: #e0e0e0 !important;
      padding: 12px 28px !important;
      font-weight: 500 !important;
      transition: all 0.3s ease !important;
    }

    .amc-dropdown>li>a:hover {
      background: #FF6B35 !important;
      color: white !important;
      padding-left: 35px !important;
    }

    /* Mobile Menu */
    @media (max-width: 991px) {
      .amc-navbar-center {
        display: block !important;
        text-align: left !important;
      }

      .amc-menu-link {
        padding: 14px 20px !important;
      }

      .amc-dropdown {
        background: #0c2a6e !important;
        box-shadow: none !important;
      }
    }

    @media (min-width: 541px) {
      .navbar-header .logo {
        display: none !important;
      }
    }

    @media (max-width: 540px) {
      .header {
        display: none;
      }

      .navbar-header {
        display: flex;
        background: #fff;
        padding: 5px 10px;
        align-items: center;
      }

      .logo a img {
        width: 100%;
      }

      .amc-intro-section {
        padding: 40px 0;
        background: #ffffff;
        overflow: hidden;
      }

      .report-grid {
        display: grid;
        grid-template-columns: 1fr !important;
        gap: 25px;
      }

      .annual-report-section {
        height: auto !important;
        padding: 60px 0;
        background: #f7f9fc;
      }

      .amc-course-card {
        grid-template-columns: 1fr !important;
      }

      .content-block h1 {
        font-size: 28px !important;
      }

      .our-work h1 {
        font-size: 28px !important;
        margin-top: 20px !important;
      }

      .amc-intro-section {
        padding: 40px 0 !important;
      }

      .marquee-sibling {
        width: 40% !important;
      }
    }
  </style>
</head>

<body>

  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="logo">
            <a href="{{ url('/') }}">
              <img src="{{ asset('images/logo.png') }}" class="img-responsive">
            </a>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="header-right-buttons" style="display:flex;justify-content:flex-end;gap:15px;">
            <a href="{{ url('contact-us') }}" class="header-btn header-btn-outline">
              <i class="fa fa-phone"></i> Contact Us
            </a>

            <a href="{{ url('career') }}" class="header-btn header-btn-outline">
              <i class="fa fa-briefcase"></i> Career
            </a>

            <a href="#" class="header-btn header-btn-primary" data-toggle="modal" data-target="#myModal">
              <i class="fa fa-envelope"></i> Send Enquiry
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- NAVBAR – SAME STRUCTURE --}}
  <div class="amc-navbar-container">
    <nav class="navbar navbar-default amc-navbar-main">
      <div class="container">

        <div class="navbar-header">
          <div class="logo">
            <a href="{{ url('/') }}">
              <img src="{{ asset('images/logo.png') }}" class="img-responsive">
            </a>
          </div>

          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#amcMainMenu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <div class="collapse navbar-collapse" id="amcMainMenu">
          <ul class="nav navbar-nav amc-navbar-center">

            <li>
              <a href="{{ url('/') }}" class="amc-menu-link">Home</a>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle amc-menu-link" data-toggle="dropdown">
                About Us <span class="amc-caret"></span>
              </a>
              <ul class="dropdown-menu amc-dropdown">
                <li><a href="{{ url('chairman-message') }}">Message from Chairman</a></li>
                <li><a href="{{ url('secretary-message') }}">Message from Secretary</a></li>
                <li><a href="{{ url('about-us') }}">About Institution</a></li>
                <li><a href="{{ url('vision-mission') }}">Vision & Mission</a></li>
                <li><a href="{{ asset('images/aims.jpg') }}" target="_blank">Aims & Objectives</a></li>
                <li><a href="{{ url('view-certificate') }}">View Certification</a></li>
                <li><a href="{{ route('faqs') }}">FAQs</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle amc-menu-link" data-toggle="dropdown">
                Admission & Courses <span class="amc-caret"></span>
              </a>
              <ul class="dropdown-menu amc-dropdown">
                <li><a href="{{ url('application-form') }}">Admission Form</a></li>
                <li><a href="{{ url('courses') }}">Our Courses</a></li>
              </ul>
            </li>

            <li>
              <a href="{{ url('program') }}" class="amc-menu-link">Programmes</a>
            </li>

            <li>
              <a href="{{ route('blogs') }}" class="amc-menu-link">Blogs</a>
            </li>

            <li>
              <a href="{{ url('annual-report') }}" class="amc-menu-link">Annual Report</a>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle amc-menu-link" data-toggle="dropdown">
                Affiliation <span class="amc-caret"></span>
              </a>
              <ul class="dropdown-menu amc-dropdown">
                <li><a href="{{ url('govt-recognition') }}">Govt. Recognition</a></li>
                <li><a href="{{ url('skill-development') }}">Skill Development</a></li>
                <li><a href="{{ url('urdu-academy') }}">Urdu Academy</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle amc-menu-link" data-toggle="dropdown">
                Gallery <span class="amc-caret"></span>
              </a>
              <ul class="dropdown-menu amc-dropdown">
                <li><a href="{{ url('photo-gallery') }}">Image Gallery</a></li>
                <li><a href="{{ url('video-gallery') }}">Video Gallery</a></li>
              </ul>
            </li>

          </ul>

        </div>

      </div>
    </nav>
  </div>

  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/wow.min.js') }}"></script>
  <script src="{{ asset('assets/js/marquee.js') }}"></script>

  <script>
    $(function () {
      $('.simple-marquee-container').SimpleMarquee();
    });
  </script>