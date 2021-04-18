<?php

namespace Mensagem;

use Prototype\Prototype;

class Mensagem implements Prototype
{

  private  $id;
  private  $conteudo;
  private  $de_usuario;
  private  $para_usuario;
  private  $data_hora;


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
    return clone $this;
  }

    public function getData_hora()
    {
        return $this->data_hora;
    }

    public function setData_hora($data_hora)
    {
        $this->data_hora = $data_hora;
    }
}
