<?php

use ConexaoDB\ConexaoDB;
use RedeSocial\Factory\FactoryRedeSocial;
use Usuario\Factory\FactoryUsuario;
use Usuario\DAO\UsuarioDAO;

require(__DIR__."/class/Autoloading.php");

try{
$conn = new ConexaoDB();
$usuarioDAO = new UsuarioDAO($conn->getConexao());
$usuarioDAO->createTable();
}
catch(Exception $e) {
    echo $e->getMessage();
}


$factoryRedeSocial = new FactoryRedeSocial();
$facebook = $factoryRedeSocial->criarFacebook();

$factoryUsuario = new FactoryUsuario();

$usu1 = $factoryUsuario->criarUsuario("Welisvelton", "Cabral", "1993-07-27", "welisvelton@gmail.com", "123456", "M");


echo $facebook->getNome();



?>