@extends('adminlte::page')

@section('title', '楽曲一覧 - ongeki.maya2silence.com')

@section('content_header')
    <h1>楽曲一覧</h1>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/admin/song_list.css" />
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
            <form method="POST" action="{{ route('admin.songs.search') }}">
                @csrf
                <div class="mt-3">
                    <p class="m-0">キーワード</p>
                    <div class="d-flex">
                        <input class="form-control" type="search" name="keywords" placeholder="search for keywords" value="{{ !empty($selected['keyword']) ? $selected['keyword'] : '' }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="m-0">バージョン</p>
                    <div class="form-group">
                        @foreach ($versions as $key => $version)
                            @if (!empty($selected['version']) && in_array($version->id, $selected['version']))
                                <label class="checkbox_btn checked" aria-pressed="true">
                                    <input type="checkbox" name="version[]" value="{{ $version->id }}" checked>{{ $version->version }}
                                </label>
                            @else
                                <label class="checkbox_btn" aria-pressed="true">
                                    <input type="checkbox" name="version[]" value="{{ $version->id }}">{{ $version->version }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="mt-2">
                    <p class="m-0">カテゴリ</p>
                    <div class="form-group">
                        @foreach ($categories as $key => $category)
                            @if (!empty($selected['category']) && in_array($category->id, $selected['category']))
                                <label class="checkbox_btn checked" aria-pressed="true">
                                    <input type="checkbox" name="category[]" value="{{ $category->id }}" checked>{{ $category->category }}
                                </label>
                            @else
                                <label class="checkbox_btn" aria-pressed="true">
                                    <input type="checkbox" name="category[]" value="{{ $category->id }}">{{ $category->category }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="mt-2">
                    <p class="m-0">ライバル</p>
                    <div class="form-group">
                        @php
                            // ちょっと強引に実装
                            $elements = ['na' => '未登録', 'aqua' => 'AQUA', 'leaf' => 'LEAF', 'fire' => 'FIRE', 'all' => 'ALL'];
                        @endphp
                        @foreach ($elements as $key => $element)
                            @if (!empty($selected['element']) && in_array($key, $selected['element']))
                                <label class="checkbox_btn checked" aria-pressed="true">
                                    <input type="checkbox" name="element[]" value="{{ $key }}" checked>{{ $element }}
                                </label>
                            @else
                                <label class="checkbox_btn" aria-pressed="true">
                                    <input type="checkbox" name="element[]" value="{{ $key }}">{{ $element }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            </form>
        </section>
    </div>
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
        {{ $songs->links('admin.layouts.simple_pagenate') }}
    @endif
    <table class="w-100">
        <thead>
            <tr>
                <th colspan="2">タイトル</th>
                <th class="text-center">敵</th>
                <th class="text-center">M</th>
                <th class="text-center">E</th>
                <th class="text-center">L</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($songs as $song)
                <tr>
                    <td class="text-center"><img class="m-1" width="50" src="{{ asset("storage/songs/jacket/$song->id.jpg") }}"></td>
                    <td class="text-left"><a href="{{ route('admin.songs.detail', $song->id) }}" class="{{ $song->deleted == '1' ? 'text-red' : '' }}">
                            {{ $song->title }}
                        </a></td>
                    <td class="text-center">{{ $song->enemy_level && $song->enemy_element ? '○' : '-' }}</td>
                    <td class="text-center">{{ $status[$loop->index]['master'] }}</td>
                    <td class="text-center">{{ $status[$loop->index]['expert'] }}</td>
                    <td class="text-center">{{ $status[$loop->index]['lunatic'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (!$searching)
        {{ $songs->links('admin.layouts.simple_pagenate') }}
    @endif
    <div class="mt-2">
        <dt>M/E/L リストの見方</dt>
        <dd class="">
            <span class="d-block"><b class="mr-2">－</b>: 未登録</span>
            <span class="d-block"><b class="mr-2">▲</b>: 定数のみ登録</span>
            <span class="d-block"><b class="mr-2">▼</b>: ノーツ･ベルのみ登録</span>
            <span class="d-block"><b class="mr-2">○</b>: 全て登録</span>
        </dd>
    </div>
@stop
