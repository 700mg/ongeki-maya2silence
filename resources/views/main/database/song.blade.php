@extends('main.layouts.template_b')

@section('title')
    <span>{{ config('userconst.main.database') }}</span>
@endsection

@section('content')
    <div class="d-flex justify-content-between p-1">
        <a href="{{ route('database.list') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"></path>
            </svg>
            楽曲一覧へ戻る
        </a>
    </div>
    <!-- 基本情報 -->
    <div class="section">
        <span>基本情報</span>
        <div class="row">
            {{-- ジャケット --}}
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <div class="jacket mb-3">
                    <img class="m-2 rounded" src="{{ asset("storage/songs/jacket/$song->id.jpg") }}" alt="ジャケット画像">
                </div>
            </div>
            {{-- 基本情報 --}}
            <div class="col-md-8">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">タイトル</span>
                    </div>
                    <span class="form-control">{{ $song->title }}</span>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">フリガナ</span>
                    </div>
                    <span class="form-control">{{ $song->ruby }}</span>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">アーティスト</span>
                    </div>
                    <span class="form-control">{{ $song->artist }}</span>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">カテゴリー</span>
                    </div>
                    <span class="form-control">{{ $song->getCategoryName->category }}</span>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">バージョン</span>
                    </div>
                    <span class="form-control">{{ $song->getVersionName->version }}</span>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">対戦相手</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">属性</span>
                    </div>
                    <span class="form-control">{{ $song->enemy_element }}</span>
                    <div class="input-group-prepend">
                        <span class="input-group-text">レベル</span>
                    </div>
                    <span class="form-control">Lv{{ $song->enemy_level }}</span>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text info_header">実装日</span>
                    </div>
                    <span class="form-control"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <!-- 譜面情報 -->
        <span>譜面情報</span>
        <table class="difficult_table">
            <thead>
                <tr>
                    <th>難易度</th>
                    <th>ノーツ</th>
                    <th>ベル</th>
                    <th>定数</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>MASTER</td>
                    <td>{{ empty($song->master->notes) ? '-' : $song->master->notes }}</td>
                    <td>{{ empty($song->master->bells) ? '-' : $song->master->bells }}</td>
                    <td>{{ empty($song->master->const) ? '-' : $song->master->const }}</td>
                </tr>
                <tr>
                    <td>EXPERT</td>
                    <td>{{ empty($song->expert->bells) ? '-' : $song->expert->notes }}</td>
                    <td>{{ empty($song->expert->const) ? '-' : $song->expert->bells }}</td>
                    <td>{{ empty($song->expert->notes) ? '-' : $song->expert->const }}</td>
                </tr>
                <tr>
                    <td>ADVANCED</td>
                    <td>{{ empty($song->advanced->notes) ? '-' : $song->advanced->notes }}</td>
                    <td>{{ empty($song->advanced->bells) ? '-' : $song->advanced->bells }}</td>
                    <td>{{ empty($song->advanced->const) ? '-' : $song->advanced->const }}</td>
                </tr>
                <tr>
                    <td>BASIC</td>
                    <td>{{ empty($song->basic->notes) ? '-' : $song->basic->notes }}</td>
                    <td>{{ empty($song->basic->bells) ? '-' : $song->basic->bells }}</td>
                    <td>{{ empty($song->basic->const) ? '-' : $song->basic->const }}</td>
                </tr>
                <tr>
                    <td>LUNATIC</td>
                    <td>{{ empty($song->lunatic->notes) ? '-' : $song->lunatic->notes }}</td>
                    <td>{{ empty($song->lunatic->bells) ? '-' : $song->lunatic->bells }}</td>
                    <td>{{ empty($song->lunatic->const) ? '-' : $song->lunatic->const }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/main/database/song.css" />
@stop

@section('js')
    <script src="/script/main/database_song.js"></script>
@stop

@section('footer')
    <div class="footer text-center mt-3">
        <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/database/)</p>
        <p>不具合･要望等があれば<a href="/#admin" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
    </div>
@endsection
