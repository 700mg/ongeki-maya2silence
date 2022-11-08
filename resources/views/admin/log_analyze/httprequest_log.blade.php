@extends('adminlte::page')

@section('title', 'ログ:HTTPリクエスト')

@section('content_header')
    <h1>ログ:HTTPリクエスト</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin/log_analyze.css" />
@stop

@section('js')
@stop

@section('content')
    <div class="section">
        <p class="text-right m-0"> 合計: {{ $logs->total() }}件 </p>
        {{ $logs->links('admin.layouts.simple_pagenate') }}
        <table class="w-100">
            <thead>
                <tr>
                    <th class="">日時</th>
                    <th class="">アクセス先</th>
                    <th class="">パラメータ</th>
                    <th class="">user_id</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->to }}</td>
                        <td>{{ empty($log->param) ? '-' : $log->param }}</td>
                        <td>{{ empty($log->user_id) ? '-' : $log->user_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $logs->links('admin.layouts.simple_pagenate') }}
    </div>
@stop
