<?php

namespace App\Model;

use App\Entity\Pessoa;

class PessoaModel
{
    private $fileName;
    private $listPessoa = [];

    public function __construct()
    {
        $this->fileName = "../database/pessoa.db";
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

        foreach($this->listPessoa as $p) {
            $temp[] = [
                "id_pessoa" => $p->getId(),
                "nome" => $p->getNome(),
                "email" => $p->getEmail(),
                "id_categoria" => $p->getCat(),
            ];

            $fp = fopen($this->fileName,"w");
            fwrite($fp, json_encode($temp));
            fclose($fp);
        }
    }

    private function load()
    {

    }
}