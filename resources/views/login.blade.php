<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MineSweeperOnline - Login</title>

    @include("partial.head.bootstrap")
    @vite("resources/assets/font-awesome-pro-v6/css/all.css")
    @vite("resources/css/logo.sass")
    @vite("resources/css/game/mascot.sass")

    @vite("resources/js/game/MineSweeperMascot.ts")
</head>
<body class="antialiased">

<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="logo-big w-5 p-5 mb-5"></div>
                        <h3 class="mb-5">Log In</h3>

                        <div class="w-25 m-auto">
                            @include('partial.mascot', ["id" => "login-mascot"])
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="username" placeholder="Username or Email" aria-label="Username or Email" id="username-input" class="form-control form-control-lg my-3"/>
                            <div class="input-group">
                                <input type="password" name="password" placeholder="Password" id="password-input" aria-label="Password" class="form-control form-control-lg"/>
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-eye" id="show-password-button"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check d-flex justify-content-start mb-4">
                            <input class="form-check-input mx-2" type="checkbox" value="" name="Remember Password" id="remember-psw"/>
                            <label class="form-check-label" for="remember-psw"> Remember password </label>
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<span id="text-length-determining" class=""></span>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mascot = new window.Mascot("login-mascot")
        mascot.setState('standard')

        const aux = document.getElementById("text-length-determining")

        const bodyMouseFollow = (e) => {
            mascot.setEyeRotation(e.pageX, e.pageY)
        }

        const textFollow = (e) => {
            e.preventDefault()
            e.stopPropagation()
            const textPosition = e.target.selectionStart

            aux.innerText = e.target.value.substr(0, textPosition)
            const rect = e.target.getBoundingClientRect()
            mascot.setEyeRotation(rect.left + Math.min(aux.offsetWidth, e.target.clientWidth), rect.top)
        }

        document.getElementById('username-input').addEventListener('keyup', textFollow)
        document.getElementById('username-input').addEventListener('click', (e) => {
            mascot.setState("standard")
            textFollow(e)
        })
        document.body.addEventListener('mousemove', bodyMouseFollow)
        document.body.addEventListener('click', () => {
            mascot.setState("standard")
            document.body.addEventListener('mousemove', bodyMouseFollow)
        })
        document.getElementById('username-input').addEventListener('focus', (e) => {
            document.body.removeEventListener('mousemove', bodyMouseFollow)
        })

        let show_password = false

        const passwordClick = (e) => {
            e.stopPropagation()
            if(!show_password){
                mascot.setState("password")
                mascot.clearEyeRotation()
                document.body.removeEventListener('mousemove', textFollow)
                e.target.removeEventListener('keyup', textFollow)
                return;
            }

            mascot.clearEyeRotation()
            mascot.setState("password-spy")
            textFollow(e)
            e.target.addEventListener('keyup', textFollow)
        }

        document.getElementById('show-password-button').addEventListener('click', (e) => {
            e.stopPropagation()
            if(show_password){
                show_password = false
                e.target.classList.remove('fa-eye-slash')
                e.target.classList.add('fa-eye')
                document.getElementById('password-input').type = "password"
            } else {
                show_password = true
                e.target.classList.remove('fa-eye')
                e.target.classList.add('fa-eye-slash')
                document.getElementById('password-input').type = "text"
            }
            document.getElementById('password-input').focus()
        })
        document.getElementById('password-input').addEventListener('click', passwordClick)
        document.getElementById('password-input').addEventListener('focus', (e) => {
            document.body.removeEventListener('mousemove', bodyMouseFollow)
            passwordClick(e)
        })


    })
</script>

</html>
