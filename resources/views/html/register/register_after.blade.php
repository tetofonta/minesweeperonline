@extends('layouts.nonav')

@section('title')
    Thankyou
@endsection

@section('css')
    @vite("resources/css/logo.sass")
@endsection

@section('body')
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <a href="/" alt="homepage"><div class="logo-big w-5 p-5 mb-5"></div></a>
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
@endsection
