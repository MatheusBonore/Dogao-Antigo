<?php
    require_once('Conexao.php');

    class connect extends Conexao{
        function __construct() {
            $this->pdo = $this->Connect();
        }

        function __destruct() {
            $this->con = null;
            $this->pdo = null;
            //Se vc der die() e fechar esse objeto antes de fechar a pagina ele para de carregar a pagina
            //Eu só usaria o Die para erros n para finalizar atividades ou execuções;
            //die(); 
        }
        function getPdo(){
            return $this->pdo;
        }
    }

    

?>
