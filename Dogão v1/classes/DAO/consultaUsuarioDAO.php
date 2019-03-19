<?php
    class consultaUsuarioDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
        function consultarUsuario($email, $informacao){
            try{
                $stmt = $this->pdo->prepare('SELECT id_login FROM login WHERE email_login = :EMAIL');
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
                echo 'ERRO[consultarUsuario]: {'. $ex->getMessage() . '}';
            }
        }
        
        function optionForm(){
            try{
                $stmt = $this->pdo->prepare('SELECT nome_racas FROM racas ORDER BY nome_racas');
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo'<option value="'.$row['nome_racas'].'">'.$row['nome_racas'].'</option>';
                }
                print_r($row);
            } catch (PDOException $ex) {
                 echo 'ERRO[optionForm]: {'. $ex->getMessage() . '}';
            }
        }
    }
?>