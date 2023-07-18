@inject('gameController', 'App\Http\Controllers\GameController')

<nav class="navbar navbar-expand-lg bg">
    <div class="container">
        <a class="logo-navbar navbar-brand" href="/"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between align-items-center py-4" id="navbar-menu">
            <ul class="navbar-nav mr-auto">
                <li class="
                    nav-item
                    dropdown
                    @if(Request::is('standings'))
                        active
                    @endif
                ">
                    <a class="nav-link dropdown-toggle" href="#" id="classifiche-dropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Standings
                    </a>
                    <div class="dropdown-menu" aria-labelledby="classifiche-dropdown" id="standings-dropdown">
                        <a class="dropdown-item" href="/standings/all?page=0&page_size=10">All times</a>
                        <a class="dropdown-item" href="/standings/month?page=0&page_size=10">This Month</a>
                        <a class="dropdown-item" href="/standings/day?page=0&page_size=10">Today</a>
                    </div>
                </li>
                <li class="
                    nav-item
                    @if(Request::is('info'))
                        active
                    @endif
                ">
                    <a class="nav-link" href="#">Info</a>
                </li>
            </ul>

            <div class="input-group d-flex justify-content-center mx-lg-5 mx-sm-1">
{{--                <input type="search" id="search-bar" placeholder="Search" aria-label="Search" aria-describedby="search-addon" class="form-control" />--}}
{{--                <button type="button" class="btn btn-primary">--}}
{{--                    <i class="fas fa-search"></i>--}}
{{--                </button>--}}
            </div>

            @if(!Request::is('game') && !Request::is('game/new'))
                <a class="btn btn-primary btn-md d-flex text-nowrap py-3 px-2 mx-3 d-none d-lg-block"
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

            <ul class="navbar-nav">
                @if(!Request::is('game') && !Request::is('game/new'))
                    <li class="d-block d-lg-none nav-item">
                    <a class="nav-link"
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
                </li>
                @endif
                @auth
                    <li class="
                        nav-item
                        dropdown
                        @if(Request::is('profile') || Request::is('chpsw') || Request::is('chimg') || Request::is('profile.get'))
                            active
                        @endif
                    ">
                        <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->username }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="user-dropdown">
                            <a class="dropdown-item" href="/profile">Profile</a>
                            <a class="dropdown-item" href="/logout">Logout</a>
                        </div>
                    </li>
                @endauth
                @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/login" id="Login" role="button">
                                Login
                            </a>
                        </li>
                @endguest
                <li class="nav-item d-flex flex-row align-items-center">
                    <a class="nav-link" href="javascript:void(0)" id="theme-toggler" role="button">
                        <span class="theme-icon" style="display: none" id="theme-icon-light"><i class="fa-solid fa-brightness fa-lg"></i><span class="d-sm-block d-md-none">Light Theme</span></span>
                        <span class="theme-icon" style="display: none" id="theme-icon-dark"><i class="fa-solid fa-moon-stars fa-lg"></i><span class="d-sm-block d-md-none">Dark Theme</span></span>
                        <span class="theme-icon" style="display: none" id="theme-icon-auto"><i class="fa-solid fa-moon-over-sun fa-lg"></i><span class="d-sm-block d-md-none">Auto Theme</span></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include("html.home.modal.newgame", ["id" => "newgame-dialog"])
