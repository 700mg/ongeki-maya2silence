@extends('adminlte::page')
@section('title', '管理画面ダッシュボード(仮)')
@inject('aa', 'App\Http\Controllers\Admin\AccessAnalyzeController')

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">今日のアクセス</h3>
        </div>
        <div class="card-body">
            <div class="counter_header">今日の合計アクセス数
                <span class="counter_body">{{ $count['daily'] }}</span>
            </div>
            {{-- 今日1日のアクセス内訳 --}}
            <div id="chart_access_today"></div>
        </div>
    </div>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">今月の合計アクセス</h3>
        </div>
        <div class="card-body">
            <div class="counter_header">今月の合計アクセス数
                <span class="counter_body">{{ $count['monthly'] }}</span>
            </div>
            {{-- 今月のアクセス合計 --}}
            <div id="chart_access_month"></div>
        </div>
    </div>
    <div id="google-line-chart"></div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin/dashboard.min.css" />
    <style>
        .counter_header {
            font-size: .75rem;
            font-weight: bold;
            color: #555;
        }

        .counter_body {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            font-size: 1.25rem;
            margin-left: .25rem;
            font-weight: bold;
            color: #111;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });

        async function drawDailyChart() {
            const gid = "chart_access_today";
            const options = {
                'title': '今日のアクセス内訳',
                'width': document.getElementById("chart_access_today").width,
                "is3D": true,
            };
            const type = "PieChart";
            let rows = await getChartData("daily");
            drawChart(rows, options, gid, type);
        }

        async function drawMonthChart() {
            const gid = "chart_access_month";
            const options = {
                'title': '今月のアクセス詳細',
                'width': document.getElementById("chart_access_today").width,
                "legend": 'none',
                "is3D": true,
            };
            const type = "ColumnChart";

            let rows = await getChartData("month");
            drawChart(rows, options, gid, type);
        }

        function drawChart(rows, options, gid, type) {
            // Create the data table.
            let data = new google.visualization.DataTable();
            data.addColumn('string', "アクセス先");
            data.addColumn('number', "アクセス数");
            data.addRows(rows);

            // Instantiate and draw our chart, passing in some options.
            if (type == "PieChart")
                var chart = new google.visualization.PieChart(document.getElementById(gid));
            else if (type == "ColumnChart")
                var chart = new google.visualization.ColumnChart(document.getElementById(gid));

            chart.draw(data, options);
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawDailyChart);
            google.charts.setOnLoadCallback(drawMonthChart);
        });

        function getChartData(key) {
            return fetch("/admin/access_analyze/get/" + key).then((res) => {
                return res.json();
            });
        }

        var handleErrors = function(response) {
            return (response.ok) ? response : response.json().then(function(err) {
                throw Error(err.message)
            });
        }
    </script>
@stop
