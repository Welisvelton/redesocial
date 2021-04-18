<?php 

namespace RedeSocial\Story;

abstract class aStory
{
    protected $usuario;
    protected $foto;

    public function __construct($usuario, $foto)
    {
        $this->usuario = $usuario;
        $this->foto    = $foto;
    }

    public function postar()
    {

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
}