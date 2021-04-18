<?php 

namespace Login;

use ConexaoDB\ConexaoDB;
use Exception;
use Usuario\DAO\UsuarioDAO;

class LoginUsuario implements Login
{
    public static function logar($email, $senha)
    {
        $conn = ConexaoDB::getConexao();
        $usuDAO = new UsuarioDAO($conn);

        $usu = $usuDAO->checaUsuario($email, $senha);

        if(!empty($usu)){

            $dados = array(
                'idUsuario'=>$usu->getId(),
                'nome' => $usu->getNome()
            );
            
            $_SESSION['login'] = serialize($dados);
            header("Location: /index.php?");
        } else {
           throw new \Exception("Usuário não encontrado!");
        }


    }

    public static function logout():void
    {
        unset($_SESSION['login']);

        header("Location: /index.php");

    }

    public static function verificaLogin():void
    {
        if(empty($_SESSION['login'])){
            throw new Exception("Você precisa fazer login para continuar");
        }

    }

    public static function getDadosLogin()
    {
        if(empty($_SESSION['login'])){
            return false;
        }

        return unserialize($_SESSION['login']);
    }
        
}


?>