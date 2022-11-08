@extends('adminlte::page')

@section('title', 'ブックマークレット登録')

@section('content_header')
    @if (session('bookmarklet'))
        <h1>登録成功</h1>
    @endif
@stop

@section('content')
    @if (session('bookmarklet'))
        <div class="alert alert-success" role="alert">正常に登録しました。</div>
        <iframe src="{{ route('bookmarklet.detail', session('bookmarklet')->id) }}" width="100%" height="640"></iframe>
        <a class="btn btn-outline-primary m-3" href="{{ route('admin.bookmarklet.regist') }}">続けて登録する</a>
    @else
        <p class="pt-3">不正なアクセスです</p>
        <p class="">5秒後にダッシュボードにリダイレクトします...</p>
    @endif
@endsection

@section('js')
    @if (!session('bookmarklet'))
        <script type="text/javascript">
            setTimeout(function() {
                window.location.href = "{{ route('admin.bookmarklet.regist') }}";
            }, 5 * 1000);
        </script>
    @endif
@endsection
