<?php
    class cadastroUsuarioDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo = $Conexao->getPdo();             
        }
        function email_registrado($dados_cadastro){
            try{
                $email_cadastro = $dados_cadastro->getEmail_cadastro();

                $stmt = $this->pdo->prepare('SELECT email_login FROM login WHERE email_login = :EMAIL');
                $param = array(':EMAIL'=>$email_cadastro);
                $stmt->execute($param);

                if($stmt->rowCount()>0){
                    return 1;
                    ## POSSIVELMENTE PODE ACONTECER DE CADASTRAR DOIS EMAILS, CAUSANDO CONFLITO
                }else{
                    return 0;
                }
                
            } catch (PDOException $ex) {
                echo 'ERRO[email_registrado]: {'. $ex->getMessage() . '}';
            }
        }
        function cadastrar($dados_cadastro){
            try{
                $nome_cadastro = $dados_cadastro->getNome_cadastro();
                $sobrenome_cadastro = $dados_cadastro->getSobrenome_cadastro();
                $email_cadastro = $dados_cadastro->getEmail_cadastro();
                $senha_cadastro = $dados_cadastro->getSenha_cadastro();
                $dia_cadastro = $dados_cadastro->getDia_cadastro();
                $mes_cadastro = $dados_cadastro->getMes_cadastro();
                $ano_cadastro = $dados_cadastro->getAno_cadastro();
                $genero_cadastro = $dados_cadastro->getGenero_cadastro();
                $telefone1_cadastro = $dados_cadastro->getTelefone1_cadastro();
                $telefone2_cadastro = $dados_cadastro->getTelefone2_cadastro();
                $cep_cadastro = $dados_cadastro->getCep_cadastro();
                $pais_cadastro = $dados_cadastro->getPais_cadastro();
                $estado_cadastro = $dados_cadastro->getEstado_cadastro();
                $cidade_cadastro = $dados_cadastro->getCidade_cadastro();
                $bairro_cadastro = $dados_cadastro->getBairro_cadastro();
                $rua_cadastro = $dados_cadastro->getRua_cadastro();
                $numero_cadastro = $dados_cadastro->getNumero_cadastro();
                
                $stmt = $this->pdo->prepare('INSERT INTO login (email_login,senha_login) VALUES (:EMAIL, :SENHA)');
                $param = array(':EMAIL'=>$email_cadastro,':SENHA'=>$senha_cadastro);
                $stmt->execute($param);
                
                $stmt = $this->pdo->prepare('SELECT id_login FROM login WHERE email_login = :EMAIL');
                $param = array(':EMAIL'=>$email_cadastro);
                $stmt->execute($param);
                
                $id_login = $stmt->fetch(PDO::FETCH_ASSOC);
                #$id_login['id_login'];
                
                $stmt = $this->pdo->prepare('INSERT INTO usuario (id_login,nome_usuario,sobrenome_usuario,datanascimento_usuario,genero_usuario,telefone01_usuario,telefone02_usuario,cep_usuario,pais_usuario,estado_usuario,cidade_usuario,bairro_usuario,rua_usuario,numcasa_usuario,foto_usuario) VALUES (:ID,:NOME,:SOBRENOME,:DTNASCIMENTO,:GENERO,:TELEFONE1,:TELEFONE2,:CEP,:PAIS,:ESTADO,:CIDADE,:BAIRRO,:RUA,:NUMERO,:FOTO)');
                $param = array(
                    ':ID'=>$id_login["id_login"],
                    ':NOME'=>$nome_cadastro,
                    ':SOBRENOME'=>$sobrenome_cadastro,
                    ':DTNASCIMENTO'=>$ano_cadastro.'-'.$mes_cadastro.'-'.$dia_cadastro,
                    ':GENERO'=>$genero_cadastro,
                    ':TELEFONE1'=>$telefone1_cadastro,
                    ':TELEFONE2'=>$telefone2_cadastro,
                    ':CEP'=>$cep_cadastro,
                    ':PAIS'=>$pais_cadastro,
                    ':ESTADO'=>$estado_cadastro,
                    ':CIDADE'=>$cidade_cadastro,
                    ':BAIRRO'=>$bairro_cadastro,
                    ':RUA'=>$rua_cadastro,
                    ':NUMERO'=>$numero_cadastro,
                    ':FOTO'=>'layout/user.png'
                );
            
                $stmt->execute($param);
                
                
                /*$stmt = $this->pdo->prepare('SELECT email_login FROM login WHERE email_login = :EMAIL');
                $param = array(':EMAIL'=>$email_cadastro);
                $stmt->execute($param);

                if($stmt->rowCount()>0){
                    return 1;
                    ## POSSIVELMENTE PODE ACONTECER DE CADASTRAR DOIS EMAILS, CAUSANDO CONFLITO
                }else{
                    return 0;
                }*/
                
            } catch (PDOException $ex) {
                echo 'ERRO[cadastrar]: {'. $ex->getMessage() . '}';
            }
        }
    }
    

/*require_once('Conexao.php');
class usuarioDAO{
    function __construct() {
        $this->con = new Conexao();
        $this->pdo = $this->con->Connect();
    }
    
    function login($email_usuario, $senha_usuario){
        try{
            if(isset($_SESSION['DADOS']['EMAIL']) and isset($_SESSION['DADOS']['SENHA'])){
                $email_usuario = $_SESSION['DADOS']['EMAIL'];
                $senha_usuario = base64_decode($_SESSION['DADOS']['SENHA']);
            }
            
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$email_usuario);
            $stmt->execute($param);
            
            ## EMAIL NÃO EXISTE 1
            ## SENHA ERRADA 2
            ## EMAIL EXISTE 3
            
            if($stmt->rowCount()>0){
                #EXISTE EMAIL
                #echo '<script>alert("EXISTE EMAIL");</script>';
                
                $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL AND senha_login = :SENHA');
                $param = array(
                    ':EMAIL'=>$email_usuario,
                    ':SENHA'=>md5($senha_usuario)
                );
                
                $stmt->execute($param);
                
                if($stmt->rowCount()>0){
                    $stmt = $this->pdo->prepare('UPDATE login SET ip_login = :IP, data_login = :DATA, hora_login = :HORA WHERE email_login = :EMAIL');
                    $param = array(
                        ':IP'=>$_SERVER['REMOTE_ADDR'],
                        ':DATA'=>date('Y-m-d'),
                        ':HORA'=>date('h:i:s'),
                        ':EMAIL'=>$email_usuario
                    );
                    
                    $_SESSION['DADOS']['EMAIL'] = $email_usuario;
                    $_SESSION['DADOS']['SENHA'] = base64_encode($senha_usuario);
                    $stmt->execute($param);
                    #echo '<script>alert("Achou tudo!!");</script>';
                    return 3;
                    
                }else{
                    #echo '<script>alert("Senha Errada");</script>';
                    return 2;
                }
                
                
            }else{
                #NÃO EXISTE EMAIL
                return 1;               
            }
        } catch (PDOxception $ex) {
            echo 'ERRO[login]: {'. $ex->getMessage() . '}';
        }
    }
    
    function pegar_informacao($email, $informacao){
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$email);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_login = $row['id_login'];
            }
            
            $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE id_login = :ID');
            $param = array(':ID'=>$id_login);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row[$informacao];
            }
            
        } catch (PDOException $ex) {
            echo 'ERRO[pegar_informacao]: {'. $ex->getMessage() . '}';
        }
    }
    
    function cadastrarPart1(dadosPart1 $dadosPart1){
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$_SESSION['DADOS']['EMAIL']);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_usuario = $row['id_login'];
                
                if($dadosPart1->getTelefone1() !== 'NULL'){
                    $stmt = $this->pdo->prepare('UPDATE usuario SET telefone01_usuario= :TELEFONE01 WHERE id_login= :ID');
                    $param = array(
                        ':TELEFONE01'=>$dadosPart1->getTelefone1(),
                        ':ID'=>$id_usuario
                    );
                    
                    $stmt->execute($param);
                }
                
                if($dadosPart1->getTelefone2() !== 'NULL'){
                    $stmt = $this->pdo->prepare('UPDATE usuario SET telefone02_usuario= :TELEFONE02 WHERE id_login= :ID');
                    $param = array(
                        ':TELEFONE02'=>$dadosPart1->getTelefone2(),
                        ':ID'=>$id_usuario
                    );
                    
                    $stmt->execute($param);
                }
                
                if($dadosPart1->getNumero() !== 'NULL'){
                    $stmt = $this->pdo->prepare('UPDATE usuario SET numcasa_usuario= :NUMERO WHERE id_login= :ID');
                    $param = array(
                        ':NUMERO'=>$dadosPart1->getNumero(),
                        ':ID'=>$id_usuario
                    );
                    
                    $stmt->execute($param);
                }
                
                
                $stmt = $this->pdo->prepare('UPDATE usuario SET cep_usuario= :CEP, estado_usuario= :ESTADO, cidade_usuario= :CIDADE, bairro_usuario= :BAIRRO, rua_usuario= :RUA WHERE id_login = :ID');
                $param = array(
                    ':CEP'=>$dadosPart1->getCep(),
                    ':ESTADO'=>$dadosPart1->getEstado(),
                    ':CIDADE'=>$dadosPart1->getCidade(),
                    ':BAIRRO'=>$dadosPart1->getBairro(),
                    ':RUA'=>$dadosPart1->getRua(),
                    ':ID'=>$id_usuario
                );
            
                return $stmt->execute($param);
                
                
            }
            
            
            
            
        } catch (Exception $ex) {
            echo 'ERRO[cadastrarPart1]: {' . $ex->getMessage() . '}';
        }
        
        
    }
    
    function cadastrar_foto_profile($foto, $email){
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$email);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_login = $row['id_login'];
            
            
                $stmt = $this->pdo->prepare('UPDATE usuario SET foto_usuario= :FOTO WHERE id_login= :ID');
                $param = array(
                    ':FOTO' => $foto,
                    ':ID' => $id_login
                );

                $stmt->execute($param);
            }
            
        } catch (PDOException $ex) {
            echo 'ERRO[cadastrar_foto_profile]: {'. $ex->getMessage() . '}';
        }
    }
    
    function cadastrar_foto_bg($foto, $email){
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$email);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_login = $row['id_login'];
            
            
                $stmt = $this->pdo->prepare('UPDATE usuario SET capa_usuario= :FOTO WHERE id_login= :ID');
                $param = array(
                    ':FOTO' => $foto,
                    ':ID' => $id_login
                );

                $stmt->execute($param);
            }
            
        } catch (PDOException $ex) {
            echo 'ERRO[cadastrar_foto_capa]: {'. $ex->getMessage() . '}';
        }
    }
    
    function cadastrar_foto_null($email){
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$email);
            $stmt->execute($param);
            
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_login = $row['id_login'];
            
            
                $stmt = $this->pdo->prepare('UPDATE usuario SET foto_usuario= :FOTO WHERE id_login= :ID');
                $param = array(
                    ':FOTO' => 'NULL',
                    ':ID' => $id_login
                );

                $stmt->execute($param);
            }
        } catch (PDOException $ex) {
            echo 'ERRO[cadastrar_foto_null]: {'. $ex->getMessage() . '}';
        }
    }
}
*/