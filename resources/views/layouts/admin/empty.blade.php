<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Viettel Booking') }}</title>

    <!-- Theme Styles -->
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- Datatable CSS -->
    <link href="{{ asset('theme/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('theme/css/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- Morris CSS -->
    <link href="{{ asset('theme/css/morris.css') }}" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="{{ asset('theme/css/animate.css') }}" rel="stylesheet">
    <!-- Datepicker CSS -->
    <link href="{{ asset('theme/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet">
    <!-- Color CSS -->
    <link href="{{ asset('theme/css/colors/megna.css') }}" rel="stylesheet">
    <!-- Datetimepicker CSS -->
    <link href="{{ asset('theme/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="{{ asset('theme/css/summernote.css') }}" rel="stylesheet">
    <!-- Toast CSS -->
    <link href="{{ asset('theme/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- Multiselect CSS -->
    <link href="{{ asset('theme/css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@yield('content')

<!-- Theme Scripts -->
<!-- jQuery -->
<script src="{{ asset('theme/js/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('theme/js/tether.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap-extension.min.js') }}"></script>
<!-- Datatable JavaScript -->
<script src="{{ asset('theme/js/jquery.dataTables.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('theme/js/sidebar-nav.min.js') }}"></script>
<!--slimscroll JavaScript -->
<script src="{{ asset('theme/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('theme/js/waves.js') }}"></script>
<!--Morris JavaScript -->
<script src="{{ asset('theme/js/raphael-min.js') }}"></script>
<script src="{{ asset('theme/js/morris.js') }}"></script>
<!-- Sparkline chart JavaScript -->
<script src="{{ asset('theme/js/jquery.sparkline.min.js') }}"></script>
<!-- jQuery peity -->
<script src="{{ asset('theme/js/jquery.peity.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.peity.init.js') }}"></script>
<!-- Bootbox -->
<script src="{{ asset('theme/js/bootbox.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('theme/js/moment.min.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('theme/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Datetimepicker -->
<script src="{{ asset('theme/js/bootstrap-datetimepicker.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('theme/js/summernote.min.js') }}"></script>
<!-- Toast -->
<script src="{{ asset('theme/js/jquery.toast.js') }}"></script>
<!-- Multiselect -->
<script src="{{ asset('theme/js/bootstrap-multiselect.js') }}"></script>
<!-- Row Sorter -->
<script src="{{ asset('theme/js/row-sorter.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('theme/js/custom.min.js') }}"></script>
<!-- Scripts -->
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
