<?php 

namespace RedeSocial\Factory;

use RedeSocial\Feed\aFeed;
use RedeSocial\Feed\FeedFacebook;
use RedeSocial\Story\aStory;
use RedeSocial\Story\StoryFacebook;

class FactoryPostFacebook implements AbstractFactoryPost
{
    public function criarFeed($usuario, $foto, $legenda):aFeed
    {
        return new FeedFacebook($usuario, $foto, $legenda);
        
    }

    public function criarStory($usuario, $foto):aStory
    {
        return new StoryFacebook($usuario, $foto);
        
    }

}
