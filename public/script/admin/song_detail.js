/* made by maya2silence.com */
const eventStart = /iphone|ipod|ipad|android/.test(navigator.userAgent.toLowerCase()) ? "touchstart" : "mousedown";

function detailEdit() {
    document.querySelectorAll("div.detail_btn").forEach(e => {
        e.classList.toggle('d-block');
        e.classList.toggle('d-none');
    });
    document.querySelector("div.img_outer").classList.add("editing");
    document.querySelector("form.detail fieldset").disabled = false;

    i_jacket.addEventListener("change", function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("img#jacket").attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    })
    document.querySelector("div.img_outer").addEventListener(eventStart, function (e) {
        var openInput = (function () {
            i_jacket.click();
            return false;
        })();
    });

}
function difficultEdit() {
    document.querySelectorAll("div.difficult_btn").forEach(e => {
        e.classList.toggle('d-block');
        e.classList.toggle('d-none');
    });
    document.querySelector("form.difficult>fieldset").disabled = false;
}

function sendForm(type) {
    const cfm = confirm("この内容で保存しますか?");
    if (!cfm) return;
    document.querySelector("." + type + ".form").submit();
}

function deleteData(){
    const cfm = confirm("本当に削除してよろしいですか?");
    if (!cfm) return;
    song_delete.submit();
}
