@extends('adminlte::page')

@section('title', '登録成功 - ongeki.maya2silence.com')

@section('content_header')
    @if (session('song'))
        <h1>登録成功</h1>
    @endif
@stop

@section('content')
    @if (session('song'))
        <div class="alert alert-success" role="alert">正常に登録しました。</div>
        <dt>ジャケット</dt>
        <dd><img width="150" height="150" src="{{ asset('storage/songs/jacket/' . session('song')->id . '.jpg') }}"></dd>
        <dt>タイトル</dt>
        <dd>{{ session('song')->title }}</dd>
        <dt>フリガナ</dt>
        <dd>{{ session('song')->ruby ? session('song')->ruby : '未登録' }}</dd>
        <dt>アーティスト</dt>
        <dd>{{ session('song')->artist ? session('song')->artist : '未登録' }}</dd>
        <dt>バージョン</dt>
        <dd>{{ session('song')->getVersionName->version }}</dd>
        <dt>カテゴリ</dt>
        <dd>{{ session('song')->getCategoryName->category }}</dd>
        <a class="btn btn-outline-primary m-3" href="{{ route('admin.songs.detail', session('song')->id) }}">譜面情報を登録する</a>
        <a class="btn btn-outline-primary m-3" href="{{ route('admin.songs.regist') }}">続けて登録する</a>
    @else
        <p class="pt-3">不正なアクセスです</p>
        <p class="">5秒後にダッシュボードにリダイレクトします...</p>
    @endif
@endsection

@section('js')
    @if (!session('song'))
        <script type="text/javascript">
            setTimeout(function() {
                window.location.href = "{{ route('admin.songs.regist') }}";
            }, 5 * 1000);
        </script>
    @endif
@endsection
