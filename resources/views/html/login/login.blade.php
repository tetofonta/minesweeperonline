@extends('layouts.nonav')

@section('title')
    Login
@endsection

@section('css')
    @vite("resources/css/logo.sass")
    @vite("resources/css/game/mascot.sass")
@endsection

@section('scripts')
    @vite('resources/js/LoginMascotBehavior.ts')
@endsection

@section('body')
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <a href="/" alt="homepage"><div class="logo-big w-5 p-5 mb-5"></div></a>
                        <h3 class="mb-5">Log In</h3>

                        @isset($error_msg)
                            <div class="alert alert-danger">
                                {{ $error_msg }}
                            </div>
                        @endif

                        <div class="w-25 m-auto">
                            @include('partial.mascot', ["id" => "login-mascot"])
                        </div>

                        <form action="/login" method="post" class="form-outline mb-4">
                            <input type="text" name="name" placeholder="Username or Email"
                                   aria-label="Username or Email" id="username-input"
                                   class="form-control form-control-lg my-3"/>
                            <div class="input-group">
                                @csrf
                                <input type="password" name="password" placeholder="Password" id="password-input"
                                       aria-label="Password" class="form-control form-control-lg"/>
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-eye" id="show-password-button"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary btn-lg btn-block w-100 my-3" type="submit"><i
                                    class="fa-solid fa-right-to-bracket"></i> Login
                            </button>
                        </form>
                        <a href="/register" class="my-3">First time? Register an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<span id="text-length-determining" style="opacity: 0"></span>
@endsection
