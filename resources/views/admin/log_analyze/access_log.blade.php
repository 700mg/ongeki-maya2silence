@extends('adminlte::page')

@section('title', 'ログ:アクセスログ')

@section('content_header')
    <h1>ログ:アクセスログ</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin/log_analyze.css" />
@stop

@section('js')
@stop

@section('content')
    <p class="text-right m-0"> 合計: {{ $logs->total() }}件 </p>
    {{ $logs->links('admin.layouts.simple_pagenate') }}
    <dl class="">
        <dt class="row mb-1">
            <div class="col-1">ID</div>
            <div class="col-3">アクセス先</div>
            <div class="col-3">パラメータ</div>
            <div class="col-2">user</div>
            <div class="col-3">時刻</div>
        </dt>
        @foreach ($logs as $log)
            <dd class="row align-items-center">
                <div class="col-1">{{ $log->id }}</div>
                <div class="col-3">{{ $log->to }}</div>
                <div class="col-3">{{ $log->param }}</div>
                <div class="col-2">{{ $log->user_id }}</div>
                <div class="col-3">{{ $log->created_at }}</div>
            </dd>
        @endforeach
    </dl>
    {{ $logs->links('admin.layouts.simple_pagenate') }}
@stop
