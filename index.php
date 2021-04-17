<?php

use RedeSocial\Factory\FactoryRedeSocial;
use Usuario\Factory\FactoryUsuario;

require(__DIR__."/class/Autoloading.php");

$factoryRedeSocial = new FactoryRedeSocial();
$facebook = $factoryRedeSocial->criarFacebook();

$factoryUsuario = new FactoryUsuario();

$usu1 = $factoryUsuario->criarUsuario("Welisvelton", "Cabral", "1993-07-27", "welisvelton@gmail.com", "123456", "M");


echo $facebook->getNome();



?>