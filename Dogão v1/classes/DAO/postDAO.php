<?php
    class postDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
    	function mostrarPost($mostrar){
    		try {
                $stmt = $this->pdo->prepare('SELECT id_login,email_login FROM login WHERE email_login = :EMAIL_LOGIN');
                $param = array(':EMAIL_LOGIN'=>$_SESSION['Login']);
                $stmt->execute($param);

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_login = $row['id_login'];

                if($mostrar != 'todos'){
        			$stmt = $this->pdo->prepare('
    					SELECT 
    	    				post.id_post,
    	    				post.id_login,
    	    				post.id_animal,
    	    				post.data_post,
    	    				post.categoria_post,
                            post.titulo_post,
                            post.local_post,
    	    				animal.id_login,
    	    				animal.id_animal,
    	    				animal.nome_animal,
    	    				animal.raca_animal,
    	    				animal.idade_animal,
    	    				animal.pelagem_animal,
    	    				animal.cor_animal,
    	    				animal.tamanho_animal,
    	    				animal.descricao_animal,
    	    				animal.foto_animal,
    	    				usuario.id_login,
    	    				usuario.nome_usuario,
    	    				usuario.sobrenome_usuario,
    	    				usuario.cidade_usuario,
    	    				usuario.estado_usuario,
    	    				usuario.foto_usuario
    					FROM 
        					post,animal,usuario 
    					WHERE 
                            post.categoria_post = :CATEGORIA
                        AND
    						post.id_animal = animal.id_animal 
    					AND 
    						post.id_login = animal.id_login 
    					AND 
    						post.id_login = usuario.id_login  
    					ORDER BY 
    						post.data_post 
    					DESC
    				');
                    $param = array(':CATEGORIA'=>$mostrar);
        			$stmt->execute($param);
                }else{
                    $stmt = $this->pdo->prepare('
                        SELECT 
                            post.id_post,
                            post.id_login,
                            post.id_animal,
                            post.data_post,
                            post.categoria_post,
                            post.titulo_post,
                            post.local_post,
                            animal.id_login,
                            animal.id_animal,
                            animal.nome_animal,
                            animal.raca_animal,
                            animal.idade_animal,
                            animal.pelagem_animal,
                            animal.cor_animal,
                            animal.tamanho_animal,
                            animal.descricao_animal,
                            animal.foto_animal,
                            usuario.id_login,
                            usuario.nome_usuario,
                            usuario.sobrenome_usuario,
                            usuario.cidade_usuario,
                            usuario.estado_usuario,
                            usuario.foto_usuario
                        FROM 
                            post,animal,usuario 
                        WHERE 
                            post.id_animal = animal.id_animal 
                        AND 
                            post.id_login = animal.id_login 
                        AND 
                            post.id_login = usuario.id_login
                        ORDER BY 
                            post.data_post 
                        DESC
                    ');
                    $stmt->execute();
                }

                $result = $stmt->rowCount();
                if($result < 1){
                    echo '
                    <div style="position: relative;text-align: start;margin: 0px 0px 15px 0px;">
                        <div style="width: 100%;min-height: 50px;">
                            <div style="display:block; margin: 10px 0 0 0; color:#90949C;">
                                <center>Nenhuma publicação</center> 
                            </div>
                        </div>
                    </div>
                    ';
                }

    			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_dono = $row['id_login'];
                    $id_post = $row['id_post'];
                    $id_animal = $row['id_animal'];
    				$nome = $row["nome_usuario"].' '.$row["sobrenome_usuario"];

    				$nome_animal = $row['nome_animal'];
    				$tamanho_animal = $row['tamanho_animal'];
    				$pelagem_animal = $row['pelagem_animal'];
    				$cor_animal = $row['cor_animal'];
    				$raca_animal = $row['raca_animal'];
    				$local_animal = $row['local_post'];
    				$descricao_animal = $row['descricao_animal'];
                    $titulo_animal =$row['titulo_post'];
                    $foto_animal = $row['foto_animal'];
                    $foto_usuario = $row['foto_usuario'];

    				$data = $row['data_post'];

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



                    $stmtBB = $this->pdo->prepare('SELECT id_login,id_animal,id_post FROM post WHERE id_login = :ID_LOGIN AND id_animal = :ID_ANIMAL');
                    $paramBB = array(':ID_LOGIN'=>$id_login,':ID_ANIMAL'=>$id_animal);
                    
                    $stmtBB->execute($paramBB);

                    $resultBB = $stmtBB->rowCount();

                    if($resultBB < 1){

                        $div = '<form method="POST" style="margin:0px; padding:0px;">
                        <input type="hidden" name="id_remetente" value="'.$id_login.'">
                        <input type="hidden" name="id_destinatario" value="'.$id_dono.'">
                        <input type="hidden" name="id_animal" value="'.$id_animal.'">
                        <input type="hidden" name="id_post" value="'.$id_post.'">
                        <div style="color: #90949c; font-size: 14px; font-family: lucida grande,tahoma,verdana,arial,sans-serif;background-color: #f6f7f9; border-top: #EBEBEB solid 1px; padding: 10px;">';

                        
                        if($row['categoria_post'] == 'perdido'){
                            $button = $div.'<button type="submit" name="notificar" value="encontrei">Encontrei esse animal</button></div></form>';
                        }elseif($row['categoria_post'] == 'encontrado'){
                            $button = $div.'<button type="submit" name="notificar" value="meuanimal">Esse animal é meu</button></div></form>'; 
                        }elseif($row['categoria_post'] == 'doacao'){
                            $button = $div.'<button type="submit" name="notificar" value="adotar">Eu tenho enteresse em adotalo</button></div></form>';
                        }

                        
                    }else{
                        $button = '';
                    }

                        

    				if($row['categoria_post'] == 'perdido'){
    					$categoria ='<div style="background-color:#158CBA; color:white;border: 1px solid transparent; border-color: #127BA3;border-width: 0 0 4px 0; padding: 10px;">Animal Perdido</div>';
    				}elseif($row['categoria_post'] == 'encontrado'){
                        $categoria ='<div style="background-color:#3DC17A; color:white;border: 1px solid transparent; border-color: #2F975F;border-width: 0 0 4px 0; padding: 10px;">Animal Encontrado</div>';
                    }else{
    					$categoria ='<div style="background-color:#ff851b; color:white;border: 1px solid transparent; border-color: #ff7701;border-width: 0 0 4px 0; padding: 10px;">Animal para doação</div>';
    				}



    				echo'<div style="background-color: white;border:solid 1px #E6E9EB;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px;margin: 0px 0px 25px 0px; ">
                    <div style="width: 100%;min-height: 50px;">
                        <div style="display:block; margin: 10px 0 0 0;">
                            <figure style="border-radius:10%; margin: 0 12px 0 12px; position: relative; float: left; height:40px; width:40px; overflow:hidden;">
                                <img style="" src="'.$foto_usuario.'" alt="" width="100%">
                            </figure>
                            <div style=" width: auto; height: 100%; padding-left: 62px;">
                                <span style="font-size: 16px; display: table;">
                                    <span style="font-weight:bold;">'.$nome.'</span>
                                    <span class="icon-location" style="color:#158CBA;font-size: 15px;font-weight: 500;"></span>
                                    '.$row["cidade_usuario"].'

                                <span style="color: #90949c; display: table; margin: 0 0 10px 0; font-size: 14px; cursor: pointer; font-family: lucida grande,tahoma,verdana,arial,sans-serif;">
                                    <abbr title="'.$tempo.'">
                                        <span>'.$tempo.'</span>
                                    </abbr>
                                </span>
                            </div>
                        </div>
                    </div>
                    '.$categoria.'
                    <div>
                        <img src="'.$foto_animal.'" alt="FOTO" width="100%">
                        <div dir="ltr" style="  line-height: 20px;margin: 0 16px 16px;   -webkit-tap-highlight-color: inherit;   font-size: 14px;    line-height: 20px;    word-wrap: break-word;-webkit-font-smoothing: antialiased;white-space: pre-line;color: #212121;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
                        <div style="color:black; font-size:20px; font-weight: bolder;">'.$titulo_animal.'</div>
                        <span style="font-size:16px; font-weight: bold;">
                            '.$nome_animal.'
                        </span>
                        <div style="border-top: #EBEBEB solid 1px;">
                            <strong>Tamanho do Animal:</strong> '.$tamanho_animal.', <strong>Pelagem do Animal:</strong> '.$pelagem_animal.', <strong>Cor do Animal:</strong> '.$cor_animal.', <strong>Raça do Animal:</strong> '.$raca_animal.', <strong>Local:</strong>  '.$local_animal.'.
                        </div>
                            '.$descricao_animal.'
                        </div>

                    </div>
                    '.$button.'
                </div>';
    			}

    		} catch (PDOException $ex) {
    			echo 'ERRO[mostrarPost]: {'. $ex->getMessage() . '}';
    		}
        }

		function mostrarAnimal(){
    		try {
                $stmt = $this->pdo->prepare('SELECT id_login FROM login WHERE email_login = :EMAIL');
    			$param = array(':EMAIL'=>$_SESSION['Login']);
    			$stmt->execute($param);

    			$row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_login = $row['id_login'];

    			$stmt = $this->pdo->prepare('SELECT id_login,id_animal,nome_animal,raca_animal,foto_animal FROM animal WHERE id_login = :ID_LOGIN ORDER BY nome_animal');
                $param = array(':ID_LOGIN'=>$id_login);
				
    			$stmt->execute($param);
                $result = $stmt->rowCount();

                $aa = "jQuery('div#4d2q-a1v').show(); jQuery('div#boxBlack').show(); var offsetTop = jQuery('div#4d2q-a1v').offset().top; jQuery('html,body').animate({    scrollTop:(offsetTop - 75)},300);";

                if($result < 1){


                    
                    echo'
                        <div style="position: relative;text-align: start;margin: 0px 0px 0px 0px;">
                        <div style="width: 100%;">
                            <div style="display:block; margin: 10px 0 0 0; color:#90949C;">
                                <center>Nenhum animal registrado.</center> 
                            </div>
                        </div>
                    </div>
                        <div style="background-color: white;
                            border:solid 1px #E6E9EB;
                            border-bottom: solid 1px;
                            border-color: #e5e6e9 #dfe0e4 #d0d1d5;
                            border-radius: 0px 0px 3px;
                            
                            margin: 5px 0 5px 0 ;position: relative;cursor: pointer;text-align: start; color:#90949C; padding:15px 0px 0px 0px;" onclick="'.$aa.'"><center><span class="icon-plus" style="margin:0px 10px  0px 0px;"></span> Adicionar animal</center></div>
                    ';
                }

    			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    //border-right: solid 4px #3DC17A;


    				$id_animal = $row['id_animal'];
    				$nome_animal = $row['nome_animal'];
    				$raca_animal = $row['raca_animal'];
                    $foto_animal = $row['foto_animal'];

    				

                    $stmt0A = $this->pdo->prepare('SELECT id_animal,categoria_post FROM post WHERE id_animal = :ID_ANIMAL');
                    $param0A = array(':ID_ANIMAL'=>$id_animal);
                    $stmt0A->execute($param0A);


                    $result0A = $stmt0A->rowCount();

                    if(isset($_GET['fil'])){
                        $get = '?fil='.$_GET['fil'] . '&';
                    }else{
                        $get = '?';
                    }

                    if($result0A > 0){
                        $row = $stmt0A->fetch(PDO::FETCH_ASSOC);
                        $categoria_cor = $row['categoria_post'];

                        if($categoria_cor == 'perdido'){
                            $cor = '#158CBA';
                        }else if($categoria_cor == 'encontrado'){
                            $cor = '#3DC17A';
                        }else{
                            $cor = '#FF851B';
                        }

                        echo'
                            <abbr title="'.$nome_animal.': '.$raca_animal.'"><div id="excluirAnimal" style="position:relative;display:block; margin: 0px 0 0 0;padding:0px 0px 0px 0px;cursor:pointer; background-color:white; margin-top:2px;border: solid 1px #E6E9EB;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px;">
                                <div id="excluir" style="background-color:black; display:none; position:absolute; width:100%; height:100%; z-index:2; color:white; opacity:0.4;"><a href="'.$get.'excluirAnimal='.$id_animal.'" style="position:absolute;text-decoration:none;color:white;width:100%; height:100%;"><center><div style="padding-top:10px; font-size:25px;"><span class="icon-cross"></span></div></center></a></div>
                                <figure style="margin: 0 0px 0 0px; position: relative; float: left; width:47px; height:47px; overflow:hidden;">
                                    <img src="'.$foto_animal.'" alt="PERFIL DONO" height="100%">
                                </figure>
                                <div style="height: 100%;  padding-left: 52px;border-right: solid 4px '.$cor.';">
                                    <span style="font-weight:bold; font-size: 16px; display: table;">
                                        '.$nome_animal.'                                  
                                    </span>
                                    <span style="color: #90949c; display: table; margin: 0 0 10px 0; font-size: 14px; cursor: pointer; font-family: lucida grande,tahoma,verdana,arial,sans-serif;">
                                    <div style="width:auto;overflow: hidden;text-overflow: ellipsis;">'.$raca_animal.'</div>
                                    </span>
                                </div>
                            </div></abbr>
                        ';
                    }else{
        				echo'
        					<abbr title="'.$nome_animal.': '.$raca_animal.'"><div id="excluirAnimal" style="position:relative;display:block; margin: 0px 0 0 0;padding:0px 0px 0px 0px;cursor:pointer; background-color:white; margin-top:2px;border: solid 1px #E6E9EB;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px;">
                            <div id="excluir" style="background-color:black; display:none; position:absolute; width:100%; height:100%; z-index:2; color:white; opacity:0.4;"><a href="'.$get.'excluirAnimal='.$id_animal.'" style="position:absolute;text-decoration:none;color:white;width:100%; height:100%;"><center><div style="padding-top:10px; font-size:25px;"><span class="icon-cross"></span></div></center></a></div>
                                <figure style="margin: 0 0px 0 0px; position: relative; float: left; width:47px; height:47px; overflow:hidden;">
                                    <img src="'.$foto_animal.'" alt="PERFIL DONO" height="100%">
                                </figure>
                                <div style="height: 100%;  padding-left: 52px;">
                                    <span style="font-weight:bold; font-size: 16px; display: table;">
                                        '.$nome_animal.'                                  
                                    </span>
                                    <span style="color: #90949c; display: table; margin: 0 0 10px 0; font-size: 14px; cursor: pointer; font-family: lucida grande,tahoma,verdana,arial,sans-serif;">
                                    <div style="width:auto;overflow: hidden;text-overflow: ellipsis;">'.$raca_animal.'</div>
                                    </span>
                                </div>
                            </div></abbr>
        				';
                    }
    			}

                if($result > 0){
                        echo '<div style="background-color: white;
                                border:solid 1px #E6E9EB;
                                border-bottom: solid 1px;
                                border-color: #e5e6e9 #dfe0e4 #d0d1d5;
                                border-radius: 0px 0px 3px;
                                
                                margin: 5px 0 5px 0 ;position: relative;cursor: pointer;text-align: start; color:#90949C; padding:15px 0px 0px 0px;" onclick="'.$aa.'"><center><span class="icon-plus" style="margin:0px 10px  0px 0px;"></span> Adicionar mais animal</center></div>';
                    }

    		} catch (PDOException $ex) {
    			echo 'ERRO[mostrarAnimal]: {'. $ex->getMessage() . '}';
    		}
    	}

        function listarMeusAnimais(){
            try {
                $stmt = $this->pdo->prepare('SELECT id_login,email_login FROM login WHERE email_login = :EMAIL');
                $param = array(':EMAIL'=>$_SESSION['Login']);
                $stmt->execute($param);


                if($stmt->rowCount()>0){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id_login = $row['id_login'];
                
                    $stmt = $this->pdo->prepare('SELECT id_login,id_animal,nome_animal,raca_animal,foto_animal FROM animal WHERE id_login = :ID_LOGIN ORDER BY nome_animal');
                    $param = array(':ID_LOGIN'=>$id_login);
                    $stmt->execute($param);

                    $stmtAA = $this->pdo->prepare('SELECT id_login,id_animal FROM post WHERE id_login = :ID_LOGIN');
                    $paramAA = array(':ID_LOGIN'=>$id_login);
                    $stmtAA->execute($paramAA);

                    $quantidade = $stmtAA->rowCount()  +1;

                    $result = $stmt->rowCount();
                    
                    if($result  < $quantidade){
                        echo '
                        <div style="position: relative;text-align: start;margin: 0px 0px 0px 0px;">
                        <div style="width: 100%;">
                            <div style="display:block; padding:0px 15px 0px 15px; margin: 10px 0 0 0; color:#90949C;">
                                <center>Nenhum animal registrado para escolher.</center>
                            </div>
                        </div>
                        </div>';
                    }

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $id_animal = $row['id_animal'];
                        $nome_animal = $row['nome_animal'];
                        $raca_animal = $row['raca_animal'];
                        $foto_animal = $row['foto_animal'];


                        $stmt0A = $this->pdo->prepare('SELECT id_animal, id_login FROM post WHERE id_animal = :ID_ANIMAL AND id_login = :ID_LOGIN');
                        $param0A = array(
                            ':ID_ANIMAL'=>$id_animal,
                            ':ID_LOGIN'=>$id_login
                        );

                        $stmt0A->execute($param0A);                    
                        $result0A = $stmt0A->rowCount();
                    
                        if($result0A < 1){
                            $jquery = "'".$id_animal."'";
                            echo'
                              
                                


                                <div style="width: 100000000px;">
                                    <div class="box-container">

                                        <figure class="fotoAnimalContainer">
                                            <center><img src="'.$foto_animal.'" height="160px"></center>
                                            <figcaption>'.$nome_animal.'
                                            <figcaption style="color: #90949c;white-space: nowrap;word-wrap: normal;font-size: 12px;">'.$raca_animal.'</figcaption>
                                                     <label for="listaAnimal'.$id_animal.'" onclick="preencher('.$jquery.');">
                                                     <input style="position:absolute; opacity:0; " required type="radio" name="id_animal" value="'.$id_animal.'" id="listaAnimal'.$id_animal.'">
                                                     <div id="buttonSelecionar'.$id_animal.'" class="buttonSelecionar" style="background-color:#F6F7F9; border:solid 1px #CED0D4; color:#74777E; border-radius:2px; font-size:13px; padding:3px 0px 3px 0px; margin:5px 0px 5px 0px; cursor:pointer;"><center>Selecionar</center></div></label>
                                            </figcaption>

                                        </figure>


                                    </div>
                                </div>
                                
                            
                            ';
                        }
                    }
                }

            } catch (PDOException $ex) {
                echo 'ERRO[listarMeusAnimais]: {'. $ex->getMessage() . '}';
            }
        }
    }
?>