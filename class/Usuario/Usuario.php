<?php

namespace Usuario;

class Usuario extends aUsuario implements PrototypeUsuario
{

    public function __construct(
        $nome,
        $sobrenome,
        $nascimento,
        $email,
        $senha,
        $genero
    ) {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->nascimento = $nascimento;
        $this->email = $email;
        $this->senha = $senha;
        $this->genero = $genero;
    }


    public function clonar(): Usuario
    {
        return clone $this;
    }


}
