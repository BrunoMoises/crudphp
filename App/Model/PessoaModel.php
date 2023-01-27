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
        return json_encode((new Serialize())->serialize($this->listPessoa));
    }

    public function create(Pessoa $pessoa)
    {
        $this->listPessoa[] = $pessoa;
        $this->save();

        return "ok";
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