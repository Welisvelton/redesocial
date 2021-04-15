<?php 

namespace ConexaoDB;

class ConexaoDB
{
    private $conexao;

    public function __construct()
    {
        
    }

    public function getConexao()
    {
        if($this->conexao != null){
            return $this->conexao;
        }
        
    }


}