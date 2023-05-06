<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MineSweeperOnline</title>

        @include("partial.head.bootstrap")
        @vite("resources/css/navbar.sass")
        @vite("resources/assets/font-awesome-pro-v6/css/all.css")
    </head>
    <body class="antialiased">

        @include("partial.navbar")


    </body>
</html>
