<?php 

namespace FactoryTikTok;

use RedeSocial\aRedeSocial;
use RedeSocial\Factory\AbstractFactoryRedeSocial;
use RedeSocial\TikTok;

class FactoryTikTok implements AbstractFactoryRedeSocial
{
    public function criarRedeSocial(string $nome, string $descricao): aRedeSocial
    {
        return new TikTok($nome, $descricao);
    }
}

?>