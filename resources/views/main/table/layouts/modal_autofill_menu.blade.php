<div class="modal_container" id="modal_autocheck">
    <h5 class="modal_header">自動塗りつぶし</h5>
    <span onclick="closeModal()" class="modal_close_btn">
        <span class="modal_close_btn_inner"></span>
    </span>
    <div class="modal_body">
        <div class="ac_subheader">
            <span>ID:</span><span id="p_id_result">設定されていません</span>
        </div>
        <span class="ac_subheader">塗りつぶし設定</span>
        <div class="ac_subcontainer">
            <span>設定したスコア以上の曲を塗りつぶします</span>
        </div>
        <div class="ac_subcontainer">
            <div class="ac_input ac_green">
                <div class="ac_input_header">緑</div>
                <div class="ac_input_switch">
                    <label for="ac_flag_1">有効</label>
                    <input id="ac_flag_1" type="checkbox">
                </div>
                <div class="ac_input_main">
                    <span><input id="ac_input_1" type="number" placeholder="スコア" class="ac_num_input no-spin" inputmode="numeric" max="1010000" maxlength="7"></span>
                    <div style="margin: 10px 0 0;">
                        <button class="ac_num_btn" onclick="ac_input_1.value=1010000">MAX</button>
                        <button class="ac_num_btn" onclick="ac_input_1.value=1007500">SSS+</button>
                        <button class="ac_num_btn" onclick="ac_input_1.value=1000000">SSS</button>
                        <button class="ac_num_btn" onclick="ac_input_1.value=990000">SS+</button>
                    </div>
                    <div style="margin: 5px 0 0;">
                        <span>条件</span>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_ab1" data-type="ab" data-id="1" value="4"><label class="ac_cb_btn" for="ac_cb_ab1">AB</label>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_fc1" data-type="fc" data-id="1" value="2"><label class="ac_cb_btn" for="ac_cb_fc1">FC</label>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_fb1" data-type="fb" data-id="1" value="1"><label class="ac_cb_btn" for="ac_cb_fb1">FB</label>
                    </div>
                </div>
            </div>
            <div class="ac_input ac_red">
                <div class="ac_input_header">赤</div>
                <div class="ac_input_switch">
                    <label for="ac_flag_2">有効</label>
                    <input id="ac_flag_2" type="checkbox">
                </div>
                <div class="ac_input_main">
                    <div><input id="ac_input_2" type="number" placeholder="スコア" class="ac_num_input no-spin" inputmode="numeric" max="1010000" maxlength="7"></span>
                        <div style="margin: 10px 0 0;">
                            <button class="ac_num_btn" onclick="ac_input_2.value=1010000">MAX</button>
                            <button class="ac_num_btn" onclick="ac_input_2.value=1007500">SSS+</button>
                            <button class="ac_num_btn" onclick="ac_input_2.value=1000000">SSS</button>
                            <button class="ac_num_btn" onclick="ac_input_2.value=990000">SS+</button>
                        </div>
                        <div style="margin: 5px 0 0;">
                            <span>条件</span>
                            <input type="checkbox" class="ac_cb_input" id="ac_cb_ab2" data-type="ab" data-id="2" value="4"><label class="ac_cb_btn" for="ac_cb_ab2">AB</label>
                            <input type="checkbox" class="ac_cb_input" id="ac_cb_fc2" data-type="fc" data-id="2" value="2"><label class="ac_cb_btn" for="ac_cb_fc2">FC</label>
                            <input type="checkbox" class="ac_cb_input" id="ac_cb_fb2" data-type="fb" data-id="2" value="1"><label class="ac_cb_btn" for="ac_cb_fb2">FB</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ac_input ac_blue">
                <div class="ac_input_header">青</div>
                <div class="ac_input_switch">
                    <label for="ac_flag_3">有効</label>
                    <input id="ac_flag_3" type="checkbox">
                </div>
                <div class="ac_input_main">
                    <span><input id="ac_input_3" type="number" placeholder="スコア" class="ac_num_input no-spin" inputmode="numeric" max="1010000" maxlength="7"></span>
                    <div style="margin: 10px 0 0;">
                        <button class="ac_num_btn" onclick="ac_input_3.value=1010000">MAX</button>
                        <button class="ac_num_btn" onclick="ac_input_3.value=1007500">SSS+</button>
                        <button class="ac_num_btn" onclick="ac_input_3.value=1000000">SSS</button>
                        <button class="ac_num_btn" onclick="ac_input_3.value=990000">SS+</button>
                    </div>
                    <div style="margin: 5px 0 0;">
                        <span>条件</span>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_ab3" data-type="ab" data-id="3" value="4"><label class="ac_cb_btn" for="ac_cb_ab3">AB</label>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_fc3" data-type="fc" data-id="3" value="2"><label class="ac_cb_btn" for="ac_cb_fc3">FC</label>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_fb3" data-type="fb" data-id="3" value="1"><label class="ac_cb_btn" for="ac_cb_fb3">FB</label>
                    </div>
                </div>
            </div>
            <div class="ac_input ac_clear">
                <div class="ac_input_header">透明</div>
                <div class="ac_input_switch">
                    <label for="ac_flag_4">有効</label>
                    <input id="ac_flag_4" type="checkbox">
                </div>
                <div class="ac_input_main">
                    <span><input id="ac_input_4" type="number" placeholder="スコア" class="ac_num_input no-spin" inputmode="numeric" max="1010000" maxlength="7"></span>
                    <div style="margin: 10px 0 0;">
                        <button class="ac_num_btn" onclick="ac_input_4.value=1010000">MAX</button>
                        <button class="ac_num_btn" onclick="ac_input_4.value=1007500">SSS+</button>
                        <button class="ac_num_btn" onclick="ac_input_4.value=1000000">SSS</button>
                        <button class="ac_num_btn" onclick="ac_input_4.value=990000">SS+</button>
                    </div>
                    <div style="margin: 5px 0 0;">
                        <span>条件</span>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_ab4" data-type="ab" data-id="4" value="4"><label class="ac_cb_btn" for="ac_cb_ab4">AB</label>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_fc4" data-type="fc" data-id="4" value="2"><label class="ac_cb_btn" for="ac_cb_fc4">FC</label>
                        <input type="checkbox" class="ac_cb_input" id="ac_cb_fb4" data-type="fb" data-id="4" value="1"><label class="ac_cb_btn" for="ac_cb_fb4">FB</label>
                    </div>
                </div>
            </div>
            <div class="ac_subcontainer">
                <span><button class="btn" id="p_calc">塗りつぶす</button></span>
            </div>
        </div>
        <script>
            $(document).on("input", "input.ac_num_input", (e) => {
                //if(this.value.length > this.maxLength)
                var val = $(e.currentTarget).val(),
                    len = $(e.currentTarget).val().length,
                    max = parseInt($(e.currentTarget).attr("maxLength"));
                if (val.length > max) {
                    $(e.currentTarget).val(val.slice(0, max));
                }
            });


            $(document).on("change", "input.ac_cb_input", (e) => {
                var ct = e.target;
                if (ct.checked && ct.dataset.type === "ab") {
                    $("#ac_cb_fc" + ct.dataset.id).prop("checked", true);
                    return;
                }
                if (!ct.checked && ct.dataset.type === "fc") {
                    $("#ac_cb_ab" + ct.dataset.id).prop("checked", false);
                    return;
                }
            });

            p_calc.addEventListener("click", function() {
                $.ajax({
                    type: "POST",
                    url: "./script/autocheck.php",
                    async: false,
                    dataType: "json",
                    data: {
                        id: p_id_result.innerText,
                        csrf: p_csrf.value,
                        lv: location.search,
                        target: {
                            green: {
                                flag: ac_flag_1.checked,
                                val: ac_input_1.value,
                                lamp: function() {
                                    var s = 0;
                                    $("input.ac_cb_input[data-id='1']:checked").each(function(i, e) {
                                        s += +$(e).val();
                                    });
                                    return s;
                                }
                            },
                            red: {
                                flag: ac_flag_2.checked,
                                val: ac_input_2.value,
                                lamp: function() {
                                    var s = 0;
                                    $("input.ac_cb_input[data-id='1']:checked").each(function(i, e) {
                                        s += +$(e).val();
                                    });
                                    return s;
                                }
                            },
                            blue: {
                                flag: ac_flag_3.checked,
                                val: ac_input_3.value,
                                lamp: function() {
                                    var s = 0;
                                    $("input.ac_cb_input[data-id='1']:checked").each(function(i, e) {
                                        s += +$(e).val();
                                    });
                                    return s;
                                }
                            },
                            clear: {
                                flag: ac_flag_4.checked,
                                val: ac_input_4.value,
                                lamp: function() {
                                    var s = 0;
                                    $("input.ac_cb_input[data-id='1']:checked").each(function(i, e) {
                                        s += +$(e).val();
                                    });
                                    return s;
                                }
                            }
                        },
                        type: "CALC"
                    }
                }).done(function(d) {
                    autoFill(d);
                }).fail(function() {
                    window.alert("ERROR");
                });
            });
        </script>
    </div>
</div>
<div class="modal_container" id="modal_checkresult" style="text-align: center;">
    <h5 class="modal_header">自動塗りつぶし</h5>
    <span onclick="closeModal()" class="modal_close_btn"></span>
    <div class="modal_body">
        <div class="ac_subheader">
            <span id="ac_status"></span>
        </div>
    </div>
</div>
