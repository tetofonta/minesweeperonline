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
    @if(!is_null(auth()->user()) && auth()->user()->active)
        <div class="container my-4">
            <div class="p-4 mx-6 my-3 bg" id="game-playground">
            <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Surrender">
                <a type="button" data-bs-toggle="modal" data-bs-target="#surrenderModal"><i
                        class="fa-duotone fa-flag fa-fade fa-xl"></i></a>
            </span>
                <div class="d-flex flex-column m-3 m-sm-1">
                    <div class="d-flex flex-column flex-nowrap justify-content-around align-items-center">
                        <div class="d-flex w-25 h-25"
                             style="max-height: 150px; max-width: 150px; min-height: 80px; min-width: 80px">
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
                $('[data-toggle="tooltip"]').tooltip()
                if ("{{$error}}" === "1") {
                    $('#newgame-dialog').modal('show')
                    const game = new window.Game(10, 10, 10, "mascot", "game-playground", "timer", "bombs", "field", false);
                    game.init('game-playground');
                    return;
                }

                @if(!isset($error) || !$error)
                const game = new window.Game({{$width}}, {{$height}}, {{$bombs}}, "mascot", "game-playground", "timer", "bombs", "field", true);
                game.init('game-playground');
                @endif
            })
        </script>


        @include("html.game.modal.surrender", ["id" => "surrenderModal"])
        @include("html.game.modal.win-lost", ["id" => "endGameModal"])
    @else
        <div class="container my-4">
            <div
                class="p-4 mx-6 my-5 alert alert-danger" role="alert">
                Your account has been blocked by an admin. This means you no longer appear in the standings and you
                cannot play any new games.
                Your game history is being analyzed by our staff.
                If you have questions, please contact <a href="mailto:support@minesweeperonline.net">support@minesweeperonline.net</a>
            </div>
        </div>
    @endif
@endsection
