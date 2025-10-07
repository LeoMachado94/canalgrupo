<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="#">
    <title>Canal Service - Dashboard</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('template/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/argon.css?v=1.1.0') }}" type="text/css">
</head>

<body>
<!-- Sidenav -->
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('layouts.topnav-recover')
    <!-- Page content -->
    @yield('content')
</div>
<!-- Argon Scripts -->
<!-- Core -->
{{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}

<script src="{{ asset('template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('template/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<!-- Optional JS -->
{{--<script src="{{ asset('template/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>--}}
{{--<script src="{{ asset('template/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>--}}

@yield('scripts')
<!-- Argon JS -->
<script src="{{ asset('template/assets/js/argon.js?v=1.1.0') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<!-- Demo JS - remove this in your project -->
{{--<script src="{{ asset('template/assets/js/demo.min.js') }}"></script>--}}
</body>

</html>
