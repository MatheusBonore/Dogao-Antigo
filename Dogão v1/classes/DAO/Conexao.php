<?php
date_default_timezone_set("Brazil/East");
    class Conexao{
        private $user;
        private $pass;
        private $host;
        private $base;
        private $file;
        public $pdo;
        
        public function Connect(){
            try{
                $this->user = "u397006275_dogao";
                $this->pass = "dogao2016";
                $this->host = "mysql.hostinger.com.br";
                $this->base = "u397006275_dogao";
                /*$this->user = "root";
                $this->pass = "";
                $this->host = "localhost";
                $this->base = "dogao";*/
                
                $parametros = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
             
                
                $this->file = "mysql:host=" . $this->host . ";dbname=" . $this->base;
                $this->pdo = new PDO($this->file, $this->user, $this->pass, $parametros);
                
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
                
                if(!$this->pdo){
                    echo "ERRO NA CONEXAO";
                }
                return $this->pdo;
            } catch (PDOException $ex) {
                echo 'ERRO[Connect]: {'. $ex->getMessage(). '}';

            }
        }
    }
?>