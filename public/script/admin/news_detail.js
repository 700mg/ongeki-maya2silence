/* made by maya2silence.com */
const eventStart = /iphone|ipod|ipad|android/.test(navigator.userAgent.toLowerCase()) ? "touchstart" : "mousedown";

document.addEventListener("DOMContentLoaded", function () {
    editBtn.addEventListener("click", toggleBtn);
    submitBtn.addEventListener("click", submitForm);
});

function toggleBtn() {
    document.querySelectorAll("div.submit_btn").forEach(e => {
        e.classList.toggle('d-block');
        e.classList.toggle('d-none');
    });
    document.querySelector("form.main_form>fieldset").disabled = false;
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
