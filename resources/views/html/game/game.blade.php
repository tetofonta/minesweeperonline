@extends('layouts.main')

@section('title')
    GAME
@endsection

@section('css')
    @vite("resources/css/game/mascot.sass")
    @vite("resources/css/game/game.sass")
    @vite("resources/css/navbar.sass")
@endsection

@section('body')

    <div class="container my-4">
        <div class="p-4 mx-6 my-3 bg" id="game-playground">
            <div class="d-flex flex-column m-3 m-sm-1">
                <div class="d-flex flex-column flex-nowrap justify-content-around align-items-center">
                    <div class="d-flex w-25 h-25" style="max-height: 150px; max-width: 150px; min-height: 80px; min-width: 80px">
                        @include('partial.mascot', ["id" => "mascot"])
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-row w-75">
                        <div>
                            <h1 class="text-center"><i class="fa-solid fa-timer"></i></h1>
                            <h2 class="text-center" id="timer">00:00</h2>
                        </div>
                        <div>
                            <h1 class="text-center"><i class="fa-solid fa-bomb"></i></h1>
                            <h2 class="text-center" id="bombs">00</h2>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column mt-3" id="field">

                </div>
            </div>

        </div>
    </div>

    @vite('resources/js/game/Game.ts')
    <script type="module">

        document.addEventListener('DOMContentLoaded', () => {
            if("{{$error}}" === "1") {
                $('#newgame-dialog').modal('show')
                return;
            }

@if(!isset($error) || !$error)
            const game = new window.Game({{$width}}, {{$height}}, {{$bombs}}, "mascot", "game-playground", "timer", "bombs", "field");
            game.init('game-playground');
@endif
        })
    </script>
@endsection
