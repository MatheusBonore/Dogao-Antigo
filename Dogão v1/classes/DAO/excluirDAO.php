<?php
    class excluirDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
        function excluirNotificacao($id_notificacao){
            try {
                $stmt = $this->pdo->prepare('SELECT id_notificacao FROM notificacao WHERE id_notificacao = :ID_NOTIFICACAO');
                $param = array(':ID_NOTIFICACAO'=>$id_notificacao);
                $stmt->execute($param);

                if($stmt->rowCount() > 0){
                    $stmt = $this->pdo->prepare('DELETE FROM notificacao WHERE id_notificacao = :ID_NOTIFICACAO');
                    $stmt->execute($param);
                }
            } catch (PDOException $ex) {
                echo 'ERRO[excluirNotificacao]: {'. $ex->getMessage() . '}';
            }
        }

        function excluirAnimal($id_animal){
            try {
            	$stmt = $this->pdo->prepare('SELECT id_post,id_animal FROM post WHERE id_animal = :ID_ANIMAL');
            	$param = array(':ID_ANIMAL'=>$id_animal);

            	$stmt->execute($param);

            	$stmtAA = $this->pdo->prepare('SELECT id_animal,foto_animal FROM animal WHERE id_animal = :ID_ANIMAL');
            	$paramAA = array(':ID_ANIMAL'=>$id_animal);

            	$stmtAA->execute($paramAA);

            	if($stmtAA->rowCount()>0){
            		$rowAA = $stmtAA->fetch(PDO::FETCH_ASSOC);
            		$foto_animal = $rowAA['foto_animal'];

            		unlink($foto_animal);
            	}

            	if($stmt->rowCount() > 0){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id_post = $row['id_post'];

                    $stmt = $this->pdo->prepare('SELECT id_notificacao,id_post FROM notificacao WHERE id_post = :ID_POST');
                    $param = array(
                        ':ID_POST'=>$id_post
                    );

                    $stmt->execute($param);

                    if($stmt->rowCount() > 0){
                        $stmt = $this->pdo->prepare('DELETE FROM notificacao WHERE id_post = :ID_POST');
                        $param = array(':ID_POST'=>$id_post);
                        $stmt->execute($param);
                    }

            		$stmt = $this->pdo->prepare('DELETE FROM post WHERE id_animal = :ID_ANIMAL');
            		$param = array(':ID_ANIMAL'=>$id_animal);
            		$stmt->execute($param);

            		$stmt = $this->pdo->prepare('DELETE FROM animal WHERE id_animal = :ID_ANIMAL');
            		$param = array(':ID_ANIMAL'=>$id_animal);
            		$stmt->execute($param);
            	}else{
            		$stmt = $this->pdo->prepare('DELETE FROM animal WHERE id_animal = :ID_ANIMAL');
            		$param = array(':ID_ANIMAL'=>$id_animal);
            		$stmt->execute($param);
            	}

                $stmtAA = $this->pdo->prepare('SELECT id_animal FROM animal WHERE id_animal = :ID_ANIMAL');
                $paramAA = array(':ID_ANIMAL'=>$id_animal);

                $stmtAA->execute($paramAA);

                if($stmtAA->rowCount()>1){
                    return 'Excluido com sucesso.';
                }


            } catch (PDOException $ex) {
            	echo 'ERRO[excluirAnimal]: {'. $ex->getMessage() . '}';
            }
        }
    }
?>