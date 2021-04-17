<?php

namespace Usuario;

interface PrototypeUsuario
{
    //TODO Remover classe, utilizar o prototype geral
    public function clonar(): Usuario;
}
