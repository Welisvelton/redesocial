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
  DAO\UsuarioDAO,
  Usuario
};

require(__DIR__ . "/class/Autoloading.php");

try {
  /* Cria a rede social */
  $factory = new FactoryFacebook();
  $redeSocial = $factory->criarRedeSocial();


  $conn = ConexaoDB::getConexao();
  $usuarioDAO = new UsuarioDAO($conn);


  if (!empty($_POST['email']) && !empty($_POST['nome']) && !empty($_POST['senha'])) {

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
    $dia = filter_input(INPUT_POST, 'dia', FILTER_SANITIZE_STRING);
    $mes = filter_input(INPUT_POST, 'mes', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);
    $data = $ano . "-" . $mes . "-" . $dia;
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);

    $factoryUsuario = new FactoryUsuario();
    $usuarioCadastro =  $factoryUsuario->criarUsuario($nome, $sobrenome, $data, $email, $senha, $genero);
    $return = $usuarioDAO->inserir($usuarioCadastro);

    if ($return == true) {
      LoginUsuario::logar($email, $senha);
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
}






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

    .container-cadastro {
      width: 95%;
      max-width: 400px;
      height: auto;
      padding: 10px;
      margin: auto auto;

    }

    .flex {
      display: flex;
    }

    .input-100 {
      width: 98%;
    }

    .input-50 {
      width: 50%;
    }

    .input-33 {
      width: 33.3333%;
    }

    .input-20 {
      width: 20%;
    }


    .input {
      display: inline-block;
      font-size: 16px;
      line-height: 25px;
      border: #34487c solid 1px;
      box-sizing: border-box;
      margin: 3px 8px 5px 0px;
      border-radius: 8px;
      padding: 8px;
      color: #34487c;

    }

    .botao {
      width: 100%;
      font-size: 16px;
      line-height: 25px;
      border: #34487c solid 1px;
      box-sizing: border-box;
      margin-bottom: 5px;
      border-radius: 8px;
      padding: 8px;
      background-color: #34487c;
      color: #d6dced;
      cursor: pointer;
    }
  </style>
</head>

<body>




  <div class="barra-superior">
    <?php if (!empty($ussu)) : ?>
      <span> Olá, <?= $usu->getNome(); ?> </span> &nbsp; <a href="?sair"> <button>Sair</button></a>

    <?php else : ?>

      <form action="/index.php" method="POST" class="form-login">
        Entre para começar
        <input type="text" name="email" size="10" placeholder="E-mail" /> <input type="password" name="senha" value="" size="10" placeholder="Senha" />
        <input type="submit" value="Entrar" /> <a href="cadastrar.php"> <input type="button" value="Cadastrar" />
        </a>
      </form>
    <?php endif; ?>

  </div>






  <h1><?= $redeSocial->getNome() ?></h1>


  <div class="container-cadastro">

    <form action="/cadastrar.php" method="POST" enctype="multipart/form-data">
      <div class="flex">
        <input type="text" name="nome" value="" placeholder="Nome" required class="input input-50" />
        <input type="text" name="sobrenome" value="" placeholder="Sobrenome" required class="input input-50" />
      </div>
      <input type="email" name="email" value="" placeholder="E-mail" class="input input-100" />
      <br />
      Data Nascimento:
      <div class="flex">

        <select name="dia" class="input input-33">
          <?php for ($i = 1; $i < 31; $i++) :
            echo "<option value=\"{$i}\" >{$i}</option>";
          endfor;
          ?>


        </select>

        <select name="mes" class="input input-33">
          <option value="01">Janeiro</option>
          <option value="02">Fevereiro</option>
          <option value="03"> Março</option>
          <option value="04">Abril</option>
          <option value="05">Maio</option>
          <option value="06">Junho</option>
          <option value="07">Julho</option>
          <option value="08">Agosto</option>
          <option value="09">Setembro</option>
          <option value="10">Outubro</option>
          <option value="11">Novembro</option>
          <option value="12">Dezembro</option>
        </select>

        <input type="text" name="ano" value="" placeholder="Ano 1993" class="input input-33" />
      </div>

      <select name="genero" class="input input-100">
        <option value="F">Feminino</option>
        <option value="M">Masculino</option>
      </select>
      <input type="password" name="senha" value="" placeholder="Senha" class="input input-100" />

      <input type="submit" value="Cadastrar" class="botao">



    </form>
  </div>


</body>

</html>