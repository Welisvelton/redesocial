<?php 

namespace RedeSocial;

abstract class aRedeSocial{
    protected $nome;
    protected $descricao;

    public function __construct($nome, $descricao)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;

    }
}


?>