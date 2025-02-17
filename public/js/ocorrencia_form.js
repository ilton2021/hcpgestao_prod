//Pesquisa select
$(document).ready(function () {
    $(".js-example-basic-single").select2();
});

$(document).ready(function () {
    $(".js-example-basic-multiple").select2();
});
// Função para ajustar automaticamente tamanho dos inputs textarea
function ajustarTextArea(textarea) {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
}
document.querySelectorAll("textarea").forEach((textarea) => {
    textarea.addEventListener("input", () => {
        ajustarTextArea(textarea);
    });
});
//
// Contador de caractere do campo descrição_evento
const campo = document.getElementById("descrição_evento");
const contador = document.getElementById("contador");
const limite = parseInt(campo.getAttribute("maxlength"));

campo.addEventListener("input", () => {
    const caracteresDigitados = campo.value.length;
    contador.innerHTML = `${caracteresDigitados}/${limite}`;

    if (caracteresDigitados >= limite) {
        contador.style.color = "red";
        campo.value = campo.value.slice(0, limite);
    } else {
        contador.style.color = "";
    }
});
//
// Contador de caractere do campo acao_imediata
const campo_ = document.getElementById("acao_imediata");
const contador_ = document.getElementById("contador_2");
const limite_ = parseInt(campo_.getAttribute("maxlength"));

campo_.addEventListener("input", () => {
    const caracteresDigitados_ = campo_.value.length;
    contador_.innerHTML = `${caracteresDigitados_}/${limite_}`;

    if (caracteresDigitados_ >= limite_) {
        contador_.style.color = "red";
        campo_.value = campo_.value.slice(0, limite_);
    } else {
        contador_.style.color = "";
    }
});
//


