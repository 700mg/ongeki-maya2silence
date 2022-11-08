/*--------------------------*/
/* made by maya2silence.com */
/*--------------------------*/

const ua = navigator.userAgent.toLowerCase();
const isSP = /iphone|ipod|ipad|android/.test(ua);
const isiOS = /iphone|ipod|ipad/.test(ua);
const eventStart = isSP ? 'touchstart' : 'mousedown';
const eventEnd = isSP ? 'touchend' : 'mouseup';
const eventLeave = isSP ? 'touchmove' : 'mouseleave';

document.addEventListener("DOMContentLoaded", function () {
    console.log("Initialize start...");
    // ジャケットサイズ変更
    jacket_size_range.addEventListener("input", changeJacketSize);
    // Exp,Lun非表示ボタン
    document.querySelectorAll("input.toggleHideDiffBtn").forEach(e => e.addEventListener("change", hiddenJacket));
    // Exp,Lun非表示ボタン
    document.querySelectorAll("input[name='option_sort']").forEach(e => e.addEventListener("change", toggleSortDisp));
    // 楽曲検索ボタン
    search_submit.addEventListener("click", searchForKeyword);
    // タイトル
    toggleDispTitle_check.addEventListener("change", toggleDispTitle);
    // 枠の斜線有効化ボタン
    toggleEnableSlash_check.addEventListener("change", toggleEnableSlash);
    // ジャケット画像のアレ
    document.querySelectorAll(".wrapper").forEach(function (o) {
        o.addEventListener(eventStart, () => touched = true);
        o.addEventListener(eventEnd, changeFlag);
        o.addEventListener(eventLeave, () => touched = false);
        o.addEventListener("long-press", dispSongData);
    });
    // スマホだったらジャケサイズを50に変更
    jacket_size_range.value = isSP ? 50 : 75;
    checkFlagCount();
    changeJacketSize();
    if (!SHARE_DATA.length) loadFromLocal();
    else _fill(SHARE_DATA);
    console.log("Initialize done.");
});

// 解像度が変わった時に自動サイズ変更
window.onresize = function () {
    console.log("Detect DisplaySize changes.");
    // if (window.innerWidth < 768) jacket_size_range.value = 50;
    // else jacket_size_range.value = 75;
    // changeJacketSize();
}

var toggleDispTitle = function () {
    // toggleを使わない処理が面倒そうだからjQueryを使う
    $(".label_title").toggle();
}

var toggleEnableSlash = function () {
    // toggleを使わない処理が面倒そうだからjQueryを使う
    $(".slash").toggle();
}

// ジャケットサイズ変更
var changeJacketSize = function () {
    let size = jacket_size_range.value,
        persent = size / 100,
        cssRules = [].slice.call(document.styleSheets).filter(e => { return e.title == "table_style" })[0].cssRules;

    // 察して
    jacket_size_text.innerText = size;

    // ややこしいし弄らなくてもいいかな
    for (let i = 0; i < cssRules.length; i++) {
        let css = cssRules[i];
        if (css.media) continue;
        if (!css.selectorText) continue;
        if (css.selectorText == ".jacket") {
            css.style.width = size + "px";
            css.style.height = size + "px";
            css.style.margin = Math.floor(10 * persent) + "px";
        } else if (css.selectorText == ".slash") {
            css.style.width = Math.floor(10 * persent) + Number(size) + "px";
            css.style.height = Math.floor(10 * persent) + Number(size) + "px";
        } else if (css.selectorText.indexOf(".checked") != -1) {
            if (css.selectorText != ".checked4") {
                css.style.borderWidth = Math.round(7 * persent + 1) + "px";
                css.style.margin = Math.floor(10 * persent - 7 * persent) + "px";
            }
        } else if (css.selectorText == ".wrapper") {
            css.style.height = Math.round(122 * persent) + "px";
            css.style.width = Math.round(122 * persent) + "px";
        }
    }
}

// 定数とVer別切り替え
var toggleSortDisp = function () {
    // toggleを使わない処理が面倒そうだからjQueryを使う
    $(table_const).toggle();
    $(table_version).toggle();
}

// タップでフラグ切り替え
let touched = false;
var changeFlag = function () {
    if (touched) {
        touched = false;
        // querySelectorAllにしてるのは、対象が定数とバージョンの2つ存在するため
        let i = this.dataset.sid,
            f = Number(this.dataset.flag),
            w = document.querySelectorAll(`div.wrapper[data-sid='${i}']`),
            e = document.querySelectorAll(`div.wrapper[data-sid='${i}']>div.jacket`);

        // check1~3は同じ処理
        if (f >= 1 && f <= 3) {
            let s = f + 1;
            e.forEach(o => {
                o.classList.toggle(`checked${f}`);
                o.classList.toggle(`checked${s}`);
                slashColor(o.nextElementSibling, s);
            });
            w.forEach(() => this.dataset.flag = s);
        } else {
            e.forEach(o => {
                o.classList.toggle(`checked${(f == 4) ? 4 : 1}`);
                slashColor(o.nextElementSibling, (f == 4) ? 0 : 1);
            });
            w.forEach(() => this.dataset.flag = (f == 4) ? 0 : 1);
        }
    }
    checkFlagCount();
    if (toggleAutoSave_check.checked) saveToLocal();
}

// 曲の情報とかをモーダルで表示
var dispSongData = function () {
    const body = JSON.stringify({ id: this.dataset.sid });
    const method = "POST";
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
    fetch(SONG_DATA_URL, { method, headers, body }).then((res) => res.json()).then(e => {
        song_info_jacket.src = e.jacket_src;
        song_info_title.innerText = e.title;
        song_info_artist.innerText = e.artist;
        song_info_date.innerText = e.date;
        song_info_version.innerText = e.version;
        song_info_category.innerText = e.category;
        //song_info_sdvxin.innerText = e.sdvx_in;
        //song_info_sdvxin.href = e.sdvx_in;
        song_info_database.href = SONG_DATABASE_URL + e.id;
        // 何事もなかったらモーダルを表示
        const modal = bootstrap.Modal.getOrCreateInstance(modal_song_info);
        modal.show();
    }).catch(console.error);
}

// 検索機能
var searchForKeyword = function () {
    const body = JSON.stringify({ keywords: keywords.value, lv: lv });
    const method = "POST";
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
    fetch(SONG_SEARCH_URL, { method, headers, body }).then((res) => res.json()).then(res => {
        // サーバーと正常通信できたら処理
        search_result.innerHTML = "";
        if (res.hasOwnProperty("errors")) search_result.innerText = res.message;
        else {
            if (!res.length) search_result.innerText = "見つかりませんでした";
            else
                res.forEach(e => {
                    let cd = document.createElement("div"),
                        ci = document.createElement("img"),
                        ca = document.createElement("a");

                    cd.className = "row align-items-center justify-contents-center search_result_list";
                    cd.onclick = function () {
                        let w = document.querySelectorAll(`div.wrapper[data-id='${e.id}']`),
                            b = document.createElement("div");

                        // タップしたときに背景を暗くして、対象だけを全面表示する
                        if (document.getElementById("search_bg")) removeSearchClass();

                        b.id = "search_bg";
                        b.addEventListener("click", removeSearchClass);
                        document.body.appendChild(b);

                        // 定数バージョンどっちでも対応させるためにここもforEach
                        w.forEach(f => {
                            f.classList.add("search-targets");
                            f.addEventListener("click", removeSearchClass);
                        });

                        // モーダル閉じる
                        bootstrap.Modal.getOrCreateInstance(modal_search).hide();

                        // 移動
                        let nowDisp = $("#table_const").is(":visible") ? "c" : "v",
                            posTop = document.getElementById(`${nowDisp}_${e.id}`).getBoundingClientRect().top,
                            posOffset = window.pageYOffset - (window.innerHeight / 2);

                        window.scrollTo({ left: 0, top: posTop + posOffset, behavior: 'smooth' });

                        // 綺麗サッパリ
                        keywords.value = "";
                        search_result.innerHTML = "";
                    }
                    // 各種情報追加
                    ci.className = "col-2";
                    ci.src = e.jacket_src;  // ジャケ画像
                    ca.className = "col-8";
                    ca.innerText = e.title; // タイトル
                    // 検索結果に追加
                    cd.appendChild(ci);
                    cd.appendChild(ca);
                    search_result.appendChild(cd);

                    function removeSearchClass() {
                        // イベントリスナを解除してからエレメントを消す、念のため
                        search_bg.removeEventListener("click", removeSearchClass);
                        search_bg.remove();
                        document.querySelectorAll(".search-targets").forEach(s => {
                            s.removeEventListener("click", removeSearchClass);
                            s.classList.remove("search-targets");
                        });
                    }
                });
        }
    }).catch(console.error);
    return;
}

// 斜線の色を強引に変える関数
var slashColor = function (e, c) {
    if (c == 0) {
        $(e).attr("class", "slash");
    } else if (c == 1 || c == "checked1") {
        $(e).addClass("s_green");
    } else if (c == 2 || c == "checked2") {
        $(e).removeClass("s_green");
        $(e).addClass("s_red");
    } else if (c == 3 || c == "checked3") {
        $(e).removeClass("s_red");
        $(e).addClass("s_blue");
    } else if (c == 4 || c == "checked4") {
        $(e).removeClass("s_blue");
        $(e).addClass("s_clear");
    }
}

// フラグ数をカウントするやつ
var checkFlagCount = function () {
    // querySelectorよりgetElementsの方が早いらしい
    let g = c_green.innerHTML = document.getElementsByClassName("checked1").length / 2,
        r = c_red.innerHTML = document.getElementsByClassName("checked2").length / 2,
        b = c_blue.innerHTML = document.getElementsByClassName("checked3").length / 2,
        c = c_clear.innerHTML = document.getElementsByClassName("checked4").length / 2;

    c_total.innerHTML = document.getElementsByClassName("jacket").length / 2;
    c_sum.innerHTML = parseInt(r + g + b + c);
}

// セーブデータ書き込み
var saveToLocal = function () {
    let jacket = document.querySelectorAll("div[id*='c_']>div.jacket[class*='checked']"),
        data = { songs: [] };

    jacket.forEach(e => {
        let p = e.parentNode.dataset,
            c = {};
        c.sid = p.sid;
        c.chk = p.flag;
        data.songs.push(c);
    });

    localStorage.setItem("maya2_ongeki_lv" + lv, JSON.stringify(data));
    modal_message_text.innerText = "保存しました";
    // 何事もなかったらモーダルを表示
    const modal = bootstrap.Modal.getOrCreateInstance(modal_message);
    if (toggleAutoSave_check.checked) return;
    modal.show();
}

// セーブデータ読み込み
var loadFromLocal = function () {
    const ls = localStorage.getItem("maya2_ongeki_lv" + lv);
    if (!ls) return;

    const data = JSON.parse(ls);
    if (!data.songs.length) return;
    const d = data.songs;

    // Array.filterを使うべきなんだろうけどステップ数考えるとforEachが楽そう。知らんけど
    let jacket = [].slice.call(document.querySelectorAll(`div.wrapper>div.jacket`));
    jacket.forEach(e => {
        let sid = e.parentNode.dataset.sid,
            x;
        if (x = d.find(e => { return e.sid == sid })) {
            const regExp = new RegExp(/\bchecked\d/);
            const regMatch = e.className.match(regExp);
            // 一度クラスを消す
            if (regMatch) e.classList.remove(regMatch);
            e.classList.add(`checked${x.chk}`);
            e.parentNode.dataset.flag = x.chk;
            slashColor(e.nextElementSibling, x.chk);
        } else {
            for (let i = 1; i <= 4; i++) {
                e.classList.remove("checked" + i);
                slashColor(e.nextElementSibling, 0);
            }
        }
    });
    checkFlagCount();
}

// フラグリセット
var resetJacketFlag = function () {
    let j = document.querySelectorAll("div.wrapper:not([data-sid='0'])");
    j.forEach((w) => {
        w.dataset.flag = "0";
        let e = w.querySelector("div.jacket");
        for (let i = 1; i <= 4; i++) {
            e.classList.remove("checked" + i);
            slashColor(e.nextElementSibling, 0);
        }
    });
    checkFlagCount();
}

// Expertとかを非表示にする処理
var hiddenJacket = function () {
    let t = this.value,
        elm = document.querySelectorAll(`div[class='jacket']>div[class*='${t}']`);
    elm.forEach(e => e.parentNode.parentNode.classList.toggle("hidden"));
}

// 自動塗りつぶし
var autoFill = function (songs) {
    resetJacketFlag();

    // 塗りつぶせなかった楽曲
    let missing = [];

    if (!Object.keys(songs).length) return;
    Object.keys(songs).forEach((key) => {
        songs[key].forEach((song) => {
            let i = song,
                c = key == "green" ? 1 : key == "red" ? 2 : key == "blue" ? 3 : 4,
                w = document.querySelectorAll(`div.wrapper[data-sid='${i}']`),
                e = document.querySelectorAll(`div.wrapper[data-sid='${i}']>div.jacket`);

            if (w.length == 0) {
                missing.push(i);
                return false;
            }

            w.forEach((o) => o.dataset.flag = c);
            e.forEach((o) => {
                o.classList.add(`checked${c}`);
                slashColor(o.nextElementSibling, c);
            });
        });
    });

    if (missing.length) {
        let t = "<ul style='font-weight:normal'>";
        missing.forEach(m => {
            t += "<li style='text-align: left;'>" + m + "</li>";
        });
        t += "</ul>";
        fill_result_success.classList.add("d-none");
        fill_result_warning.classList.remove("d-none");
        fill_result_warning.innerHTML = "以下の曲が塗りつぶせませんでした<br>" + t;
    } else {
        fill_result_success.classList.remove("d-none");
        fill_result_warning.classList.add("d-none");
    }
    checkFlagCount();
    return;
}

// ongeki-score.logにデータを問い合わせるやつ
let fetchXhr;
var fetchToOSL = function () {
    if (fetchXhr) return;
    const body = JSON.stringify({ value: document.querySelector("input[name='osl_id']").value });
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
    fetchXhr = fetch(OSL_FETCH_URL, { method: "POST", headers, body }).then(handleErrors).then((r) => r.json())
        .then(onFulfilled).catch(onRejectresponse).then(() => fetchXhr = null);;

    function onFulfilled(response) {
        ac_id.value = document.querySelector("input[name='osl_id']").value;
        fill_input_alert.classList.add("d-none");
        fill_input_alert.innerText = "";
        bootstrap.Modal.getOrCreateInstance(modal_fill_input).hide();
        bootstrap.Modal.getOrCreateInstance(modal_fill_option).show();
    }
    function onRejectresponse(response) {
        fill_input_alert.classList.remove("d-none");
        fill_input_alert.innerText = response.message;
        console.error(response.message);
    }
}

// 塗りつぶし用のデータを受け取るやつ
let fillXhr;
var fillFromOSL = function () {
    if (fillXhr) return;

    const body = JSON.stringify({ "id": ac_id.value, "lv": lv, "target": _v() });
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
    fillXhr = fetch(OSL_FILL_URL, { method: "POST", headers, body }).then(handleErrors).then((r) => r.json())
        .then(onFulfilled).catch(onRejectresponse).then(() => fillXhr = null);

    function onFulfilled(response) {
        autoFill(response.data);
        bootstrap.Modal.getOrCreateInstance(modal_fill_option).hide();
        bootstrap.Modal.getOrCreateInstance(modal_fill_result).show();
    }
    function onRejectresponse(response) {
        fill_option_alert.classList.remove("d-none");
        fill_option_alert.innerText = response.message;
        console.error(response.message);
    }
    function _v() {
        // めんどくさいのでここで数合わせ
        let color = ["", "green", "red", "blue", "clear"],
            array = {};
        for (let i = 1; i <= 4; i++) {
            if (document.getElementById(`ac_flag_${i}`).checked) {
                let sc = document.getElementById(`ac_input_${i}`).value,
                    lp = [].slice.call(document.querySelectorAll(`input[name='ac_lamp_${i}']`)).filter(e => { return e.checked }).reduce((a, e) => { return +a + +e.value }, 0);
                array[color[i]] = { "value": sc, "lamp": lp };
            }
        }
        return array;
    }
}

// 画像出力
let expXhr;
var exportImage = function () {
    if (expXhr) return;

    // 定数の範囲がおかしいかチェック
    if (Number(document.querySelector("select[name=range_1]").value) > Number(document.querySelector("select[name=range_2]").value))
        document.querySelector("select[name=range_1]").parentElement.classList.add("is-invalid");
    else
        document.querySelector("select[name=range_1]").parentElement.classList.remove("is-invalid");

    const body = JSON.stringify({ value: _v(), option: _o() });
    const headers = { 'Content-Type': 'application/json', "Accept": "application/json" };
    expXhr = fetch("https://api.maya2silence.com/ongeki-export/index.php", { method: "POST", headers, body }).then(handleErrors).then((r) => r.json())
        .then(onFulfilled).catch(onRejectresponse).then(() => expXhr = null);

    function onFulfilled(response) {
        export_executeBtn.innerText = "画像出力";
        export_executeBtn.disabled = false;
        export_image.src = response.path;
        export_image.addEventListener("load", function () {
            export_loading.classList.add("d-none");
            this.classList.remove("d-none")
        });
        export_loading.classList.remove("d-none");
        bootstrap.Modal.getOrCreateInstance(modal_export_image_view).show();
    }
    function onRejectresponse(response) {
        console.error(response.message);
    }
    function _v() {
        return [].slice.call(document.querySelectorAll("#table_const .wrapper")).filter(e => { return e.dataset.flag != 0 }).map(e => { return String(e.dataset.sid + numToAlp(e.dataset.flag)) }).join();
        function numToAlp(s) { return s == 1 ? "A" : s == 2 ? "B" : s == 3 ? "C" : s == 4 ? "D" : "" }
    }
    function _o() {
        return {
            table: document.querySelector("input[name=opt_table]:checked").value,
            slash: document.querySelector("input[name=opt_shash]:checked").value,
            name: document.querySelector("input[name=t_header]").value,
            r_min: document.querySelector("select[name=range_1]").value,
            r_max: document.querySelector("select[name=range_2]").value,
            hide_exp: export_hiddenExpert.checked.toString(),
            hide_lun: export_hiddenLunatic.checked.toString(),
            hide_vanilla: export_hiddenVanilla.checked.toString()
        }
    }
}

// チェックの進捗をサーバーに保存
let stsXhr;
var saveToServer = function () {
    if (stsXhr) return;

    let status = modal_save_confirm.querySelector("[name=save_status]");
    if (!status.checked) {
        bootstrap.Modal.getOrCreateInstance(modal_option).hide();
        bootstrap.Modal.getOrCreateInstance(modal_save_confirm).show();
        status.checked = true;
    } else {
        const body = JSON.stringify({ "value": _v(), "lv": lv });
        const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
        stsXhr = fetch(DATA_SAVE_URL, { method: "POST", headers, body }).then(handleErrors).then((r) => r.json())
            .then(onFulfilled).catch(onRejectresponse).then(toggleModal).then(() => stsXhr = null);
    }

    function onFulfilled(response) {
        modal_save_confirm_result.querySelector("[name=result]").innerText = response.message;
    }
    function onRejectresponse(response) {
        modal_save_confirm_result.querySelector("[name=result]").innerText = response.message;
        console.error(response.message);
    }
    function toggleModal() {
        status.checked = false;
        bootstrap.Modal.getOrCreateInstance(modal_save_confirm).hide();
        bootstrap.Modal.getOrCreateInstance(modal_save_confirm_result).show();
    }
    function _v() {
        let jacket = document.querySelectorAll("div[id*='c_']>div.jacket[class*='checked']"),
            data = [];

        jacket.forEach(e => {
            let p = e.parentNode.dataset,
                c = {};
            c.sid = p.sid;
            c.chk = p.flag;
            data.push(c);
        });
        return data;
    }
}

// ↑の逆
let lfsXhr;
var loadFromServer = function () {
    if (lfsXhr) return;

    let status = modal_load_confirm.querySelector("[name=load_status]");
    if (!status.checked) {
        bootstrap.Modal.getOrCreateInstance(modal_option).hide();
        bootstrap.Modal.getOrCreateInstance(modal_load_confirm).show();
        status.checked = true;
    } else {
        const body = JSON.stringify({ "lv": lv });
        const headers = { 'Content-Type': 'application/json', "Accept": "application/json", 'X-CSRF-TOKEN': CSRF_TOKEN };
        lfsXhr = fetch(DATA_LOAD_URL, { method: "POST", headers, body }).then(handleErrors).then((r) => r.json())
            .then(onFulfilled).catch(onRejectresponse).then(toggleModal).then(() => lfsXhr = null);
    }

    function onFulfilled(response) {
        modal_load_confirm_result.querySelector("[name=result]").innerText = response.message;
        _fill(response.data)
    }
    function onRejectresponse(response) {
        modal_load_confirm_result.querySelector("[name=result]").innerText = response.message;
        console.error(response.message);
    }
    function toggleModal() {
        status.checked = false;
        bootstrap.Modal.getOrCreateInstance(modal_load_confirm).hide();
        bootstrap.Modal.getOrCreateInstance(modal_load_confirm_result).show();
    }
}

// fetch用ハンドラ判別関数
var handleErrors = function (response) {
    if (!response.ok)
        return response.json().then(function (err) { throw Error(err.message) });
    else
        return response;
}

var _fill = function (js) {
    // 新しく調整するのめんどくさいからコピペする
    const data = JSON.parse(js);
    if (!data.length) return;

    let jacket = [].slice.call(document.querySelectorAll(`div.wrapper>div.jacket`));
    jacket.forEach(e => {
        let sid = e.parentNode.dataset.sid,
            x;
        if (x = data.find(e => { return e.sid == sid })) {
            const regExp = new RegExp(/\bchecked\d/);
            const regMatch = e.className.match(regExp);
            // 一度クラスを消す
            if (regMatch) e.classList.remove(regMatch);
            e.classList.add(`checked${x.chk}`);
            e.parentNode.dataset.flag = x.chk;
            slashColor(e.nextElementSibling, x.chk);
        } else {
            for (let i = 1; i <= 4; i++) {
                e.classList.remove("checked" + i);
                slashColor(e.nextElementSibling, 0);
            }
        }
    });
    checkFlagCount();
}
