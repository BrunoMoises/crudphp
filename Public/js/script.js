"use strict"

$(document).ready(function(){
    readAll();
});

console.clear();

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

    } else {
        return;
    }
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
        console.log("Editar");
    }
}

function resetForm() {
    $('#txtId').val("0");
    $('#txtNome').val("");
    $('#txtEmail').val("");
    $('#seCategoria').val("3");
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
        url : "api/pessoa",
        type : "GET",
        data : {},
        dataType : "json",
        success : function(data) {
            
        },
        error : function(error) {
            alert("Houve um erro na busca");
        }
    });
}