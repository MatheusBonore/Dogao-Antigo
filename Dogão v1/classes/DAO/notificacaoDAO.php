<?php
    class notificacaoDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
    	function notificacao($id_login){
    		try {
    			$stmt = $this->pdo->prepare('SELECT id_login,email_login FROM login WHERE email_login = :ID_LOGIN');
    			$param = array(':ID_LOGIN'=>$id_login);
    			$stmt->execute($param);

    			$row = $stmt->fetch(PDO::FETCH_ASSOC);
    			$id_login = $row['id_login'];

    			$stmt = $this->pdo->prepare('SELECT id_destinatario FROM notificacao WHERE id_destinatario = :ID_LOGIN');
    			$param = array(':ID_LOGIN'=>$id_login);
    			$stmt->execute($param);

    			$result = $stmt->rowCount();

    			if($result > 0){
    				return $result;
    			}else{
    				return $result;
    			}


    		} catch (PDOException $ex) {
    			echo 'ERRO[notificacao]: {'. $ex->getMessage() . '}';
    		}
    	}

    	function mostrarNotificacao($id_login){
    		try {
    			$stmt = $this->pdo->prepare('SELECT id_login,email_login FROM login WHERE email_login = :ID_LOGIN');
    			$param = array(':ID_LOGIN'=>$id_login);
    			$stmt->execute($param);

    			$row = $stmt->fetch(PDO::FETCH_ASSOC);
    			$id_login = $row['id_login'];

    			$stmt = $this->pdo->prepare('SELECT * FROM notificacao WHERE id_destinatario = :ID_LOGIN ORDER BY data DESC');
    			$param = array(':ID_LOGIN'=>$id_login);
    			$stmt->execute($param);

    			$result = $stmt->rowCount();

    			$rows =  array();

    			if($result > 0){
    				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    					$rows['notificacao'] = $row;


    					$data = $rows['notificacao']['data'];

						$date = $data;
					    $retval = '';
					    $date = strtotime($date);
					    $difference = time() - $date;
					    $periods = array('Decada' => 315360000,
					        'Ano' => 31536000,
					        'Mês' => 2628000,
					        'Semana' => 604800, 
					        'Dia' => 86400,
					        'Hora' => 3600,
					        'Minuto' => 60,
					        'Segundo' => 1);

					    foreach ($periods as $key => $value) {
					        if ($difference >= $value) {
					            $time = floor($difference/$value);
					            $difference %= $value;
					            $retval .= ($retval ? ' ' : '').$time.' ';
					            $retval .= (($time > 1) ? $key.'s' : $key);
					        }
					        
					    }
					    if($retval == 0){
					    	$tempo = 'Agora';
					    }else{
					    	$tempo =$retval.' atrás';      
						}

						$rows['notificacao']['data'] = $tempo;


    					//USUARIO
    					$stmtAA = $this->pdo->prepare('SELECT nome_usuario,sobrenome_usuario,cidade_usuario,estado_usuario,telefone01_usuario,telefone02_usuario,foto_usuario FROM usuario WHERE id_login = :ID_LOGIN');
    					$paramAA = array(':ID_LOGIN'=>$rows['notificacao']['id_remetente']);
    					$stmtAA->execute($paramAA);
    					$rowAA = $stmtAA->fetch(PDO::FETCH_ASSOC);

    					//ANIMAL
    					$stmtBB = $this->pdo->prepare('SELECT nome_animal,raca_animal,foto_animal FROM animal WHERE id_login = :ID_LOGIN AND id_animal = :ID_ANIMAL');
    					$paramBB = array(
    						':ID_LOGIN'=>$rows['notificacao']['id_destinatario'],
    						':ID_ANIMAL'=>$rows['notificacao']['id_animal']
    					);
    					$stmtBB->execute($paramBB);
    					$rowBB = $stmtBB->fetch(PDO::FETCH_ASSOC);

    					//POST
    					$stmtCC = $this->pdo->prepare('SELECT categoria_post FROM post WHERE id_login = :ID_LOGIN AND id_animal = :ID_ANIMAL');
    					$paramCC = array(
    						':ID_LOGIN'=>$rows['notificacao']['id_destinatario'],
    						':ID_ANIMAL'=>$rows['notificacao']['id_animal']
    					);
    					$stmtCC->execute($paramCC);
    					$rowCC = $stmtCC->fetch(PDO::FETCH_ASSOC);
    					

    					//COLOCANDO NO ARRAY ROWS
    					$rows['usuario'] = $rowAA;
    					$rows['animal'] = $rowBB;
    					$rows['post'] = $rowCC;

    					if(isset($_GET['fil'])){
	                        $get = '?fil='.$_GET['fil'] . '&';
	                    }else{
	                        $get = '?';
	                    }

	                    if($rows['post']['categoria_post'] == 'perdido'){
	                    	$rows['post']['categoria_post'] = 'Encontrei seu animal';
	                    }else if($rows['post']['categoria_post'] == 'doacao'){
							$rows['post']['categoria_post'] = 'Tenho interesse de adotar o seu animal.';
	                    }else{
	                    	$rows['post']['categoria_post'] = 'Esse animal é meu, e tenho como provar.';
	                    }

    					echo '
    					<span style="color:black; opacity:0.8;"><strong>'.$rows['notificacao']['data'].'</strong> - 

    					<a href="'.$get.'excluirNotificacao='.$rows['notificacao']['id_notificacao'].'">Excluir</a>

    					</span>
    					<div style="border-right:solid 4px #3DC17A; background-color: #EEEEEE;box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .2); margin-bottom: 14px;">
                        <div style="border-bottom: solid 1px;
    border-color: #e5e6e9 #dfe0e4 #d0d1d5;">
                            <figure style="background-color:white;margin:0px; float: left; padding: 0px; width: 70px; height: 70px; overflow: hidden;">
                                <img src="'.$rows['usuario']['foto_usuario'].'" height="100%">
                            </figure>

                            <div style=" height: 68px; padding:2px 10px 0px 80px">
                                <strong>'.$rows['usuario']['nome_usuario'].' '.$rows['usuario']['sobrenome_usuario'].'</strong><br/>
                                '.$rows['usuario']['cidade_usuario'].' - '.$rows['usuario']['estado_usuario'].'<br/>
                                <span style="font-size:10px;">'.$rows['usuario']['telefone01_usuario'].' / '.$rows['usuario']['telefone02_usuario'].'</span><br/>
                            </div>
                        </div>

                        <div>
                            <figure style="margin:0px; float: right; padding: 0px; width: 70px; height: 70px; overflow: hidden;">
                                <img src="'.$rows['animal']['foto_animal'].'" height="100%">
                            </figure>

                            <div style="height: 68px; padding:2px 80px 0px 10px">
                                <strong>'.$rows['post']['categoria_post'].'</strong><br/>
                                '.$rows['animal']['nome_animal'].' : 
                                '.$rows['animal']['raca_animal'].'<br/>
                            </div>
                        </div>
                    </div>';

    					//var_dump($rows);
    				}


    			}
    		} catch (PDOException $ex) {
    			echo 'ERRO[mostrarNotificacao]: {'. $ex->getMessage() . '}';
    		}
    	}

    	function cadastrarNotificacao($dados_notificacao){
    		try {
    			$stmt = $this->pdo->prepare('SELECT id_remetente,id_destinatario,id_post FROM notificacao WHERE id_remetente = :ID_REMETENTE AND id_destinatario = :ID_DESTINATARIO AND id_post = :ID_POST');
    			$param  = array(
    				':ID_REMETENTE'=>$dados_notificacao->getId_remetente(),
    				':ID_DESTINATARIO'=>$dados_notificacao->getId_destinatario(),
    				':ID_POST'=>$dados_notificacao->getId_post()
    			);

    			$stmt->execute($param);
    			$result = $stmt->rowCount();

    			if($result < 1){
	    			$stmt = $this->pdo->prepare('INSERT INTO notificacao (id_remetente,id_destinatario,id_animal,id_post,data) VALUES (:ID_REMETENTE,:ID_DESTINATARIO,:ID_ANIMAL,:ID_POST,:DATA)');
	    			$param = array(
	    				':ID_REMETENTE'=>$dados_notificacao->getId_remetente(),
	    				':ID_DESTINATARIO'=>$dados_notificacao->getId_destinatario(),
	    				':ID_ANIMAL'=>$dados_notificacao->getId_animal(),
	    				':ID_POST'=>$dados_notificacao->getId_post(),
	    				':DATA'=>$dados_notificacao->getData()
	    			);

	    			$stmt->execute($param);
	    		}else{
	    			$stmt = $this->pdo->prepare('UPDATE notificacao SET data = :DATA WHERE id_remetente = :ID_REMETENTE AND id_destinatario = :ID_DESTINATARIO AND id_post = :ID_POST');
	    			$param = array(
	    				':ID_REMETENTE'=>$dados_notificacao->getId_remetente(),
	    				':ID_DESTINATARIO'=>$dados_notificacao->getId_destinatario(),
	    				':ID_POST'=>$dados_notificacao->getId_post(),
	    				':DATA'=>$dados_notificacao->getData()
	    			);
	    			$stmt->execute($param);
	    		}

	    		return 'Notificação enviada para o usuario cujo publicou.';
    		} catch (PDOException $ex) {
    			echo 'ERRO[cadastrarNotificacao]: {'. $ex->getMessage() . '}';
    		}
    	}
    }
?>