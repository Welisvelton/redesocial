<?php

use ConexaoDB\ConexaoDB;
use RedeSocial\Factory\FactoryInstagram;
use RedeSocial\Factory\FactoryFacebook;
use RedeSocial\Factory\FactoryTikTok;
use Usuario\Factory\FactoryUsuario;
use Usuario\DAO\UsuarioDAO;

require(__DIR__."/class/Autoloading.php");

try{
    //  TODO no padrão singleton não se pode instanciar a classe conexão, seu construtor deve ser privado, verifica o comentario na classe UsuarioDAO
$conn = new ConexaoDB();
// 
$usuarioDAO = new UsuarioDAO($conn->getConexao());
$usuarioDAO->createTable();
}
catch(Exception $e) {
    echo $e->getMessage();
}


$factory = new FactoryTikTok();
$redeSocial = $factory->criarRedeSocial();


$factoryUsuario = new FactoryUsuario();
$usu1 = $factoryUsuario->criarUsuario("Welisvelton", "Cabral", "1993-07-27", "welisvelton@gmail.com", "123456", "M");



echo $redeSocial->getNome();


try{
    $usuarioDAO->inserir($usu1);

} catch(Exception $e){
    echo $e->getMessage();
}




?>
