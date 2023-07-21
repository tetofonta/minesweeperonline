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

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(Array({{count($points)}}).fill(0)),
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

        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
            <div class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
                <div class="user-profile-img"
                     @if( Storage::exists("public/avatars/" . sha1($user->username)) )
                         style="background-image: url({{ Storage::url("public/avatars/" . sha1($user->username)) }})"
                    @endif
                >
                    @if($user->username == auth()->user()->username)
                        <button class="image-edit d-flex align-items-center justify-content-center"
                                data-bs-toggle="modal" data-bs-target="#profileimgModal">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 300%"></i>
                        </button>
                    @endif
                </div>
                <h1>{{ $user->username }}</h1>
            </div>
            @if($user->username == auth()->user()->username)
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
                @if($user->username == auth()->user()->username)
                    <li>Email: {{ auth()->user()->id }}</li>
                @endif

                <li>Last Login: {{ auth()->user()->last_login }}</li>
                <li>Player since: {{ auth()->user()->created_at }}</li>
                <li>Points: {{ auth()->user()->getPoints() }}</li>
                <li>Current Position: #{{ auth()->user()->getStandingPosition() }}</li>
            </ul>
        </div>
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
                    <tr>
                        <td>@if($game->ranked)<i class="fa-duotone fa-ranking-star"></i>@endif</td>
                        <td>{{ $game->bombs }}</td>
                        <td>{{ $game->created_at }}</td>
                        <td>{{ date_diff($game->finished_at, $game->created_at)->format("%hh %im %ss") }}</td>
                        <td>{{ $game->status }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($user->username == auth()->user()->username)
            <div class="p-4 mx-6 my-3 d-flex justify-content-between bg danger-border flex-column flex-md-row">
                <h3>DANGER ZONE</h3>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                        class="fa-solid fa-trash"></i> Delete Account
                </button>
            </div>
        @endif
    </div>
    @if($user->username == auth()->user()->username)
        @include("html.profile.modal.profileadmin", ["id" => "adminModal"])
        @include("html.profile.modal.profiledelete", ["id" => "deleteModal"])
        @include("html.profile.modal.profileimage", ["id" => "profileimgModal"])
    @endif
@endsection
