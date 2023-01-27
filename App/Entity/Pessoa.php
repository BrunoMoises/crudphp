<?php

namespace App\Entity;

class Pessoa {
    private $id_pessoa;
    private $nome;
    private $email;
    private $id_categoria;

    public function __construct($id_pessoa = '', $nome = '', $email = '', $id_categoria = '')
    {
        $this->id_pessoa = $id_pessoa;
        $this->nome = $nome;
        $this->email = $email;
        $this->id_categoria = $id_categoria;
    }

    public function setId($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCat($id_categoria)
    {
        $this->id_categoria = $id_categoria;
    }

    public function getId()
    {
        return $this->id_pessoa;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCat()
    {
        return $this->id_categoria;
    }
}