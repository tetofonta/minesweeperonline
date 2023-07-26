<?php
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $ends[$number % 10];
}
    ?>
@inject('gameController', 'App\Http\Controllers\GameController')



@extends('layouts.main')

@section('title')
    HOME Page
@endsection

@section('css')
    @vite("resources/css/game/mascot.sass")
    @vite("resources/css/logo.sass")
@endsection

@section('body')

    @if(!is_null(auth()->user()) && !auth()->user()->active)
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

    <div id="carousel" class="carousel slide" data-bs-ride="carousel" style="height: 70vh; max-height: 740px">
        <div class="carousel-indicators">
            <div data-bs-target="#carousel" data-bs-slide-to="0" class="active"></div>
            <div data-bs-target="#carousel" data-bs-slide-to="1"></div>
            <div data-bs-target="#carousel" data-bs-slide-to="2"></div>
        </div>
        <div class="carousel-inner h-100">
            <div class="carousel-item active h-100">
                <div class="container my-4 d-flex flex-column flex-md-row h-100 justify-content-around">
                    <div class="d-flex flex-column justify-content-center">
                        <h1>{{App\Models\Game::all()->count()}} Total Played Games</h1>
                        <p>As if one person played {{App\Models\Game::getTotalDuration()}} hours uninterruptedly.</p>
                    </div>
                    <div class="w-25 m-auto py-4 d-flex flex-column justify-content-center align-items-center" style="max-width: 150px">
                        @include('partial.mascot', ["id" => "mascot"])
                    </div>
                </div>
            </div>
            <div class="carousel-item h-100">
                <div class="container my-4 d-flex flex-column h-100 justify-content-around">
                    <div class="d-flex flex-row justify-content-center">
                        <h1>{{App\Models\User::all()->count()}} Total Playing Users</h1>
                    </div>
                    <div>
                        <div
                            class="p-4 mx-6 mt-3 mb-0 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
                            <div
                                class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
                                <?php
                                $users = App\Models\User::getStandings()->limit(3)->get();
                                ?>
                                <div class="user-profile-img d-none d-md-block"
                                     @if( Storage::exists("public/avatars/" . sha1($users[0]->username)) )
                                         style="background-image: url({{ Storage::url("public/avatars/" . sha1($users[0]->username)) }})"
                                    @endif
                                >
                                </div>
                                <h3><a href="/profile/{{ $users[0]->username }}">{{ $users[0]->username }}</a></h3>
                            </div>
                            <div
                                class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
                                <h2>{{ $users[0]->points }} <i class="fa-duotone fa-trophy"
                                                               style="--fa-primary-color: #f8e45c; --fa-secondary-color: #f8e45c;"></i>
                                </h2>
                            </div>
                        </div>
                        <div class="flex-column flex-md-row mx-6 mt-1 mb-3 d-none d-md-flex">
                            <div class="p-4 mx-6 mb-3 d-flex justify-content-evenly flex-column bg flex-md-row align-items-center w-100 w-md-50">
                                <div class="user-profile-img user-profile-img-small mx-3"
                                     @if( Storage::exists("public/avatars/" . sha1($users[1]->username)) )
                                         style="background-image: url({{ Storage::url("public/avatars/" . sha1($users[2]->username)) }})"
                                    @endif
                                ></div>
                                <div class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
                                    <h3><a href="/profile/{{ $users[1]->username }}">{{ $users[1]->username }}</a></h3>
                                </div>
                                <div
                                    class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column align-items-center">
                                    <h2>{{ $users[1]->points }}</h2>
                                    <h2><i class="fa-duotone fa-trophy"
                                           style="--fa-primary-color: #77767b; --fa-secondary-color: #77767b;"></i></h2>
                                </div>
                            </div>
                            <div class="p-4 mx-6 mb-3 d-flex justify-content-evenly flex-column bg flex-md-row align-items-center w-100 w-md-50">
                                <div class="user-profile-img user-profile-img-small mx-3"
                                     @if( Storage::exists("public/avatars/" . sha1($users[2]->username)) )
                                         style="background-image: url({{ Storage::url("public/avatars/" . sha1($users[2]->username)) }})"
                                    @endif
                                ></div>
                                <div class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
                                    <h3><a href="/profile/{{ $users[2]->username }}">{{ $users[2]->username }}</a></h3>
                                </div>
                                <div
                                    class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column align-items-center">
                                    <h2>{{ $users[2]->points }}</h2>
                                    <h2><i class="fa-duotone fa-trophy"
                                       style="--fa-primary-color: #b5835a; --fa-secondary-color: #b5835a;"></i></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item h-100">
                    <div class="container my-4 d-flex flex-column flex-md-row h-100 justify-content-around">
                        @auth()
                            <div class="d-flex flex-column justify-content-center">
                                <h1>Still Here?
                                    @if($gameController::isGameRunning())
                                        Resume the
                                    @else
                                        Start a new
                                    @endif game!</h1>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                @if(!Request::is('game') && !Request::is('game/new') && !(!is_null(auth()->user()) && !auth()->user()->active))
                                    <a class="btn btn-primary btn-md d-flex text-nowrap py-3 px-2 mx-3 d-lg-block"
                                       @auth
                                           @if($gameController::isGameRunning())
                                               href="/game"
                                       @else
                                           data-bs-toggle="modal" data-bs-target="#newgame-dialog"
                                       @endif
                                       @else
                                           href="/login"
                                        @endauth
                                    >
                                        @if($gameController::isGameRunning())
                                            Resume Game
                                        @else
                                            New Game
                                        @endif
                                    </a>
                                @endif
                            </div>
                        @endauth
                        @guest()
                            <div class="d-flex flex-column justify-content-center">
                                <h1>Join NOW!</h1>
                                <p>Be the {{App\Models\User::all()->count() + 1}} <sup>{{ordinal(App\Models\User::all()->count() + 1)}}</sup> user playing with us! </p>
                            </div>
                            <div class="d-flex flex-column justify-content-center"><a href="/register" class="btn btn-primary btn-lg p-4">Join Now</a></div>
                        @endguest
                    </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="bg d-flex flex-column flex-md-row align-content-center justify-content-center align-items-center py-1 py-5 my-4">
        <div class="w-75 w-md-25 d-flex flex-column align-items-center">
            <i style="font-size: 80pt" class="fa-solid fa-heart"></i>
            <h5 class="my-4 w-50">Developed with love by a student. That's me :)</h5>
        </div>
        <div class="w-75 w-md-25 d-flex flex-column align-items-center">
            <i style="font-size: 80pt" class="fa-duotone fa-gears"></i>
            <h5 class="my-4 w-50">Highly performant algorithm. Fast response without having to check the whole board</h5>
        </div>
        <div class="w-75 w-md-25 d-flex flex-column align-items-center">
            <i style="font-size: 80pt" class="fa-duotone fa-gamepad"></i>
            <h5 class="my-4 w-50">Useful for wasting time. Play with your colleagues instead of working!</h5>
        </div>
    </div>

    <div class="container py-4 my-4">
        <h3>Algorithm description</h3>
        <ol>
            <li>
                Generate one master seed randomly. This seed will be used to generate the board and the solution.
            </li>
            <li>
                Use a special function f(x, y) such as, given the cell coordinates, returns a number different for all other cells.
            </li>
            <li>
                Generate each cell seed using the master seed and the value of f for that cell.
            </li>
            <li>
                Generate the first random number for each cell of the board using the cell seed.
            </li>
            <li>
                Order the resulting values in descending order and set the limit parameter as the n<sup>th</sup> value, where n is the number of mines.
            </li>
        </ol>
        <h3>Utilization</h3>
        <div>
            Each game is represented by the master seed and the limit parameter.
            The cell is a mine if <i>next_rand(master_seed + f(x, y)) >= limit</i>.
        </div>
    </div>

    @vite('resources/js/404Behavior.ts')

@endsection
