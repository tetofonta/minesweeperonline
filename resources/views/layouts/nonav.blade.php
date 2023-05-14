<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>minesweeperonline - @yield('title')</title>

    @vite("resources/js/external/jquery.min.js")
    @include("partial.head.bootstrap")
    @vite("resources/assets/font-awesome-pro-v6/css/all.css")

    @yield('scripts')
    @yield('css')
    @vite('resources/css/app.sass')
</head>
<body class="antialiased">
@yield('navbar')
@yield('body')

</body>
</html>
