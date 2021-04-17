<?php

namespace Mensagem;

interface IBuilderMensagem
{
  public function criarTexto(string $texto): void;
  public function criarAudio(string $audio): void;
  public function criarDocumento(string $documento): void;
  public function criarImagem(string $imagem): void;
  public function criarVideo(string $video): void;
  public function criarLocalizacao(string $localizacao): void;
  public function criarContato(string $contato): void;
}
