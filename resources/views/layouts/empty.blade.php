<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url('/logo.jpg') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>X-CMS Login</title>
    <!-- Theme Styles -->
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('theme/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/admin/css/bootstrap-extension.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
@yield('content')
<script src="{{ asset('theme/admin/js/jquery.min.js') }}"></script>
{{--<script src="{{ asset('theme/admin/js/bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ asset('theme/admin/js/bootstrap-extension.min.js') }}"></script>--}}
</body>
</html>
