<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{{$title}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/aos.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/ionicons.min.css') }}">
    
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/fe/css/style.css') }}">
    
    <script src="{{ URL:: asset('assets/fe/js/jquery.min.js')}}"></script>
    <script>
        var siteUrl = '<?php echo url('/'); ?>';
    </script>
    
    <!-- Jquery Validation Js-->        
    <script src="{{ URL:: asset('js/jquery_validation/jquery.validate.min.js')}}"></script>
    <script src="{{ URL:: asset('js/jquery_validation/additional-methods.min.js')}}"></script>
  </head>
  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
      
      
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target" id="ftco-navbar">
        <div class="container">
          <a class="navbar-brand" href="index.html">Church<span>Software</span></a>
          <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
          </button>

          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav nav ml-auto">
              <li class="nav-item"><a href="#home-section" class="nav-link"><span>Home</span></a></li>
              <li class="nav-item"><a href="#services-section" class="nav-link"><span>Services</span></a></li>              
              <li class="nav-item"><a href="#about-section" class="nav-link"><span>About</span></a></li>
              <li class="nav-item"><a href="#testimony-section" class="nav-link"><span>Testimony</span></a></li>
              <li class="nav-item"><a href="#contact-section" class="nav-link"><span>Contact</span></a></li>
              <li class="nav-item"><a href="#sign-up" class="nav-link"><span>SignUp</span></a></li>
              <li class="nav-item"><a href="#sign-in" class="nav-link"><span>SignIn</span></a></li>
              <!-- {{ URL::asset('webapp/signup')}} -->
            </ul>
          </div>
        </div>
      </nav>
      
        

    