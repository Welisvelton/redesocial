<?php 
use ConexaoDB\ConexaoDB;
use Login\LoginUsuario;
use Mensagem\BuilderMensagem;
use Mensagem\DAO\MensagemDAO;
use Mensagem\Mensagem;
use RedeSocial\Factory\{
  FactoryInstagram,
  FactoryFacebook,
  FactoryTikTok
};

use Usuario\{
  aUsuario,
  Factory\FactoryUsuario,
  DAO\UsuarioDAO
};


require(__DIR__ . "/class/Autoloading.php");

try {
    $conn = ConexaoDB::getConexao();

$usuDAO = new UsuarioDAO($conn);
$usuDAO->createTable();

$msDAO = new MensagemDAO($conn);
$msDAO->createTable();
} catch (Exception $e) {
    echo $e->getMessage();
}



?>