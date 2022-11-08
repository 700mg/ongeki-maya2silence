@extends('adminlte::page')

@section('title', '楽曲一覧 - ongeki.maya2silence.com')

@section('content_header')
    <h1>楽曲一覧</h1>
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
                    <p class="m-0">表示先</p>
                    <div class="form-group">
                        @foreach ($object_to as $o)
                            <label class="checkbox_btn" aria-pressed="true">
                                <input type="checkbox" name="object[]" value="{{ $o->id }}">{{ $o->name_jp }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="mt-2">
                    <p class="m-0">作成者</p>
                    <div class="form-group">
                        @foreach ($user as $u)
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
    {{--
    <p class="text-right m-0">
        @if (!$searching)
            現在登録済楽曲数: {{ $songs->total() }}
        @else
            検索結果: {{ $songs->total() }}曲
        @endif

    </p>
    @if ($searching && $songs->total() > 100)
        <div class="alert alert-warning" role="alert">
            検索結果が多いため、ID降順で上位100曲までを表示しています。<br />
            目的の楽曲が見つからない場合、条件を追加し更に絞り込んでください。
        </div>
    @else
         $songs->links('admin.layouts.simple_pagenate')
    @endif
    --}}
    <table class="w-100">
        <thead>
            <tr>
                <th class="col_date">日時</th>
                <th>見出し</th>
                <th class="col_object">表示先</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($news as $n)
                <tr>
                    <td>{{ date('Y/m/d', strtotime($n->created_at)) }}</td>
                    <td><a href="{{ route('admin.news.detail', $n->id) }}">{{ $n->header }}</a></td>
                    <td>{{ $n->getObject->name_jp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $news->links('admin.layouts.simple_pagenate') }}
@stop
