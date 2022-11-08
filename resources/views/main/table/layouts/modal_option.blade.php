{{-- オプションモーダル --}}
<div class="modal fade" id="modal_option" tabindex="-1" aria-labelledby="modal_option_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_option_label">オプション</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                {{-- 非表示項目切り替え --}}
                <fieldset class="mb-3">
                    <label class="form-label m-0">非表示設定</label>
                    <div class="m-3 mt-1 mb-1">
                        <div class="form-check form-switch">
                            <input class="form-check-input toggleHideDiffBtn" type="checkbox" id="toggleHideExpert" value="expert">
                            <label class="form-check-label" for="toggleHideExpert">Expertを非表示</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input toggleHideDiffBtn" type="checkbox" id="toggleHideLunatic" value="lunatic">
                            <label class="form-check-label" for="toggleHideLunatic">Lunaticを非表示</label>
                        </div>
                    </div>
                </fieldset>
                {{-- 項目別切り替え --}}
                <fieldset class="mb-3">
                    <label class="form-label m-0">ソート設定</label>
                    <div class="m-3 mt-1 mb-1">
                        <input type="radio" class="btn-check" name="option_sort" id="sortByConst" autocomplete="off" checked>
                        <label class="btn btn-outline-secondary" for="sortByConst" data-bs-toggle="tooltip" title="" data-bs-original-title="定数降順で表示します">定数別</label>

                        <input type="radio" class="btn-check" name="option_sort" id="sortByVersion" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="sortByVersion" data-bs-toggle="tooltip" title="" data-bs-original-title="バージョン降順で表示します">バージョン別</label>
                    </div>
                </fieldset>
                {{-- ジャケット設定 --}}
                <fieldset class="mb-3">
                    <label class="form-label m-0">ジャケットサイズ設定</label>
                    <div class="m-3 mt-1 mb-1">
                        <div class="input-group align-items-center">
                            <div class="input-group-text input_value">
                                <span id="jacket_size_text" style="width:2em">75</span>px
                            </div>
                            <input id="jacket_size_range" class="form-range form-control jacket_size_range" type="range" value="75" min="50" max="150">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mb-3">
                    <label class="form-label m-0">ジャケット設定</label>
                    <div class="m-3 mt-1 mb-1">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleDispTitle_check" checked>
                            <label class="form-check-label" for="toggleDispTitle_check">タイトル表示</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleEnableSlash_check" checked>
                            <label class="form-check-label" for="toggleEnableSlash_check">斜線有効</label>
                        </div>
                    </div>
                </fieldset>
                {{-- 項目別切り替え --}}
                <fieldset class="mb-3">
                    <label class="form-label m-0">セーブ設定</label>
                    <div class="m-3 mt-1 mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleAutoSave_check">
                            <label class="form-check-label" for="toggleAutoSave_check" data-bs-toggle="tooltip" title="" data-bs-original-title="チェックする度に保存します">自動保存有効</label>
                        </div>
                    </div>
                    @auth
                        <div class="m-3 mt-1 mb-1">
                            <div class="row align-items-center gx-0">
                                <span class="col-9 mb-1 fs-80p">今のチェックをサーバーに保存します。</span>
                                <span class="col-3 mb-1"><a class="btn btn-outline-primary fs-75p d-inline" type="button" onclick="saveToServer()">保存</a></span>
                            </div>
                            <div class="row mb-2 align-items-center gx-0">
                                <span class="col-9 mb-1 fs-80p">サーバーからチェックを読み込みます。</span>
                                <span class="col-3 mb-1"><a class="btn btn-outline-primary fs-75p d-inline" type="button" onclick="loadFromServer()">読込</a></span>
                            </div>
                        </div>
                    @endauth
                </fieldset>
                {{-- 項目別切り替え --}}
                <fieldset class="mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">その他</legend>
                    <div class="m-3 mt-1 mb-1">
                        <div class="row align-items-center">
                            <span class="col-7 mb-1 fs-80p">表全体のスクリーンショットを出力します</span>
                            <span class="col-3 mb-1"><a class="btn btn-primary fs-75p d-inline" type="button" data-bs-toggle="modal" data-bs-target="#modal_export_image" data-bs-dismiss="modal" aria-expanded="false">画像出力</a></span>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <span class="col-7 mb-1 fs-80p">ongeki-score-logからスコアを取得し、自動で塗りつぶします</span>
                            <span class="col-3 mb-1"><a class="btn btn-primary fs-75p d-inline" type="button" data-bs-toggle="modal" data-bs-target="#modal_fill_input" data-bs-dismiss="modal" aria-expanded="false">塗りつぶし</a></span>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
@auth
    {{-- 保存しますかのアレ --}}
    <div class="modal fade" id="modal_save_confirm" tabindex="-1" aria-labelledby="modal_save_confirm_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_save_confirm_label">確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
                </div>
                <div class="modal-body">
                    <input type="checkbox" name="save_status" class="d-none" />
                    <div name="save_message" class="">保存してよろしいですか?</div>
                    <div name="error_message" class="d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="modal_save_confirm.querySelector('[name=save_status]').checked=false;">キャンセル</button>
                    <button type="button" name="confirm_btn" class="btn btn-success" onclick="saveToServer()">保存</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_save_confirm_result" tabindex="-1" aria-labelledby="modal_save_confirm_result_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
                </div>
                <div class="modal-body">
                    <div name="result" class=""></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 保存しますかのアレ --}}
    <div class="modal fade" id="modal_load_confirm" tabindex="-1" aria-labelledby="modal_load_confirm_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_load_confirm_label">確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
                </div>
                <div class="modal-body">
                    <input type="checkbox" name="load_status" class="d-none" />
                    <div name="save_message" class="">サーバーから読み込みますか?</div>
                    <div name="error_message" class="d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="modal_save_confirm.querySelector('[name=save_status]').checked=false;">キャンセル</button>
                    <button type="button" name="confirm_btn" class="btn btn-success" onclick="loadFromServer()">はい</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_load_confirm_result" tabindex="-1" aria-labelledby="modal_load_confirm_result_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
                </div>
                <div class="modal-body">
                    <div name="result" class=""></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
@endauth
