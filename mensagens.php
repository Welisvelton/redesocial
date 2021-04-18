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

  /*Inicia os objetos que farão a manipulação no banco de dados*/
  $conn = ConexaoDB::getConexao();
  $usuarioDAO = new UsuarioDAO($conn);
  $msgDAO = new MensagemDAO($conn);


  /* Recebe a referência (id) do usuário que receberá as mensagens*/
  $para_usuario = (empty($_GET['para_usu'])) ? null : filter_input(INPUT_GET, 'para_usu', FILTER_SANITIZE_NUMBER_INT);

  /* Pega a referência do usuário que está logado, para saber quem enviará as mensagens */
  $de_usuario = LoginUsuario::getDadosLogin();

  /* */
  $thisUsu = $usuarioDAO->getUsuarioId($de_usuario['idUsuario']);
  $usuPara = $usuarioDAO->getUsuarioId($para_usuario);



  /* - PROTOTYPE - PARA ENCAMINHAMENTO DE MENSAGENS*/
  if (!empty($_GET['idMensagem']) && !empty($para_usuario)) {

    $idMensagem = filter_input(INPUT_GET, 'idMensagem', FILTER_SANITIZE_NUMBER_INT);

    $msg = $msgDAO->getMensagemPorId($idMensagem); // A variável recebe uma mensagem a partir da chave primária
    $encaminhar = $msg->clonar(); // a variável recebe um clone da mensagem
    $encaminhar->setDe_usuario($thisUsu->getId()); // Quem envia é alterado
    $encaminhar->setPara_usuario($usuPara->getId()); // Quem recebe é alterado

    $msgDAO->inserir($encaminhar); // a mensagem é gravada no banco de dados
    $msg = null;
  }


  /*BUILDER - CONSTROI UMA MENSAGEM POR ETAPAS E ENVIA AO FINAL*/
  $bmsg = new BuilderMensagem();
  $testeConteudo = null; // Se um conteúdo for adicionado no final 

  if (!empty($_POST['sendmsg'])) {

    $texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING);
    if (!empty($texto)) {
      $bmsg->criarTexto($texto);
      $testeConteudo++;
    }
  }

  if (!empty($_GET['audio'])) {
    $bmsg->criarAudio("Este é o meu áudio " . $usuPara->getNome());
    $testeConteudo++;
  }

  if (!empty($_GET['video'])) {
    $bmsg->criarVideo("Este é o meu vídeo " . $usuPara->getNome());
    $testeConteudo++;
  }

  if (!empty($_GET['imagem'])) {
    $bmsg->criarImagem("Esta é a foto " . $usuPara->getNome());
    $testeConteudo++;
  }

  if (!empty($testeConteudo)) {
    $msg = $bmsg->getResult();
    $msg->setDe_usuario($thisUsu->getId());
    $msg->setPara_usuario($usuPara->getId());
    $msgDAO->inserir($msg);
  }

  /* ----------------------------------*/


  /* EXCLUI UMA MENSAGEM */
  if (!empty($_GET['excluir'])) {
    $excluir = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);
    $msgDAO->deletar($excluir);
  }


  /* LISTA AS MENSAGENS DE DOIS USUÁRIOS */
  $listaConversas = $msgDAO->listarConversa($thisUsu->getId(), $usuPara->getId());


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
  <link href="/assets/css/style.css" rel="stylesheet">
  </link>
  <script>
    var moverScrol = {
      setar: function(id) {
        var elmnt = document.getElementById(id);
        elmnt.scrollIntoView();
      }
    }
  </script>
  <script>
    var Mensagem = {
      deUsuario: null,
      paraUsuario: null,
      idMensagem: null,
      encaminhar: function(idDe, idPara) {
        this.deUsuario = idDe;
        this.paraUsuario = idPara;

        console.log("De : " + this.deUsuario);
        console.log("Para : " + this.paraUsuario);

        this.enviar();
      },

      verUsuarios: function() {
        var elem = document.getElementById("container-lista-usuarios");
        elem.style.height = window.innerHeight + "px"
        moverScrol.setar('inicio')
      },
      fechar() {
        var elem = document.getElementById("container-lista-usuarios");
        elem.style.height = "0px"
      },
      setIdMensagem: function(idMensagem) {
        this.idMensagem = idMensagem
        this.verUsuarios();
        console.log("iD DA MENSAGEM : " + this.idMensagem);
      },
      enviar() {
        window.location = "/mensagens.php?idMensagem=" + this.idMensagem + "&para_usu=" + this.paraUsuario;
      }
    }
  </script>
</head>

<body>
  <div id="inicio"></div>
  <?php if (!empty($para_usuario)) : ?>
    <?= $usuPara->getNome(); ?>
    <hr />
    <div class="mensagens">
      <?php if (!empty($listaConversas)) : ?>
        <?php foreach ($listaConversas as $msg) : ?>
          <div class="<?= ($msg->getDe_usuario() == $thisUsu->getId()) ? "saida" : "entrada" ?>">
            <div class="data-hora"> <?= $msg->getData_hora(); ?></div>
            <?= $msg->getConteudo() ?>
            <hr />
            <a href="?para_usu=<?= $usuPara->getId() ?>&excluir=<?= $msg->getId() ?>">Encluir</a>
            <a href="JavaScript:Mensagem.setIdMensagem('<?= $msg->getId() ?>')"> Encaminhar </a>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        Você ainda não tem conversas com <?= $usuPara->getNome(); ?>
      <?php endif; ?>
    </div>
    <br />
    <div>
      <form action="mensagens.php?para_usu=<?= $usuPara->getId(); ?>" method="POST">
        <input type="hidden" name="sendmsg" value="1">
        <textarea name="texto" class="caixa-texto"></textarea>
        <input type="submit" value="Enviar">
      </form>
    </div>
    <hr />
    <div class="box-form">
      <a href="?para_usu=<?= $usuPara->getId() ?>&audio=1">
        <input type="button" value="Audio" class="botoes-extras">
      </a>
      <br />
      <a href="?para_usu=<?= $usuPara->getId() ?>&imagem=1">
        <input type="button" value="imagem" class="botoes-extras">
      </a>
      <br />
      <a href="?para_usu=<?= $usuPara->getId() ?>&video=1">
        <input type="button" value="Video" class="botoes-extras">
      </a>
      <br />
    </div>
    <div id="final"></div>
  <?php endif; ?>

  <div id="container-lista-usuarios">
    <div>
      <a href="JavaScript:Mensagem.fechar()"> X </a>
    </div>
    <div>
      <?php if (!empty($thisUsu)) : ?>
        <?php foreach ($usuarioDAO->listarUsuarios($thisUsu->getId()) as $amigos) : ?>
          <a href="JavaScript:Mensagem.encaminhar(<?= $thisUsu->getId(); ?>, <?= $amigos->getId(); ?>)">
            <div class="box-usuarios">
              <div class="avatar"> </div>
              <div>
                <?= $amigos->getNome(); ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      <?php endif ?>
    </div>
  </div>

  <script>
    moverScrol.setar('final');
  </script>

</body>
</html>