/*--------------------------*/
/* made by maya2silence.com */
/*--------------------------*/

let song_detail; // あ

document.addEventListener("DOMContentLoaded", function () {
    // 楽曲情報とかとか。 初期化を兼ねてる為にgsdは即時実行
    get_song_data();
    song_title.addEventListener("change", get_song_data);
    document.querySelectorAll("input[name='difficult']").forEach(e => e.addEventListener("change", set_song_data));
    document.querySelectorAll("select.song_search_select").forEach(e => e.addEventListener("change", song_filtering));

    // 各レンジ、調整ボタン、リセットボタン用イベントリスナ
    document.querySelectorAll("input.input_range").forEach(e => e.addEventListener("input", input_range));
    document.querySelectorAll("button.input_button").forEach(e => e.addEventListener("click", input_button));
    document.querySelectorAll("button.reset_button").forEach(e => e.addEventListener("click", reset_button));
    document.querySelectorAll("button.shortcut_button").forEach(e => e.addEventListener("click", shortcut_button));

    //
    document.querySelectorAll("*[data-tool='boarder']").forEach(e => e.addEventListener("input", boarder_culc));
    document.querySelectorAll("*[data-tool='score']").forEach(e => e.addEventListener("input", score_culc));

    //
    search_submit.addEventListener("click", search_song);
});

// データ取得処理
var get_song_data = function () {
    const body = JSON.stringify({ id: song_title.value });
    const method = "POST";
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
    fetch(SONG_DATA_URL, { method, headers, body }).then((res) => res.json()).then(
        e => {
            song_detail = e;
            const DIFFICULT = ["lunatic", "basic", "advanced", "expert", "master"];
            DIFFICULT.forEach(d => {
                document.getElementById(`difficult_${d}`).disabled = isEmpty(e[d]) ? true : false;
                document.getElementById(`difficult_${d}`).checked = isEmpty(e[d]) ? false : true;
            });
            function isEmpty(arr) { return (arr.note && arr.bell) ? false : true; }
        }
    ).then(set_song_data).catch(console.error);
}

// 取得したデータを色々とセットアップ
var set_song_data = function () {
    // 登録されていない難易度は無効化してるはずだから選択されるはずがない
    const song = song_detail;
    let elm_diff = document.querySelector("input[name='difficult']:checked"),
        nowSelDiff = elm_diff == null ? null : elm_diff.value,
        flag_diff = false;

    song_status.classList.add("d-none");
    // 念の為にね
    if (!song || !song.hasOwnProperty(nowSelDiff) || (!song[nowSelDiff].note && !song[nowSelDiff].bell)) flag_diff = true;
    notes_value.value = flag_diff ? 0 : song[nowSelDiff].note;
    bells_value.value = flag_diff ? 0 : song[nowSelDiff].bell;
    const_value.value = flag_diff ? 0 : song[nowSelDiff].const;
    if (flag_diff) {
        const modal = bootstrap.Modal.getOrCreateInstance(modal_song_notfound);
        modal.show();
    }
    tool_init();
}

// 検索機能
var search_song = function () {
    const body = JSON.stringify({ keywords: keywords.value });
    const method = "POST";
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
    fetch(SONG_SEARCH_URL, { method, headers, body }).then((res) => res.json()).then(res => {
        if (res.hasOwnProperty("errors")) search_result.innerText = res.message;
        else {
            // どの難易度があるのかもやりたいなぁ
            search_result.innerHTML = "";
            res.forEach(r => {
                let e = document.createElement("a");
                e.textContent = r.title;
                e.classList = "search_result_btn";
                e.dataset.value = r.id;
                e.addEventListener("click", set_search_result);
                search_result.appendChild(e);
            });
        }
    }).catch(console.error);
}

var set_search_result = function () {
    // イベントリスナを解除してから中身を消す(一応)
    document.querySelectorAll("a.search_result_btn").forEach(e => e.removeEventListener("click", set_search_result));
    keywords.value = search_result.innerHTML = "";

    // 選択中の楽曲を切り替え
    song_title.value = this.dataset.value;

    // なんかこうしないと動かない、ドキュメントと違うんだけど何故?
    const modal = bootstrap.Modal.getOrCreateInstance(modal_song_search);
    modal.hide();

    get_song_data();
}

// なんかアレ
var song_filtering = function () {
    let cat_val = song_category.value,
        ver_val = song_version.value;

    // iOS対策でoptionをspanで囲う、jQuery以外で解決できない為妥協
    if (cat_val == "all" && ver_val == "all") {
        song_title.querySelectorAll("option").forEach(e => { if (e.parentNode.className == "sel_hidden") $(e).unwrap(); });
    } else if (cat_val == "all" || ver_val == "all") {
        let key = cat_val == "all" ? "version" : "category",
            val = key == "category" ? cat_val : ver_val;
        song_title.querySelectorAll("option").forEach(e => {
            if (e.dataset[key] != val && e.parentNode.className != "sel_hidden")
                $(e).wrap('<span class="sel_hidden">');
            else if (e.dataset[key] == val && e.parentNode.className == "sel_hidden")
                $(e).unwrap();
            else return false;
        });
    } else {
        song_title.querySelectorAll("option").forEach(e => {
            if (e.dataset.category == cat_val && e.dataset.version == ver_val && e.parentNode.className == "sel_hidden")
                $(e).unwrap();
            else if ((e.dataset.category != cat_val || e.dataset.version != ver_val) && e.parentNode.className != "sel_hidden")
                $(e).wrap('<span class="sel_hidden">');
            else return false;
        });
    }
}

// 調整レンジ処理
var input_range = function () {
    let toolType = this.dataset.tool,
        keyType = this.dataset.key;

    document.getElementById(`${keyType}_value`).value = this.value;
    if (document.getElementById(`${keyType}_text`)) document.getElementById(`${keyType}_text`).innerText = this.value;

    // 選択中のツール計算処理を実行 コレ以外になにか手はある...?
    eval(`${toolType}_culc()`);
}

// 調整ボタン処理
var input_button = function () {
    let toolType = this.dataset.tool,
        keyType = this.dataset.key,
        btnValue = Number(this.dataset.value);

    if (keyType == "notes" || keyType == "bells") {
        let e = document.getElementById(`${keyType}_value`),
            v = Math.ceil((Number(e.value) + Number(btnValue)) * 10) / 10;
        if (toolType == "notes" || toolType == "bells") song_status.classList.remove("d-none");
        if (e.max <= v || e.min >= v) e.max <= v ? e.value = e.max : e.value = e.min;
        else e.value = v;
        tool_init();
        return;
    } else {
        document.getElementById(`${keyType}_range`).value = Number(document.getElementById(`${keyType}_value`).value) + Number(btnValue);
        document.getElementById(`${keyType}_value`).value = Number(document.getElementById(`${keyType}_range`).value);
        if (document.getElementById(`${keyType}_text`)) document.getElementById(`${keyType}_text`).innerText = document.getElementById(`${keyType}_value`).value;

        // 選択中のツール計算処理を実行 コレ以外になにか手はある...?
        eval(`${toolType}_culc()`);
        return;
    }
}

var shortcut_button = function () {
    let toolType = this.dataset.tool,
        keyType = this.dataset.key,
        btnValue = Number(this.dataset.value);

    document.getElementById(`${keyType}_range`).value = Number(btnValue);
    document.getElementById(`${keyType}_value`).value = Number(document.getElementById(`${keyType}_range`).value);
    if (document.getElementById(`${keyType}_text`)) document.getElementById(`${keyType}_text`).innerText = document.getElementById(`${keyType}_value`).value;
    // 選択中のツール計算処理を実行 コレ以外になにか手はある...?
    eval(`${toolType}_culc()`);
    return;
}

// リセット処理
var reset_button = function (n = null) {
    let toolType = (typeof (n) === "string" || n instanceof String) ? n : this.dataset.tool,
        bellVal = toolType != "rate" ? document.querySelector(`input[id^=${toolType}_bell_range]`).max : null;

    document.querySelectorAll(`input[id^=${toolType}]`).forEach(e => e.value = e.dataset.default == "bell" ? bellVal : e.dataset.default);
    document.querySelectorAll(`span[id^=${toolType}][id$=text]`).forEach(e => e.innerText = e.dataset.default == "bell" ? bellVal : "0");

    // 値を0に戻すため一度計算
    eval(`${toolType}_culc()`);
}

// 以下ボーダー計算処理
var gs, gb;
var tool_init = function () {
    let n = Number(notes_value.value),
        b = Number(bells_value.value);

    gs = Number(950000 / n);
    gb = Number(60000 / b);

    boarder_init();
    score_init();
    rate_init();
    reset_button("boarder");
    reset_button("score");
    rate_culc();
    return;
}

var boarder_init = function () {
    // 無理やりw
    boarder_bell_value.max = boarder_bell_range.max = boarder_bell_text.innerText = bells_value.value;
    boarder_bell_value.value = boarder_bell_range.value = bells_value.value;

    return;
}

var boarder_culc = function () {
    let h = Number(boarder_hit_value.value) * 4,            // Hit
        m = Number(boarder_miss_value.value) * 10,          // Miss
        b = Number(boarder_bell_value.value),               // Bell
        d = Number(boarder_damage_value.value) * 10,        // Damage
        t = 1010000 - Number(boarder_tcscore_value.value);  // Target Score

    let bl = Math.floor(60000 - (gb * b)),  // bell loss point
        pt = Math.floor((t - bl - d) / gs * 10);       // ded point

    boarder_result.innerText = pt - h - m;
    return;
}

var score_init = function () {
    // 無理やりw
    score_bell_value.max = score_bell_range.max = score_bell_text.innerText = bells_value.value;
    score_bell_value.value = score_bell_range.value = bells_value.value;
    return;
}

var score_culc = function () {
    let r = Number(score_break_value.value),
        h = Number(score_hit_value.value),
        m = Number(score_miss_value.value),
        b = Number(score_bell_value.value),
        d = Number(score_damage_value.value),
        c = Number(notes_value.value) - r - h - m;

    score_critical_text.innerText = c;
    score_result.innerText = Math.floor(((c + (r * 0.9) + (h * 0.6)) * gs) + (gb * b) - (d * 10));
    return;
}

var rate_init = function () {
    // 無理やりw
    rate_const_range.value = const_value.value;
    rate_const_value.value = const_value.value;
    return;
}

var rate_culc = function () {
    let s = Number(rate_tcscore_value.value),
        t = s - 970000,
        c = Number(rate_const_value.value),
        r = Number(0);

    // ifの方が楽そう
    if (t < 30000) r = Math.floor(t / 200) / 100;
    else if (t >= 30000 && t < 37500) r = (Math.floor((t - 30000) / 150) / 100) + 1.5;
    else if (t >= 37500) r = 2.0;

    if (isNaN(r) || (s < 0 || s > 1010000)) rate_result.innerText = "計算できません";
    else rate_result.innerText = (Number(c) + r).toFixed(2);
    return;
}
