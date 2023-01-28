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
            return json_encode(["result" => $result]);
        }

        return json_encode(["result" => $this->pessoaModel->create($pessoa)]);
    }

    function update($id_pessoa = 0, $data = null)
    {
        $pessoa = $this->convertType($data);
        $pessoa->setId($id_pessoa);
        $result = $this->validate($pessoa, true);

        if ($result != "") {
            return json_encode(["result" => $result]);
        }


        $result = $this->pessoaModel->update($pessoa);

        return json_encode(["result" => $result]);
    }

    function delete($id = 0)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($id <= 0)
            return json_encode(["result" => "invalid id"]);

        $result = $this->pessoaModel->delete($id);

        return json_encode(["result" => $result]);
    }

    function readById($id = 0)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($id <= 0)
            return json_encode(["result" => "invalid id"]);

        return $this->pessoaModel->readById($id);
    }

    function readAll()
    {
        return json_encode($this->pessoaModel->readAll());
    }

    private function convertType($data)
    {
        return new Pessoa(
            null,
            (isset($data['nome']) ? filter_var($data['nome'], FILTER_SANITIZE_STRING) : null),
            (isset($data['email']) ? filter_var($data['email'], FILTER_SANITIZE_STRING) : null),
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