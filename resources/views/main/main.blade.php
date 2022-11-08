@extends('main.layouts.template')

@section('title')
    <span>maya2 オンゲキツール</span>
@endsection

@section('css')
    <link href="{{ asset('/css/main/main.css') }}" rel="stylesheet">
@endsection

@section('script')
@endsection

@section('content')
    <div id="update" class="container">
        <div class="outerContainer">
            <div class="subTitle">最新情報</div>
            <div class="innerContainer">
                <ul>
                    @foreach ($news as $n)
                        <li class="news-info">
                            <a href="{{ route('news.view', $n->id) }}" class="news-header" target="_blank" rel="noopener">{{ $n->header }}</a><span class="info-date">@date($n->created_at)</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="outerContainer">
            <div class="subTitle">関連ツール</div>
            <div class="innerContainer">
                <div class="t_list">
                    <a href="{{ route('main.table.noLv') }}">
                        <div>
                            <img class="list_img" src="{{ asset('storage/asset/c_t.jpg') }}">
                            <div>
                                <span class="list_title">楽曲定数表</span>
                                <span class="list_expl">各レベルの定数表</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('main.calculator') }}">
                        <div>
                            <img class="list_img" src="{{ asset('storage/asset/b_t.jpg') }}">
                            <div>
                                <span class="list_title">テクニカル計算機</span>
                                <span class="list_expl">テクニカルスコア関連の計算機</span>
                            </div>
                        </div>
                    </a>
                    <a href="/taskgacha" style="display: none">
                        <div>
                            <img class="list_img" src="{{ asset('storage/asset/g_t.jpg') }}">
                            <div>
                                <span class="list_title">課題曲ガチャ</span>
                                <span class="list_expl">課題曲をガチャ形式で選曲</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="qa" class="container">
        <div class="outerContainer">
            <div class="subTitle">よくある質問</div>
            <div class="innerContainer">
                <dl>
                    <dt>このツールはなに</dt>
                    <dd>オンゲキの定数表とスコア等の計算機です。</dd>
                    <dt>使いにくい/うまく動かない</dt>
                    <dd>使いやすいように日々改良を行い不具合を見つけ次第修正していますが、改修要望・不具合が御座いましたらお手数ですが管理者までご連絡下さい。<br>
                        <strong style="color: red;">なおキャッシュクリアすると保存状況が消えます。</strong>
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div id="donate" class="container">
        <div class="outerContainer">
            <div class="subTitle">寄付について</div>
            <div class="innerContainer">
                <p>本ツール・サービスは無料でお使い頂けますが、ご支援を募集しています。</p>
                <p>ご支援頂ける方がいらっしゃいましたら、お手数ですが開発者(<a href="https://twitter.com/7t45a">@7t45a</a>)までご連絡ください。</p>
                <p>開発者ほしい物リスト: <a target="_blank" rel="noopener" href="https://www.amazon.jp/hz/wishlist/ls/1GLYOD9R0Y6R4?ref_=wl_share">リンク</a></p>
            </div>
        </div>
    </div>

    <div id="rule" class="container">
        <div class="outerContainer">
            <div class="subTitle">利用規約</div>
            <div class="innerContainer">
                <p><strong style="font-weight: bold;color: red;">必ずお読みください。</strong>
                    <br>以下の規約は登録・利用をもって全て同意したものとします。
                </p>
                <ol>
                    <li>本サービスを予告なく中止,終了する可能性があります。また中止, 終了に対し運営者は一切の責任を負いかねます。</li>
                    <li>本サービスに使用されている画像等の知的財産権は全て著作権は所有者に帰属します。</li>
                    <li>本サービスで利用している一部ファイルの無断使用を禁止とします。</li>
                    <li>本サービスに関して不利益･損害を与えた者の利用を禁止できるものします。</li>
                    <li>本規約を予告なく追加・変更・削除できるものとします。</li>
                </ol>
                <p>【2022/2/17 制定】</p>
                <p>【2022/10/30 改訂】</p>
            </div>
        </div>
    </div>

    <div id="other" class="container">
        <div class="outerContainer">
            <div class="subTitle">その他</div>
            <div class="innerContainer">
                <p>不具合、要望、相談が御座いましたら下記管理人までご連絡下さい。</p>
                <ul id="admin">
                    <li>【開発・運営】なた (<a href="https://twitter.com/7t45a">@7t45a</a>)</li>
                    <li>【定数表運営】すわ (<a href="https://twitter.com/suoineau_ac">@suoineau_ac</a>)</li>
                    <li>【計算機運営】マサ (<a href="https://twitter.com/nsono_saberPUC">@nsono_saberPUC</a>)</li>
                </ul>
                <p>本ツールの運営に携わっている方々にこの場を借りて御礼申し上げます。</p>
                <p style="font-size: 75%;">本サービスはファンツールであり㈱SEGA様とは一切の関係はございません。<br>また本サービスに関わるトラブルへの責任を負いかねます。</p>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="footer" style="margin-top:0.75rem; text-align: center;">
        <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/)</p>
        <p>不具合･要望等があれば<a href="#admin" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
    </div>
@endsection
