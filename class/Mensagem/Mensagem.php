<?php

namespace Mensagem;

use Prototype\Prototype;

class Mensagem implements Prototype
{

  private int $id;
  private string $conteudo;
  private int $de_usuario;
  private int $para_usuario;


  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getConteudo()
  {
    return $this->conteudo;
  }

  public function setConteudo($conteudo)
  {
    $this->conteudo = $conteudo;
  }

  public function getDe_usuario()
  {
    return $this->de_usuario;
  }

  public function setDe_usuario($de_usuario)
  {
    $this->de_usuario = $de_usuario;
  }

  public function getPara_usuario()
  {
    return $this->para_usuario;
  }

  public function setPara_usuario($para_usuario)
  {
    $this->para_usuario = $para_usuario;
  }

  public function clonar(): Mensagem
  {
    return $this;
  }
}
