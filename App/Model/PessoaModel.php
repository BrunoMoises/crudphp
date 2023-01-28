<?php

namespace App\Model;

use App\Entity\Pessoa;
use App\Util\Serialize;
use App\Database\Database;
use Exception;
use mysqli;

class PessoaModel
{
    public $database;
    private $db;
    private $items;
    private $listPessoa = [];

    public function __construct()
    {
        $this->load();
    }

    public function getConnection()
    {
        $this->db = null;
        try {
            $this->db = new mysqli('localhost', 'root', '', 'crud');
        } catch (Exception $e) {
            echo "Database could not be connected: " . $e->getMessage();
        }

        return $this->db;
    }

    public function readAll()
    {
        return $this->listPessoa;
    }

    public function readById($id_pessoa)
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $this->items->id_pessoa = $id_pessoa;
        $this->items->getId();

        if ($this->items->nome != null) {

            $pes_arr = array(
                "id_pessoa" => $this->items->id_pessoa,
                "nome" => $this->items->nome,
                "email" => $this->items->email,
                "id_categoria" => $this->items->id_categoria
            );

            http_response_code(200);

            return json_encode($pes_arr);
        }
    }

    public function create(Pessoa $pessoa)
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $this->items->nome = $pessoa->getNome();
        $this->items->email = $pessoa->getEmail();
        $this->items->id_categoria = $pessoa->getCat();
        
        if (!$this->items->createPessoa())
            return "Erro ao gravar";

        return "ok";
    }

    /*
    public function update(Pessoa $pessoa)
    {
    $result = "not found";
    for ($i = 0; $i < count($this->listPessoa); $i++) {
    if ($this->listPessoa[$i]->getId() == $pessoa->getId()) {
    $this->listPessoa[$i] = $pessoa;
    $result = "ok";
    }
    }
    $this->save();
    return $result;
    }
    public function delete($id_pessoa)
    {
    $result = "not found";
    for ($i = 0; $i < count($this->listPessoa); $i++) {
    if ($this->listPessoa[$i]->getId() == $id_pessoa) {
    unset($this->listPessoa[$i]);
    $result = "ok";
    }
    }
    $this->listPessoa = array_filter(array_values($this->listPessoa));
    $this->save();
    return $result;
    } */
    private function load()
    {
        $this->db = $this->getConnection();
        $this->items = new Database($this->db);

        $records = $this->items->getPessoas();
        $itemCount = $records->num_rows;
        $pessoaArr = array();

        if ($itemCount > 0) {
            while ($row = $records->fetch_assoc()) {
                array_push($this->listPessoa, $row);
            }
        } else {
            http_response_code(404);
            return json_encode(
                array("message" => "Não encontrado.")
            );
        }
    }
}