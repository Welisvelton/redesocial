<?php

namespace Mensagem\DAO;

use Exception;
use PDOException;
use PDO;
use Mensagem\Mensagem;

class MensagemDAO
{
  protected $conexao;
  protected $tableName = "mensagem";

  public function __construct(PDO $conexao)
  {
    $this->conexao = $conexao;
  }

  public function listarConversa($deUsu, $paraUsu)
  {
    try {

      $sql = "SELECT * FROM {$this->tableName} 
      WHERE de_usuario=:de_usuario AND para_usuario=:para_usuario OR
       de_usuario=:para_usuario  AND para_usuario=:de_usuario
      ORDER by data_hora ASC";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":de_usuario", $deUsu, PDO::PARAM_INT);
      $stmt->bindValue(":para_usuario", $paraUsu, PDO::PARAM_INT);

      $stmt->execute();

      $msgs = $stmt->fetchAll(PDO::FETCH_OBJ);

      if (!empty($msgs)) {

        foreach ($msgs as $ms) {
          $mtemp = new Mensagem();
          $mtemp->setId($ms->id);
          $mtemp->setConteudo($ms->conteudo);
          $mtemp->setDe_usuario($ms->de_usuario);
          $mtemp->setPara_usuario($ms->para_usuario);
          $mtemp->setData_hora($ms->data_hora);
          $listaMsg[] = $mtemp;
        }

        return $listaMsg;
      }

      return false;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getMensagemPorId($id){
    try {

      $sql = "SELECT * FROM {$this->tableName} WHERE id=:id ";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      $stmt->execute();

      $ms = $stmt->fetch(PDO::FETCH_OBJ);

      if (!empty($ms)) {
          $mtemp = new Mensagem();
          $mtemp->setId($ms->id);
          $mtemp->setConteudo($ms->conteudo);
          $mtemp->setDe_usuario($ms->de_usuario);
          $mtemp->setPara_usuario($ms->para_usuario);
          $mtemp->setData_hora($ms->data_hora);
         
        return $mtemp;
      }

      return false;

    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function inserir(Mensagem $mensagem): bool
  {
    try {

      $sql = "INSERT INTO {$this->tableName} (conteudo, de_usuario, para_usuario)
            value (:conteudo, :de_usuario, :para_usuario)";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":conteudo", $mensagem->getConteudo(), PDO::PARAM_STR);
      $stmt->bindValue(":de_usuario", $mensagem->getDe_usuario(), PDO::PARAM_INT);
      $stmt->bindValue(":para_usuario", $mensagem->getPara_usuario(), PDO::PARAM_INT);

      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getLastId()
  {
    $this->conexao->lastInsertId();
  }

  public function deletar($id): bool
  {
    try {

      $sql = "DELETE FROM $this->tableName WHERE id=:id";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);

      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function deletarPorUsuario($id): bool
  {
    try {

      $sql = "DELETE FROM $this->tableName WHERE de_usuario=:id or para_usuario=:id";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);

      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function createTable()
  {
    try {
      $sql = "CREATE TABLE IF NOT EXISTS `Mensagem`(
                `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `conteudo` VARCHAR(1000),
                `data_hora` TIMESTAMP NULL DEFAULT now(),
                `de_usuario` INT NOT NULL,
                `para_usuario` INT NOT NULL,
                CONSTRAINT `fk_de_usuario`
                  FOREIGN KEY (`de_usuario`)
                  REFERENCES `Usuario` (`id`),
                CONSTRAINT `fk_para_usuario`
                  FOREIGN KEY (`para_usuario`)
                  REFERENCES `Usuario` (`id`)
            ) Engine=InnoDB CHARSET=utf8 collate utf8_unicode_ci";

      $stmt = $this->conexao->prepare($sql);
      return $stmt->execute();
    } catch (\PDOException $e) {
      throw new Exception("Erro ao criar a tabela. " . $e->getMessage());
    }
  }
}
