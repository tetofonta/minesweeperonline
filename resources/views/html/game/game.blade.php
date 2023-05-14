@extends('layouts.main')

@section('title')
    GAME
@endsection

@section('body')

    <div id="game-playground"></div>

    @vite('resources/js/game/Game.ts')
    <script type="module">

        document.addEventListener('DOMContentLoaded', () => {
            if("{{$error}}" === "1") {
                $('#newgame-dialog').modal('show')
                return;
            }

@if(!isset($error) || !$error)
            const game = new window.Game({{$width}}, {{$height}}, {{$bombs}});
            game.init('game-playground');
@endif
        })
    </script>
@endsection
