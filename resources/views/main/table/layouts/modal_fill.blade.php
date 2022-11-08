<div class="modal fade" id="modal_fill_input" tabindex="-1" aria-labelledby="modal_fill_input_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_fill_input_label">塗りつぶし</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-secondary mb-1" role="alert"><a href="https://ongeki-score.net" target="_blank" rel="noopenner">OngekiScoreLog</a>のデータから塗りつぶします。</div>
                <fieldset class="mb-1">
                    <div class="fs-80p">OngekiScoreLog内ID</div>
                    <div class="input-group">
                        <div class="input-group-text input_value">ID</div>
                        <input class="form-control" name="osl_id" type="number" inputmode="numeric">
                    </div>
                </fieldset>
                <div class="alert alert-danger mb-1 d-none" role="alert" id="fill_input_alert"></div>
            </div>
            <div class="modal-footer">
                <button id="export_executeBtn" class="btn btn-primary fs-75p d-inline" onclick="fetchToOSL()">読み込み</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_fill_option" tabindex="-1" aria-labelledby="modal_fill_option_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_fill_option_label">塗りつぶし</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ac_id">
                <div class="alert alert-danger mb-1 d-none" role="alert" id="fill_option_alert"></div>
                <fieldset class="row gx-0 p-1 pb-2" style="background:rgba(144, 238, 144, 0.75);">
                    <div class="col-2 justify-content-center">
                        <label for="ac_flag_1">緑</label>
                        <input class="form-check-input" type="checkbox" id="ac_flag_1">
                    </div>
                    <div class="col-10">
                        <div class="input-group">
                            <input class="form-input form-control" id="ac_input_1" type="number" placeholder="スコア" inputmode="numeric" max="1010000" maxlength="7">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_1.value=1010000">MAX</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_1.value=1007500">SSS+</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_1.value=1000000">SSS</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_1.value=990000">SS</button>
                        </div>
                        <div class="text-center">
                            <span>条件</span>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_1" id="ac_cb_ab1" data-type="ab" data-id="1" value="4"><label class="ac_cb_btn" for="ac_cb_ab1">AB</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_1" id="ac_cb_fc1" data-type="fc" data-id="1" value="2"><label class="ac_cb_btn" for="ac_cb_fc1">FC</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_1" id="ac_cb_fb1" data-type="fb" data-id="1" value="1"><label class="ac_cb_btn" for="ac_cb_fb1">FB</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="row gx-0 p-1 pb-2" style="background:rgba(255, 194, 204, 0.75);">
                    <div class="col-2 justify-content-center">
                        <label for="ac_flag_2">赤</label>
                        <input class="form-check-input" type="checkbox" id="ac_flag_2">
                    </div>
                    <div class="col-10">
                        <div class="input-group">
                            <input class="form-input form-control" id="ac_input_2" type="number" placeholder="スコア" inputmode="numeric" max="1010000" maxlength="7">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_2.value=1010000">MAX</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_2.value=1007500">SSS+</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_2.value=1000000">SSS</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_2.value=990000">SS</button>
                        </div>
                        <div class="text-center">
                            <span>条件</span>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_2" id="ac_cb_ab2" data-type="ab" data-id="2" value="4"><label class="ac_cb_btn" for="ac_cb_ab2">AB</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_2" id="ac_cb_fc2" data-type="fc" data-id="2" value="2"><label class="ac_cb_btn" for="ac_cb_fc2">FC</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_2" id="ac_cb_fb2" data-type="fb" data-id="2" value="1"><label class="ac_cb_btn" for="ac_cb_fb2">FB</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="row gx-0 p-1 pb-2" style="background:rgba(173, 216, 230, 0.75);">
                    <div class="col-2 justify-content-center">
                        <label for="ac_flag_3">青</label>
                        <input class="form-check-input" type="checkbox" id="ac_flag_3">
                    </div>
                    <div class="col-10">
                        <div class="input-group">
                            <input class="form-input form-control" id="ac_input_3" type="number" placeholder="スコア" inputmode="numeric" max="1010000" maxlength="7">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_3.value=1010000">MAX</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_3.value=1007500">SSS+</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_3.value=1000000">SSS</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_3.value=990000">SS</button>
                        </div>
                        <div class="text-center">
                            <span>条件</span>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_3" id="ac_cb_ab3" data-type="ab" data-id="3" value="4"><label class="ac_cb_btn" for="ac_cb_ab3">AB</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_3" id="ac_cb_fc3" data-type="fc" data-id="3" value="2"><label class="ac_cb_btn" for="ac_cb_fc3">FC</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_3" id="ac_cb_fb3" data-type="fb" data-id="3" value="1"><label class="ac_cb_btn" for="ac_cb_fb3">FB</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="row gx-0 mb-1 p-1 pb-2" style="background:rgba(237, 237, 237, 0.75);">
                    <div class="col-2 justify-content-center">
                        <label for="ac_flag_4">透</label>
                        <input class="form-check-input" type="checkbox" id="ac_flag_4">
                    </div>
                    <div class="col-10">
                        <div class="input-group">
                            <input class="form-input form-control" id="ac_input_4" type="number" placeholder="スコア" inputmode="numeric" max="1010000" maxlength="7">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_4.value=1010000">MAX</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_4.value=1007500">SSS+</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_4.value=1000000">SSS</button>
                            <button class="btn btn-secondary fs-75p" onclick="ac_input_4.value=990000">SS</button>
                        </div>
                        <div class="text-center">
                            <span>条件</span>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_4" id="ac_cb_ab4" data-type="ab" data-id="4" value="4"><label class="ac_cb_btn" for="ac_cb_ab4">AB</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_4" id="ac_cb_fc4" data-type="fc" data-id="4" value="2"><label class="ac_cb_btn" for="ac_cb_fc4">FC</label>
                            <input type="checkbox" class="form-check-input" name="ac_lamp_4" id="ac_cb_fb4" data-type="fb" data-id="4" value="1"><label class="ac_cb_btn" for="ac_cb_fb4">FB</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button id="export_executeBtn" class="btn btn-primary fs-75p d-inline" onclick="fillFromOSL()">塗りつぶす</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_fill_result" tabindex="-1" aria-labelledby="modal_fill_result_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_fill_result_label">塗りつぶし</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success mb-1 d-none" role="alert" id="fill_result_success">塗りつぶしました。</div>
                <div class="alert alert-warning mb-1 d-none" role="alert" id="fill_result_warning"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
