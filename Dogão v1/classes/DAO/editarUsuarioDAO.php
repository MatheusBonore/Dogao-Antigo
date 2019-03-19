<?php
    class editarUsuarioDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
        function editarPerfil($dados_editarUsuario){
        	try {
        		$stmt = $this->pdo->prepare('UPDATE usuario SET telefone01_usuario = :TELEFONE01, telefone02_usuario = :TELEFONE02, cep_usuario = :CEP, pais_usuario = :PAIS, estado_usuario = :ESTADO, cidade_usuario = :CIDADE, bairro_usuario = :BAIRRO, rua_usuario = :RUA, numcasa_usuario = :NUMERO WHERE id_login = :ID_LOGIN');
        		$param = array(
        			':ID_LOGIN'=>$dados_editarUsuario->getId_login(),
        			':TELEFONE01'=>$dados_editarUsuario->getTelefone01(),
        			':TELEFONE02'=>$dados_editarUsuario->getTelefone02(),
        			':CEP'=>$dados_editarUsuario->getCep(),
        			':PAIS'=>$dados_editarUsuario->getPais(),
        			':ESTADO'=>$dados_editarUsuario->getEstado(),
        			':CIDADE'=>$dados_editarUsuario->getCidade(),
        			':BAIRRO'=>$dados_editarUsuario->getBairro(),
        			':RUA'=>$dados_editarUsuario->getRua(),
        			':NUMERO'=>$dados_editarUsuario->getNumero()
        		);

        		$stmt->execute($param);
        	} catch (PDOException $ex) {
        		echo 'ERRO[editarPerfil]: {'. $ex->getMessage() . '}';
        	}
        }

        function editarFoto($foto_usuario,$id_login){
            try {
                $stmt = $this->pdo->prepare('SELECT foto_usuario FROM usuario WHERE id_login = :ID_LOGIN');
                $param = array(
                    ':ID_LOGIN'=>$id_login
                );
                $stmt->execute($param);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $fotoAntiga = $row['foto_usuario'];
                unlink($fotoAntiga);

                $stmt = $this->pdo->prepare('UPDATE usuario SET foto_usuario = :FOTO_USUARIO WHERE id_login = :ID_LOGIN');
                $param = array(
                    ':FOTO_USUARIO'=>$foto_usuario,
                    ':ID_LOGIN'=>$id_login
                );
                $stmt->execute($param);
            } catch (PDOException $ex) {
                echo 'ERRO[editarFoto]: {'. $ex->getMessage() . '}';
            }
        }
    }
?>