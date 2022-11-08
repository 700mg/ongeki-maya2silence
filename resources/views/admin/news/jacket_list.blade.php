@extends('adminlte::page')

@section('title', 'ジャケット一覧 - ongeki.maya2silence.com')

@section('content_header')
    <h1>ジャケット一覧</h1>
@stop

@section('content')
        <div class="">
            @foreach ($songs as $song)
                <div class="d-inline-flex flex-column flex-wrap m-1 mb-3">
                    <img class="jacket rounded" src="{{ asset("storage/songs/jacket/$song->id.jpg") }}">
                    <span class="title">ID:{{  $song->id }} {{ $song->title }}</span>
                </div>
            @endforeach
        </div>
        {{ $songs->links('admin.layouts.simple_pagenate') }}
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/admin/jacket.css" />
@stop

@section('js')

@stop
