<?php

namespace RedeSocial;

abstract class aRedeSocial
{
    protected $nome;
    protected $descricao;

    public function __construct($nome, $descricao)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
    }
    public function getNome(): string
    {
      return $this->nome;
    }
  
    public function setNome($nome): void
    {
      $this->nome = $nome;
    }
  
    public function getDescricao(): string
    {
      return $this->descricao;
    }
  
    public function setDescricao($descricao): void
    {
      $this->descricao = $descricao;
    }
}
