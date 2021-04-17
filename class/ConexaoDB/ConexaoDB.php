<?php

namespace ConexaoDB;

use PDO;
use PDOException;

class ConexaoDB extends PDO
{
    private static $conexao;

    public function __construct()
    {
        //
    }

    public function getConexao(): PDO
    {
        if (empty(self::$conexao)) {
            try {
                // TODO bdname, senha
                self::$conexao = new PDO('mysql:host=localhost; dbname=ew_rede_social', 'root', '');
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexao->exec('set names utf8');
                return self::$conexao;
            } catch (PDOException $e) {
                echo ($e->getMessage());
            }
        }

        return $this->conexao;
    }
}
