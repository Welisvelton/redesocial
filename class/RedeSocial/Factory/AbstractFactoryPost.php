<?php 

namespace RedeSocial\Factory;

use RedeSocial\Feed\aFeed;
use RedeSocial\Story\aStory;

interface AbstractFactoryPost
{
    public function criarFeed($usuario, $foto, $legenda):aFeed;
    public function criarStory($usuario, $foto):aStory;

}