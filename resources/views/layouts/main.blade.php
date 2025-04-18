<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main/app-dark.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.svg')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>
    <link href="{{asset('https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.css')}}" rel="stylesheet">
    <script src="{{asset('https://api.mapbox.com/mapbox-gl-js/v3.11.0/mapbox-gl.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/map.css?')}}?v={{ time() }}">
    <link rel="stylesheet" href="{{asset('assets/css/shared/iconly.css')}}">
</head>

<body>
    <div id="app">
    @include('layouts.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
            @yield('container')

        @include('layouts.footer')

            

        </div>
    </div>
    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    
<!-- Need: Apexcharts -->
<script src="{{asset('assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
@yield('maps')
</body>

</html>
