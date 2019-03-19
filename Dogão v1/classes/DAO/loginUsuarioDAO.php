<?php
    class loginUsuarioDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
        function login($dados_login){
            try{
                $email_entrar = $dados_login->getEmail_login();
                $senha_entrar = $dados_login->getSenha_login();

                $stmt = $this->pdo->prepare('SELECT email_login FROM login WHERE email_login = :EMAIL');
                $param = array(':EMAIL'=>$email_entrar);
                $stmt->execute($param);

                if($stmt->rowCount()>0){
                    #EMAIL EXISTE
                    $stmt = $this->pdo->prepare('SELECT senha_login FROM login WHERE email_login = :EMAIL AND senha_login = :SENHA');
                    $param = array(
                        ':EMAIL'=>$email_entrar,
                        ':SENHA'=>$senha_entrar
                    );
                    $stmt->execute($param);
                    
                    if($stmt->rowCount()>0){
                        #EMAIL E SENHA CORRETOS
                        $stmt = $this->pdo->prepare('UPDATE login SET ip_login = :IP, data_login = :DATA WHERE email_login = :EMAIL');
                        $param = array(
                            ':IP'=>$_SERVER['REMOTE_ADDR'],
                            ':DATA'=>date('Y-m-d h:i:s'),
                            ':EMAIL'=>$email_entrar
                        );
                        $stmt->execute($param);
                        return 0;
                    }else{
                        #SENHA ERRADA
                        return 1;
                    }
                }else{
                    #EMAIL NÃO EXISTE
                    return 2;
                }
            } catch (PDOxception $ex) {
                echo 'ERRO[login]: {'. $ex->getMessage() . '}';
            } 
        }
    }
/*
    function login($email_usuario, $senha_usuario){
        try{
            if(isset($_SESSION['DADOS']['EMAIL']) and isset($_SESSION['DADOS']['SENHA'])){
                $email_usuario = $_SESSION['DADOS']['EMAIL'];
                $senha_usuario = base64_decode($_SESSION['DADOS']['SENHA']);
            }
            
            $stmt = $this->pdo->prepare('SELECT * FROM login WHERE email_login = :EMAIL');
            $param = array(':EMAIL'=>$email_usuario);
            $stmt->execute($param);
            
   
            ## EMAIL EXISTE 0 
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
}*/
?>