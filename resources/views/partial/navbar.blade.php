@inject('gameController', 'App\Http\Controllers\GameController')

<nav class="navbar navbar-expand-lg bg p-0">
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
                    @if(Request::is('standings/all') || Request::is('standings/month') || Request::is('standings/day'))
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
                <li class="
                    nav-item
                    dropdown
                    @if(Request::is('/admin/') || Request::is('/admin/user/') || Request::is('/admin/game/') )
                        active
                    @endif
                ">
                    <a class="nav-link dropdown-toggle" href="#" id="admin-dropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <div class="dropdown-menu" aria-labelledby="admin-dropdown">
                        <a class="dropdown-item" href="{{route('admin.user')}}">User Management</a>
                        <a class="dropdown-item" href="{{route('admin.game')}}">Game Management</a>
                    </div>
                </li>
            </ul>

            <div class="input-group d-flex justify-content-center mx-lg-5 mx-sm-1">
                <input type="search" data-bs-toggle="dropdown" id="search-bar" placeholder="Search" aria-label="Search" aria-describedby="search-addon" class="form-control dropdown-toggle" />
                <ul class="dropdown-menu dropdown-menu-left w-100" role="menu" id="search-result">

                </ul>
            </div>

            @if(!Request::is('game') && !Request::is('game/new') && !(!is_null(auth()->user()) && !auth()->user()->active))
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

            <ul class="navbar-nav  mr-auto">
                @if(!Request::is('game') && !Request::is('game/new') && !(!is_null(auth()->user()) && !auth()->user()->active))
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
                            <a class="dropdown-item" href="{{route('profile', ["username" => auth()->user()->username])}}">Profile</a>
                            @if(auth()->user()->admin)
                                <a class="dropdown-item" href="{{route('admin.dashboard')}}">Admin Dashboard</a>
                            @endif
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
                        <span class="theme-icon" style="display: none" id="theme-icon-light"><i class="fa-solid fa-brightness fa-lg d-sm-none d-md-block"></i><span class="d-sm-block d-md-none">Change to Dark Theme</span></span>
                        <span class="theme-icon" style="display: none" id="theme-icon-dark"><i class="fa-solid fa-moon-stars fa-lg d-sm-none d-md-block"></i><span class="d-sm-block d-md-none">Change to Auto Theme</span></span>
                        <span class="theme-icon" style="display: none" id="theme-icon-auto"><i class="fa-solid fa-moon-over-sun fa-lg d-sm-none d-md-block"></i><span class="d-sm-block d-md-none">Change to Light Theme</span></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('search-bar').addEventListener('keydown', (e) => {
            fetch('/api/profile/search?q=' + encodeURIComponent(e.target.value))
                .then(res => res.json())
                .then(res => {
                    document.getElementById('search-result').innerHTML = res.map(e => `<li onclick="window.location.href = '/profile/${encodeURIComponent(e.username)}'" class='search-result'><b>${e.username}</b> <span style='float: right'>${e.points}</span></li>`).join('\n')
                })
        })
    })
</script>

@include("html.home.modal.newgame", ["id" => "newgame-dialog"])
