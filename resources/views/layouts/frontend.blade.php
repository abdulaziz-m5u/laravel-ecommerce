<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.png') }}">
		
		<!-- all css here -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/pe-icon-7-stroke.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/icofont.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/easyzoom.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
        <script src="{{ asset('frontend/assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>

        <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>

        @include('partials.header')

        @yield('content')

     
       
		
		<!-- all js here -->
        <script src="{{ asset('frontend/assets/js/vendor/jquery-1.12.0.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/popper.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/waypoints.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/ajax-mail.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>
</html>
