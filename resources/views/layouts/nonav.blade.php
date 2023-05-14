<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>minesweeperonline - @yield('title')</title>

    @include("partial.head.bootstrap")
    @vite("resources/assets/font-awesome-pro-v6/css/all.css")

    @yield('scripts')
    @yield('css')

</head>
<body class="antialiased">
@yield('navbar')
@yield('body')

</body>
</html>
