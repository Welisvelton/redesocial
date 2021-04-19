<?php

use ConexaoDB\ConexaoDB;
use Login\LoginUsuario;
use RedeSocial\Factory\{ FactoryInstagram, FactoryFacebook, FactoryPostFacebook, FactoryTikTok };
use Usuario\{ aUsuario, Factory\FactoryUsuario, DAO\UsuarioDAO };

require(__DIR__ . "/class/Autoloading.php");

try {
  /* Cria a rede social */
  $factory = new FactoryFacebook();
  $redeSocial = $factory->criarRedeSocial();

  /* */
  $conn = ConexaoDB::getConexao();
  $usuarioDAO = new UsuarioDAO($conn);
} catch (Exception $e) {
  echo $e->getMessage();
}

$factoryUsuario = new FactoryUsuario();

try {

  /* A variavel $dadosLogado recebe alguns dados que são gravados na sessão de login */
  $dadosLogado = LoginUsuario::getDadosLogin();
  if (!empty($dadosLogado)) {
    $usu = $usuarioDAO->getUsuarioId($dadosLogado['idUsuario']);

    /** Abstract Factory - uma fábrica que cria vários */
    $factoryPost = new FactoryPostFacebook();

   $feed = $factoryPost->criarFeed(
      $usu,
      '/caminho/da/foto/a/ser/postada.jpeg',
      "Final de semana de muito trabalho na rede social");

    $story =  $factoryPost->criarStory($usu, '/caminho/da/foto/final-de-semana-chegadno-ao-fim.jpeg');

    $feed->postar();
    $story->postar();
  }

  /** Inicia a ação de logar */
  if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    LoginUsuario::logar($email, $senha); // Faz login
  }

  /* Aciona o método para fazer logout */
  if (isset($_GET['sair'])) {
    LoginUsuario::logout();
  }
} catch (Exception $e) {
  $msgSistema = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rede Social</title>
  <link href="/assets/css/style.css?v1" rel="stylesheet"> </link>

</head>

<body>

  <div class="barra-superior">
    <strong><?= $redeSocial->getNome() ?> </strong> &nbsp; &nbsp;

    <form action="" method="POST" class="form-login">
      <?php if (!empty($usu)) : ?>
        <span> Olá, <?= $usu->getNome(); ?>!</span> &nbsp;
        <a href="?sair"> <input type="button" value="Sair"></a>
        <a href="cadastrar.php"><input type="button" value="Cadastrar amigo" />

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
    <div>

      <br>
    </div>
    <?php if (!empty($usu) && $usuarioDAO->listarUsuarios($usu->getId())) : ?>
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
   
  </div>

  <?php if (!empty($usu)) : ?>
    <div class="container-chat">
      <iframe src="" id="chat" name="chat"></iframe>
    </div>
  <?php endif; ?>

  <?php include(__DIR__ . "/footer.php"); ?>
</body>
</html>