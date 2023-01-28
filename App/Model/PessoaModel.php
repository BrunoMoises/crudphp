<?php

namespace App\Model;

use App\Entity\Pessoa;
use App\Util\Serialize;

class PessoaModel
{
    private $fileName;
    private $listPessoa = [];

    public function __construct()
    {
        $this->fileName = "../database/pessoa.db";
        $this->load();
    }

    public function readAll()
    {
        return (new Serialize())->serialize($this->listPessoa);
    }

    public function readById($id_pessoa)
    {
        foreach ($this->listPessoa as $p) {
            if ($p->getId() == $id_pessoa)
                return (new Serialize())->serialize($p);
        }

        return json_encode([]);
    }

    public function create(Pessoa $pessoa)
    {
        $pessoa->setId($this->getLastId());
        $this->listPessoa[] = $pessoa;
        $this->save();

        return "ok";
    }

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
    }

    private function save()
    {
        $temp = [];

        foreach ($this->listPessoa as $p) {
            $temp[] = [
                "id_pessoa" => $p->getId(),
                "nome" => $p->getNome(),
                "email" => $p->getEmail(),
                "id_categoria" => $p->getCat()
            ];

            $fp = fopen($this->fileName, "w");
            fwrite($fp, json_encode($temp));
            fclose($fp);
        }
    }

    private function getLastId()
    {
        $lastId = 0;

        foreach ($this->listPessoa as $p) {
            if ($p->getId() > $lastId)
                $lastId = $p->getId();
        }

        return $lastId + 1;
    }

    private function load()
    {
        if (!file_exists($this->fileName))
            return [];

        $fp = fopen($this->fileName, "r");
        $str = fread($fp, filesize($this->fileName));
        fclose($fp);

        $arrayPessoa = json_decode($str);

        foreach ($arrayPessoa as $p) {
            $this->listPessoa[] = new Pessoa(
                    $p->id_pessoa,
                    $p->nome,
                    $p->email,
                    $p->id_categoria
            );
        }
    }
}