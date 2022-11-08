/* made by maya2silence.com */
const eventStart = /iphone|ipod|ipad|android/.test(navigator.userAgent.toLowerCase()) ? "touchstart" : "mousedown";

document.addEventListener("DOMContentLoaded", function () {
    submitBtn.addEventListener(eventStart, submitForm);

    let valueRequired = ["header", "contents"];
    valueRequired.forEach(w => {
        document.querySelector(`*[name='${w}']`).addEventListener("input", inputMonitoring);
    });
});

const inputMonitoring = function () {
    if (!this.value) this.classList.add("is-invalid");
    else this.classList.remove("is-invalid");
}

const submitForm = function () {
    // 強引
    let isEmpty = false;
    [document.querySelector("input[name='header']"),
    document.querySelector("textarea[name='contents']")].forEach(e => {
        e.classList.remove("is-invalid");
        if (!e.value) {
            e.classList.add("is-invalid");
            isEmpty = true;
        }
    });

    if (!isEmpty) {
        if (!confirm("この内容で保存しますか?")) return;
        else document.querySelector("form.main_form").submit();
    }
}

const addInputTag = function () {
    let input = document.createElement("input");
    input.setAttribute("type", "file");
    input.setAttribute("class", "mb-1");
    input.setAttribute("accept", ".jpg,.png");
    input.setAttribute("name", "images[]");
    files_column.appendChild(input);
}
