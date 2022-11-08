@extends('adminlte::page')

@section('title', 'ブックマークレット一覧')

@section('content_header')
    <h1>ブックマークレット一覧</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/admin/news_list.css" />
@stop

@section('js')
    <script src="/script/admin/song_list.js"></script>
@stop

@section('content')
    @if (session('success_message'))
        <div class="alert alert-success" role="alert">{{ session('success_message') }}</div>
    @endif

    <a class="collapsed btn btn-outline-secondary d-inline-flex align-items-center mb-2" data-bs-toggle="collapse" href="#search" aria-controls="#search" aria-expanded="false">
        絞込み検索<span class="collapse_icon"></span>
    </a>
    <div class="collapse" id="search">
        <section class="search w-100 p-2 rounded mb-2">
            <form method="GET" action="{{ route('admin.songs.search') }}">
                @csrf
                <div class="mt-3">
                </div>
                <div class="mt-2">
                    <p class="m-0">作成者</p>
                    <div class="form-group">
                        @foreach ($users as $u)
                            <label class="checkbox_btn" aria-pressed="true">
                                <input type="checkbox" name="user[]" value="{{ $u->id }}">{{ $u->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary" style="font-size:75%" type="submit"><i class="fas fa-search"></i>&nbsp;検索</button>
                </div>
            </form>
        </section>
    </div>

    <table class="w-100">
        <thead>
            <tr>
                <th>見出し</th>
                <th class="col_date">日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookmarklets as $bookmarklet)
                <tr>
                    <td><a href="{{ route('admin.bookmarklet.detail', $bookmarklet->id) }}">{{ $bookmarklet->header }}</a></td>
                    <td>{{ date('Y/m/d', strtotime($bookmarklet->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bookmarklets->links('admin.layouts.simple_pagenate') }}
@stop
