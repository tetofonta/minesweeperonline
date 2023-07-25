@extends('layouts.main')

@section('title')
    Profile
@endsection

@section('css')
    @vite("resources/css/logo.sass")
@endsection

@section('scripts')
    @vite("resources/js/external/chart.min.js")

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('myChart');

            @if(isset($points))
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(Array({{count($points)}}).fill(0)) || [],
                    datasets: [{
                        label: "{{$user->username}}'s points",
                        data: [{{implode(",", $points)}}],
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
            @endif

        })
    </script>
@endsection

@section('body')
    <div class="container my-4">

        @if(isset($error_msg) || isset($info_msg))
            <div
                class="p-4 mx-6 my-5 alert @isset($error_msg) alert-danger @endisset @isset($info_msg) alert-success @endisset"
                role="alert">
                @isset($error_msg)
                    {{ $error_msg }}
                @endisset
                @isset($info_msg)
                    {{ $info_msg }}
                @endisset
            </div>
        @endif

        @if(!$user->active)
            <div
                class="p-4 mx-6 my-5 alert alert-danger" role="alert">
                Your account has been blocked by an admin. This means you no longer appear in the standings and you
                cannot play any new games.
                Your game history is being analyzed by our staff.
                If you have questions, please contact <a href="mailto:support@minesweeperonline.net">support@minesweeperonline.net</a>
            </div>
        @endif

        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
            <div class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
                <div
                    @if( Storage::exists("public/avatars/" . sha1($user->username)) && $user->active )
                        class="user-profile-img"
                    style="background-image: url({{ Storage::url("public/avatars/" . sha1($user->username)) }})"
                    @elseif (!$user->active)
                        class="user-profile-img user-profile-blocked"
                    @else()
                        class="user-profile-img"
                    @endif()
                >
                    @if(!is_null(auth()->user()) && $user->username == auth()->user()->username && $user->active)
                        <button class="image-edit d-flex align-items-center justify-content-center"
                                data-bs-toggle="modal" data-bs-target="#profileimgModal">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 300%"></i>
                        </button>
                    @endif
                </div>
                <h1>{{ $user->username }}</h1>
            </div>
            @if(!is_null(auth()->user()) && $user->username == auth()->user()->username)
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal"><i
                            class="fa-solid fa-hammer"></i> Edit account
                    </button>
                </div>
            @endif
        </div>
        <div class="p-4 mx-6 my-3 mb-4 bg">
            <h3>User Info</h3>
            <ul>
                @if(!is_null(auth()->user()) && $user->username == auth()->user()->username)
                    <li>Email: {{ auth()->user()->id }}</li>
                @endif

                <li>Last Login: {{ is_null($user->last_login) ? "Never" : $user->last_login }}</li>
                <li>Player since: {{ $user->created_at }}</li>
                @if($user->active)
                    <li>Points: {{ $user->getPoints() }}</li>
                    <li>Current Position: #{{ $user->getStandingPosition() }}</li>
                @endif
            </ul>
        </div>
        @if($user->active)
            <div class="p-4 mx-6 my-3 mb-4 bg">
                <canvas id="myChart"></canvas>
            </div>
            <div class="p-4 mx-6 my-3 mb-4 bg">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Bombs</th>
                        <th scope="col">Date</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Result</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->games as $game)
                        @if($game->status != 'running')
                            <tr>
                                <td>@if($game->ranked)
                                        <i class="fa-duotone fa-ranking-star"></i>
                                    @endif</td>
                                <td>{{ $game->bombs }}</td>
                                <td>{{ $game->created_at }}</td>
                                <td>{{ date_diff($game->finished_at, $game->created_at)->format("%hh %im %ss") }}</td>
                                <td>{{ $game->status }}</td>

                            </tr>
                        @endif()
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if(!is_null(auth()->user()) && $user->username == auth()->user()->username)
            <div class="p-4 mx-6 my-3 d-flex justify-content-between bg danger-border flex-column flex-md-row">
                <h3>DANGER ZONE</h3>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                        class="fa-solid fa-trash"></i> Delete Account
                </button>
            </div>
        @endif
    </div>
    @if(!is_null(auth()->user()) && $user->username == auth()->user()->username)
        @include("html.profile.modal.profileadmin", ["id" => "adminModal"])
        @include("html.profile.modal.profiledelete", ["id" => "deleteModal"])
        @include("html.profile.modal.profileimage", ["id" => "profileimgModal"])
    @endif
@endsection
