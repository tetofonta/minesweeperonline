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
<div class="container my-4">

    @if(isset($error_msg) || isset($info_msg))
        <div class="p-4 mx-6 my-5 alert @isset($error_msg) alert-danger @endisset @isset($info_msg) alert-success @endisset" role="alert">
            @isset($error_msg)
                {{ $error_msg }}
            @endisset
            @isset($info_msg)
                {{ $info_msg }}
            @endisset
        </div>
    @endif

    <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row">
        <h1>{{ auth()->user()->username }}</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal"><i class="fa-solid fa-hammer"></i> Edit account</button>
    </div>
    <div class="p-4 mx-6 my-3 mb-4 bg">
        <h3>User Info</h3>
        <ul>
            <li>Email: {{ auth()->user()->id }}</li>
            <li>Last Login: {{ auth()->user()->last_login }}</li>
            <li>Player since: {{ auth()->user()->created_at }}</li>
        </ul>
    </div>
    <div class="p-4 mx-6 my-3 d-flex justify-content-between bg danger-border flex-column flex-md-row">
        <h3>DANGER ZONE</h3>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Delete Account</button>
    </div>
</div>

@include("html.profile.modal.profileadmin", ["id" => "adminModal"])
@include("html.profile.modal.profiledelete", ["id" => "deleteModal"])

</body>

</html>
