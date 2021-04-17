<?php 

namespace UsuarioDAO;
use ConexaoDB\ConexaoDB;
use Exception;
use PDOException;
use Usuario\aUsuario;
use PDO;

class UsuarioDAO
{
    private $conexao;
    private $tableName = "Usuario";
    
    public function __construct(ConexaoDB $conexao)
    {
        $this->conexao = $conexao;
    }

    public function inserir(aUsuario $usuario):bool
    {
        try{

            $sql = "INSERT INTO {$this->tableName} (nome, sobrenome, data_nascimento, email, senha, genero)
            value (:nome, :sobrenome, :data_nascimento, :email, :senha, :genero)";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(":sobrenome", $usuario->getSobrenome(), PDO::PARAM_STR);
            $stmt->bindValue(":nascimento", $usuario->getNascimento(), PDO::PARAM_STR);
            $stmt->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(":senha", $usuario->getSenha(), PDO::PARAM_STR);
            $stmt->bindValue(":genero", $usuario->getGenero(), PDO::PARAM_STR);
            
            return $stmt->execute();

        } catch(PDOException $e){

        }
    }

    public function deletar(aUsuario $usuario):bool
    {
        try{

            $sql = "DELETE FROM $this->tableName WHERE id=:id";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(":id", $usuario->getId(), PDO::PARAM_STR);
            
            return $stmt->execute();

        } catch(PDOException $e){

        }
    }

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
            ) Engine=InnoDB collate utf8_unicode_ci CHARSET=utf8";

            $stmt = $this->conexao->prepare($sql);
            return $stmt->execute();

        } catch (\PDOException $e) {
            throw new Exception("Erro ao criar a tabela. " . $e->getMessage());
        }
    }
} 
