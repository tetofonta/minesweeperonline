@extends('layouts.main')

@section('title')
    Profile
@endsection

@section('css')
    @vite("resources/css/logo.sass")
@endsection

@section('body')
<div class="container my-4">

    @if(isset($error_msg) || isset($info_msg))
        <div class="p-4 mx-6 my-5 alert @isset($error_msg) alert-danger @endisset @isset($info_msg) alert-success @endisset" role="alert">
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
                @if( Storage::exists("public/avatars/" . sha1(auth()->user()->username)) )
                    style="background-image: url({{ Storage::url("public/avatars/" . sha1(auth()->user()->username)) }})"
                @endif
            >
                <button class="image-edit d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#profileimgModal">
                    <i class="fa-solid fa-pen-to-square" style="font-size: 300%"></i>
                </button>
            </div>
            <h1>{{ auth()->user()->username }}</h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal"><i class="fa-solid fa-hammer"></i> Edit account</button>
        </div>
    </div>
    <div class="p-4 mx-6 my-3 mb-4 bg">
        <h3>User Info</h3>
        <ul>
            <li>Email: {{ auth()->user()->id }}</li>
            <li>Last Login: {{ auth()->user()->last_login }}</li>
            <li>Player since: {{ auth()->user()->created_at }}</li>
        </ul>
    </div>
    <div class="p-4 mx-6 my-3 d-flex justify-content-between bg danger-border flex-column flex-md-row">
        <h3>DANGER ZONE</h3>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i> Delete Account</button>
    </div>
</div>

@include("html.profile.modal.profileadmin", ["id" => "adminModal"])
@include("html.profile.modal.profiledelete", ["id" => "deleteModal"])
@include("html.profile.modal.profileimage", ["id" => "profileimgModal"])
@endsection
