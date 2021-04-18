<?php 

namespace RedeSocial\Factory;

use RedeSocial\aRedeSocial;
use RedeSocial\TikTok;

class FactoryTikTok implements FactoryRedeSocial
{
    public function criarRedeSocial(): aRedeSocial
    {
        return new TikTok("TikTok", "Se divirta com vários filtros nesta rede social");
    }
}