/* made by maya2silence.com */
const eventStart = /iphone|ipod|ipad|android/.test(navigator.userAgent.toLowerCase()) ? "touchstart" : "mousedown";

document.addEventListener("DOMContentLoaded", function () {
    // toggle input btn
    document.querySelectorAll("label.checkbox_btn").forEach((e) => e.addEventListener(eventStart, toggleBtn));
});

function toggleBtn() {
    this.classList.toggle("checked");
}

function toggleText(e) {
    if (e.classList.contains("collapsed")) e.innerText = "閉じる";
    else e.innerText = "絞込み検索";
}
