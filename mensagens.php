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
  $usuarioDAO = new UsuarioDAO($conn);

  $para_usuario = (empty($_GET['para_usu'])) ? null : filter_input(INPUT_GET, 'para_usu', FILTER_SANITIZE_NUMBER_INT);
  $de_usuario = LoginUsuario::getDadosLogin();

  $msgDAO = new MensagemDAO($conn);

  $thisUsu = $usuarioDAO->getUsuarioId($de_usuario['idUsuario']);
  $usuPara = $usuarioDAO->getUsuarioId($para_usuario);



  $bmsg = new BuilderMensagem();
  $testeConteudo = 0;

  if (!empty($_POST['sendmsg'])) {
  
    $texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING);
    if (!empty($texto)) {
      $bmsg->criarTexto($texto);
      $testeConteudo++;
    }
  }

  if(!empty($_GET['audio'])){
    $bmsg->criarAudio("Este é o meu áudio ". $usuPara->getNome());
    $testeConteudo++;
  }

  if(!empty($_GET['video'])){
    $bmsg->criarVideo("Este é o meu vídeo ". $usuPara->getNome());
    $testeConteudo++;
  }

  if(!empty($_GET['imagem'])){
    $bmsg->criarImagem("Esta é a foto ". $usuPara->getNome());
    $testeConteudo++;
  }

  if (!empty($testeConteudo)) {
    $msg = $bmsg->getResult();
    $msg->setDe_usuario($thisUsu->getId());
    $msg->setPara_usuario($usuPara->getId());
    $msgDAO->inserir($msg);
  }


  if (!empty($_GET['excluir'])) {
    $excluir = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);
    $msgDAO->deletar($excluir);
  }


  $listaConversas = $msgDAO->listarConversa(1, $para_usuario);
} catch (Exception $e) {
  echo $e->getMessage();
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

    input,
    textarea {
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

    .container-chat {
      width: 90%;
      max-width: 300px;
      height: auto;
      max-height: 500px;
      position: absolute;
      right: 20px;
      bottom: 0px;
      background-color: #34487c;
      box-sizing: border-box;
      padding: 8px;
    }

    .container-chat>iframe {
      width: 100%;
      border: none;
      height: 400px;
    }

    .caixa-texto {
      width: 100%;
      box-sizing: border-box;
      padding: 8px;
      height: auto;
      min-height: 50px;
      border-radius: 5px;
      border: 1px #34487c solid;
      font-size: 14px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;

    }

    .box-form {
      height: auto;
      display: flex;
    }

    .botoes-extras {
      width: 100%;
    }

    .saida {
      padding: 8px;
      width: 100%;
      font-size: 12px;
      margin-bottom: 8px;
      border: #34487c 1px solid;
      border-radius: 12px;
      border-bottom-left-radius: 0px;
      box-sizing: border-box;
      background-color: #d2daec;

    }

    .entrada {
      padding: 8px;
      width: 100%;
      font-size: 12px;
      margin-bottom: 8px;
      border: #34487c 1px solid;
      border-radius: 12px;
      border-bottom-right-radius: 0px;
      box-sizing: border-box;
      background-color: #fcfdfe;

    }
  </style>
</head>

<body>

  <?php if (!empty($para_usuario)) : ?>
    <?= $usuPara->getNome(); ?>
    <hr />
    <div class="mensagens">
      <?php if (!empty($listaConversas)) : ?>
        <?php foreach ($listaConversas as $msg) : ?>
          <div class="<?= ($msg->getDe_usuario() == $thisUsu->getId()) ? "saida" : "entrada" ?>">
            <?= $msg->getConteudo() ?>
            <hr />
            <a href="?para_usu=<?= $usuPara->getId() ?>&excluir=<?= $msg->getId() ?>">Encluir</a>
            <?= $msg->getData_hora();?>
          </div>
        <?php endforeach; ?>

      <?php else : ?>

        Você ainda não tem conversas com <?= $usuPara->getNome(); ?>

      <?php endif; ?>

    </div>
    <br />
    <div>
      <form action="" method="POST">
        <input type="hidden" name="sendmsg" value="1">
        <textarea name="texto" class="caixa-texto"></textarea>
        <input type="submit" value="Enviar">
      </form>

    </div>
    <hr />
    <div class="box-form">
      <a href="?para_usu=<?= $usuPara->getId() ?>&audio=1" >
      <input type="button" value="Audio" class="botoes-extras">
      </a><br />
      <a href="?para_usu=<?= $usuPara->getId() ?>&imagem=1" >
      <input type="button" value="imagem" class="botoes-extras"></a><br />
      <a href="?para_usu=<?= $usuPara->getId() ?>&video=1" >
      <input type="button" value="Video" class="botoes-extras">
      </a><br />
    </div>
    <div id="final"></div>
  <?php endif; ?>

  <script>
    var finalPagina = {
      setar: function() {
       var elmnt = document.getElementById("final");
        elmnt.scrollIntoView();
      }
    }
    finalPagina.setar();
  </script>
</body>

</html>