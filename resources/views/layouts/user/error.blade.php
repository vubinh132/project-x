<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Virtus | Error') }}</title>

    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/bootstrap-extension.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet">
</head>
<body>
<section id="wrapper" class="error-page">
    <div class="error-box">
        <div class="error-body text-center">
            @yield('content')

            <div class="small text-danger" style="margin: 0 20px 30px; max-height:220px; overflow: scroll;">
                {{ isset($message) ? $message : '' }}
            </div>

            <a href="/" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Về Trang Chủ</a>
        </div>
        <footer class="footer text-center">
            <?php echo date("Y"); ?> &copy; Viettel Telecom. All rights reserved.
        </footer>
    </div>
</section>

<!-- jQuery -->
<script src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/js/tether.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap-extension.min.js') }}"></script>
</body>
</html>

