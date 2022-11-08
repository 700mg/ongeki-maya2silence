@extends('adminlte::page')

@section('title', '管理画面ダッシュボード(仮)')

@section('content')
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
                <span>累計アクセス:{{ $table_weekly_total }}</span>
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
                <span>累計アクセス:{{ $calc_weekly_total }}</span>
                <canvas id="myChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 335px;" width="418" height="312" class="chartjs-render-monitor"></canvas>
            </div>
        </div>

    </div>
@stop

@section('css')

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        const ctx = document.getElementById("myChart").getContext("2d");
        const data = {{ Js::from($table_weekly) }};
        const myChart = new Chart(ctx, data);
        const ctx2 = document.getElementById("myChart2").getContext("2d");
        const data2 = {{ Js::from($calc_weekly) }};
        const myChart2 = new Chart(ctx2, data2);
    </script>
@stop
