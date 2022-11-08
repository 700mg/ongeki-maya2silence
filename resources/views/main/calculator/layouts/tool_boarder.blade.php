<div id="boardertool" class="tool_contents">
    <div class="mt-2 mb-2">
        <p class="m-0">目標Tcスコアから許容Critical数を計算します</span>
    </div>
    <hr />
    <div class="col-8 m-auto mb-3">
        <div class="text-center"><span class="fs-75p">範囲:940,000~1,010,000</span></div>
        <div class="input-group col-sm-8">
            <span class="input-group-text">目標Tcスコア</span>
            <input id="boarder_tcscore_value" class="form-control text-center" type="number" inputmode="numeric" value="1000000" min="940000" max="1010000" data-default="1000000">
            <input id="boarder_tcscore_range" class="d-none" type="range" step="10" value="1000000" min="940000" max="1010000" data-tool="boarder" data-key="boarder_hit" data-default="1000000">
        </div>
        <div class="text-center m-1">
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_tcscore" data-value="-100">-100</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_tcscore" data-value="-10">-10</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_tcscore" data-value="10">+10</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_tcscore" data-value="100">+100</button>
        </div>
        {{-- スクリーンショットを考慮してここを隠せるようにする... 多分他にいいレイアウトがあるはず --}}
        <a class="collapsed mt-1 mb-1 d-inline-flex align-items-center" onclick="" data-bs-toggle="collapse" href="#boarder_tcscore_button" aria-controls="#boarder_tcscore_button" aria-expanded="false">
            ショートカット<span class="collapse_icon"></span>
        </a>
        <div class="collapse" id="boarder_tcscore_button">
            <div class="text-center m-1">
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="1007500">SSS+</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="1000000">SSS</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="990000">SS</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="970000">S</button>
            </div>
            <div class="text-center">
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="1009000">'9000</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="1005000">'5000</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="boarder" data-key="boarder_tcscore" data-value="1002000">'2000</button>
            </div>
        </div>
    </div>
    <hr />
    <fieldset class="mt-2 mb-0">
        <legend>計算結果</legend>
        <div class="input-group align-items-center">
            <div class="input-group">
                <div class="input-group-text"><span class="style_break">BREAK</span></div>
                <span class="form-control fs-3"><span id="boarder_result" class="style_result">0</span></span>
            </div>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_hit">HIT</span></div>
            <input id="boarder_hit_range" class="form-range form-control input_range" type="range" value="0" min="0" max="200" data-tool="boarder" data-key="boarder_hit" data-default="0">
            <div class="input-group-text input_value">
                <span id="boarder_hit_text">0</span>
                <input id="boarder_hit_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_hit" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_hit" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_miss">MISS</span></div>
            <input id="boarder_miss_range" class="form-range form-control input_range" type="range" value="0" min="0" max="200" data-tool="boarder" data-key="boarder_miss" data-default="0">
            <div class="input-group-text input_value">
                <span id="boarder_miss_text">0</span>
                <input id="boarder_miss_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_miss" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_miss" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_bell">BELL</span></div>
            <input id="boarder_bell_range" class="form-range form-control input_range" type="range" value="0" min="0" max="200" data-tool="boarder" data-key="boarder_bell" data-default="bell">
            <div class="input-group-text input_value">
                <span id="boarder_bell_text" data-default="bell">0</span>
                <input id="boarder_bell_value" class="d-none" value="0" data-default="bell">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_bell" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_bell" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_damage">DAMAGE</span></div>
            <input id="boarder_damage_range" class="form-range form-control input_range" type="range" value="0" min="0" max="200" data-tool="boarder" data-key="boarder_damage" data-default="0">
            <div class="input-group-text input_value">
                <span id="boarder_damage_text">0</span>
                <input id="boarder_damage_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_damage" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="boarder" data-key="boarder_damage" data-value="1">+1</button>
        </div>
        <div class="text-center m-2">
            <button class="btn btn-light reset_button" data-tool="boarder">リセット</button>
        </div>
    </fieldset>
</div>
