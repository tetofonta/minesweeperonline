<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MineSweeperOnline - Register</title>

    @include("partial.head.bootstrap")
    @vite("resources/assets/font-awesome-pro-v6/css/all.css")
    @vite("resources/css/logo.sass")
    @vite("resources/css/game/mascot.sass")
</head>
<body class="antialiased">

<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="logo-big w-5 p-5 mb-5"></div>
                        <h3>Welcome {{ $username }}</h3>
                        <h5 class="mb-5">Thanks for registering to MineSweeperOnline.</h5>

                        In order to be able to login you must verify your email where a code has been sent.
                        <a class="btn btn-primary btn-lg btn-block w-100 my-3" href="/login"><i class="fa-solid fa-right-to-bracket"></i> Back to Login</a>
                        <a class="btn btn-secondary btn-lg btn-block w-100 my-3" href="/"><i class="fa-solid fa-house"></i> Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<span id="text-length-determining" class=""></span>
</body>


</html>