@extends('main.layouts.template_b')

@section('title')
    <span>{{ config('userconst.main.bookmarklet') }}</span>
@endsection

@section('css')
    <link href="/css/main/news/news.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-flex justify-content-between p-1">
        <a href="{{ route('bookmarklet.list') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"></path>
            </svg>
            一覧へ戻る
        </a>
    </div>
    <div class="container news_container">
        <div class="news_header">{{ $bookmarklet->header }}</div>
        <div class="news_contents">
            @php
                $update_at = date('Y/m/d', strtotime($bookmarklet->updated_at));
                $create_at = date('Y/m/d', strtotime($bookmarklet->created_at));

                $cols = explode("\n", $bookmarklet->contents);
            @endphp
            @foreach ($cols as $c)
                @if (preg_match('/##IMG(?P<ID>\d+)/', $c, $match))
                    @php
                        if (!empty($bookmarklet->images)) {
                            $img = explode(',', $bookmarklet->images);
                            $path = asset(sprintf('storage/bookmarklet/%d/%s', $bookmarklet->id, $img[$match['ID']]));
                            $img_tag = sprintf('<img src=%s />', $path);
                            echo "<p class='mb-3'>" . preg_replace('/##IMG\d+/', $img_tag, $c) . '</p>';
                        }
                    @endphp
                @elseif (preg_match('/^###/', $c))
                    @php
                        echo "<p class='mb-3'>" . str_replace('###', '', $c) . '</p>';
                    @endphp
                @elseif($c == "\r")
                    @php
                        echo "<br/>";
                    @endphp
                @else
                    <p class="mb-3">{{ $c }}</p>
                @endif
            @endforeach
        </div>
        <div class="news_footer">
            <span>【作成】{{ $create_at }}</span>
            @if ($bookmarklet->updated_at != $bookmarklet->created_at)
                <span>【更新】{{ $update_at }}</span>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/bookmarklet)</p>
    <p>不具合･要望等があれば<a href="/#admin" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
@endsection
