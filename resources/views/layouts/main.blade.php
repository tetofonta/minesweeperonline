@extends('layouts.nonav')

@section('css')
    @vite("resources/css/navbar.sass")
    @vite("resources/css/logo.sass")
@endsection

@section('navbar')
    @include('partial.navbar')
@endsection

@section('footer')
    @include('partial.footer')
@endsection
