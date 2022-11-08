@extends('main.layouts.template_b')

@section('css')
    <link rel="stylesheet" href="/css/main/table/table.css" title="table_style" />
@endsection

@section('script')
    <script src="/script/main/table/table.js"></script>
    <script src="/script/main/table/long-press-event.min.js"></script>
    <script type="text/javascript">
        const lv = {{ $lv }};
        const SONG_DATA_URL = "{{ route('song.detail') }}";
        const SONG_DATABASE_URL = "{{ route('database.song', '/') }}/";
        const SONG_SEARCH_URL = "{{ route('song.search') }}";
        const SONG_EXPORTIMAGE_URL = "https://api.maya2silence.com/ongeki-export/";
        const OSL_FETCH_URL = "{{ route('main.table.osl.fetch') }}";
        const OSL_FILL_URL = "{{ route('main.table.osl.fill') }}";
        const DATA_SAVE_URL = "{{ route('main.table.save') }}";
        const DATA_LOAD_URL = "{{ route('main.table.load') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const SHARE_DATA = {!! empty($data) ? '""' : Js::from($data) !!};
    </script>
@endsection

@section('title')
    <span>{{ config('userconst.main.table') }}&nbsp;[Lv{{ $lv }}]</span>
@endsection

@section('header_menu')
    <span class="header_cont" onclick="saveToLocal();">SAVE</span>
    <span class="header_cont" onclick="resetJacketFlag();">RESET</span>
    <span class="header_cont" onclick="loadFromLocal();">RELOAD</span>
    <a type="button" class="header_cont" data-bs-toggle="modal" data-bs-target="#modal_search" aria-expanded="false"><i class="fa-solid fa-magnifying-glass"></i></a>
    <a type="button" class="header_cont" data-bs-toggle="modal" data-bs-target="#modal_option" aria-expanded="false"><i class="fa-solid fa-gear"></i></a>
@endsection

@section('content')
    {{-- 管理人からのお知らせとか。 --}}
    <div class="news_colcontainer">
        <div class="alert alert-info">
            <div class="mb-2 text-center" style="border-bottom: #333 solid 1px;">お知らせ</div>
            {{-- ここに最新5件分のお知らせを表示 --}}
            @foreach ($news as $n)
                <div class="row news_col m-0 gx-0">
                    <span class="col-sm-3 text-left text-sm-center">@date($n->created_at)</span>
                    <a class="col-sm-9" href="{{ route('news.view', $n->id) }}" target="_blank" rel="noopener">{{ $n->header }}</a>
                </div>
            @endforeach
        </div>
    </div>
    @isset($success)
        <div class="alert alert-success mb-3" style="margin: 0px auto; max-width: 560px !important;" role="alert">{{ $success }}</div>
    @endisset
    @isset($error)
        <div class="alert alert-danger mb-3" style="margin: 0px auto; max-width: 560px !important;" role="alert">{{ $error }}</div>
    @endisset
    <div id="song_table">
        @include('main.table.layouts.table_const')
        @include('main.table.layouts.table_version')
    </div>
@endsection

@section('outer_content')
    <div id="modal">
        @include('main.table.layouts.modal_option')
        @include('main.table.layouts.modal_song_search')
        @include('main.table.layouts.modal_song_info')
        @include('main.table.layouts.modal_message')
        @include('main.table.layouts.modal_export_menu')
        @include('main.table.layouts.modal_fill')
    </div>
    @include('main.table.layouts.check_counter')
@endsection

@section('footer')
    <div class="main_footer">
        <p>maya2 オンゲキツール 定数表 (https://ongeki.maya2silence.com/table/)</p>
        <p>不具合･要望等があれば<a href="https://twitter.com/suoineau_ac" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
    </div>
@endsection
