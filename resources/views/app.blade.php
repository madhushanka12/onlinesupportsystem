<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="{{ asset('css/themes/theme.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/themes/icons.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet">
        <!-- Scripts -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        <script src="{{ asset('js/themes/head.js') }}"></script>
        <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('libs/preline/preline.js') }}"></script>

        <script src="{{ asset('js/themes/app.js') }}"></script>
        <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('libs/jquery-knob/jquery.knob.min.js') }}"></script>
        <script src="{{ asset('libs/morris.js/morris.min.js') }}"></script>
        <script src="{{ asset('libs/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('js/themes/pages/dashboard.js') }}"></script>
    </body>
</html>
