@extends('layouts.paginated', ["use_first_content" => false, "route" => "admin.game", "route_info" => []])

@section('title')
    Game Management
@endsection

@section('css')
    @vite("resources/css/logo.sass")
@endsection

@section('scripts')
    <script>
        function openDeleteModal(id) {
            $('#deletegameid').val(id)
            $('#deleteidtitle').text(id)
            $('#deletemodal').modal('show')
        }
    </script>
@endsection

@section('thead')
    <thead>
    <tr>
        <th>Id</th>
        <th>Bombs</th>
        <th>Dimensions</th>
        <th>Status</th>
        <th>Started</th>
        <th>Duration</th>
        <th>Ranked</th>
        <th></th>
    </tr>
    </thead>
@endsection

@section('content')
    @foreach($elements as $game)
        <tr>
            <td>{{$game->id}}</td>
            <td>{{$game->bombs}}</td>
            <td>{{$game->width}}x{{$game->height}}</td>
            <td>{{$game->status}}</td>
            <td>{{$game->created_at}}</td>
            <td>{{$game->status != 'running' ?  date_diff($game->finished_at, $game->created_at)->format("%hh %im %ss") : ""}}</td>
            <td>@if($game->ranked)
                    <i class="fa-regular fa-square-check"></i>
                @else()
                    <i class="fa-solid fa-square-xmark"></i>
                @endif</td>
            <td>
                <a href="javascript:void(0)" onclick="openDeleteModal('{{$game->id}}')"
                   class="btn btn-outline"><i class="fa-solid fa-trash" style="color: red;"></i></a>
            </td>
        </tr>
    @endforeach
@endsection

@section('body_content')
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/game/" method="post" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User delete for <span id="deleteidtitle"></span></h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="id" type="hidden" value="" id="deletegameid"/>
                    Are you sure you want to delete this game?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Abort</button>
                    <button type="submit" class="btn btn-secondary">Delete Game</button>
                </div>
            </form>
        </div>
@endsection
