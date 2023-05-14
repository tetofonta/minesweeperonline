@extends('layouts.nonav')

@section('css')
    @vite("resources/css/navbar.sass")
@endsection

@section('navbar')
    @include('partial.navbar')
@endsection
