<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if (!app()->isLocal())
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        @endif

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img') }}/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img') }}/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img') }}/favicon/favicon-16x16.png">
        <link rel="manifest" href="{{ asset('img') }}/favicon/site.webmanifest">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">

        <link type="text/css" href="{{ asset('css') }}/custom.css?v=1.0.2" rel="stylesheet">

        @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        <div class="main-content">
            @include('layouts.navbars.navbar')

            <div class="container{{ ($fluid ?? false) ? '-fluid' : '' }} mt-2 mb-5">
                @yield('content')
            </div>
        </div>

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        @stack('js')
        @include('components.scripts.nav-persistent')

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>
