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
                        <h3 class="mb-5">Register to MineSweeperOnline</h3>

                        @isset($error_msg)
                            <div class="alert alert-danger">
                                {{ $error_msg }}
                            </div>
                        @endif

                        <form action="/register" method="post" class="form-outline mb-4">
                            @csrf
                            <input type="text" name="username" placeholder="Username" aria-label="Username" id="username-input" class="form-control form-control-lg my-3"/>
                            <input type="email" name="email" placeholder="Email" aria-label="Email" id="email-input" class="form-control form-control-lg my-3"/>
                            <div class="input-group my-3">
                                <input type="password" name="password" placeholder="Password" id="password-input" aria-label="Password" class="form-control form-control-lg"/>
                                <button type="button" class="btn btn-primary" id="toggle-show-password">
                                    <i class="fas fa-eye" id="show-password-button"></i>
                                </button>
                            </div>
                            <div class="input-group my-3">
                                <input type="password" name="password-repeat" placeholder="Repeat Password" id="password-repeat-input" aria-label="Password Repeat" class="form-control form-control-lg"/>
                                <button type="button" class="btn btn-primary" id="toggle-show-password-repeat">
                                    <i class="fas fa-eye" id="show-password-repeat-button"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary btn-lg btn-block w-100" type="submit"><i class="fa-solid fa-plus"></i> Register</button>
                        </form>
                        <a href="/login" class="my-3">Already have an account? Log In!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<span id="text-length-determining" class=""></span>
</body>

<script>
    let show_password = [false, false]
    document.getElementById("toggle-show-password").addEventListener('click', () => {
        document.getElementById("password-input").type = show_password[0] ? "password" : "text"
        show_password[0] = !show_password[0]
    })
    document.getElementById("toggle-show-password-repeat").addEventListener('click', () => {
        document.getElementById("password-repeat-input").type = show_password[1] ? "password" : "text"
        show_password[1] = !show_password[1]
    })
</script>

@vite("resources/js/LoginMascotBehavior.ts")

</html>
