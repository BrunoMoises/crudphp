<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>CRUD</title>
    <link rel="icon" type="image/x-icon" href="./img/logo.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js"></script>
</head>

<body>
    <div class="container">
        <header>
            <div class="row mt-3">
                <div class="col-md-6">
                    <a href="index.php"><img class="pointer" src="./img/logo.png" alt="CRUD"
                            style="max-width: 40px;"></a>
                </div>
                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-outline-info" id="bt-new">Nova pessoa</button>
                </div>
        </header>
        <hr class="border-info">
        <div class="row mt-3">
            <table class="table table-striped-columns table-bordered">
                <thead>
                    <tr>
                        <th colspan="3">Codigo</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <script id="tmplLinha" type="text/template">
                <tr>
                    <td width="10"><i class="bi-x-circle-fill icon icon-x pointer" title="Excluir pessoa"
                            aria-multiline="Excluir pessoa" onclick="deletePessoa('{{id_pessoa}}')"></i></td>
                    <td width="10"><i class="bi-pencil-fill icon icon-edit pointer" title="Editar pessoa"
                            aria-multiline="Editar pessoa" onclick="editaPessoa('{{id_pessoa}}')"></i></td>
                    <td align="center" width="40">{{id_pessoa}}</td>
                    <td>{{Nome}}</td>
                    <td>{{Email}}</td>
                    <td>{{id_categoria}}</td>
                </tr>
            </script>
        </div>
    </div>

    <div class="modal fade" id="modalNovaPessoa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="frmCreate" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Criar/Editar Pessoa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="txtNome">Nome</label>
                                <input type="hidden" id="txtId" value="">
                                <input type="text" id="txtNome" placeholder="Preencha o nome..." class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="txtEmail">E-mail</label>
                                <input type="email" id="txtEmail" placeholder="Preencha o E-mail..."
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="seCategoria">Categoria</label>
                                <select id="seCategoria" class="form-control">
                                    <option value="3">Normal</option>
                                    <option value="2">Gerente</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success" id="btnSubmit">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>