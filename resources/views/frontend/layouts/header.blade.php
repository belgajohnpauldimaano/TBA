<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('page_title')    
    <link href="{{ asset('frontend/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/node_modules/owl.carousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/node_modules/owl.carousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
    <link href="{{ asset('cms/plugins/alertifyjs/css/alertify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/plugins/alertifyjs/css/themes/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('cms/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    @yield('styles')

    <link href="{{ asset('frontend/assets/css/app.css') }}" / rel="stylesheet">
    <link href="{{ asset('favicon.png') }}" rel=icon>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('frontend/assets/img/logo-white.png') }}" alt="TBA LOGO"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="nav-owl hidden-xs">
                  <div class="nav-owl__menu owl-carousel">
                      {{-- <a href="{{ route('films') }}" class="nav-owl__link nav-owl__link--text">Films</a>
                      <a href="{{ route('about') }}" class="nav-owl__link nav-owl__link--text">About</a>
                      <a href="{{ route('contact') }}" class="nav-owl__link nav-owl__link--text">Contact</a>
                      <a href="#" class="nav-owl__link nav-owl__link--text nav-owl__link--announcements">Announcements</a> --}}
                      <a href="{{ route('films') }}" class="nav-owl__link nav-owl__link--img nav-owl__link--film"></a>
                      <a href="{{ route('about') }}" class="nav-owl__link nav-owl__link--img nav-owl__link--about"></a>
                      <a href="{{ route('contact') }}" class="nav-owl__link nav-owl__link--img nav-owl__link--contact"></a>
                      <a href="#" class="nav-owl__link nav-owl__link--img nav-owl__link--announcements"></a>
                      <a href="#" class="nav-owl__link nav-owl__link--img nav-owl__link--cinema-76"></a>
                      <a href="#" class="nav-owl__link nav-owl__link--img nav-owl__link--cinema-tropa"></a>
                  </div>
                </div>
                <div class="visible-xs">
                    <ul class="nav navbar-nav navbar-right text-center">
                        <li><a href="{{ route('films') }}"><img src="{{ asset('frontend/assets/img/Films.png') }}" class="center-block"></a></li>
                        <li><a href="{{ route('about') }}"><img src="{{ asset('frontend/assets/img/About.png') }}" class="center-block"></a></li>
                        <li><a href="{{ route('contact') }}"><img src="{{ asset('frontend/assets/img/Contact.png') }}" class="center-block"></a></li>
                        <li><a href="#"><img src="{{ asset('frontend/assets/img/Announcements.png') }}" class="center-block"></a></li>
                        <li><a href="#"><img src="{{ asset('frontend/assets/img/CInema-76.png') }}" class="center-block"></a></li>
                        <li><a href="#"><img src="{{ asset('frontend/assets/img/Cinetropa.png') }}" class="center-block"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    @if(Request::route()->getName() != 'home')
        <nav class="navbar navbar-inverse navbar-fixed-top navbar__scrolled" style="background: url({{ asset('frontend/assets/img/navbar.png') }}) #d5ab44 no-repeat; display: none;"">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('frontend/assets/img/logo-black.png') }}" alt="TBA LOGO"></a>
                </div>
                <a href="#" class="gotoTop">
                    <div class="va-block">
                        <div class="va-middle">
                            <div class="fa-rotate-180">
                                <span class="caret"></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </nav>
    @endif