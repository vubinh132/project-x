<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Virtus') }}</title>
    <!-- Theme Styles -->
    <link href="{{ asset('theme/user/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/user/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/user/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/user/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/user/css/Pe-icon-7-stroke.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/user/css/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/user/css/flexslider.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Damion' rel='stylesheet' type='text/css'>
    <link href="{{ asset('theme/user/css/style.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
</head>
<body>

@yield('content')


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!-- Theme Scripts -->
<!-- jQuery -->
<script src="{{ asset('theme/user/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('theme/user/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('theme/user/js//owl.carousel.min.js') }}"></script>
<script src="{{ asset('theme/user/js/jquery.debouncedresize.js') }}"></script>
<script src="{{ asset('theme/user/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('theme/user/js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('theme/user/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('theme/user/js/chosen.jquery.min.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="{{ asset('theme/user/js/jquery.flexslider-min.js') }}"></script>
<script src="{{ asset('theme/user/js/jquery.jplayer.min.js') }}"></script>
<script src="{{ asset('theme/user/js/jquery.countTo.js') }}"></script>
<script src="{{ asset('theme/user/js/Modernizr.js') }}"></script>
{{--<script src="{{ asset('theme/user/js/hm-masonry.js') }}"></script>--}}
{{--<script src="{{ asset('theme/user/js/hm-map.min.js') }}"></script>--}}
<script src="{{ asset('theme/user/js/custom.js') }}"></script>

<!-- Scripts -->
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/user.js') }}"></script>


@yield('extra_scripts')
</body>
</html>
