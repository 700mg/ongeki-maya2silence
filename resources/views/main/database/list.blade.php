@extends('main.layouts.template_b')

@section('title')
    <span>{{ config('userconst.main.database') }}</span>
@endsection

@section('content')
    @if ($searching && $songs->total() > 100)
        <div class="alert alert-warning" role="alert">
            検索結果が多いため、上位100曲までを表示しています。<br />
            目的の楽曲が見つからない場合、条件を追加し更に絞り込んでください。
        </div>
    @endif

    <div class="row align-items-end mb-2">
        <div class="col-6 mb-0">
            <a class="collapsed btn btn-outline-secondary d-inline-flex align-items-center" data-bs-toggle="collapse" href="#search" aria-controls="#search" aria-expanded="false">
                絞込み検索<span class="collapse_icon"></span>
            </a>
        </div>
        <div class="col-6 m-0" style="text-align: right">
            <span>{{ !$searching ? '現在登録済曲数' : '検索結果' }}:&nbsp;{{ $songs->total() }}曲</span>
        </div>
    </div>

    <div class="collapse" id="search">
        <section class="search w-100 p-2 rounded mb-2">
            <form method="POST" action="{{ route('database.search') }}">
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
            </form>
        </section>
    </div>

    @if (!$searching)
        {{ $songs->links('admin.layouts.simple_pagenate') }}
    @endif

    <dl class="">
        @foreach ($songs as $song)
            <dd class="pt-1 pb-1 mb-0">
                <a class="row align-items-center" href="{{ route('database.song', $song->id) }}">
                    <div class="col-3"><img class="" width="50" src="{{ asset("storage/songs/jacket/$song->id.jpg") }}"></div>
                    <div class="col-9">{{ $song->title }}</div>
                </a>
            </dd>
        @endforeach
    </dl>
    @if (!$searching)
        {{ $songs->links('admin.layouts.simple_pagenate') }}
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/main/database/song.css" />
@stop

@section('script')
    <script src="/script/main/database/list.js"></script>
@stop

@section('footer')
    <div class="footer text-center mt-3">
        <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/database/)</p>
        <p>不具合･要望等があれば<a href="https://twitter.com/suoineau_ac" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
    </div>
@endsection
