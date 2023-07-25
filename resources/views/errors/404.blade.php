@extends('layouts.main')

@section('title', '404')
@section('css')
    @vite("resources/css/game/mascot.sass")
    @vite("resources/css/logo.sass")
@endsection

@section('body')
    <div class="w-100 d-flex justify-content-center flex-column align-items-center" style="height: 80vh">
        <div class="w-25 py-4" style="max-width: 150px">
            @include('partial.mascot', ["id" => "mascot"])
        </div>
        <h1>404</h1>
        <p>Looks like there was nothing under this flag...</p>
    </div>
    @vite('resources/js/404Behavior.ts')
@endsection
