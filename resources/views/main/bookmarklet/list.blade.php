@extends('main.layouts.template_b')

@section('title')
    <span>{{ config('userconst.main.bookmarklet') }}</span>
@endsection

@section('content')
    <div class="text-center">
        <p>今まで公開したブックマークレットなどのちょっとしたプログラム置き場です。</p>
    </div>
    {{ $bookmarklets->links('admin.layouts.simple_pagenate') }}
    <dl class="">
        @forelse ($bookmarklets as $bookmarklet)
            <dd class="row align-items-center">
                <div class="col-8"><a href="{{ route('bookmarklet.detail', $bookmarklet->id) }}">{{ $bookmarklet->header }}</a></div>
                <div class="col-4">{{ $bookmarklet->created_at }}</div>
            </dd>
        @empty
            <dd class="text-center">1つも登録されていません。</dd>
        @endforelse
    </dl>
    {{ $bookmarklets->links('admin.layouts.simple_pagenate') }}
@stop

@section('css')
    <link rel="stylesheet" href="/css/main/database/song.css" />
@stop

@section('script')
@stop

@section('footer')
    <div class="footer text-center mt-3">
        <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/bookmarklet/)</p>
        <p>不具合･要望等があれば<a href="/#admin" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
    </div>
@endsection
