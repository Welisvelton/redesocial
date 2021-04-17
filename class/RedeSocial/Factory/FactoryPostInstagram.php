<?php 

namespace RedeSocial\Factory;

use RedeSocial\Feed\FeedInstagram;
use RedeSocial\Story\StoryInstagram;

class FactoryPostInstagram implements AbstractFactoryPost
{
    public function criarFeed($usuario, $foto, $legenda): FeedInstagram
    {
        return new FeedInstagram($usuario, $foto, $legenda);
        
    }

    public function criarStory($usuario, $foto): StoryInstagram
    {
        return new StoryInstagram($usuario, $foto);
        
    }

}