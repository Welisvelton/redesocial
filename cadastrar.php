<?php

use ConexaoDB\ConexaoDB;
use Login\LoginUsuario;
use Mensagem\BuilderMensagem;
use Mensagem\DAO\MensagemDAO;
use Mensagem\Mensagem;
use RedeSocial\Factory\{ FactoryInstagram, FactoryFacebook,  FactoryTikTok };
use Usuario\{ aUsuario, Factory\FactoryUsuario, DAO\UsuarioDAO,  Usuario };

require(__DIR__ . "/class/Autoloading.php");

try {

  /* Cria a rede social */
  $factory = new FactoryFacebook();
  $redeSocial = $factory->criarRedeSocial();


  $conn = ConexaoDB::getConexao();
  $usuarioDAO = new UsuarioDAO($conn);


  /*Inicia o processo de exclusão do usuário que está logado*/
  if (!empty($_GET['excluir'])) {
    $idExclusao = LoginUsuario::getDadosLogin()['idUsuario'];
    $usuarioDAO->deletar($idExclusao);
    LoginUsuario::logout();
  }

  /* FACTORY - Usa a factory para criar um usuário  */
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

    /* A Factory cria o usuário */
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

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/style.css?v1" rel="stylesheet">
    </link>
    <title>Rede Social</title>
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



    <h1 style="text-align: center;">Cadastre-se para usar o <br /><?= $redeSocial->getNome() ?></h1>
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
                    <?php for ($i = 1; $i < 31; $i++) : ?>
                    <?php echo "<option value=\"{$i}\" >{$i}</option>"; ?>
                    <?php endfor; ?>
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
                <option value="O">Outro</option>
            </select>

            <input type="password" name="senha" value="" placeholder="Senha" class="input input-100" />

            <input type="submit" value="Cadastrar" class="botao">

        </form>
    </div>
</body>
</html>