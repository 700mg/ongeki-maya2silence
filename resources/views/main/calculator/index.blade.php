@extends('main.layouts.template_b')

@section('css')
    <link rel="stylesheet" href="/css/main/calculator/calculator.css" />
@endsection

@section('script')
    <script src="/script/main/calculator/calculator.js"></script>
    <script type="text/javascript">
        const SONG_DATA_URL = "{{ route('song.data') }}";
        const SONG_SEARCH_URL = "{{ route('song.search') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
    </script>
@endsection

@section('title')
    <span>{{ config('userconst.main.calculator') }}</span>
@endsection

@section('content')
    {{-- 管理人からのお知らせとか。 --}}
    <div class="alert alert-info">
        <div class="mb-2 text-center" style="border-bottom: #333 solid 1px;">お知らせ</div>
        {{-- ここに最新5件分のお知らせリンク?を表示 --}}
        @foreach ($news as $n)
            <div class="row news_col m-0">
                <span class="col-sm-3 text-sm-end">@date($n->created_at)</span>
                <a class="col-sm-9" href="{{ route('news.view', $n->id) }}" target="_blank" rel="noopener">{{ $n->header }}</a>
            </div>
        @endforeach
    </div>
    {{-- 曲情報とかとか。 --}}
    <div class="song_detail">
        {{-- 難易度切り替え --}}
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">難易度</legend>
            <div class="col-sm-10">
                <div class="text-center">
                    <div class="d-inline-block">
                        <input class="form-check-input d-none" type="radio" name="difficult" id="difficult_basic" value="basic">
                        <label class="form-check-label btn btn-light" style="padding:5px" for="difficult_basic">
                            <span class="style_basic">BAS</span>
                        </label>
                    </div>
                    <div class="d-inline-block">
                        <input class="form-check-input d-none" type="radio" name="difficult" id="difficult_advanced" value="advanced">
                        <label class="form-check-label btn btn-light" style="padding:5px" for="difficult_advanced">
                            <span class="style_advanced">ADV</span>
                        </label>
                    </div>
                    <div class="d-inline-block">
                        <input class="form-check-input d-none" type="radio" name="difficult" id="difficult_expert" value="expert">
                        <label class="form-check-label btn btn-light" style="padding:5px" for="difficult_expert">
                            <span class="style_expert">EXP</span>
                        </label>
                    </div>
                    <div class="d-inline-block">
                        <input class="form-check-input d-none" type="radio" name="difficult" id="difficult_master" value="master">
                        <label class="form-check-label btn btn-light" style="padding:5px" for="difficult_master">
                            <span class="style_master">MAS</span>
                        </label>
                    </div>
                    <div class="d-inline-block">
                        <input class="form-check-input d-none" type="radio" name="difficult" id="difficult_lunatic" value="lunatic">
                        <label class="form-check-label btn btn-light" style="padding:5px" for="difficult_lunatic">
                            <span class="style_lunatic">LUN</span>
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>
        {{-- カテゴリ･曲名とか --}}
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">曲名</legend>
            <div class="col-sm-10">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">曲名</div>
                    </div>
                    <select id="song_title" class="form-control form-select" placeholder="曲名">
                        @foreach ($songs as $song)
                            <option value="{{ $song->id }}" data-category="{{ $song->category }}" data-version="{{ $song->version }}" @if ($loop->first) selected @endif>{{ $song->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">カテゴリー</div>
                    </div>
                    <select id="song_category" class="form-control form-select song_search_select" placeholder="カテゴリ" data-key="category">
                        <option value="all">全て</option>
                        @foreach ($categories as $category)
                            @if ($category->id !== 0)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">バージョン</div>
                    </div>
                    <select id="song_version" class="form-control form-select song_search_select" placeholder="バージョン" data-key="version">
                        <option value="all">全て</option>
                        @foreach ($versions as $version)
                            @if ($version->id !== 0)
                                <option value="{{ $version->id }}">{{ $version->version }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-light fs-75p m-1" data-bs-toggle="modal" data-bs-target="#modal_song_search" aria-expanded="false">キーワードで検索</button>
            </div>
        </fieldset>
        <a class="collapsed mb-2 d-inline-flex align-items-center" onclick="" data-bs-toggle="collapse" href="#songData" aria-controls="#songData" aria-expanded="false">
            詳細設定<span class="collapse_icon"></span>
        </a>
        <div class="collapse" id="songData">
            {{-- ノーツ数 --}}
            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">ノーツ数</legend>
                <div class="col-sm-10">
                    <div class="input-group mb-1">
                        <span class="input-group-text">min:1</span>
                        <input id="notes_value" class="form-control" type="number" inputmode="numeric" pattern="\d" value="0" min="0" max="5000" autocomplete="off">
                        <span class="input-group-text">max:5000</span>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="notes" data-key="notes" data-value="-100">-100</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="notes" data-key="notes" data-value="-10">-10</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="notes" data-key="notes" data-value="-1">-1</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="notes" data-key="notes" data-value="1">+1</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="notes" data-key="notes" data-value="10">+10</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="notes" data-key="notes" data-value="100">+100</button>
                    </div>
                </div>
            </fieldset>
            {{-- ベル数 --}}
            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">ベル数</legend>
                <div class="col-sm-10">
                    <div class="input-group mb-1">
                        <span class="input-group-text">min:1</span>
                        <input id="bells_value" class="form-control" type="number" inputmode="numeric" pattern="\d" value="0" min="0" max="5000" autocomplete="off">
                        <span class="input-group-text">max:5000</span>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="bells" data-key="bells" data-value="-100">-100</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="bells" data-key="bells" data-value="-10">-10</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="bells" data-key="bells" data-value="-1">-1</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="bells" data-key="bells" data-value="1">+1</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="bells" data-key="bells" data-value="10">+10</button>
                        <button class="btn btn-outline-secondary fs-75p input_button" data-tool="bells" data-key="bells" data-value="100">+100</button>
                    </div>
                </div>
                <div class="d-none">
                    <input id="const_value" class="d-none" type="number">
                </div>
            </fieldset>
            <div id="song_status" class="alert alert-secondary d-none" role="alert">カスタム設定が読み込まれています</div>
        </div>
    </div>
    {{-- ツール切り替えタブ --}}
    <div class="tool_body">
        {{-- タブコントローラー --}}
        <input id="tab_input1" class="panel-radios" type="radio" name="tab-radios" checked>
        <input id="tab_input2" class="panel-radios" type="radio" name="tab-radios">
        <input id="tab_input3" class="panel-radios" type="radio" name="tab-radios">
        <input id="tab_input4" class="panel-radios" type="radio" name="tab-radios">
        <input id="tab_input5" class="panel-radios" type="radio" name="tab-radios">
        {{-- タブリスト --}}
        <ul id="tool_btn">
            <li id="tool_tab1"><label class="tool_label" for="tab_input1">ボーダー</label></li>
            <li id="tool_tab2"><label class="tool_label" for="tab_input2">スコア</label></li>
            <li id="tool_tab3"><label class="tool_label" for="tab_input3">レート計算</label></li>
        </ul>
        {{-- メインツール --}}
        <div class="tool_wrapper">
            @include('main.calculator.layouts.tool_boarder')
            @include('main.calculator.layouts.tool_score')
            @include('main.calculator.layouts.tool_rating')
        </div>
    </div>
    <div class="modal_container">
        @include('main.calculator.layouts.modal_song_search')
        @include('main.calculator.layouts.modal_songdata_notfound')
    </div>
@endsection

@section('footer')
    <p>maya2 オンゲキツール 計算機 (https://ongeki.maya2silence.com/calc/)</p>
    <p>不具合･要望等があれば<a href="https://twitter.com/nsono_saberPUC" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
@endsection
