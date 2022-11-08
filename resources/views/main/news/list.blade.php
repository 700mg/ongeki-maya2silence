@extends('main.layouts.template_b')

@section('title')
    <span>{{ config("userconst.main.news") }}</span>
@endsection

@section('css')
    <link href="/css/main/news/news.css" rel="stylesheet">
@endsection

@section('content')
    <h2>お知らせ一覧</h2>
    {{ $news->links('admin.layouts.simple_pagenate') }}
    <dl class="">
        @foreach ($news as $n)
            @php
                $create_at = date('m/d', strtotime($n->created_at));
            @endphp
            <dd class="row align-items-center">
                <div class="col-2">{{ $create_at }}</div>
                <div class="col-10"><a href="{{ route('news.view', $n->id) }}">{{ $n->header }}</a></div>
            </dd>
        @endforeach
    </dl>
    {{ $news->links('admin.layouts.simple_pagenate') }}
@endsection

@section('footer')
    <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/news)</p>
    <p>不具合･要望等があれば<a href="/#admin" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
@endsection
