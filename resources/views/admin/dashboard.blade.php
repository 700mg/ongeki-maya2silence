@extends('adminlte::page')

@section('title', '管理画面ダッシュボード(仮)')

@section('content')
    <div class="card card-info m-2">
        <div class="card-header">
            <h3 class="card-title">アクセスアナライザー</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="">
                <h3>{{ date("Y/m/d") }}</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">アクセス数</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- TABLE ACCESS --}}
                        @foreach ($table_daily as $key => $table)
                            <tr scope="row">
                                <th><a href="{{ $key }}">{{ str_replace(Request::getUriForPath(''), '', $key) }}</a></th>
                                <td>{{ $table }}</td>
                            </tr>
                        @endforeach
                        {{-- CALCULATOR ACCESS --}}
                        @foreach ($calc_daily as $key => $calc)
                            <tr scope="row">
                                <th><a href="{{ $key }}">{{ str_replace(Request::getUriForPath(''), '', $key) }}</a></th>
                                <td>{{ $calc }}</td>
                            </tr>
                        @endforeach
                        {{-- NEWS ACCESS --}}
                        @foreach ($news_daily as $key => $news)
                            <tr scope="row">
                                <th><a href="{{ $key }}">{{ str_replace(Request::getUriForPath(''), '', $key) }}</a></th>
                                <td>{{ $news }}</td>
                            </tr>
                        @endforeach
                        {{-- DATABASE ACCESS --}}
                        @foreach ($db_daily as $key => $db)
                            <tr scope="row">
                                <th><a href="{{ $key }}">{{ str_replace(Request::getUriForPath(''), '', $key) }}</a></th>
                                <td>{{ $db }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- 動作が非常に重いから一度無効化する --}}
    {{--
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">定数表 月間アクセス数</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <span>累計アクセス:</span>
                <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 335px;" width="418" height="312" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">計算機 月間アクセス数</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <span>累計アクセス:</span>
                <canvas id="myChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 335px;" width="418" height="312" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>
    --}}
@stop

@section('css')

@stop

@section('js')
    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        const ctx = document.getElementById("myChart").getContext("2d");
        const data = {{ Js::from($table_weekly) }};
        const myChart = new Chart(ctx, data);
        const ctx2 = document.getElementById("myChart2").getContext("2d");
        const data2 = {{ Js::from($calc_weekly) }};
        const myChart2 = new Chart(ctx2, data2);
    </script>
    --}}
@stop
