@extends('layouts.main')

@section('body')
    <div class="container my-4">
        @if(count($elements) > 0 && $first == 1 && $use_first_content)
            <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
                @yield('first_content')
            </div>
        @endif

        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column align-items-center">
            <table class="table table-striped w-100">
                @yield('thead')
                <tbody>
                @yield('content')
                </tbody>
            </table>
            <div class="d-flex w-100 align-items-center justify-content-between">
                @if($page == 0)
                    <span></span>
                @else
                    <a
                        href="{{route($route, array_merge($route_info, ['page' => $page - 1, "page_size" => $perpage]))}}"
                        class="btn btn-outline-light">
                        <i class="fa-solid fa-backward"></i>
                    </a>
                @endif
                <span>{{$first}} - {{$last}} / {{$count}}</span>
                @if($last >= $count)
                    <span></span>
                @else
                    <a
                        href="{{route($route, array_merge($route_info, ['page' => $page + 1, "page_size" => $perpage]))}}"
                        class="btn btn-outline-light">
                        <i class="fa-solid fa-forward"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    @yield('body_content')
@endsection
