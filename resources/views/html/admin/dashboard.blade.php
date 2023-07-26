@extends('layouts.main')

@section('title')
    Admin Dashboard
@endsection

@section('css')
    @vite("resources/css/logo.sass")
@endsection

@section('scripts')
    @vite("resources/js/external/chart.min.js")

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const upie = document.getElementById('user_pie');
            const gpie = document.getElementById('games_pie');
            const hist = document.getElementById('user_hist');
            const ghist = document.getElementById('games_hist');

            new Chart(upie, {
                type: 'doughnut',
                data: {
                    labels: ['active', 'inactive', 'blocked'],
                    datasets: [{
                        data: [{{$elements['active']}}, {{$elements['inactive']}}, {{$elements['blocked']}}],
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

            new Chart(hist, {
                type: 'line',
                data: {
                    labels: "{{implode(',', $user_history_ticks)}}".split(','),
                    datasets: [{
                        data: [{{implode(',', $user_history_data)}}],
                        label: 'User Count'
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

            new Chart(gpie, {
                type: 'doughnut',
                data: {
                    labels: "{{implode(',', $games_status_ticks)}}".split(','),
                    datasets: [{
                        data: [{{implode(',', $games_status_data)}}],
                    }]
                }
            });

            new Chart(ghist, {
                type: 'line',
                data: {
                    labels: "{{implode(',', $games_history_ticks)}}".split(','),
                    datasets: [{
                        data: [{{implode(',', $games_history_data)}}],
                        label: 'Game Count'
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
        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
            <div class="w-100 w-md-25">
                <canvas id="user_pie"></canvas>
            </div>
            <div class="w-100 w-md-75">
                <canvas id="user_hist"></canvas>
            </div>
        </div>
        <div class="p-4 mx-6 my-3 d-flex justify-content-between bg flex-column flex-md-row align-items-center">
            <div class="w-100 w-md-25">
                <canvas id="games_pie"></canvas>
            </div>
            <div class="w-100 w-md-75">
                <canvas id="games_hist"></canvas>
            </div>
        </div>
    </div>

@endsection
