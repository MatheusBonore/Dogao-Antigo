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
                $this->user = "root";
                $this->pass = "";
                $this->host = "localhost";
                $this->base = "dogao";
                
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
    
    class connect {
        function __construct() {
            $this->con = new Conexao();
            $this->pdo = $this->con->Connect();
        }
    }
    
    class consultar extends connect{
        function consult($nome_racas){
            $stmt = $this->pdo->prepare('SELECT nome_racas FROM racas WHERE nome_racas = :NOME_RACA');
            $param = array(':NOME_RACA'=>$nome_racas);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                echo'já cadastrado';
            }else{
                $stmt = $this->pdo->prepare('INSERT INTO racas (nome_racas) VALUES (:NOME_RACA)');
                $param = array(':NOME_RACA'=>$nome_racas);
                $stmt->execute($param);
                echo'cadastrado com sucesso';
            }
        }
    }
    
    
    $consultar = new consultar();
    if(isset($_GET['raca']) and !empty($_GET['raca'])){
        $nome_racas = $_GET['raca'];
        $consultar->consult($nome_racas);
    }
?>


<form method="GET">
    <input type="text" name="raca"/>
    <input type="submit"/>
</form>

<div style="white-space: pre; -webkit-column-count: 3; /* Chrome, Safari, Opera */
    -moz-column-count: 3; /* Firefox */
    column-count: 3;">
A
Alano Espanhol
Airedale Terrier 
American Staffordshire Terrier 
American Water Spaniel 
Antigo Cão de Pastor Inglês

B
Basset Azul da Gasconha 
Basset Fulvo da Bretanha
Basset Hound 
Beagle 
Bearded Collie 
Bichon Maltês 
Bobtail 
Border Collie 
Boston Terrier 
Boxer 
Bull Terrier 
Bullmastiff
Bulldog 

C
Cão de Montanha dos Pirinéus
Caniche 
Chihuahua
Cirneco do Etna
Chow Chow 
Cocker Spaniel (Americano ou Inglês)

D
Dálmata 
Dobermann 
Dogue Alemão
Dogue Argentino
Dogue Canário

F
Fox Terrier 
Foxhound

G
Galgo
Golden Retriever 
Gos d'Atura 

K
Komondor

H
Husky Siberiano

L
Laika 
Labrador Retriever

M
Malamute-do-Alasca
Mastin dos Pirenéus
Mastin do Tibete
Mastin Espanhol
Mastín Napolitano

P
Pastor Alemão
Pastor Belga 
Pastor de Brie
Pastor dos Pirenéus de Cara Rosa 
Pequinês
Perdigueiro
Pinscher
Pitbull 
Podengo
Poodle
Pointer 
Pug

R
Rhodesian Ridgeback
Rottweiler 
Rough Collie

S
Sabueso (Espanhol ou Italiano)
Saluki
Samoiedo 
São Bernardo 
Scottish Terrier 
Setter Irlandés 
Shar-Pei 
Shiba Inu 
Smooth Collie
Staffordshire Bull Terrier

T
Teckel
Terra-nova 
Terrier Australiano
Terrier Escocês 
Terrier Irlandês 
Terrier Japonês
Terrier Negro Russo
Terrier Norfolk
Terrier Norwich
Terrier Tibetano

V
Vira Lata (SRD - Sem Raça Definida)

W
Welhs Terrier
West Highland T.
Wolfspitz

Y
Yorkshire Terrier</div>

<a href="http://caes.mundoentrepatas.com/racas-caes.htm">http://caes.mundoentrepatas.com/racas-caes.htm</a>