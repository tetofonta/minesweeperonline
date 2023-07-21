@extends('layouts.main')

@section('title')
    GAME
@endsection

@section('body')
    <div class="container my-4">
        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
            <?php
            $page = isset($_GET['page']) ? intval($_GET['page']) : 0;
            $perpage = isset($_GET['page_size']) ? intval($_GET['page_size']) : 10;
            $first = $page * $perpage + 1;
            $last = $first + count($users) - 1;
            $i = $first;
            ?>

            @if(count($users) > 0 && $i === 1)
                <div class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
                    <div class="user-profile-img"
                         @if( Storage::exists("public/avatars/" . sha1($users[0]->username)) )
                             style="background-image: url({{ Storage::url("public/avatars/" . sha1($users[0]->username)) }})"
                        @endif
                    >
                    </div>
                    <h1><a href="/profile/{{ $users[0]->username }}">{{ $users[0]->username }}</a></h1>
                </div>
                <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
                    <h1>{{ $users[0]->points }} <i class="fa-duotone fa-trophy"
                                                   style="--fa-primary-color: #f8e45c; --fa-secondary-color: #f8e45c;"></i>
                    </h1>
                </div>
            @endif
        </div>
        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column align-items-center">
            <table class="table table-striped w-100">
                <tbody>

                @foreach($users as $user)
                    @if($i > 1)
                        <tr>
                            <td><b>#{{$i++}}</b></td>
                            <td><a href="/profile/{{ $user->username }}">{{$user->username}}</a></td>
                            <td>
                                {{$user->points}}
                                @if($i === 3)
                                    <i class="fa-duotone fa-trophy"
                                       style="--fa-primary-color: #77767b; --fa-secondary-color: #77767b;"></i>
                                @elseif($i === 4)
                                    <i class="fa-duotone fa-trophy"
                                       style="--fa-primary-color: #b5835a; --fa-secondary-color: #b5835a;"></i>
                                @endif
                            </td>
                        </tr>
                    @else
                            <?php $i++ ?>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="d-flex w-100 align-items-center justify-content-between">
                @if($page == 0) <span></span> @else
                <a
                        href="{{route('standings', ['all', 'page' => $page - 1, "page_size" => $perpage])}}"
                        class="btn btn-outline-light">
                    <i class="fa-solid fa-backward"></i>
                </a>
                @endif
                <span>{{$first}} - {{$last}} / {{$count}}</span>
                @if($last >= $count) <span></span> @else
                <a
                        href="{{route('standings', ['all', 'page' => $page + 1, "page_size" => $perpage])}}"
                        class="btn btn-outline-light">
                    <i class="fa-solid fa-forward"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
@endsection
