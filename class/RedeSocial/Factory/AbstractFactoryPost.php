<?php 

namespace RedeSocial\Factory;

use RedeSocial\Feed\aFeed;
use RedeSocial\Story\aStory;
use Usuario\aUsuario;

interface AbstractFactoryPost
{
    public function criarFeed(aUsuario $usuario, $foto, $legenda):aFeed;
    public function criarStory(aUsuario $usuario, $foto):aStory;

}