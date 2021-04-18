<?php

namespace Mensagem;

use Mensagem\Mensagem;

class BuilderMensagem implements IBuilderMensagem
{
  private $result;

  public function __construct()
  {
    $this->result = new Mensagem();
    
  }

  public function criarTexto(string $texto): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Texto: $texto");
  }

  public function criarAudio(string $audio): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Audio: $audio");
  }

  public function criarDocumento(string $documento): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Documento: $documento");
  }

  public function criarImagem(string $imagem): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Imagem: $imagem");
  }

  public function criarVideo(string $video): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Video: $video");
  }

  public function criarContato(string $contato): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Contato: $contato");
  }

  public function criarLocalizacao(string $localizacao): void
  {
    $this->result->setConteudo($this->result->getConteudo() . " Localização: $localizacao");
  }

  public function getResult(): Mensagem
  {
    return $this->result;
  }

  public function reset()
  {
  
    $this->result = new Mensagem();

  }
}
