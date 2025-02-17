
window.onload = function () {
    $('#telefone').mask('9999-9999');
};

document.addEventListener('keydown', function (event) { //pega o evento de precionar uma tecla
    if (event.keyCode != 46 && event.keyCode !=
        8) { //verifica se a tecla precionada nao e um backspace e delete
        var i = document.getElementById("telefone").value.length; //aqui pega o tamanho do input
        if (i === 0)
            document.getElementById("telefone").value = document.getElementById("telefone").value + "(";
        if (i === 3)
            document.getElementById("telefone").value = document.getElementById("telefone").value + ")";
        if (i === 8) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
            document.getElementById("telefone").value = document.getElementById("telefone").value + "-";
    }
});

document.addEventListener('keydown', function (event) { //pega o evento de precionar uma tecla
    if (event.keyCode != 46 && event.keyCode !=
        8) { //verifica se a tecla precionada nao e um backspace e delete
        var i = document.getElementById("cnpj").value.length; //aqui pega o tamanho do input
        if (i === 2)
            document.getElementById("cnpj").value = document.getElementById("cnpj").value + ".";
        if (i === 6)
            document.getElementById("cnpj").value = document.getElementById("cnpj").value + ".";
        if (i === 10) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
            document.getElementById("cnpj").value = document.getElementById("cnpj").value + "/";
        if (i === 15) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
            document.getElementById("cnpj").value = document.getElementById("cnpj").value + "-";
    }
});

document.addEventListener('keydown', function (event) { //pega o evento de precionar uma tecla
    if (event.keyCode != 46 && event.keyCode !=
        8) { //verifica se a tecla precionada nao e um backspace e delete
        var i = document.getElementById("cep").value.length; //aqui pega o tamanho do input
        if (i === 2)
            document.getElementById("cep").value = document.getElementById("cep").value + ".";
        if (i === 6)
            document.getElementById("cep").value = document.getElementById("cep").value + "-";
    }
});

window.onload = function () {
    function ajustarTextArea(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }

    document.querySelectorAll("textarea").forEach((textarea) => {
        textarea.addEventListener("input", () => {
            ajustarTextArea(textarea);
        });

        ajustarTextArea(textarea); // Adiciona o ajuste inicial de altura para cada textarea
    });
};


var cont = 0;
qtd_capacidades = parseInt(qtd_capacidades);

var ultimoValor = "";
var inputNumero = [];
objetoJS.forEach(element => {
    if (element.descricao !== ultimoValor) {
        cont++
        // Cria o elemento div com a classe "d-flex flex-sm-column multiCapacidade" e o ID "capacidade_1"
        const divCapacidade = document.createElement('div');
        divCapacidade.setAttribute('class', 'd-sm-flex flex-sm-column multiCapacidade mt-2');
        divCapacidade.setAttribute('id', 'capacidade_' + cont);

        const inativarLista = document.createElement('input');
        inativarLista.setAttribute('type', 'hidden');
        inativarLista.setAttribute('name', 'inativar_lista_' + cont + '[]');
        inativarLista.setAttribute('id', 'inativar_lista_' + cont);
        inativarLista.value = element.id;

        // Cria o elemento div com a classe "border border-dark rounded rounded-3 p-1"
        const divBorder = document.createElement('div');
        divBorder.setAttribute('class', 'border border-dark rounded rounded-3 p-2 mt-2');

        const toggleButton = document.createElement('button');

        toggleButton.textContent = 'Definir descrição';
        toggleButton.setAttribute('type', 'button'); // Define o tipo do botão como "button"
        toggleButton.setAttribute('class', 'btn btn-dark btn-sm m-1');

        // Adiciona o manipulador de eventos ao botão
        toggleButton.addEventListener('click', function () {
            if (labelDescLista.style.display === 'none') {
                labelDescLista.style.display = 'block';
                textareaDescLista.style.display = 'block';
            } else {
                labelDescLista.style.display = 'none';
                textareaDescLista.style.display = 'none';
            }
        });

        // Cria o elemento label com o atributo for "desc_lista" e o texto "Descrição da lista de capacidades:"
        const labelDescLista = document.createElement('label');
        labelDescLista.setAttribute('for', 'desc_lista_' + cont);
        labelDescLista.style.fontWeight = 'bold';
        labelDescLista.textContent = 'Descrição da lista de capacidades: ';
        element.descricao.includes("SEM_DESC_") ? labelDescLista.setAttribute("style", "display: none;") : "";

        // Cria o elemento textarea com a classe "form-control m-1 w-100", o ID "desc_lista", o nome "desc_lista[]", e o placeholder "Describe yourself here..."
        const textareaDescLista = document.createElement('textarea');
        textareaDescLista.setAttribute('class', 'form-control m-1 w-100');
        textareaDescLista.setAttribute('id', 'desc_lista_' + cont);
        textareaDescLista.setAttribute('name', 'desc_lista_' + cont + '[]');
        textareaDescLista.setAttribute('rows', '1');
        textareaDescLista.setAttribute('placeholder',
            'Descreva uma introdução para os dados de capacidade que serão apresentados...');
        textareaDescLista.value = element.descricao;
        element.descricao.includes("SEM_DESC_") ? textareaDescLista.setAttribute("style", "display: none;") : "";

        // Cria o elemento div com a classe "d-sm-flex multiLocal"
        const divMultiLocal = document.createElement('div');
        divMultiLocal.setAttribute('class', 'd-sm-flex flex-sm-column multiLocal');

        const labelTituloItens = document.createElement('label');
        labelTituloItens.style.fontWeight = 'bold';
        labelTituloItens.textContent = 'Capacidades: ';

        var cont_itens = false;
        objetoJS.forEach(qtd_capacidades => {

            if (qtd_capacidades.descricao == element.descricao) {

                const divMultiLocalInputs = document.createElement('div');
                divMultiLocalInputs.setAttribute('class', 'd-sm-flex');

                const inativarItem = document.createElement('input');
                inativarItem.setAttribute('type', 'hidden');
                inativarItem.setAttribute('name', 'inativar_item_' + cont + '[]');
                inativarItem.setAttribute('id', 'inativar_item_' + cont);
                inativarItem.value = qtd_capacidades.id;

                const inputUnidades_capacity = document.createElement('input');
                inputUnidades_capacity.setAttribute('type', 'hidden');
                inputUnidades_capacity.setAttribute('name', 'unidades_capacity_' + cont + '[]');
                inputUnidades_capacity.setAttribute('id', 'unidades_capacity' + cont);
                inputUnidades_capacity.value = qtd_capacidades.id;

                // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "quantidade[]", e o placeholder "Digite a quatidade maxima.."
                const inputQuantidade = document.createElement('input');
                inputQuantidade.setAttribute('class', 'form-control form-control-sm m-1 w-25 numero');
                inputQuantidade.setAttribute('type', 'text');
                inputQuantidade.setAttribute('name', 'quantidade_' + cont + '[]');
                inputQuantidade.setAttribute('id', 'quantidade_' + cont);
                inputQuantidade.setAttribute('placeholder', 'Quantidade maxima..');
                inputQuantidade.value = qtd_capacidades.quantidades;

                // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "desc_local[]", e o placeholder "Digite o local.."
                const inputDescLocal = document.createElement('input');
                inputDescLocal.setAttribute('class', 'form-control form-control-sm m-1');
                inputDescLocal.setAttribute('type', 'text');
                inputDescLocal.setAttribute('name', 'desc_local_' + cont + '[]');
                inputDescLocal.setAttribute('id', 'desc_local' + cont);
                inputDescLocal.setAttribute('placeholder', 'Digite o local..');
                inputDescLocal.value = qtd_capacidades.desc_quantidades;



                const buttonRemoveLocal = document.createElement("button");
                buttonRemoveLocal.setAttribute("type", "button");
                buttonRemoveLocal.classList.add("btn", "btn-danger", "btn-sm", "m-1");
                buttonRemoveLocal.textContent = "-";
                buttonRemoveLocal.addEventListener("click", function () {
                    const divPai = buttonRemoveLocal.closest(".d-sm-flex").parentNode;
                    divPai.removeChild(buttonRemoveLocal.closest(".d-sm-flex"));
                    var inativa = document.getElementById('inativa_item');
                    inativa.appendChild(inativarItem);
                });
                // Adiciona o elemento inputQuantidade, o elemento inputDescLocal, e o elemento buttonAddLocal ao elemento divMultiLocal
                divMultiLocalInputs.appendChild(inputUnidades_capacity)
                divMultiLocalInputs.appendChild(inputQuantidade);
                divMultiLocalInputs.appendChild(inputDescLocal);
                cont_itens === true ? divMultiLocalInputs.appendChild(buttonRemoveLocal) : "";
                divMultiLocal.appendChild(divMultiLocalInputs);

                ultimaDesc = element.descricao;
                cont_itens = true;
            } else {
                cont_itens = false;
            }
        });

        // Cria o elemento button com a classe "btn btn-dark btn-sm m-1", o tipo "button", e o texto "+"
        const buttonAddLocal = document.createElement('button');
        buttonAddLocal.setAttribute('class', 'btn btn-dark btn-sm mb-2 w-100');
        buttonAddLocal.setAttribute('type', 'button');
        buttonAddLocal.textContent = 'Adicionar novo local';
        buttonAddLocal.addEventListener('click', (function (cont) {
            return function () {
                adicionarLocalCapacidade(cont);
            }
        })(cont));

        const buttonDelete = document.createElement('button');
        buttonDelete.classList.add('btn', 'btn-danger', 'btn-sm');
        buttonDelete.textContent = 'Apagar lista de capacidades';
        buttonDelete.setAttribute('style', 'float: right'); //
        buttonDelete.addEventListener('click', function () {
            var inativa = document.getElementById('inativa_lista');
            inativa.appendChild(inativarLista);
            var parentDiv = this.parentNode;
            var grandparentDiv = parentDiv.parentNode;
            grandparentDiv.remove();
        });

        // Adiciona o elemento labelDescLista, o elemento textareaDescLista, o elemento divMultiLocal ao elemento divBorder
        element.descricao.includes("SEM_DESC_") ? divBorder.appendChild(toggleButton) : "";
        divBorder.appendChild(labelDescLista);
        divBorder.appendChild(buttonDelete);
        divBorder.appendChild(textareaDescLista);
        divBorder.appendChild(labelTituloItens);
        divBorder.appendChild(divMultiLocal);
        divBorder.appendChild(buttonAddLocal);


        // Adiciona o elemento divBorder e o elemento buttonAddLista ao elemento divCapacidade
        divCapacidade.appendChild(divBorder);


        // Adiciona o elemento divCapacidade ao elemento pai
        const pai = document.querySelector('#capacidade_pai');
        pai.appendChild(
            divCapacidade);

    }
    ultimoValor = element.descricao;

});
document.getElementById('cont_capacidade').value = cont;

function validarCamposNumero() {
    const inputsNumero = document.querySelectorAll('.numero');

    inputsNumero.forEach(function (inputNumero) {
        inputNumero.addEventListener('input', function (event) {
            const valor = event.target.value;
            event.target.value = valor.replace(/\D/g, '');
        });
    });
}
validarCamposNumero();

const buttonAddListaCapacidade = document.getElementById('btn-add-lista-capacidade');
buttonAddListaCapacidade.addEventListener('click', function () {
    cont++;
    adicionarListaCapacidade(cont);
});


function adicionarListaCapacidade(cont) {

    console.log(cont);
    // Cria o elemento div com a classe "d-flex flex-sm-column multiCapacidade" e o ID "capacidade_1"
    const divCapacidade = document.createElement('div');
    divCapacidade.setAttribute('class', 'd-sm-flex flex-sm-column multiCapacidade mt-4');
    divCapacidade.setAttribute('id', 'capacidade_' + cont);

    // Cria o elemento div com a classe "border border-dark rounded rounded-3 p-1"
    const divBorder = document.createElement('div');
    divBorder.setAttribute('class', 'border border-dark rounded rounded-3 p-1');

    // Cria o elemento label com o atributo for "desc_lista" e o texto "Descrição da lista de capacidades:"
    const labelDescLista = document.createElement('label');
    labelDescLista.setAttribute('for', 'desc_lista_' + cont);
    labelDescLista.style.fontWeight = 'bold';
    labelDescLista.textContent = 'Descrição da lista de capacidades: ';

    // Cria o elemento textarea com a classe "form-control m-1 w-100", o ID "desc_lista", o nome "desc_lista[]", e o placeholder "Describe yourself here..."
    const textareaDescLista = document.createElement('textarea');
    textareaDescLista.setAttribute('class', 'form-control m-1 w-100');
    textareaDescLista.setAttribute('id', 'desc_lista_' + cont);
    textareaDescLista.setAttribute('name', 'desc_lista_' + cont + '[]');
    textareaDescLista.setAttribute('rows', '1');
    textareaDescLista.setAttribute('placeholder',
        'Descreva uma introdução para os dados de capacidade que serão apresentados...');

    const labelTituloItens = document.createElement('label');
    labelTituloItens.style.fontWeight = 'bold';
    labelTituloItens.textContent = 'Capacidades: ';

    // Cria o elemento div com a classe "d-sm-flex multiLocal"
    const divMultiLocal = document.createElement('div');
    divMultiLocal.setAttribute('class', 'd-sm-flex flex-sm-column multiLocal');
    const divMultiLocalInputs = document.createElement('div');
    divMultiLocalInputs.setAttribute('class', 'd-sm-flex');

    const inputUnidades_capacity = document.createElement('input');
    inputUnidades_capacity.setAttribute('type', 'hidden');
    inputUnidades_capacity.setAttribute('name', 'unidades_capacity_' + cont + '[]');
    inputUnidades_capacity.setAttribute('id', 'unidades_capacity' + cont);
    inputUnidades_capacity.value = "";

    // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "quantidade[]", e o placeholder "Digite a quatidade maxima.."
    const inputQuantidade = document.createElement('input');
    inputQuantidade.setAttribute('class', 'form-control form-control-sm m-1 w-25 numero');
    inputQuantidade.setAttribute('type', 'text');
    inputQuantidade.setAttribute('name', 'quantidade_' + cont + '[]');
    inputQuantidade.setAttribute('id', 'quantidade_' + cont);
    inputQuantidade.setAttribute('placeholder', 'Quantidade maxima..');

    // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "desc_local[]", e o placeholder "Digite o local.."
    const inputDescLocal = document.createElement('input');
    inputDescLocal.setAttribute('class', 'form-control form-control-sm m-1');
    inputDescLocal.setAttribute('type', 'text');
    inputDescLocal.setAttribute('name', 'desc_local_' + cont + '[]');
    inputDescLocal.setAttribute('id', 'desc_local' + cont);
    inputDescLocal.setAttribute('placeholder', 'Digite o local..');

    // Cria o elemento button com a classe "btn btn-dark btn-sm m-1", o tipo "button", e o texto "+"
    const buttonAddLocal = document.createElement('button');
    buttonAddLocal.setAttribute('class', 'btn btn-dark btn-sm m-1 w-100 mb-2');
    buttonAddLocal.setAttribute('type', 'button');
    buttonAddLocal.textContent = 'Adicionar novo local';
    buttonAddLocal.addEventListener('click', function () {
        adicionarLocalCapacidade(cont);
    });
    // Adiciona o elemento inputQuantidade, o elemento inputDescLocal, e o elemento buttonAddLocal ao elemento divMultiLocal
    divMultiLocalInputs.appendChild(inputUnidades_capacity);
    divMultiLocalInputs.appendChild(inputQuantidade);
    divMultiLocalInputs.appendChild(inputDescLocal);
    divMultiLocal.appendChild(divMultiLocalInputs);

    const buttonDelete = document.createElement('button');
    buttonDelete.classList.add('btn', 'btn-danger', 'btn-sm');
    buttonDelete.textContent = 'Apagar lista de capacidades';
    buttonDelete.setAttribute('style', 'float: right'); //
    buttonDelete.addEventListener('click', function () {
        var parentDiv = this.parentNode;
        var grandparentDiv = parentDiv.parentNode;
        grandparentDiv.remove();
    });

    // Adiciona o elemento labelDescLista, o elemento textareaDescLista, o elemento divMultiLocal ao elemento divBorder
    divBorder.appendChild(labelDescLista);
    divBorder.appendChild(buttonDelete);
    divBorder.appendChild(textareaDescLista);
    divBorder.appendChild(labelTituloItens);
    divBorder.appendChild(divMultiLocal);
    divBorder.appendChild(buttonAddLocal);



    // Adiciona o elemento divBorder e o elemento buttonAddLista ao elemento divCapacidade
    divCapacidade.appendChild(divBorder);


    // Adiciona o elemento divCapacidade ao elemento pai
    const pai = document.querySelector('#capacidade_pai');
    pai.appendChild(divCapacidade);
    document.getElementById('cont_capacidade').value = cont;
    validarCamposNumero();
}


function adicionarLocalCapacidade(id_capcidade) {

    const inputUnidades_capacity = document.createElement('input');
    inputUnidades_capacity.setAttribute('type', 'hidden');
    inputUnidades_capacity.setAttribute('name', 'unidades_capacity_' + id_capcidade + '[]');
    inputUnidades_capacity.setAttribute('id', 'unidades_capacity' + id_capcidade);
    inputUnidades_capacity.value = "";

    const inputQuantidade = document.createElement("input");
    inputQuantidade.setAttribute("type", "text");
    inputQuantidade.setAttribute("name", "quantidade_" + id_capcidade + "[]");
    inputQuantidade.setAttribute("id", "quantidade_" + id_capcidade);
    inputQuantidade.setAttribute("placeholder", "Quantidade máxima..");
    inputQuantidade.classList.add("form-control", "form-control-sm", "m-1", "w-25", "numero");

    const inputDescLocal = document.createElement("input");
    inputDescLocal.setAttribute("type", "text");
    inputDescLocal.setAttribute("name", "desc_local_" + id_capcidade + "[]");
    inputDescLocal.setAttribute("id", "desc_local_" + id_capcidade);
    inputDescLocal.setAttribute("placeholder", "Digite o local..");
    inputDescLocal.classList.add("form-control", "form-control-sm", "m-1");

    const buttonRemoveLocal = document.createElement("button");
    buttonRemoveLocal.setAttribute("type", "button");
    buttonRemoveLocal.classList.add("btn", "btn-danger", "btn-sm", "m-1");
    buttonRemoveLocal.textContent = "-";
    buttonRemoveLocal.addEventListener("click", function () {
        const divPai = divMultiLocal.parentNode;
        divPai.removeChild(divMultiLocal);
    });

    const divMultiLocal = document.createElement("div");
    divMultiLocal.classList.add("d-sm-flex");
    divMultiLocal.appendChild(inputUnidades_capacity);
    divMultiLocal.appendChild(inputQuantidade);
    divMultiLocal.appendChild(inputDescLocal);
    divMultiLocal.appendChild(buttonRemoveLocal);

    const divPai = document.querySelector("#capacidade_" + id_capcidade + " .multiLocal");
    divPai.appendChild(divMultiLocal);
    document.getElementById('cont_capacidade').value = cont;

    validarCamposNumero();

}

// Especialidades
var contEsp = 0;
qtd_especialidades = parseInt(qtd_especialidades);

var ultimoValor = "";
//var inputNumero = [];
objetoEspecialidadeJSON.forEach(element => {
    if (element.description !== ultimoValor) {
        contEsp++
        // Cria o elemento div com a classe "d-flex flex-sm-column multiEspecialidade" e o ID "especialidade_1"
        const divEspecialidade = document.createElement('div');
        divEspecialidade.setAttribute('class', 'd-sm-flex flex-sm-column multiEspecialidade mt-2');
        divEspecialidade.setAttribute('id', 'especialidade_' + contEsp);

        const inativarEspecialidades = document.createElement('input');
        inativarEspecialidades.setAttribute('type', 'hidden');
        inativarEspecialidades.setAttribute('name', 'inativar_lista_esp_' + contEsp + '[]');
        inativarEspecialidades.setAttribute('id', 'inativar_lista_esp_' + contEsp);
        inativarEspecialidades.value = element.id;

        // Cria o elemento div com a classe "border border-dark rounded rounded-3 p-1"
        const divBorderEsp = document.createElement('div');
        divBorderEsp.setAttribute('class', 'border border-dark rounded rounded-3 p-1');

        const toggleButton = document.createElement('button');

        toggleButton.textContent = 'Definir descrição';
        toggleButton.setAttribute('type', 'button'); // Define o tipo do botão como "button"
        toggleButton.setAttribute('class', 'btn btn-dark btn-sm m-1');

        // Adiciona o manipulador de eventos ao botão
        toggleButton.addEventListener('click', function () {
            if (labelDescEspeciali.style.display === 'none') {
                labelDescEspeciali.style.display = 'block';
                textareaDescListaEsp.style.display = 'block';
            } else {
                labelDescEspeciali.style.display = 'none';
                textareaDescListaEsp.style.display = 'none';
            }
        });

        // Cria o elemento label com o atributo for "desc_lista" e o texto "Descrição da lista de Especialidade:"
        const labelDescEspeciali = document.createElement('label');
        labelDescEspeciali.setAttribute('for', 'desc_lista_esp_' + contEsp);
        labelDescEspeciali.style.fontWeight = 'bold';
        labelDescEspeciali.textContent = 'Descrição da lista de Especialidade: ';
        element.description.includes("SEM_DESC_") ? labelDescEspeciali.setAttribute("style", "display: none;") : "";

        // Cria o elemento textarea com a classe "form-control m-1 w-100", o ID "desc_lista", o nome "desc_lista[]", e o placeholder "Describe yourself here..."
        const textareaDescListaEsp = document.createElement('textarea');
        textareaDescListaEsp.setAttribute('class', 'form-control m-1 w-100');
        textareaDescListaEsp.setAttribute('id', 'desc_lista_esp_' + contEsp);
        textareaDescListaEsp.setAttribute('name', 'desc_lista_esp_' + contEsp + '[]');
        textareaDescListaEsp.setAttribute('rows', '1');
        textareaDescListaEsp.setAttribute('placeholder',
            'Descreva uma introdução para os dados de Especialidade que serão apresentados...');
        textareaDescListaEsp.value = element.description;
        element.description.includes("SEM_DESC_") ? textareaDescListaEsp.setAttribute("style", "display: none;") : "";

        // Cria o elemento div com a classe "d-sm-flex multiLocal"
        const divMultiEsp = document.createElement('div');
        divMultiEsp.setAttribute('class', 'd-sm-flex flex-sm-column multiEsp');

        const labelTituloItens = document.createElement('label');
        labelTituloItens.style.fontWeight = 'bold';
        labelTituloItens.textContent = 'Especialidades: ';

        var cont_itens_esp = false;
        objetoEspecialidadeJSON.forEach(especialidades => {

            if (especialidades.description == element.description) {

                const divMultiEspInputs = document.createElement('div');
                divMultiEspInputs.setAttribute('class', 'd-sm-flex');

                const inativarItemEsp = document.createElement('input');
                inativarItemEsp.setAttribute('type', 'hidden');
                inativarItemEsp.setAttribute('name', 'inativar_item_esp_' + contEsp + '[]');
                inativarItemEsp.setAttribute('id', 'inativar_item_esp_' + contEsp);
                inativarItemEsp.value = especialidades.id;

                const inputUnidades_especialidade = document.createElement('input');
                inputUnidades_especialidade.setAttribute('type', 'hidden');
                inputUnidades_especialidade.setAttribute('name', 'unidades_especialidade_' + contEsp + '[]');
                inputUnidades_especialidade.setAttribute('id', 'unidades_especialidade_' + contEsp);
                inputUnidades_especialidade.value = especialidades.id;

                // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "desc_local[]", e o placeholder "Digite o local.."
                const inputDescEspecialidade = document.createElement('input');
                inputDescEspecialidade.setAttribute('class', 'form-control form-control-sm m-1');
                inputDescEspecialidade.setAttribute('type', 'text');
                inputDescEspecialidade.setAttribute('name', 'desc_esp_' + contEsp + '[]');
                inputDescEspecialidade.setAttribute('id', 'desc_esp_' + contEsp);
                inputDescEspecialidade.setAttribute('placeholder', 'Digite o especialidade..');
                inputDescEspecialidade.value = especialidades.specialty;

                const buttonRemoveEsp = document.createElement("button");
                buttonRemoveEsp.setAttribute("type", "button");
                buttonRemoveEsp.classList.add("btn", "btn-danger", "btn-sm", "m-1");
                buttonRemoveEsp.textContent = "-";
                buttonRemoveEsp.addEventListener("click", function () {
                    const divPaiEsp = buttonRemoveEsp.closest(".d-sm-flex").parentNode;
                    divPaiEsp.removeChild(buttonRemoveEsp.closest(".d-sm-flex"));
                    var inativaEsp = document.getElementById('inativa_item_esp');
                    inativaEsp.appendChild(inativarItemEsp);
                });
                // Adiciona o elemento inputQuantidade, o elemento inputDescLocal, e o elemento buttonAddLocal ao elemento divMultiLocal
                divMultiEspInputs.appendChild(inputUnidades_especialidade);
                divMultiEspInputs.appendChild(inputDescEspecialidade);

                cont_itens_esp === true ? divMultiEspInputs.appendChild(buttonRemoveEsp) : "";
                divMultiEsp.appendChild(divMultiEspInputs);

                ultimaDesc = element.description;
                cont_itens_esp = true;
            } else {
                cont_itens_esp = false;
            }
        });

        // Cria o elemento button com a classe "btn btn-dark btn-sm m-1", o tipo "button", e o texto "+"
        const buttonAddEsp = document.createElement('button');
        buttonAddEsp.setAttribute('class', 'btn btn-dark btn-sm w-100 mb-4');
        buttonAddEsp.setAttribute('type', 'button');
        buttonAddEsp.textContent = 'Adicionar nova especialidade';
        buttonAddEsp.addEventListener('click', (function (contEsp) {
            return function () {
                adicionarEspecialidade(contEsp);
            }
        })(contEsp));

        const buttonDeleteEsp = document.createElement('button');
        buttonDeleteEsp.classList.add('btn', 'btn-danger', 'btn-sm', 'm-1');
        buttonDeleteEsp.textContent = 'Apagar lista de especialidades';
        buttonDeleteEsp.setAttribute('style', 'float: right'); //
        buttonDeleteEsp.addEventListener('click', function () {
            var inativa = document.getElementById('inativa_lista_esp');
            inativa.appendChild(inativarEspecialidades);
            var parentDiv = this.parentNode;
            var grandparentDiv = parentDiv.parentNode;
            grandparentDiv.remove();
        });

        buttonDeleteEsp.addEventListener('click', function () {
            var parentDiv = this.parentNode;
            var grandparentDiv = parentDiv.parentNode;
            grandparentDiv.remove();
        });

        // Adiciona o elemento labelDescLista, o elemento textareaDescLista, o elemento divMultiLocal ao elemento divBorder
        element.description.includes("SEM_DESC_") ? divBorderEsp.appendChild(toggleButton) : "";
        divBorderEsp.appendChild(labelDescEspeciali);
        divBorderEsp.appendChild(buttonDeleteEsp);
        divBorderEsp.appendChild(textareaDescListaEsp);
        divBorderEsp.appendChild(labelTituloItens);
        divBorderEsp.appendChild(divMultiEsp);
        divBorderEsp.appendChild(buttonAddEsp);

        // Adiciona o elemento divBorder e o elemento buttonAddLista ao elemento divEspecialidade
        divEspecialidade.appendChild(divBorderEsp);

        // Adiciona o elemento divEspecialidade ao elemento pai
        const paiEsp = document.querySelector('#especialidade_pai');
        paiEsp.appendChild(
            divEspecialidade);

    }
    ultimoValor = element.description;

});
document.getElementById('cont_especialidade').value = contEsp;

function validarCamposNumero() {
    const inputsNumero = document.querySelectorAll('.numero');

    inputsNumero.forEach(function (inputNumero) {
        inputNumero.addEventListener('input', function (event) {
            const valor = event.target.value;
            event.target.value = valor.replace(/\D/g, '');
        });
    });
}


const buttonAddListaEspecialidade = document.getElementById('btn-add-lista-especialidade');
buttonAddListaEspecialidade.addEventListener('click', function () {
    cont++;
    adicionarListaEspecialidade(cont);
});


function adicionarListaEspecialidade(contEsp) {
    contEsp++;
    console.log(contEsp);

    // Cria o elemento div com a classe "d-flex flex-sm-column multiCapacidade" e o ID "capacidade_1"
    const divEspecialidade = document.createElement('div');
    divEspecialidade.setAttribute('class', 'd-sm-flex flex-sm-column multiEspecialidade mt-2');
    divEspecialidade.setAttribute('id', 'especialidade_' + contEsp);

    const inativarEspecialidades = document.createElement('input');
    inativarEspecialidades.setAttribute('type', 'hidden');
    inativarEspecialidades.setAttribute('name', 'inativar_lista_esp_' + contEsp + '[]');
    inativarEspecialidades.setAttribute('id', 'inativar_lista_esp_' + contEsp);
    inativarEspecialidades.value = "";

    // Cria o elemento div com a classe "border border-dark rounded rounded-3 p-1"
    const divBorderEsp = document.createElement('div');
    divBorderEsp.setAttribute('class', 'border border-dark rounded rounded-3 p-1');

    // Cria o elemento label com o atributo for "desc_lista" e o texto "Descrição da lista de Especialidade:"
    const labelDescEspeciali = document.createElement('label');
    labelDescEspeciali.setAttribute('for', 'desc_lista_esp_' + contEsp);
    labelDescEspeciali.style.fontWeight = 'bold';
    labelDescEspeciali.textContent = 'Descrição da lista de Especialidade: ';

    // Cria o elemento textarea com a classe "form-control m-1 w-100", o ID "desc_lista", o nome "desc_lista[]", e o placeholder "Describe yourself here..."
    const textareaDescListaEsp = document.createElement('textarea');
    textareaDescListaEsp.setAttribute('class', 'form-control m-1 w-100');
    textareaDescListaEsp.setAttribute('id', 'desc_lista_esp_' + contEsp);
    textareaDescListaEsp.setAttribute('name', 'desc_lista_esp_' + contEsp + '[]');
    textareaDescListaEsp.setAttribute('rows', '1');
    textareaDescListaEsp.setAttribute('placeholder',
        'Descreva uma introdução para os dados de Especialidade que serão apresentados...');
    textareaDescListaEsp.value = "";

    const labelTituloItens = document.createElement('label');
    labelTituloItens.style.fontWeight = 'bold';
    labelTituloItens.textContent = 'Especialidades: ';

    const divMultiEspInputs = document.createElement('div');
    divMultiEspInputs.setAttribute('class', 'd-sm-flex');

    // Cria o elemento div com a classe "d-sm-flex multiLocal"
    const divMultiEsp = document.createElement('div');
    divMultiEsp.setAttribute('class', 'd-sm-flex flex-sm-column multiEsp');

    const inativarItemEsp = document.createElement('input');
    inativarItemEsp.setAttribute('type', 'hidden');
    inativarItemEsp.setAttribute('name', 'inativar_item_esp_' + contEsp + '[]');
    inativarItemEsp.setAttribute('id', 'inativar_item_esp_' + contEsp);
    inativarItemEsp.value = "";

    const inputUnidades_especialidade = document.createElement('input');
    inputUnidades_especialidade.setAttribute('type', 'hidden');
    inputUnidades_especialidade.setAttribute('name', 'unidades_especialidade_' + contEsp + '[]');
    inputUnidades_especialidade.setAttribute('id', 'unidades_especialidade_' + contEsp);
    inputUnidades_especialidade.value = "";

    // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "desc_local[]", e o placeholder "Digite o local.."
    const inputDescEspecialidade = document.createElement('input');
    inputDescEspecialidade.setAttribute('class', 'form-control form-control-sm m-1');
    inputDescEspecialidade.setAttribute('type', 'text');
    inputDescEspecialidade.setAttribute('name', 'desc_esp_' + contEsp + '[]');
    inputDescEspecialidade.setAttribute('id', 'desc_esp_' + contEsp);
    inputDescEspecialidade.setAttribute('placeholder', 'Digite o especialidade..');
    inputDescEspecialidade.value = "";

    // Cria o elemento button com a classe "btn btn-dark btn-sm m-1", o tipo "button", e o texto "+"
    const buttonAddEsp = document.createElement('button');
    buttonAddEsp.setAttribute('class', 'btn btn-dark btn-sm m-1 mb-4 w-100');
    buttonAddEsp.setAttribute('type', 'button');
    buttonAddEsp.textContent = 'Adicionar nova especialidade';
    buttonAddEsp.addEventListener('click', (function (contEsp) {
        return function () {
            adicionarEspecialidade(contEsp);
        }
    })(contEsp));

    const buttonRemoveEsp = document.createElement("button");
    buttonRemoveEsp.setAttribute("type", "button");
    buttonRemoveEsp.classList.add("btn", "btn-danger", "btn-sm", "m-1");
    buttonRemoveEsp.textContent = "-";
    buttonRemoveEsp.addEventListener("click", function () {
        const divPaiEsp = buttonRemoveEsp.closest(".d-sm-flex").parentNode;
        divPaiEsp.removeChild(buttonRemoveEsp.closest(".d-sm-flex"));
        var inativaEsp = document.getElementById('inativa_item_esp');
        inativaEsp.appendChild(inativarItemEsp);
    });

    const buttonDeleteEsp = document.createElement('button');
    buttonDeleteEsp.classList.add('btn', 'btn-danger', 'btn-sm', 'm-1');
    buttonDeleteEsp.textContent = 'Apagar lista de especialidades';
    buttonDeleteEsp.setAttribute('style', 'float: right'); //
    buttonDeleteEsp.addEventListener('click', function () {
        var parentDiv = this.parentNode;
        var grandparentDiv = parentDiv.parentNode;
        grandparentDiv.remove();
    });


    // Adiciona o elemento inputQuantidade, o elemento inputDescLocal, e o elemento buttonAddLocal ao elemento divMultiLocal
    divMultiEspInputs.appendChild(inputUnidades_especialidade)
    divMultiEspInputs.appendChild(inputDescEspecialidade);
    divMultiEsp.appendChild(divMultiEspInputs);

    // Adiciona o elemento labelDescLista, o elemento textareaDescLista, o elemento divMultiLocal ao elemento divBorder
    divBorderEsp.appendChild(labelDescEspeciali);
    divBorderEsp.appendChild(buttonDeleteEsp);
    divBorderEsp.appendChild(textareaDescListaEsp);
    divBorderEsp.appendChild(labelTituloItens);
    divBorderEsp.appendChild(divMultiEsp);
    divBorderEsp.appendChild(buttonAddEsp);


    // Adiciona o elemento divBorder e o elemento buttonAddLista ao elemento divEspecialidade
    divEspecialidade.appendChild(divBorderEsp);


    // Adiciona o elemento divEspecialidade ao elemento pai
    const paiEsp = document.querySelector('#especialidade_pai');
    paiEsp.appendChild(
        divEspecialidade);

    document.getElementById('cont_especialidade').value = contEsp;
    validarCamposNumero();

}


function adicionarEspecialidade(id_especialidade) {

    const divMultiEspInputs = document.createElement('div');
    divMultiEspInputs.setAttribute('class', 'd-sm-flex');

    const inativarItemEsp = document.createElement('input');
    inativarItemEsp.setAttribute('type', 'hidden');
    inativarItemEsp.setAttribute('name', 'inativar_item_esp_' + id_especialidade + '[]');
    inativarItemEsp.setAttribute('id', 'inativar_item_esp_' + id_especialidade);
    inativarItemEsp.value = "";

    const inputUnidades_especialidade = document.createElement('input');
    inputUnidades_especialidade.setAttribute('type', 'hidden');
    inputUnidades_especialidade.setAttribute('name', 'unidades_especialidade_' + id_especialidade + '[]');
    inputUnidades_especialidade.setAttribute('id', 'unidades_especialidade_' + id_especialidade);
    inputUnidades_especialidade.value = "";

    // Cria o elemento input com a classe "form-control form-control-sm m-1", o tipo "text", o nome "desc_local[]", e o placeholder "Digite o local.."
    const inputDescEspecialidade = document.createElement('input');
    inputDescEspecialidade.setAttribute('class', 'form-control form-control-sm m-1');
    inputDescEspecialidade.setAttribute('type', 'text');
    inputDescEspecialidade.setAttribute('name', 'desc_esp_' + id_especialidade + '[]');
    inputDescEspecialidade.setAttribute('id', 'desc_esp_' + id_especialidade);
    inputDescEspecialidade.setAttribute('placeholder', 'Digite o especialidade..');
    inputDescEspecialidade.value = "";

    const buttonRemoveEsp = document.createElement("button");
    buttonRemoveEsp.setAttribute("type", "button");
    buttonRemoveEsp.classList.add("btn", "btn-danger", "btn-sm", "m-1");
    buttonRemoveEsp.textContent = "-";
    buttonRemoveEsp.addEventListener("click", function () {
        const divPaiEsp = buttonRemoveEsp.closest(".d-sm-flex").parentNode;
        divPaiEsp.removeChild(buttonRemoveEsp.closest(".d-sm-flex"));
        var inativaEsp = document.getElementById('inativa_item_esp');
        inativaEsp.appendChild(inativarItemEsp);
    });
    // Adiciona o elemento inputQuantidade, o elemento inputDescLocal, e o elemento buttonAddLocal ao elemento divMultiLocal
    divMultiEspInputs.appendChild(inputUnidades_especialidade)
    divMultiEspInputs.appendChild(inputDescEspecialidade);
    divMultiEspInputs.appendChild(buttonRemoveEsp);

    const divPai = document.querySelector("#especialidade_" + id_especialidade + " .multiEsp");
    divPai.appendChild(divMultiEspInputs);

    validarCamposNumero();

}