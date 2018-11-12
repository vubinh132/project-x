<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'X-CMS') }}</title>

    <!-- Theme Styles -->
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('theme/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/admin/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- Datatable CSS -->
    <link href="{{ asset('theme/admin/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('theme/admin/css/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- Morris CSS -->
    <link href="{{ asset('theme/admin/css/morris.css') }}" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="{{ asset('theme/admin/css/animate.css') }}" rel="stylesheet">
    <!-- Datepicker CSS -->
    <link href="{{ asset('theme/admin/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('theme/admin/css/style.css') }}" rel="stylesheet">
    <!-- Color CSS -->
    <link href="{{ asset('theme/admin/css/colors/megna.css') }}" rel="stylesheet">
    <!-- Datetimepicker CSS -->
    <link href="{{ asset('theme/admin/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="{{ asset('theme/admin/css/summernote.css') }}" rel="stylesheet">
    <!-- Toast CSS -->
    <link href="{{ asset('theme/admin/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- Multiselect CSS -->
    <link href="{{ asset('theme/admin/css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <!-- Confirm box -->
    <link href="{{ asset('theme/admin/css/jquery-confirm.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
<div class="loader"></div>
<div id="wrapper">
    @include('layouts.admin.header')

    @include('layouts.admin.sidebar')

    <div id="page-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>

        @include('layouts.admin.footer')
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!-- Theme Scripts -->
<!-- jQuery -->
<script src="{{ asset('theme/admin/js/jquery.min.js') }}"></script>
<!-- AngularJs -->
<script src="{{ asset('theme/admin/js/angular.min.js') }}"></script>
<script src="{{ asset('theme/admin/js/angular-sanitize.js') }}"></script>
<script src="{{ asset('theme/admin/js/ocLazyLoad.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('theme/admin/js/tether.min.js') }}"></script>
<script src="{{ asset('theme/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/admin/js/bootstrap-extension.min.js') }}"></script>
<!-- Datatable JavaScript -->
<script src="{{ asset('theme/admin/js/jquery.dataTables.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ asset('theme/admin/js/sidebar-nav.min.js') }}"></script>
<!--slimscroll JavaScript -->
<script src="{{ asset('theme/admin/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('theme/admin/js/waves.js') }}"></script>
<!--Morris JavaScript -->
<script src="{{ asset('theme/admin/js/raphael-min.js') }}"></script>
<script src="{{ asset('theme/admin/js/morris.js') }}"></script>
<!-- Sparkline chart JavaScript -->
<script src="{{ asset('theme/admin/js/jquery.sparkline.min.js') }}"></script>
<!-- jQuery peity -->
<script src="{{ asset('theme/admin/js/jquery.peity.min.js') }}"></script>
<script src="{{ asset('theme/admin/js/jquery.peity.init.js') }}"></script>
<!-- Comfirm box -->
<script src="{{ asset('theme/admin/js/jquery-confirm.min.js') }}"></script>
<!-- Bootbox -->
<script src="{{ asset('theme/admin/js/bootbox.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('theme/admin/js/moment.min.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('theme/admin/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Datetimepicker -->
<script src="{{ asset('theme/admin/js/bootstrap-datetimepicker.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('theme/admin/js/summernote.min.js') }}"></script>
<!-- Toast -->
<script src="{{ asset('theme/admin/js/jquery.toast.js') }}"></script>
<!-- Multiselect -->
<script src="{{ asset('theme/admin/js/bootstrap-multiselect.js') }}"></script>
<!-- Row Sorter -->
<script src="{{ asset('theme/admin/js/row-sorter.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('theme/admin/js/custom.min.js') }}"></script>
<!-- QR code JavaScript -->
<script src="{{ asset('theme/admin/js/jquery-qrcode.min.js') }}"></script>
<!-- Jquery format number -->
<script src="{{ asset('theme/admin/js/jquery.number.min.js') }}"></script>
<!-- Scripts -->
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>

<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut(1000);
    });
    @if (session('flash_message'))
    $(document).ready(function () {
        $.toast({
            heading: null,
            text: '{{ session('flash_message') }}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 4000,
            stack: 6
        })
    });
    @endif

    @if (session('flash_error'))
    $(document).ready(function () {
        $.toast({
            heading: null,
            text: '{{ session('flash_error') }}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 4000,
            stack: 6
        })
    });
    @endif
</script>

@yield('extra_scripts')
</body>
</html>
