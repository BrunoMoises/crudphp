<?php

namespace App\Database;

use App\Entity\Pessoa;
use App\Model\PessoaModel;

class Database
{
    private $db;
    private $db_table = "pessoa";
    public $id_pessoa;
    public $nome;
    public $email;
    public $id_categoria;
    public $cat;
    public $result;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPessoas()
    {
        $sqlQuery = "SELECT p.id_pessoa, p.nome, p.email, c.nome cat FROM " . $this->db_table . " p 
        INNER JOIN categoria c ON c.id_categoria = p.id_categoria";
        return $this->db->query($sqlQuery);
    }

    public function getId()
    {
        $sqlQuery = "SELECT p.id_pessoa, p.nome, p.email, c.nome cat FROM " . $this->db_table . " p 
        INNER JOIN categoria c ON c.id_categoria = p.id_categoria WHERE id_pessoa = " . $this->id_pessoa;
        $record = $this->db->query($sqlQuery);
        $dataRow = $record->fetch_assoc();
        $this->nome = $dataRow['nome'];
        $this->email = $dataRow['email'];
        $this->cat = $dataRow['cat'];
    }

    public function createPessoa()
    {
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $sqlQuery = "INSERT INTO
                    " . $this->db_table . " SET nome = '" . $this->nome . "',
                    email = '" . $this->email . "',
                    id_categoria = '" . $this->id_categoria . "'";
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function updatePessoa()
    {
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_pessoa = htmlspecialchars(strip_tags($this->id_pessoa));

        $sqlQuery = "UPDATE " . $this->db_table . " SET nome = '" . $this->nome . "',
                    email = '" . $this->email . "',
                    id_categoria = '" . $this->id_categoria . "'
                    WHERE id_pessoa = " . $this->id_pessoa;

        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    function deletePessoa()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id_pessoa = " . $this->id_pessoa;
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }
}