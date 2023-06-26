{{-- モーダル --}}
<div class="modal fade" id="modal_export_image" tabindex="-1" aria-labelledby="modal_export_image_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_export_image_label">画像出力</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                <fieldset class="mb-3">
                    <span style="font-size: small; display: block;">画像上部にタイトルを設定できます</span>
                    <div class="input-group">
                        <input class="form-control" name="t_header" type="text" placeholder="例) SSS+達成率表">
                    </div>
                </fieldset>
                <fieldset class="mb-3">
                    <span style="font-size: small; display: block;">どちらの表を生成するか選択できます</span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opt_table" id="export_constTable" value="const" checked>
                        <label class="form-check-label" for="export_constTable">定数</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opt_table" id="export_versionTable" value="version">
                        <label class="form-check-label" for="export_versionTable">バージョン</label>
                    </div>
                </fieldset>
                <fieldset class="mb-3">
                    <span style="font-size: small; display: block;">枠線に斜線を表示するか選択できます</span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opt_shash" id="export_slashDisable" value="false" checked>
                        <label class="form-check-label" for="export_slashDisable">つけない</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opt_shash" id="export_slashEnable" value="true">
                        <label class="form-check-label" for="export_slashEnable">つける</label>
                    </div>
                </fieldset>
                <fieldset class="mb-3">
                    <span style="font-size: small; display: block;">出力する定数の範囲を指定できます</span>
                    <div class="input-group">
                        @php
                            $r = [
                                '14' => ['min' => 14.0, 'max' => 15.9],
                                '13' => ['min' => 13.0, 'max' => 13.9],
                                '12' => ['min' => 12.0, 'max' => 12.9],
                                '11' => ['min' => 11.0, 'max' => 11.9],
                            ];
                        @endphp
                        <select class="form-select form-control" name="range_1" aria-label="Default select example">
                            @for ($i = $r[$lv]['min']; $i < $r[$lv]['max']; $i += 0.1)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="input-group-prepend">
                            <div class="input-group-text">&#12316;</div>
                        </div>
                        <select class="form-select form-control" name="range_2" aria-label="Default select example">
                            @for ($i = $r[$lv]['max']; $i > $r[$lv]['min']; $i -= 0.1)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="invalid-feedback">範囲が不正です</div>
                </fieldset>
                <fieldset class="mb-3">
                    <span style="font-size: small; display: block;">一部の対象曲を非表示にできます</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="opt_hidden" id="export_hiddenExpert">
                        <label class="form-check-label" for="export_hiddenExpert">Expertを非表示</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="opt_hidden" id="export_hiddenLunatic">
                        <label class="form-check-label" for="export_hiddenLunatic">Lunaticを非表示</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="opt_hidden" id="export_hiddenVanilla">
                        <label class="form-check-label" for="export_hiddenVanilla">チェックがない曲を非表示</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="opt_hidden" id="export_hiddenCheck">
                        <label class="form-check-label" for="export_hiddenCheck">チェックがある曲を非表示</label>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button id="export_executeBtn" class="btn btn-primary fs-75p d-inline" onclick="exportImage()">画像出力</button>
            </div>
        </div>
    </div>
</div>

{{-- 画像出力機能の結果のヤツモーダル --}}
<div class="modal fade" id="modal_export_image_view" tabindex="-1" aria-labelledby="modal_export_image_view_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_export_image_view_label">画像出力</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                <fieldset class="mb-1">
                    <div class="alert alert-warning fs-80p" role="alert">シェアする際は、画像を保存してからシェアしてください。</div>
                    <span id="export_loading" class="">読込中です...</span>
                    <img id="export_image" class="w-100 d-none">
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
