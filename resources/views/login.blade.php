<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MineSweeperOnline</title>

    @include("partial.head.bootstrap")
    @vite("resources/assets/font-awesome-pro-v6/css/all.css")
    @vite("resources/css/logo.sass")

</head>
<body class="antialiased">

<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="logo-big" style="width: 60%; padding-bottom: 60%"></div>
                        <h5 class="mb-5">Sign in</h5>

                        <div class="form-outline mb-4">
                            <input type="email" id="typeEmailX-2" class="form-control form-control-lg"/>
                            <label class="form-label" for="typeEmailX-2">Email</label>

                            <input type="password" id="typePasswordX-2" class="form-control form-control-lg"/>
                            <label class="form-label" for="typePasswordX-2">Password</label>
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check d-flex justify-content-start mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="form1Example3"/>
                            <label class="form-check-label" for="form1Example3"> Remember password </label>
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
