<?php

namespace Usuario\DAO;

use Exception;
use Mensagem\DAO\MensagemDAO;
use PDOException;
use Usuario\aUsuario;
use PDO;
use Usuario\Usuario;

class UsuarioDAO
{
  protected $conexao;

  protected $tableName = "usuario";

  public function __construct(PDO $conexao)
  {
    $this->conexao = $conexao;
  }

  public function checaUsuario($email, $senha)
  {
    try {

      $sql = "SELECT * FROM {$this->tableName} WHERE email=:email AND senha=:senha";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":email", $email, PDO::PARAM_STR);
      $stmt->bindValue(":senha", $senha, PDO::PARAM_STR);

      $stmt->execute();

      $return = $stmt->fetch(PDO::FETCH_OBJ);

      if (!empty($return->id)) {
        $usu =  new Usuario(
          $return->nome,
          $return->sobrenome,
          $return->data_nascimento,
          $return->email,
          $return->senha,
          $return->genero
        );
        $usu->setId($return->id);

        return $usu;
      }

      return false;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function getUsuarioId($id)
  {
    try {

      $sql = "SELECT * FROM {$this->tableName} WHERE id=:id";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $id, PDO::PARAM_STR);
      $stmt->execute();

      $return = $stmt->fetch(PDO::FETCH_OBJ);

      if (!empty($return->id)) {
        $usu = new Usuario(
          $return->nome,
          $return->sobrenome,
          $return->data_nascimento,
          $return->email,
          $return->senha,
          $return->genero
        );

        $usu->setId($return->id);

        return $usu;
      }

      return false;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function listarUsuarios($id)
  {
    try {

      $sql = "SELECT * FROM {$this->tableName} WHERE id!=:id  ORDER BY nome ASC";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $usus = $stmt->fetchAll(PDO::FETCH_OBJ);

      if (!empty($usus)) {
        foreach ($usus as $usu) {
          $usuTemp = new Usuario(
            $usu->nome,
            $usu->sobrenome,
            $usu->data_nascimento,
            $usu->email,
            $usu->senha,
            $usu->genero
          );
          $usuTemp->setId($usu->id);

          $listaUsuarios[] = $usuTemp;
        }

        return $listaUsuarios;
      }

      return false;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function inserir(aUsuario $usuario): bool
  {
    try {

      $sql = "INSERT INTO {$this->tableName} (nome, sobrenome, data_nascimento, email, senha, genero)
            value (:nome, :sobrenome, :data_nascimento, :email, :senha, :genero)";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
      $stmt->bindValue(":sobrenome", $usuario->getSobrenome(), PDO::PARAM_STR);
      $stmt->bindValue(":data_nascimento", $usuario->getNascimento(), PDO::PARAM_STR);
      $stmt->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
      $stmt->bindValue(":senha", $usuario->getSenha(), PDO::PARAM_STR);
      $stmt->bindValue(":genero", $usuario->getGenero(), PDO::PARAM_STR);

      return $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function deletar($id): bool
  {
    try {

      $msgDAO = new MensagemDAO($this->conexao);
      $msgDAO->deletarPorUsuario($id);

      $sql = "DELETE FROM $this->tableName WHERE id=:id";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $id, PDO::PARAM_STR);

      return $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Houve um erro ao tentar excluir um usuário: Usuario DAO - L " . $e->getLine());
    }
  }

  /**
   * Chamar este método criará a tabela de usuário no banco de dados,
   * especificado na classe ConexaoDB
   */
  public function createTable()
  {
    try {
      $sql = "CREATE TABLE IF NOT EXISTS usuario(
                id int(11) auto_increment primary key,
                nome varchar(20),
                sobrenome varchar(40),
                data_nascimento date,
                email varchar(40),
                senha varchar(20),
                genero varchar(1)
            ) Engine=InnoDB CHARSET=utf8 collate utf8_unicode_ci";

      $stmt = $this->conexao->prepare($sql);
      return $stmt->execute();
    } catch (\PDOException $e) {
      throw new Exception("Erro ao criar a tabela. Usuario DAO - L " . $e->getLine());
    }
  }
}
