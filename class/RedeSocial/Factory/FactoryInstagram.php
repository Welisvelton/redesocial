<?php 

namespace RedeSocial\Factory;

use RedeSocial\aRedeSocial;
use RedeSocial\Instagram;

class FactoryInstagram implements AbstractFactoryRedeSocial
{
    public function criarRedeSocial(string $nome, string $descricao): aRedeSocial
    {
        return new Instagram($nome, $descricao);
    }
}

?>