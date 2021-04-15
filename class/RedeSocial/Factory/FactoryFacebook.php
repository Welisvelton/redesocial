<?php 

namespace RedeSocial\Factory;

use RedeSocial\aRedeSocial;
use RedeSocial\Facebook;

class FactoryFacebook implements AbstractFactoryRedeSocial
{
    public function criarRedeSocial(string $nome, string $descricao): aRedeSocial
    {
        return new Facebook($nome, $descricao);
    }

}
