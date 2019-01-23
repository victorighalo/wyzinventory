<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.css"/>

    <style>
        .navbar .navbar-brand-wrapper .navbar-brand img {
            width: calc(255px - 30px);
            height: 48px;
        }
        .navbar .navbar-brand-wrapper{
            background: transparent;
        }
    </style>
    @stack('style')
</head>
<body>
<div id="app">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
@include('partials.topnav')
        <!-- partial -->
        <div class="page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('partials.sidebar')

        @yield('content')
</div>
</div>
</div>

<!-- Scripts -->



{{--<script src="{{ asset('js/vendors/jquery-3.3.1.min.js') }}" ></script>--}}
{{--<script src="{{ asset('js/app.js') }}" ></script>--}}
{{--<script src="{{ asset('js/bootstrap.min.js') }}" ></script>--}}


{{--<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>--}}
<script src="{{ asset('js/app.js') }}" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.js"></script>

@stack('script')
</body>
</html>
