"use strict"

$(document).ready(function () {
    readAll();
});

//EVENTOS
$('#bt-new').click(function () {
    openModalCreate(true);
});

$('#frmCreate').submit(function (e) {
    sendForm();
    e.preventDefault();
});

function openModalCreate(reset = true) {
    $('#modalNovaPessoa').modal('show');

    if (reset) resetForm();
}

function closeModalCreate(reset = true) {
    $('#modalNovaPessoa').modal('hide');

    if (reset) resetForm();
}

function deletePessoa(id) {
    if (confirm("Deseja realmente remover?")) {
        deleteId(id);
    } else {
        return;
    }
}

function editaPessoa(id) {
    if (id <= 0)
        return;

    readById(id, false);
}

//ENVIO
function sendForm() {
    var obj = {
        id_pessoa: $('#txtId').val(),
        nome: $('#txtNome').val(),
        email: $('#txtEmail').val(),
        id_categoria: $('#seCategoria').val()
    };

    if (obj.id_pessoa == 0) {
        create(obj);
    } else {
        update(obj);
    }
}

function resetForm() {
    $('#txtId').val("0");
    $('#txtNome').val("");
    $('#txtEmail').val("");
    $('#seCategoria').val("3");
}

function createTable(data) {
    if (data.length < 1)
        return;

    var tabela = document.querySelector(".table tbody");
    tabela.innerHTML = "";

    var tmplSource = document.getElementById("tmplLinha").innerHTML;
    var tmplHandle = Handlebars.compile(tmplSource);

    for (var i = 0; i < data.length; i++) {
        var pessoa = {};
        pessoa.id_pessoa = data[i].id_pessoa;
        pessoa.Nome = data[i].nome;
        pessoa.Email = data[i].email;
        pessoa.id_categoria = data[i].cat;

        var linha = {};
        linha.template = document.createElement("template");;
        linha.template.innerHTML = tmplHandle(pessoa)
        linha.content = document.importNode(linha.template.content, true);

        tabela.appendChild(linha.content);
    }
}

function editModal(data) {
    if (data == null)
        return;

    $('#txtId').val(data.Id);
    $('#txtNome').val(data.Nome);
    $('#txtEmail').val(data.Email);
    $('#seCategoria').val(data.Cat);

    openModalCreate(false);
}

//AJAX
function create(obj) {
    $.ajax({
        url: "api/pessoa/",
        type: "POST",
        data: obj,
        dataType: "json",
        beforeSend: function () {
            $('#btnSubmit').attr("disabled", true);
        },
        success: function (data) {
            if (data.result == "ok") {
                closeModalCreate();
                readAll();
            } else {
                alert("Houve um erro no cadastro");
            }
        },
        error: function (error) {
            alert("Houve um erro no cadastro");
        },
        complete: function () {
            $('#btnSubmit').attr("disabled", false);
        }
    });
}

function readAll() {
    $.ajax({
        url: "api/pessoa",
        type: "GET",
        data: {},
        dataType: "json",
        success: function (data) {
            createTable(data);
        },
        error: function (error) {
            alert("Houve um erro na busca");
        }
    });
}

function readById(id, view) {
    $.ajax({
        url: "api/pessoa/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (view) {
                createViewModal(data);
            } else {
                editModal(data);
            }
        }
    });
}

function deleteId(id) {
    $.ajax({
        url: "api/pessoa/" + id,
        type: "DELETE",
        dataType: "json",
        success: function (data) {
            if (data.result == "ok")
                readAll();
        },
        error: function (error) {
            alert("Houve um erro na deleção");
        }
    });
}

function update(obj) {
    $.ajax({
        url: "api/pessoa/" + obj.id_pessoa,
        type: "PUT",
        data: obj,
        dataType: "json",
        beforeSend: function () {
            $('#btnSubmit').attr("disabled", true);
        },
        success: function (data) {
            if (data.result == "ok") {
                closeModalCreate();
                readAll();
            } else {
                alert("Houve um erro ao atualizar");
            }
        },
        error: function (error) {
            alert("Houve um erro ao atualizar");
        },
        complete: function () {
            $('#btnSubmit').attr("disabled", false);
        }
    });
}