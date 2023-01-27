<?php

namespace App\Controller;

use App\Entity\Pessoa;
use App\Model\PessoaModel;

class PessoaController
{
    private $pessoaModel;
    public function __construct()
    {
        $this->pessoaModel = new PessoaModel();
    }
    function create($data = null)
    {
        $pessoa = $this->convertType($data);
        $result = $this->validate($pessoa);

        if ($result != "") {
            echo json_encode(["result" => $result]);
        }

        $this->pessoaModel->create($pessoa);
    }

    function update($id_pessoa = 0, $data = null)
    {
        $pessoa = $this->convertType($data);
        $pessoa->setId($id_pessoa);
        $result = $this->validate($pessoa, true);

        if ($result != "") {
            echo json_encode(["result" => $result]);
        }


        //return json_encode(["name" => "update"]);
    }

    function delete($id = 0)
    {
        return json_encode(["name" => "delete"]);
    }

    function readById($id = 0)
    {
        return json_encode(["name" => "readById - $id"]);
    }

    function readAll()
    {
        return json_encode(["name" => "readall"]);
    }

    private function convertType($data)
    {
        return new Pessoa(
            null,
            (isset($data['nome']) ? $data['nome'] : null),
            (isset($data['email']) ? $data['email'] : null),
            (isset($data['id_categoria']) ? $data['id_categoria'] : null)
        );
    }

    private function validate(Pessoa $pessoa, $update = false)
    {
        if ($update && $pessoa->getId() <= 0)
            return "invalid id";

        if ($pessoa->getNome() == "")
            return "invalid nome";

        if ($pessoa->getEmail() == "")
            return "invalid email";

        return "";
    }
}