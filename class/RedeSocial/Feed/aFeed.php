<?php

namespace RedeSocial\Feed;

abstract class aFeed
{

    protected $usuario;
    protected $foto;
    protected $legenda;

    
    public function __construct($usuario, $foto, $legenda)
    {
        $this->usuario = $usuario;
        $this->foto    = $foto;
        $this->legenda = $legenda;
    }

    public function postar(){
        
    }

    public function deletar()
    {

    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function getLegenda()
    {
        return $this->legenda;
    }

    public function setLegenda($legenda)
    {
        $this->legenda = $legenda;
    }
}