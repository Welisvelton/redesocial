<?php

namespace Usuario\Factory;

use Usuario\aUsuario;
use Usuario\Usuario;

class FactoryUsuario
{
    public function criarUsuario(
        $nome,
        $sobrenome,
        $datanasciemnto,
        $email,
        $senha,
        $genero
    ): aUsuario
    {
        return new Usuario($nome, $sobrenome, $datanasciemnto, $email, $senha, $genero);
    }
}
