<?php

namespace Mensagem\DAO;

use Exception;
use PDOException;
use PDO;
use Mensagem\Mensagem;

class MensagemDAO
{
  protected $conexao;
  protected $tableName = "Mensagem";

  public function __construct(PDO $conexao)
  {
    $this->conexao = $conexao;
  }

  public function inserir(Mensagem $mensagem): bool
  {
    try {

      $sql = "INSERT INTO {$this->tableName} (conteudo, de_usuario)
            value (:conteudo, :de_usuario, :para_usuario)";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":conteudo", $mensagem->getConteudo(), PDO::PARAM_STR);
      $stmt->bindValue(":de_usuario", $mensagem->getDe_usuario(), PDO::PARAM_STR);
      $stmt->bindValue(":para_usuario", $mensagem->getPara_usuario(), PDO::PARAM_STR);

      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getLastId()
  {
    $this->conexao->lastInsertId();
  }

  public function deletar(Mensagem $mensagem): bool
  {
    try {

      $sql = "DELETE FROM $this->tableName WHERE id=:id";

      $stmt = $this->conexao->prepare($sql);
      $stmt->bindValue(":id", $mensagem->getId(), PDO::PARAM_STR);

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
