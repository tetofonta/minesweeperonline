@extends('layouts.paginated', ["use_first_content" => false, "route" => "admin.user", "route_info" => []])

@section('title')
    User Management
@endsection

@section('css')
    @vite("resources/css/logo.sass")
@endsection

@section('scripts')
    <script>
        function openEditModal(username, enable, admin) {
            $('#usernameinput').val(username)
            $('#usernametitle').text(username)
            if (enable)
                $('#activeinput').attr('checked', 'checked')
            else
                $('#activeinput').removeAttr('checked')

            if (admin)
                $('#admininput').attr('checked', 'checked')
            else
                $('#admininput').removeAttr('checked')

            if (username === '{{auth()->user()->username}}')
                $('#admininput').attr('disabled', 'disabled')
            else
                $('#admininput').removeAttr('disabled')

            $('#editmodal').modal('show')
        }

        function openDeleteModal(username) {
            $('#deleteusernameinput').val(username)
            $('#deleteusernametitle').text(username)
            $('#deletemodal').modal('show')
        }
    </script>
@endsection

@section('thead')
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>LastLogin</th>
        <th>Enabled</th>
        <th>Admin</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@endsection

@section('content')
    @foreach($elements as $user)
        <tr>
            <td><a href="{{route('profile', [$user->username])}}">{{$user->username}}</a></td>
            <td>{{$user->id}}</td>
            <td>{{$user->last_login}}</td>
            <td>@if($user->active)
                    <i class="fa-regular fa-square-check"></i>
                @else
                    <i class="fa-solid fa-square-xmark"></i>
                @endif</td>
            <td>@if($user->admin)
                    <i class="fa-regular fa-square-check"></i>
                @else
                    <i class="fa-solid fa-square-xmark"></i>
                @endif</td>
            <td><a href="javascript:void(0)"
                   onclick="openEditModal('{{$user->username}}', {{$user->active ? "true" : "false"}}, {{$user->admin ? "true" : "false"}})"
                   class="btn btn-outline"><i class="fa-solid fa-pen-to-square"></i></a></td>
            <td>
                @if($user->username != auth()->user()->username)
                    <a href="javascript:void(0)" onclick="openDeleteModal('{{$user->username}}')"
                       class="btn btn-outline"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
@endsection

@section('body_content')
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/user/" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User edit for <span id="usernametitle"></span></h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="username" type="hidden" value="" id="usernameinput" />
                    <div class="form-control">
                        <label>
                            <input name="active" type="checkbox" id="activeinput"/>
                            Enabled
                        </label>
                    </div>
                    <div class="form-control">
                        <label>
                            <input name="admin" type="checkbox" id="admininput"/>
                            Admin
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit user</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/user/" method="post" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User delete for <span id="deleteusernametitle"></span></h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="username" type="hidden" value="" id="deleteusernameinput" />
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Abort</button>
                    <button type="submit" class="btn btn-secondary">Delete User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
