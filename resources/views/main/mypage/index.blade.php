@extends('main.layouts.template_b')

@section('title')
    <span>{{ config('userconst.main.mypage') }}</span>
@endsection

@section('css')
    <link href="/css/main/mypage/mypage.css" rel="stylesheet">
@endsection

@section('script')
    <script>
        //input.copyの値をクリップボードにコピーする
        const copyToClipboard = function() {
            navigator.clipboard.writeText(share_param.innerText).then(() => {
                window.alert('コピーしました');
            }, () => {
                window.alert('コピーできませんでした');
            });
        };
    </script>
@endsection

@section('content')
    <div class="p-3">
        @if (session('success'))
            <div class="alert alert-success mb-3" style="margin: 0px auto; max-width: 560px !important;" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mb-3" style="margin: 0px auto; max-width: 560px !important;" role="alert">{{ session('error') }}</div>
        @endif
        <div class="profile rounded">
            <a class="row" href="{{ 'https://twitter.com/' . Auth::user()->getTwitter->nickname }}" target="_blank" rel="noopenner">
                <div class="col-3 d-flex align-items-center justify-content-center">
                    <img src="{{ Auth::user()->getTwitter->avatar }}">
                </div>
                <div class="col-9 d-flex align-items-center">
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </a>
        </div>
        <div class="accordion" id="accordion">
            <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="accordion_items_settings_header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_items_settings" aria-expanded="true" aria-controls="accordion_items_settings">
                        <i class="fa-solid fa-wrench"></i>&nbsp;各種設定</button>
                </h2>
                <div id="accordion_items_settings" class="accordion-collapse collapse show" aria-labelledby="accordion_items_settings_header">
                    {{-- 設定内アコーディオン --}}
                    <form action="{{ route('user.mypage.update') }}" method="POST">
                        @csrf
                        <div class="accordion-body">
                            <div class="accordion" id="accordion_settings">
                                {{-- 定数表の設定 --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="settings_items_one_header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#settings_items_one" aria-expanded="true" aria-controls="settings_items_one">
                                            #1&nbsp;定数表設定
                                        </button>
                                    </h2>
                                    <div id="settings_items_one" class="accordion-collapse collapse show" aria-labelledby="settings_items_one_header">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <span class="d-block fs-80p">このパラメーターを定数表のURLの最後につけると共有が出来ます</span>
                                                <div class="input-group">
                                                    <span class="form-control" id="share_param">{{ "?share={$config['table_shareParam']}" }}</span>
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="copyToClipboard()"><span class="fs-80p">COPY</span></button>
                                                </div>
                                                <span class="d-block fs-80p">(例) {{ route('main.table', 14) . "?share={$config['table_shareParam']}" }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-80p">チェックをつけると他の人があなたのデータにアクセスできるようになります</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="table_public" id="flexSwitchCheckDefault" {{ $config['table_public'] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault">共有を許可する</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="settings_items_two_header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#settings_items_two" aria-expanded="false" aria-controls="settings_items_two">
                                            #2&nbsp;計算機設定
                                        </button>
                                    </h2>
                                    <div id="settings_items_two" class="accordion-collapse collapse show" aria-labelledby="settings_items_two_header">
                                        <div class="accordion-body">
                                            今後実装予定です
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="settings_items_three_header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#settings_items_three" aria-expanded="false" aria-controls="settings_items_three">
                                            #3&nbsp;その他
                                        </button>
                                    </h2>
                                    <div id="settings_items_three" class="accordion-collapse collapse show" aria-labelledby="settings_items_three_header">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <span class="fs-80p">OngekiScoreLogのIDを登録できます。現在特に意味はありません。</span>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text input_value">ID</div>
                                                    <input class="form-control" type="number" inputmode="numeric" name="osl_id" value="{{ empty($config['osl_id']) ? '' : $config['osl_id'] }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-2" style="text-align: right">
                            <button class="btn btn-outline-primary" type="submit">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion-item mb-2 d-none">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Accordion Item #2
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                <div class="accordion-body">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does
                    limit overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item mb-2 d-none">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Accordion Item #3
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does
                    limit overflow.
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('footer')
    <p>maya2 オンゲキツール (https://ongeki.maya2silence.com/mypage)</p>
    <p>不具合･要望等があれば<a href="/#admin" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
@endsection
