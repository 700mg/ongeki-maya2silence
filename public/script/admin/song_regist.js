/* made by maya2silence.com */
const eventStart = /iphone|ipod|ipad|android/.test(navigator.userAgent.toLowerCase()) ? "touchstart" : "mousedown";

document.addEventListener("DOMContentLoaded", function () {
    inputJacket.addEventListener("change", detectedChangeJacket);
    submitBtn.addEventListener(eventStart, submitForm);

    let valueRequired = ["title", "jacket"];
    valueRequired.forEach(w => {
        document.querySelector(`input[name='${w}']`).addEventListener("input", inputMonitoring);
    });
});

const detectedChangeJacket = function () {
    let reader = new FileReader(),
        label = this.nextElementSibling;

    if (!this.files[0]) {
        label.innerText = "選択して下さい";
        imgJacket.removeAttribute("src");
        return;
    } else {
        reader.onload = function (e) {
            imgJacket.src = e.target.result;
            imgJacket.onload = function () {
                jacketResolution.innerText = `解像度: ${imgJacket.naturalHeight}x${imgJacket.naturalWidth}`;
            }
        }
        reader.readAsDataURL(this.files[0]);
        label.innerText = this.files[0].name;
    }
}

const inputMonitoring = function () {
    if (!this.value) this.classList.add("is-invalid");
    else this.classList.remove("is-invalid");
}

const submitForm = function () {
    // 強引
    let isEmpty = false;
    [document.querySelector("input[name='title']"),
    document.querySelector("input[name='jacket']")].forEach(e => {
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
