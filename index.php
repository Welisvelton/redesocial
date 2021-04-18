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
  /* Cria a rede social */
  $factory = new FactoryFacebook();
  $redeSocial = $factory->criarRedeSocial();

  $conn = ConexaoDB::getConexao();
  $usuarioDAO = new UsuarioDAO($conn);
} catch (Exception $e) {
  echo $e->getMessage();
}

$factoryUsuario = new FactoryUsuario();

try {
  $dadosLogado = LoginUsuario::getDadosLogin();

  if (!empty($dadosLogado)) {
    $usu = $usuarioDAO->getUsuarioId($dadosLogado['idUsuario']);
  }


  if (!empty($_POST['email'])) {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    LoginUsuario::logar($email, $senha);
  }


  if (isset($_GET['sair'])) {
    LoginUsuario::logout();
  }
} catch (Exception $e) {
  echo $msgSistema = $e->getMessage();
} finally {
  $msgSistema;
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
      justify-content: space-between;
      flex-flow: flex-end;
      box-sizing: border-box;
      margin-bottom: 20px;
    }

    .form-login {
      width: auto;
      min-width: 30px;
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
      background-color: #d6dced;
      box-sizing: border-box;
      padding: 8px;
      border: #34487c;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }

    .container-chat>iframe {
      width: 100%;
      border: none;
      height: 400px;
    }

    .botao-excluir-conta {
      position: fixed;
      bottom: 2px;
      left: 2px;
    }

    .container-usuarios {
      display: flex;
      flex-direction: column;
      width: 50%;
      max-width: 400px;
      height: auto;
      background: #d6dced;
      padding: 10px;
      box-sizing: border-box;
    }

    .box-usuarios {
      display: flex;
      margin-bottom: 10px;
      align-items: center;

    }

    .avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      border: #34487c 3px solid;
      margin-right: 10px;
      background-color: #34487c;
    }

    .nome {}
  </style>
</head>

<body>

  <div class="barra-superior">
    <strong><?= $redeSocial->getNome() ?> </strong> &nbsp; &nbsp;


    <form action="" method="POST" class="form-login">
      <?php if (!empty($usu)) : ?>
        <span> Olá, <?= $usu->getNome(); ?>!</span> &nbsp;
        <a href="?sair"> <input type="button" value="Sair"></a>

      <?php else : ?>
        Entre para começar
        <input type="text" name="email" size="10" placeholder="E-mail" />
        <input type="password" name="senha" value="" size="10" placeholder="Senha" />
        <input type="submit" value="Entrar" /> <a href="cadastrar.php">
          <input type="button" value="Cadastrar" />
        </a>
      <?php endif; ?>
    </form>


  </div>

  <div class="container-usuarios">
    <div>AMIGOS
      <BR />
      <hr />
      <br>
    </div>
    <?php if (!empty($usu)) : ?>
      <?php foreach ($usuarioDAO->listarUsuarios($usu->getId()) as $amigos) : ?>
        <a href="/mensagens.php?para_usu=<?= $amigos->getId(); ?>&de_usu=<?= $usu->getId(); ?>" target="chat">
          <div class="box-usuarios">
            <div class="avatar">
            </div>
            <div>
              <?= $amigos->getNome(); ?>
            </div>
            </div>
        </a>


  
<?php endforeach; ?>
<?php endif ?>
Clique para iniciar uma conversa
</div>




<?php if (!empty($usu)) : ?>

  <div class="container-chat">

    <iframe src="" id="chat" name="chat"></iframe>
  </div>


<?php endif; ?>

<?php include(__DIR__ . "/footer.php"); ?>
</body>

</html>