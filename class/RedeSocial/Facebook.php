<?php

namespace RedeSocial;

class Facebook extends aRedeSocial
{

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
