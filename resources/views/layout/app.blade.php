<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Bangladesh Fisheries Development Corporation</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/BFDC_logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/BFDC_logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/BFDC_logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BFDC_logo.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/BFDC_logo.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="../../../unicons.iconscout.com/release/v4.0.0/css/line.css') }}">
    <link href="{{ asset('assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/css/user.min.css') }}" type="text/css" rel="stylesheet" id="user-style-default">
    <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
    <style>
      .select2 {
        display: block;
        width: 100%;
        padding: .5rem 2.5rem .5rem 1rem;
        -moz-padding-start: calc(1rem - 3px);
        font-size: 0.8rem;
        font-weight: 600;
        line-height: 1.49;
        color: var(--phoenix-900);
        background-color: var(--phoenix-input-bg);
        background-image: var(--phoenix-form-select-indicator);
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 9px 12px;
        border: 1px solid var(--phoenix-input-border-color);
        border-radius: .375rem;
        -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0);
        box-shadow: inset 0 1px 2px rgba(0,0,0,0);
        -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        -o-transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
      }
      .select2-container .select2-selection--single{
        height:34px !important;
      }
      .select2-container--default .select2-selection--single{
        border: 1px solid #fff !important; 
        border-radius: 0px !important; 
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 28px;
        margin-top: 10px;
      }
      .select2-results__option {
        padding: 6px;
        -webkit-user-select: none;
        font-size: 0.8rem;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow {
        display: none;
      }
    </style>
    
  </head>
  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      @yield('content')
    </main>
    
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script>
      var navbarTopShape = window.config.config.phoenixNavbarTopShape;
      var navbarPosition = window.config.config.phoenixNavbarPosition;
      var body = document.querySelector('body');
      var navbarDefault = document.querySelector('#navbarDefault');
      var navbarTop = document.querySelector('#navbarTop');
      var topNavSlim = document.querySelector('#topNavSlim');
      var navbarTopSlim = document.querySelector('#navbarTopSlim');
      var navbarCombo = document.querySelector('#navbarCombo');
      var navbarComboSlim = document.querySelector('#navbarComboSlim');

      var documentElement = document.documentElement;
      var navbarVertical = document.querySelector('.navbar-vertical');

      if (navbarTopShape === 'slim' && navbarPosition === 'vertical') {
        navbarDefault.remove();
        navbarTop.remove();
        navbarTopSlim.remove();
        navbarCombo.remove();
        navbarComboSlim.remove();
        topNavSlim.style.display = 'block';
        navbarVertical.style.display = 'inline-block';
        body.classList.add('nav-slim');
      } else if (navbarTopShape === 'slim' && navbarPosition === 'horizontal') {
        navbarDefault.remove();
        navbarVertical.remove();
        navbarTop.remove();
        topNavSlim.remove();
        navbarCombo.remove();
        navbarComboSlim.remove();
        navbarTopSlim.removeAttribute('style');
        body.classList.add('nav-slim');
      } else if (navbarTopShape === 'slim' && navbarPosition === 'combo') {
        navbarDefault.remove();
        //- navbarVertical.remove();
        navbarTop.remove();
        topNavSlim.remove();
        navbarCombo.remove();
        navbarTopSlim.remove();
        navbarComboSlim.removeAttribute('style');
        navbarVertical.removeAttribute('style');
        body.classList.add('nav-slim');
      } else if (navbarTopShape === 'default' && navbarPosition === 'horizontal') {
        navbarDefault.remove();
        topNavSlim.remove();
        navbarVertical.remove();
        navbarTopSlim.remove();
        navbarCombo.remove();
        navbarComboSlim.remove();
        navbarTop.removeAttribute('style');
        documentElement.classList.add('navbar-horizontal');
      } else if (navbarTopShape === 'default' && navbarPosition === 'combo') {
        topNavSlim.remove();
        navbarTop.remove();
        navbarTopSlim.remove();
        navbarDefault.remove();
        navbarComboSlim.remove();
        navbarCombo.removeAttribute('style');
        navbarVertical.removeAttribute('style');
        documentElement.classList.add('navbar-combo')

      } else {
        topNavSlim.remove();
        navbarTop.remove();
        navbarTopSlim.remove();
        navbarCombo.remove();
        navbarComboSlim.remove();
        navbarDefault.removeAttribute('style');
        navbarVertical.removeAttribute('style');
      }

      var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
      var navbarTop = document.querySelector('.navbar-top');
      if (navbarTopStyle === 'darker') {
        navbarTop.classList.add('navbar-darker');
      }

      var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
      var navbarVertical = document.querySelector('.navbar-vertical');
      if (navbarVerticalStyle === 'darker') {
        navbarVertical.classList.add('navbar-darker');
      }
    </script>
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/phoenix.js') }}"></script>
    <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce-dashboard.js') }}"></script>
  </body>
</html>