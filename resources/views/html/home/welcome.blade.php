@extends('layouts.main')

@section('title')
    HOME Page
@endsection

@section('body')

    @if(!is_null(auth()->user()) && !auth()->user()->active)
        <div class="container my-4">
            <div
                class="p-4 mx-6 my-5 alert alert-danger" role="alert">
                Your account has been blocked by an admin. This means you no longer appear in the standings and you
                cannot play any new games.
                Your game history is being analyzed by our staff.
                If you have questions, please contact <a href="mailto:support@minesweeperonline.net">support@minesweeperonline.net</a>
            </div>
        </div>
    @endif
@endsection
