<div id="ratingtool" class="tool_contents">
    <div class="mt-2 mb-2">
        <p class="m-0">定数とスコアから楽曲レート値を計算します</span>
    </div>
    <hr />

    <fieldset class="mt-2 mb-0">
        <div class="col-8 m-auto mb-3">
            <div class="text-center"><span class="fs-75p">範囲:940,000~1,010,000</span></div>
            <div class="input-group col-sm-8">
                <span class="input-group-text">Tcスコア</span>
                <input id="rate_tcscore_value" class="form-control text-center" type="number" inputmode="numeric" value="1000000" min="940000" max="1010000" data-default="1000000">
                <input id="rate_tcscore_range" class="d-none" type="range" step="10" value="1000000" min="940000" max="1010000" data-default="1000000">
            </div>
            <div class="text-center m-2">
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_tcscore" data-value="-100">-100</button>
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_tcscore" data-value="-10">-10</button>
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_tcscore" data-value="10">+10</button>
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_tcscore" data-value="100">+100</button>
            </div>
            <a class="collapsed mt-1 mb-1 d-inline-flex align-items-center" onclick="" data-bs-toggle="collapse" href="#rate_tcscore_button" aria-controls="#rate_tcscore_button" aria-expanded="false">
                ショートカット<span class="collapse_icon"></span>
            </a>
            <div class="collapse" id="rate_tcscore_button">
            <div class="text-center mb-1">
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="1007500">SSS+</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="1000000">SSS</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="990000">SS</button>
                <button class="btn btn-light pt-1 pb-1 boarder_input_btn fs-75p shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="970000">S</button>
            </div>
            <div class="text-center">
                <button class="btn btn-light fs-75p boarder_input_btn shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="1009000">'9000</button>
                <button class="btn btn-light fs-75p boarder_input_btn shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="1005000">'5000</button>
                <button class="btn btn-light fs-75p boarder_input_btn shortcut_button" data-tool="rate" data-key="rate_tcscore" data-value="1002000">'2000</button>
            </div>
            </div>
        </div>
        <div class="col-8 m-auto mb-3">
            <div class="text-center"><span class="fs-75p">範囲:0.1~15.9</span></div>
            <div class="input-group">
                <span class="input-group-text">定数</span>
                <input id="rate_const_value" class="form-control text-center" type="number" step="0.1" inputmode="numeric" value="14.5" min="0.1" max="15.9" data-default="14.5">
                <input id="rate_const_range" class="d-none" type="range" step="0.1" value="14.5" min="0.1" max="15.9" data-default="14.5">
            </div>
            <div class="text-center m-1">
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_const" data-value="-1">-1</button>
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_const" data-value="-0.1">-0.1</button>
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_const" data-value="0.1">+0.1</button>
                <button class="btn btn-outline-secondary fs-75p input_button" data-tool="rate" data-key="rate_const" data-value="1">+1</button>
            </div>
        </div>
    </fieldset>
    <hr />
    <fieldset class="mt-2 mb-0">
        <legend>計算結果</legend>
        <div class="input-group">
            <div class="input-group-text">曲レート</div>
            <span class="form-control fs-3"><span id="rate_result" class="style_result">0</span></span>
        </div>
    </fieldset>
</div>
