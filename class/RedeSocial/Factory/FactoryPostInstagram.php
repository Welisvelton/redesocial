<?php 

namespace RedeSocial\Factory;

use RedeSocial\Feed\aFeed;
use RedeSocial\Feed\FeedInstagram;
use RedeSocial\Story\aStory;
use RedeSocial\Story\StoryInstagram;

class FactoryPostInstagram implements AbstractFactoryPost
{
    public function criarFeed($usuario, $foto, $legenda): aFeed
    {
        return new FeedInstagram($usuario, $foto, $legenda);
        
    }

    public function criarStory($usuario, $foto): aStory
    {
        return new StoryInstagram($usuario, $foto);
        
    }

}