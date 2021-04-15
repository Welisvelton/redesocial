<?php 

namespace RedeSocial\Factory;

use RedeSocial\aRedeSocial;
use RedeSocial\Facebook;

interface AbstractFactoryRedeSocial
{
    public function criarRedeSocial(string $nome, string $descricao):aRedeSocial;

}
