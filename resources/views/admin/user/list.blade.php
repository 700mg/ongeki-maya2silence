@extends('adminlte::page')

@section('title', 'ユーザー一覧 - ongeki.maya2silence.com')

@section('content_header')
    <h1>ユーザー一覧</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/admin/user_list.css" />
@stop

@section('js')
@stop

@section('content')
    {{ $users->links('admin.layouts.simple_pagenate') }}
    <dl class="">
        <dt class="row mb-1">
            <div class="col-1">ID</div>
            <div class="col-7">名前</div>
            <div class="col-4">最終ログイン</div>
        </dt>
        @foreach ($users as $user)
            <dd class="row align-items-center">
                <div class="col-1">{{ $user->id }}</div>
                <div class="col-7"><a href="{{ route('admin.user.detail', $user->id) }}">{{ $user->name }}</a></div>
                <div class="col-4">{{ $user->updated_at }}</div>
            </dd>
        @endforeach
    </dl>
    {{ $users->links('admin.layouts.simple_pagenate') }}
@stop
