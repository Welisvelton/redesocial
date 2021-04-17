<?php
use ConexaoDB\ConexaoDB;
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
    $usuarioDAO = new UsuarioDAO($conn);
    $usuarioDAO->createTable();
} catch (Exception $e) {
    echo $e->getMessage();
}


$factory = new FactoryTikTok();
$redeSocial = $factory->criarRedeSocial();


$factoryUsuario = new FactoryUsuario();
/*
$usu1 = $factoryUsuario->criarUsuario(
    "Welisvelton",
    "Cabral",
    "1993-07-27",
    "welisvelton@gmail.com",
    "123456",
    "M"
);
*/

if (!empty($_POST['email'])) {
    $usu = $usuarioDAO->checaUsuario(
        filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
        filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING)
    );
}


try {
   // $msgDAO = new MensagemDAO($conn);
    
    $bmsg = new BuilderMensagem();
    $bmsg->criarTexto("Este é o texto da mensagem ok!"); 
    $bmsg->criarAudio("Este é meu áudio");
    $msg = $bmsg->getResult();


 $encaminhar = $msg->clonar();

    $encaminhar->setDe_usuario(3);

    

 

} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rede Social</title>
    <style>
        body,
        html {
            margin: 0px;
            padding: 0px;
            border: none;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 16px;
        }

        input {
            outline: none;
        }

        .barra-superior {
            width: 100%;
            height: auto;
            background-color: #34487c;
            color: white;
            padding: 8px 5px;
            display: flex;
            align-self: flex-end;
            box-sizing: border-box;
        }

        .form-login {
            width: 50%;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="barra-superior">
        <?php if (!empty($usu)) : ?>
            <span> Olá, <?= $usu->getNome(); ?> </span> &nbsp; <a href="?sair" > <button >Sair</button></a>

        <?php else : ?>

            <form action="" method="POST" class="form-login">
                Entre para começar
                <input type="text" name="email" size="10" placeholder="E-mail" /> <input type="password" name="senha" value="" size="10" placeholder="Senha" />
                <input type="submit" value="Entrar" />
            </form>
        <?php endif; ?>

    </div>


    <h1><?= $redeSocial->getNome() ?></h1>

    <?php  echo  $msg->getConteudo();?><br/>

   De: <?php  echo  $msg->getDe_usuario();?> <br/>

    De:<?php  echo  $encaminhar->getDe_usuario();?><br/>



</body>

</html>
