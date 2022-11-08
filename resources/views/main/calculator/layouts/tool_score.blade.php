<div id="scoretool" class="tool_contents">
    <div class="mt-2 mb-2">
        <p class="m-0">それぞれのノーツ数からTcスコアを計算します</p>
    </div>
    <hr />
    <fieldset class="mt-2 mb-0">
        <div class="input-group">
            <div class="input-group-text"><span class="style_critical">CRITICAL</span></div>
            <span id="score_critical_text" class="form-control fs-3">0</span>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_break">BREAK</span></div>
            <input id="score_break_range" class="form-range form-control input_range" type="range" value="0" min="0" max="99" data-tool="score" data-key="score_break" data-default="0">
            <div class="input-group-text input_value">
                <span id="score_break_text">0</span>
                <input id="score_break_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_break" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_break" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_hit">HIT</span></div>
            <input id="score_hit_range" class="form-range form-control input_range" type="range" value="0" min="0" max="99" data-tool="score" data-key="score_hit" data-default="0">
            <div class="input-group-text input_value">
                <span id="score_hit_text">0</span>
                <input id="score_hit_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_hit" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_hit" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_miss">MISS</span></div>
            <input id="score_miss_range" class="form-range form-control input_range" type="range" value="0" min="0" max="99" data-tool="score" data-key="score_miss" data-default="0">
            <div class="input-group-text input_value">
                <span id="score_miss_text">0</span>
                <input id="score_miss_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_miss" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_miss" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_bell">BELL</span></div>
            <input id="score_bell_range" class="form-range form-control input_range" type="range" value="0" min="0" max="99" data-tool="score" data-key="score_bell" data-default="bell">
            <div class="input-group-text input_value">
                <span id="score_bell_text" data-default="bell">0</span>
                <input id="score_bell_value" class="d-none" value="0" data-default="bell">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_bell" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_bell" data-value="1">+1</button>
        </div>
        <div class="input-group align-items-center">
            <div class="input-group-text"><span class="style_damage">DAMAGE</span></div>
            <input id="score_damage_range" class="form-range form-control input_range" type="range" value="0" min="0" max="99" data-tool="score" data-key="score_damage" data-default="0">
            <div class="input-group-text input_value">
                <span id="score_damage_text">0</span>
                <input id="score_damage_value" class="d-none" value="0" data-default="0">
            </div>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_damage" data-value="-1">-1</button>
            <button class="btn btn-outline-secondary fs-75p input_button" data-tool="score" data-key="score_damage" data-value="1">+1</button>
        </div>
    </fieldset>
    <hr />
    <fieldset class="mt-2 mb-0">
        <legend>計算結果</legend>
        <div class="input-group">
            <div class="input-group-text">Tcスコア</div>
            <span class="form-control fs-3"><span id="score_result" class="style_result">0</span></span>
        </div>
        <div class="text-center m-2">
            <button class="btn btn-light reset_button" data-tool="score">リセット</button>
        </div>
    </fieldset>
</div>
