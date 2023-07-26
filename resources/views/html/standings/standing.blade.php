@extends('layouts.paginated', ["use_first_content" => true, "route" => "standings", "route_info" => [$type]])

@section('title')
    Standings
@endsection

@section('first_content')
    <div class="user-profile-img"
         @if( Storage::exists("public/avatars/" . sha1($elements[0]->username)) )
             style="background-image: url({{ Storage::url("public/avatars/" . sha1($elements[0]->username)) }})"
        @endif
    >
    </div>
    <div
        class="d-flex w-100 w-md-50 align-items-md-end align-items-center flex-column flex-md-row my-3">
        <h1><a href="/profile/{{ $elements[0]->username }}">{{ $elements[0]->username }}</a></h1>
    </div>
    <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-row align-items-center">
        <h1>{{ $elements[0]->points }} <i class="fa-duotone fa-trophy"
                                          style="--fa-primary-color: #f8e45c; --fa-secondary-color: #f8e45c;"></i>
        </h1>
    </div>
@endsection

@section('content')
    <?php $i = $first; ?>
    @foreach($elements as $user)
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
@endsection
