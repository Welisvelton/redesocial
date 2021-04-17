<?php 

namespace RedeSocial\Factory;

use RedeSocial\aRedeSocial;
use RedeSocial\Instagram;

class FactoryInstagram implements FactoryRedeSocial
{
    public function criarRedeSocial(): Instagram
    {
        return new Instagram("Instagram", "Poste muitas fotos nesta rede social");
    }
}

?>