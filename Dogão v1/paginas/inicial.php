<?php


if(isset($_SESSION['Login']) and isset($_SESSION['Senha'])){
    $email_login = $_SESSION['Login'];
    $senha_login = $_SESSION['Senha'];
    $dados_login->setEmail_login($email_login);
    $dados_login->setSenha_login($senha_login);
    
    $loginUsuarioDAO->login($dados_login);
}else{
    session_destroy();
    header('Location:index.php');
}

if(isset($_POST['adicionar_animal']) and
    !empty($_POST['nome_animal']) and
    !empty($_POST['idade_animal']) and
    !empty($_POST['pelagem_animal']) and
    !empty($_POST['cor_animal']) and
    !empty($_POST['porte_animal']) and
    !empty($_POST['raca_animal']) and
    !empty($_POST['id_login'])){
        
    $id_login = $_POST['id_login'];
    $nome_animal = $_POST['nome_animal'];
    $idade_animal = $_POST['idade_animal'];
    $pelagem_animal = $_POST['pelagem_animal'];
    $cor_animal = $_POST['cor_animal'];
    $porte_animal = $_POST['porte_animal'];
    $raca_animal = $_POST['raca_animal'];

    $_UP['diretorio'] = 'uploads/animal/';

    $rr = explode('.', $_FILES['foto_animal']['name']);
    $_UP['novo_nome'] = md5(strtolower(reset($rr)));

    $_UP['extensao'] = '.webp';

    move_uploaded_file($_FILES['foto_animal']['tmp_name'], $_UP['diretorio'].$_UP['novo_nome'].$_UP['extensao']);
    $foto_animal = $_UP['diretorio'].$_UP['novo_nome'].$_UP['extensao'];

    if(!empty($_POST['descricao_animal'])){
        $descricao_animal = $_POST['descricao_animal'];
    }else{
        $descricao_animal = 'Nenhuma descrição.';
    }
    
    $dados_animal->setId_login($id_login);
    $dados_animal->setNome_animal($nome_animal);
    $dados_animal->setIdade_animal($idade_animal);
    $dados_animal->setPelagem_animal($pelagem_animal);
    $dados_animal->setCor_animal($cor_animal);
    $dados_animal->setTamanho_animal($porte_animal);
    $dados_animal->setRaca_animal($raca_animal);
    $dados_animal->setDescricao_animal($descricao_animal);
    $dados_animal->setFoto_animal($foto_animal);

    $cadastroAnimalPostDAO->cadastrarAnimal($dados_animal);
    header('Location: index.php');
}

if(isset($_POST['publicar_animal'])){
    $id_login = $_POST['id_login'];
    $id_animal = $_POST['id_animal'];
    $titulo_post = $_POST['titulo_animal'];
    $categoria_post = $_POST['categoria_animal'];
    $local_post = $_POST['local_animal'];
    
    $data_post = date('Y-m-d H:i:s');
    $data_expira_post = 30;

    $dados_post->setId_login($id_login);
    $dados_post->setId_animal($id_animal);
    $dados_post->setData_post($data_post);
    $dados_post->setData_expira_post($data_expira_post);
    $dados_post->setTitulo_post($titulo_post);
    $dados_post->setCategoria_post($categoria_post);
    $dados_post->setLocal_post($local_post);
    
    $cadastroAnimalPostDAO->cadastrarPost($dados_post);
    header('Location: index.php');
}

if(isset($_GET['excluirAnimal'])){
    $return = $excluirDAO->excluirAnimal($_GET['excluirAnimal']);
}

if(isset($_GET['excluirNotificacao'])){
    $excluirDAO->excluirNotificacao($_GET['excluirNotificacao']);
}


if(isset($_POST['notificar'])){
    $id_remetente = $_POST['id_remetente'];
    $id_destinatario = $_POST['id_destinatario'];
    $id_animal = $_POST['id_animal'];
    $id_post = $_POST['id_post'];
    $data = date('Y-m-d H:i:s');

    $dados_notificacao->setId_remetente($id_remetente);
    $dados_notificacao->setId_destinatario($id_destinatario);
    $dados_notificacao->setId_animal($id_animal);
    $dados_notificacao->setId_post($id_post);
    $dados_notificacao->setData($data);

    $return = $notificacaoDAO->cadastrarNotificacao($dados_notificacao);
}

if(isset($_POST['editarUsuario'])){
    $id_login = $_POST['id_login'];
    $telefone01 = $_POST['telefone01'];
    $telefone02 = $_POST['telefone02'];
    $cep = $_POST['cep_cadastro'];
    $pais = $_POST['pais_cadastro'];
    $estado = $_POST['estado_cadastro'];
    $cidade = $_POST['cidade_cadastro'];
    $bairro = $_POST['bairro_cadastro'];
    $rua = $_POST['rua_cadastro'];
    $numero = $_POST['numero_cadastro'];
    
    $dados_editarUsuario->setId_login($id_login);
    $dados_editarUsuario->setTelefone01($telefone01);
    $dados_editarUsuario->setTelefone02($telefone02);
    $dados_editarUsuario->setCep($cep);
    $dados_editarUsuario->setPais($pais);
    $dados_editarUsuario->setEstado($estado);
    $dados_editarUsuario->setCidade($cidade);
    $dados_editarUsuario->setBairro($bairro);
    $dados_editarUsuario->setRua($rua);
    $dados_editarUsuario->setNumero($numero);

    $editarUsuarioDAO->editarPerfil($dados_editarUsuario);
    header('Location: index.php');
}

if(isset($_POST['editarFotoUsuario'])){
    if(!empty($_FILES['foto_usuario']['name'])){
        $_UP['diretorio'] = 'uploads/perfil/';

        $rr = explode('.', $_FILES['foto_usuario']['name']);
        $_UP['novo_nome'] = md5(strtolower(reset($rr)));

        $_UP['extensao'] = '.webp';

        move_uploaded_file($_FILES['foto_usuario']['tmp_name'], $_UP['diretorio'].$_UP['novo_nome'].$_UP['extensao']);
        $foto_usuario = $_UP['diretorio'].$_UP['novo_nome'].$_UP['extensao'];

        $id_login = $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'id_login');

        $editarUsuarioDAO->editarFoto($foto_usuario,$id_login);
    }else{
        $erroFoto = '1';
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width-device, initial-scale=1">
        
        <!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
        
        <script src="js/jquery/jquery-1.12.4.js"></script>
        <script src="js/jquery/jquery-ui.js"></script>
        <script src="js/jquery/jquery.maskedinput.js"></script>
        <script src="js/cep.js"></script>
        
        <link rel="stylesheet" type="text/css" href="css/menu.css">
        <link rel="stylesheet" type="text/css" href="css/default.css">
        <link rel="stylesheet" type="text/css" href="css/estrutura.css">
        <link rel="stylesheet" type="text/css" href="css/profileBox.css">
        <link rel="stylesheet" type="text/css" href="fonts/icomoon.css">
        
        <link rel="icon" type="image/x-icon" href="layout/lg.png"/>
        <link rel="shortcut icon" type="image/x-icon" href="layout/lg.png"/>

        <title>Dogão</title>
        
        <style type="text/css">
            body{
                margin: 0px;
                padding: 0px;
                
                background-color:#eee;
            }
            
        </style>


        
    </head>
    <body>

    <?php if (isset($erroFoto) and $erroFoto > 0) {
        echo '<script>alert("Escolha uma foto primeiro.");</script>';
    } ?>
        <script>
            jQuery(document).ready(function(){

                jQuery("input#cep").mask("99999-999");
                jQuery("input#telefone01").mask("(99) 9999-9999");
                jQuery("input#telefone02").mask("(99) 99999-9999");

                <?php
                    if(isset($_POST['publicar_animal'])){
                            echo"jQuery('div#hx2q-alv').show(); jQuery('div#hx2q-als').hide(); jQuery('div#boxBlack').show();";
                            echo"var offsetTop = jQuery('div#hx2q-alv').offset().top;
jQuery('html,body').animate({
	scrollTop:(offsetTop - 75)
},0);";
                    }
                    
                ?>
            });
        </script>
        <div class="menu">
            <div>
                <img src="layout/dog-face.png" width="35"/>
            </div>

            <div class="nomeD">
                Dogão
            </div>

            <div class="botA">
                Início
            </div>

            <!--<div class="botB">
                <div style="width:25px; margin: 0px 5px 0px 5px; fill:#fff; float: left;">
                    <svg viewBox="0 0 24 24" height="100%" width="100%">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                </div>
                <input name="busca" style="margin:0px;" type="text" size="45" placeholder="Pesquisa"/>
            </div>

            <div class="botC">
                <div>
                    <svg viewBox="0 0 24 24" height="100%" width="100%">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                    </svg>
                </div>
            </div>-->
            
                <?php 
                    $notificar = $notificacaoDAO->notificacao($_SESSION['Login']);
                    
                    if($notificar >= 1){

                        $aa = "'div#notif'";

                        $bb = "'div#editar'";
                        echo '<div class="botNotificacao"><div onclick=" jQuery('.$aa.').show(); jQuery('.$bb.').hide();" style="cursor:pointer;background-color: white;font-weight: bold; color: #3DC17A; font-size: 15px; padding: 5px 10px 5px 10px; border-radius: 50%;">'.$notificar.'</div></div>';
                    }else{
                        echo '<div class="botNotificacao"></div>';
                    }

                ?>

                <div style="margin:8px 0px 0px 0px;">
                    <a href="paginas/sair.php" style="color:white;text-decoration: none;">
                        <span class="icon-exit"></span>
                    </a>

                </div>

            
        </div>



















        <div class="row">
            <div class="col-1">
                <div class="box-perfil" style="margin-top:55px;">
                    <div class="box-container-photo">
                        <div class="box-container-photo-border">
                            <figure style="width: 110px; height: 110px; padding: 0px; margin:0px; overflow:hidden;">
                                <img id="" style="width: 100%;" src="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'foto_usuario') ?>" alt=""/>
                            </figure>
                        </div>
                        <center>
                            <div style="padding: 10px 15px 0 15px; font-size: 22px; text-align: center;">
                                <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'nome_usuario') ?>
                                <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'sobrenome_usuario') ?>
                            </div>
                        </center>
                    </div>
                    <center>
                        <span style="padding-left: 15px; padding-right: 15px; color:#90949c;">
                            <span class="icon-location"></span>

                            <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'cidade_usuario') ?> - 
                            <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'estado_usuario') ?>
                        </span>
                        <p style="padding-left: 15px; font-size:14px; padding-right: 15px; color:#90949c;">
                            <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'bairro_usuario') ?> -
                            <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'rua_usuario') ?>
                        </p>
                    </center>
                    
                </div>
    	
                <div class="confg" style="margin-bottom:10px;">
                    <a onclick="jQuery('div#editar').show(); var offsetTop = jQuery('div#editar').offset().top; jQuery('html,body').animate({   scrollTop:(offsetTop - 75)},300);">
                        <span class="icon-pencil" style="font-size: 12px;"></span>  Editar perfil
                    </a>
                </div>



                <div>
                    
                    <style type="text/css">
                        div#meuAnimal{
                            margin-top: 5px;
                        }

                        div#meuAnimal>div{
                            height: 40px;
                        }
                    </style>

                    <span style="color: #666;font-size: 12px;-webkit-font-smoothing: antialiased;font-weight: bold;font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;">ANIMAIS REGISTRADOS</span>
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            jQuery('div#excluirAnimal').hover(function(){
                                jQuery(this).find('#excluir').show();
                            },function(){
                                jQuery(this).find('#excluir').hide();
                            });
                        });
                    </script>
                    <div id="meuAnimal"><?= $postDAO->mostrarAnimal(); ?></div>

                </div>
			
                
            </div>
		
            <div class="col-2">
            <style type="text/css">
                .panel{

                    border: solid 1px #E6E9EB;
                    border-bottom: solid 1px;
                    border-color: #e5e6e9 #dfe0e4 #d0d1d5;
                    border-radius: 0px 0px 3px;
                    border-radius: 2px;
                    margin-bottom: 10px;
                    background-color: white;
                }
                .panel-heading{
                    background-color: #3DC17A;
                    border-bottom:none;
                    padding: 10px 15px;
                    border-top-right-radius: 2px;
                    border-top-left-radius: 2px;
                }
                .panel-success{
                    color: white;
                    
                }
                .panel-title{
                    margin-top: 0;
                    margin-bottom: 0;
                    font-size: 15px;
                    color: inherit;

                }
                .panel-body{
                    padding: 10PX;
                    font-family: "Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif;
                    font-size: 13px;
                    line-height: 1.846;
                    color: #666666;
                }
            </style>


                <style type="text/css">
                    div.sAyi{
                        position: fixed;
                        z-index: 92398492384;
                        background: #fff;
                        height: auto;
                        width: 100%;
                    }
                    div.sadHs,div.aASas{
                        height: auto;                        
                    }
                    .sadHs{
                        margin-bottom: 15px;
                    }
                    .aASas{
                        color: rgba(0,0,0,0.87);
                        font: 500 20px Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
                        font-weight: bold;
                    }
                    .aASas>form>input, .aASas>form>select{
                        font: 400 16px Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
                        border:none;
                        background-image: none;
                        margin: 0px 0px 15px 0px;
                        padding: 0px 0px 0px 10px;

                        width: 100%;
                        height: 24px;
                        border-bottom: #EDEDED 1px solid;
                    }


                    .figcaptionProfile{
                        width: 100%;
                        height: 50%;
                        top:-100%;
                        position: relative;
                        font-size: 30px;
                        color: white;
                        opacity: 0.5;
                        padding-top: 50%;
                    }
                    .figcaptionProfile:hover{
                        opacity: 1;
                    }
                </style>


                <div class="panel panel-success" id="editar" style="display: none;">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="icon-pencil" style="font-size:13px;"></span>
                            Editar Perfil
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div id="escolha">
                            <button class="btn" onclick="jQuery('div#escolha').hide(); jQuery('div.sadHs').show();">Editar foto de perfil</button>
                            <button class="btn" onclick="jQuery('div#escolha').hide(); jQuery('div.aASas').show();">Editar informações da conta</button>
                        </div>


                        <div class="aASas" style="display:none;">
                            <form action="" method="POST">
                                <div style="margin-bottom: 24px;">
                                    <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'nome_usuario') ?>
                                    <?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'sobrenome_usuario') ?>
                                </div>
                                <input type="text" id="telefone01" name="telefone01" value="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'telefone01_usuario') ?>" placeholder="Telefone Fixo" required autocomplete="off">
                                <input type="text" id="telefone02" name="telefone02" value="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'telefone02_usuario') ?>" placeholder="Celular" required>
                                <input type="text" id="cep" name="cep_cadastro" placeholder="CEP" onblur="pesquisacep(this.value);" required autocomplete="off">
                                <select style="" name="pais_cadastro" id="pais_cadastro" required>
                                    <option value="" id="">Pais</option>
                                    <option value="br">Brasil</option>
                                </select>
                                <input style="" type="text" id="uf" maxlength="15" name="estado_cadastro" placeholder="Estado" value="" readonly required autocomplete="off">
                                <input style="" type="text" id="cidade" maxlength="15" name="cidade_cadastro" placeholder="Cidade" value="" readonly required autocomplete="off">
                                <input style="" maxlength="52" type="text" id="bairro" name="bairro_cadastro" value="" placeholder="Bairro" readonly required autocomplete="off">
                                <input style="" maxlength="52" type="text" id="rua" name="rua_cadastro" placeholder="Rua" value="" readonly required>
                                <input maxlength="6" type="text" id="numero_cadastro" style="" name="numero_cadastro" placeholder="Número" value="" required autocomplete="off">

                                <input type="hidden" name="id_login" value="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'id_login') ?>">
                                <div style="font: 500 18px Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
                                    <input type="submit" name="editarUsuario" value="Editar perfil">
                                    <button onclick="jQuery('div.aASas').hide(); jQuery('div#escolha').show();">Voltar</button>
                                </div>
                            </form>
                        </div>


                        <div class="sadHs" style="display: none; ">


                            <!-------------------- ---------------------->

                            <form action="" method="POST" enctype="multipart/form-data">
                                <label class="btn btn-success" for="foto_usuario">
                                    Escolher uma foto para o seu perfil.
                                </label>

                                <input style="display: none;" type="file" class="upload" name="foto_usuario" id="foto_usuario" onchange="document.getElementById('uploadFile_perfil').value = this.value;">
                                

                                <input style="margin-top:5px; margin-bottom:10px; width:100%;"" id="uploadFile_perfil" placeholder="" disabled="disabled">
                                
                                <input type="submit" name="editarFotoUsuario" value="Enviar alterações">
                                <button onclick="jQuery('div.sadHs').hide(); jQuery('div#escolha').show();">Voltar</button>
                            </form>
                        </div>

                        <button onclick="jQuery('div#editar').hide();">Fechar</button>
                    </div>
                </div>
















                <div class="panel panel-success" id="notif" style="display: none;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Notificações</h3>
                    </div>
                    <div class="panel-body">
                        <?php $notificacaoDAO->mostrarNotificacao($_SESSION['Login']); ?>

                        <button onclick="jQuery('div#notif').hide();">Fechar</button>
                    </div>
                </div>








                <div class="addAnimal"></div>

                <style type="text/css">
                    .btn{
                        text-transform: uppercase;
                        border: none;
                        -webkit-box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                        position: relative;

                        display: inline-block;
                        margin-bottom: 10px;
                        font-weight: normal;
                        text-align: center;
                       
                        cursor: pointer;
                        background-image: none;
                        border: 1px solid transparent;
                        
                        padding: 6px 0px;
                        font-size: 13px;
                        line-height: 1.846;
                        border-radius: 3px;
                        width: 100%;

                    }

                    .btn-success {
                        color: #ffffff;
                        background-color: #3DC17A;
                        border-color: transparent;
                    }

                   
                </style>

                <?php if(isset($return)): ?>
                   <a class="btn btn-success" onclick="jQuery(this).hide();"><?= $return ?></a>
                <?php endif; ?>
                
                <div id="hx2q-als" style="z-index: 3; position: relative;cursor: pointer;text-align: start;background-color: white;border:solid 1px #E6E9EB;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px;margin: 0px 0px 15px 0px;" onclick="jQuery('div#4d2q-a1v').hide(); jQuery('div#hx2q-alv').show(); jQuery(this).hide(); jQuery('div#boxBlack').show(); var offsetTop = jQuery('div#hx2q-alv').offset().top; jQuery('html,body').animate({	scrollTop:(offsetTop - 75)},300);">
                    <div style="width: 100%;min-height: 50px;">
                        <div style="display:block; margin: 10px 0 0 0;">
                            <figure style="border-radius:10%; margin: 0 12px 0 12px; padding: 0px; position: relative; float: left; width: 40px; height: 40px; overflow: hidden;">
                                <img src="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'foto_usuario') ?>" alt="" width="100%">
                            </figure>
                            <div style=" width: auto; height: 100%; padding: 1% 10px 0px 62px;">
                                <span style="color: #bdbdbd; display: table; -webkit-text-size-adjust: 100%;text-size-adjust: 100%;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; ">
                                   Publicar um animal como perdido, encontrado ou como doação?
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!---- AAAAA ---->
                <div id="hx2q-alv" style="z-index: 3;position:relative;display:none; text-align: start;background-color: white;border:solid 1px #E6E9EB;border-left: none; border-right: none;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px;margin: 0px 0px 15px 0px;">
                    

                    <div style="width: 100%;min-height: 50px;">
                        <div style="display:block; margin: 10px 0 0 0;">
                            <figure style="border-radius:10%; margin: 0 12px 0 12px; padding: 0px; position: relative; float: left; width: 40px; height: 40px; overflow: hidden;">
                                <img src="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'foto_usuario') ?>" alt="" width="100%">
                            </figure>
                            <div style=" width: auto; height: 100%; padding-left:62px; padding-right: 10px;">
                                <span style="display: table;font-size: 15px;font-weight: 500;color: #212121;">
                                    Publicar um animal como perdido, encontrado ou como doação?
                            </div>
                        </div>
                    </div>

                    <form enctype="multipart/form-data" style="margin: 0px; padding: 0px;" method="POST">
                        <label for="aa" style="margin:0; font-weight: normal; cursor: pointer;"><div id="perdido" style="background-color:#127BA3; color:white; padding: 10px;">
                            <input style="display:none;" type="radio" name="categoria_animal" value="perdido" id="aa" checked autocomplete="off">Animal Perdido
                            <span class="icon-checkmark"></span>
                        </div></label>
                        <label for="bb" style="margin:0; font-weight: normal; cursor: pointer;"><div id="doacao" style="background-color:#158CBA; color:white; padding: 10px; opacity: 0.8;">
                            <input style="display:none;" type="radio" name="categoria_animal" value="doacao" id="bb" autocomplete="off">Animal para doação
                            <span class="icon-checkmark" style="display: none"></span>
                        </div></label>
                        <label for="cc" style="margin:0; font-weight: normal; cursor: pointer;"><div id="encontrado" style="background-color:#158CBA; color:white; padding: 10px; opacity: 0.8;">
                            <input style="display:none;" type="radio" name="categoria_animal" value="encontrado" id="cc" autocomplete="off">Animal encontrado
                            <span class="icon-checkmark" style="display: none"></span>
                        </div></label>
                        
                        <div style="margin:5px 16px 0px 16px;color: #90949c;    font-size: 12px;    font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;"></div>










<style type="text/css">
    div.container{
        position: relative;
        background-color: white;
        height: 260px;

        width: 100%;
        max-width: 550px;

        overflow-x: hidden;
        overflow-y: hidden;
        /*overflow-y: hidden;*/
        /*border:solid 1px red;
        width: 100%; 
        height: 180px;
        padding: 10px 0 15px 0px;
        margin:0px;
        overflow-y: hidden;*/
    }

    div.container > label{}



    div.box-container{
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .2);

        height: 96%;
        width: 160px;
        
        float: left;
        margin: 0px 8px 0px 0px;



        /*box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .2);
        white-space: normal;
        height:100%;
        background-color:white;*/
    }
    figure.fotoAnimalContainer{
        overflow: hidden;
        height: 243px;

        padding: 0px;
        margin: 0px;


    }

    figure.fotoAnimalContainer > img{
        /*margin-left: -25%;*/
    }

    figure.fotoAnimalContainer > figcaption{
        font-family: Helvetica, Arial, sans-serif;
        font-size: 14px;
            margin-top: 7px;
            margin-bottom: 7px;
            margin-left: 12px;
            margin-right: 12px;
            padding-bottom: 8px;
        color: #365899;
            
    }
</style>



<style type="text/css">
    div.arrows{
        opacity: 0.6;

        cursor: pointer;

        color:gray;
        background-color: white;

        font-size: 20px;

        position: absolute;
        padding: 6px 5px 6px 9px;

        
        

        border:solid 1px gray;
    }

    div.arrows:hover{
        opacity: 1;
    }

    div.esquerda{
        border-left: none;
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px;
    }
    div.direita{
        right: 0px;
        border-right: none;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }
</style>

                            <div style="width: 100%; position: absolute;z-index: 4;margin-top: 80px;">
                                <div class="esquerda arrows" onclick="var offsetL = jQuery('div.container').scrollLeft() - 250; jQuery('div.container').animate( { scrollLeft: offsetL }, 200);">
                                    <span class="icon-arrow-left2"></span>
                                </div>

                                <div class="direita arrows" onclick="var offsetL = jQuery('div.container').scrollLeft() + 250; jQuery('div.container').animate( { scrollLeft: offsetL }, 200);">
                                    <span class="icon-arrow-right2"></span>
                                </div>
                            </div>
                        <div class="container" style="padding: 0px 0px 10px 0px;">
                            <script type="text/javascript">
                                function preencher($id){
                                    jQuery('div.buttonSelecionar').animate({backgroundColor:'#F6F7F9',color:'#74777E',borderColor:'#CED0D4'},0);
                                    jQuery('div#buttonSelecionar'+$id).animate({backgroundColor:'#127BA3',color:'white',borderColor:'#4267b2'},0);
                                }
                            </script>
                            <?= $postDAO->listarMeusAnimais() ?>
                        </div>

                        <div style="padding: 0px 16px 0px 16px; margin: 15px 0px 15px 0px;">
                            <input id="titulo_animal" class="large" type="text" name="titulo_animal" placeholder="Título da publicação" maxlength="" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; margin-bottom:5px;" value="<?php if(isset($_POST['publicar'])): echo $_POST['titulo_animal']; endif; ?>" required autocomplete="off">
                            <input id="local_animal" class="large" type="text" name="local_animal" placeholder="Local" maxlength="" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; margin-bottom:5px;" value="<?php if(isset($_POST['publicar'])): echo $_POST['local_animal']; endif; ?>" required autocomplete="off">     
                            <!--INPUT AQUI-->
                        </div>

                        <div style="padding:10px 16px 10px 16px; border-top: 1px solid #f5f5f5;">
                            <button type="reset" onclick="jQuery('div#hx2q-als').show(); jQuery('div#hx2q-alv').hide(); jQuery('div#boxBlack').hide();">Cancelar</button>
                            <input type="hidden" name="id_login" value="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'id_login'); ?>">
                            <input type="submit" name="publicar_animal" value="Publicar animal">
                        </div>
                    </form>

                </div>

























                <div id="4d2q-a1v" style=" z-index: 3;position:relative;display:none; text-align: start;background-color: white;border:solid 1px #E6E9EB;border-left: none; border-right: none;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px;margin: 0px 0px 15px 0px;" >
                    <div style="width: 100%;min-height: 50px;">
                        <div style="display:block; margin: 10px 0 0 0;">
                            <figure style="border-radius:10%; margin: 0 12px 0 12px; padding: 0px; position: relative; float: left; width: 40px; height: 40px; overflow: hidden;">
                                <img src="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'foto_usuario') ?>" alt="" width="100%">
                            </figure>
                            <div style=" width: auto; height: 100%; padding-left:62px; padding-right: 10px;">
                                <span style="display: table;font-size: 15px;font-weight: 500;color: #212121;">
                                Adicionar animal
                            </div>
                        </div>
                    </div>
                    
                    <form enctype="multipart/form-data" style="margin: 0px; padding: 0px;" method="POST">
                        
                        
                        <div style="margin:5px 16px 0px 16px;color: #90949c;    font-size: 12px;    font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;">*Todos os campos abaixo são necessario ser preenchido, exceto a descrição sendo opcional.</br>*Caso o animal não seja seu, 'encontrado na rua.' preencha os campos como (DESCONHECIDO) ou (NÃO SEI). </div>
                        <div class="erroBox" id="erroEmpty" style="margin: 10px 16px 0px 16px;"></div>
                        <div style="margin:16px;" class="formDivulgarAnimal">
                            <!--<input id="titulo_animal" class="large" type="text" name="titulo_animal" placeholder="Título" maxlength="" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; margin-bottom:5px;" value="<?php if(isset($_POST['publicar_animal'])): echo $_POST['titulo_animal']; endif; ?>" required autocomplete="off">-->
                            <input id="nome_animal" class="large" type="text" name="nome_animal" placeholder="Nome do animal" maxlength="" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;" value="<?php if(isset($_POST['adicionar_animal'])): echo $_POST['nome_animal'];  endif; ?>" required autocomplete="off">
                            <select id="idade_animal" class="large" name="idade_animal" style="display:block; margin: 5px 0px 5px 0px;" required>
                                <option value="">Idade do animal</option>
                                <option value="Não sei">Não sei</option>
                                <option value="0 á 2 anos">0 á 2 anos</option>
                                <option value="2 á 4 anos">2 á 4 anos</option>
                                <option value="4 á 6 anos">4 á 6 anos</option>
                                <option value="6 á 8 anos">6 á 8 anos</option>
                                <option value="8 á 10 anos">8 á 10 anos</option>
                                <option value="Mais de 10 anos">Mais de 10 anos</option>
                            </select>
                            <select id="pelagem_animal" class="large" name="pelagem_animal" style="display:block; margin: 5px 0px 5px 0px;" required>
                                <option value="">Pelagem</option>
                                <option value="Pêlo Longo">Pêlo Longo</option>
                                <option value="Com dupla pelagem">Com dupla pelagem</option>
                                <option value="De pêlo duro ou pêlo de arame">De pêlo duro ou pêlo de arame</option>
                                <option value="Pêlo curto">Pêlo curto</option>
                                <option value="Pêlo longo sedoso sem ondulações">Pêlo longo sedoso sem ondulações</option>
                                <option value="Pêlo longo liso e levemente áspero">Pêlo longo liso e levemente áspero</option>
                                <option value="Pêlo longo com ondulações">Pêlo longo com ondulações</option>
                                <option value="Subpêlo denso e sobrepêlo de comprimento semi-longo">Subpêlo denso e sobrepêlo de comprimento semi-longo</option>
                                <option value="Subpêlo denso e sobrepêlo semicurto">Subpêlo denso e sobrepêlo semicurto</option>
                                <option value="Tipos peculiares de pelagem">Tipos peculiares de pelagem</option>
                            </select>
                            <input id="cor_animal" class="large" type="text" name="cor_animal" placeholder="Cor do animal" maxlength="" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;" value="<?php if(isset($_POST['adicionar_animal'])): echo $_POST['cor_animal'];  endif; ?>" required autocomplete="off"> 
                            <select id="porte_animal" class="large" name="porte_animal" style="display:block; margin: 5px 0px 5px 0px;" required>
                                <option value="">Porte</option>
                                <option value="Pequeno">Pequeno</option>
                                <option value="Médio">Médio</option>
                                <option value="Grande">Grande</option>
                            </select>
                            <select id="raca_animal" class="large" name="raca_animal" style="display:block; margin: 5px 0px 5px 0px;" required>
                                <option value="">Raça</option>
                                <option value="Não sei">Não sei</option>
                                <?php $consultaUsuarioDAO->optionForm(); ?>
                            </select>
                            <!--<input id="local_animal" class="large" type="text" name="local_animal" placeholder="Local" maxlength="" style="font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; margin-bottom:5px;" value="<?php if(isset($_POST['adicionar_animal'])): echo $_POST['local_animal']; endif; ?>" required autocomplete="off">-->
                            
                           
                                <label class="btn btn-success" for="foto_animal">Escolher uma foto para o animal</label>
                                <input style="display: none;" type="file" class="upload" name="foto_animal" id="foto_animal" onchange="document.getElementById('uploadFile').value = this.value;">
                            

                            <input style="margin-top:5px; width:100%;"" id="uploadFile" placeholder="" disabled="disabled">
                            
                            <textarea name="descricao_animal" maxlength="180" style="    font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; background: transparent;    border: 0;    font-size: 12px;    height: 60px;    margin: 0;    line-height: 18px;    min-height: 18px;    outline: none;    padding: 0;    resize: none;    width: 100%;" placeholder="E aí, quais são as descrições adicional do animal?"><?php if(isset($_POST['adicionar_animal'])): echo $_POST['descricao_animal'];  endif; ?></textarea>
                        </div>
                        
                        <div style="padding:10px 16px 10px 16px; border-top: 1px solid #f5f5f5;">
                            <button type="reset" onclick="jQuery('div#hx2q-als').show(); jQuery('div#4d2q-a1v').hide(); jQuery('div#boxBlack').hide();">Cancelar</button>
                            <input type="hidden" name="id_login" value="<?= $consultaUsuarioDAO->consultarUsuario($_SESSION['Login'], 'id_login'); ?>">
                            <input type="submit" name="adicionar_animal" value="Adicionar animal">
                        </div>
                    </form>
                </div>

                















                <div id="boxBlack" style="display: none;" onclick="jQuery('div#4d2q-a1v').hide(); jQuery('div#hx2q-alv').hide(); jQuery(this).hide(); jQuery('div#hx2q-als').show(); jQuery('div#editPerfil').hide();document.body.style.overflow='initial';"></div>
                <!---- AAAAA ---->
                

                <?php
                    if(isset($_GET['fil'])){ $mostrar = $_GET['fil']; }else{ $mostrar = 'todos'; }

                        
                    if($mostrar == 'perdido'){
                        echo $postDAO->mostrarPost($mostrar);
                    }else if($mostrar == 'doacao'){
                        echo $postDAO->mostrarPost($mostrar);
                    }else if($mostrar == 'encontrado'){
                        echo $postDAO->mostrarPost($mostrar);
                    }else{
                        echo $postDAO->mostrarPost('todos');
                    }


                ?>
            </div>
			  
            <div class="col-3">
            <!-- background-color: white;border: solid 1px #E6E9EB;border-bottom: solid 1px;border-color: #e5e6e9 #dfe0e4 #d0d1d5;border-radius: 0px 0px 3px; -->
                <div style="text-align: start; padding: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;font-size: 11px;-webkit-font-smoothing: antialiased;font-weight: bold;text-transform: uppercase;color: #90949c;"><span class="icon-filter" style="font-size: 13px;"></span>  Filtrar a Página</div>
		   
                    <hr style="border: 0;height: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);border-bottom: 1px solid rgba(255, 255, 255, 0.3);">

                    <style type="text/css">
                        a.animal-perdido, a.animal-doacao, a.animal-encontrado{
                            margin:3px 0px 3px 0px;
                            padding: 5px 15px 5px 15px;
                            display: block;
                            border-radius:40px;
                            color: white;
                            text-decoration: none;
                            opacity: 0.9;
                        }

                        a.animal-perdido:hover, a.animal-doacao:hover,a.animal-encontrado:hover{
                            opacity: 1;
                        }

                        a.animal-perdido{
                            background-color: #158CBA;
                        }

                        a.animal-doacao{
                            background-color:#FEA557;
                        }

                        a.animal-encontrado{
                            background-color:#3DC17A;
                        }
                    </style>
                
                    <a href="?fil=perdido" class="animal-perdido">Animais Perdidos</a>
                    <a href="?fil=doacao" class="animal-doacao">Animais para Doação</a>
                    <a href="?fil=encontrado" class="animal-encontrado">Animais Encontrados</a>
                    <a href="?fil=todos" class="animal-todos">Animais para doação & animais perdidos & animais encontrados</a>
                </div>
		   
                <style>
                    .links>a, .links{
                        color:gray;
                        font-size: 12px;
                        text-decoration: none;
                        opacity: 0.7;
                    }
			   
                    .links>a:hover{
                        color:gray;
                        text-decoration:underline;
                        opacity: 1;
                    }
                </style>

                <div class="links" style="text-align: start; padding: 10px;">
                    <!--<a href="#">Privacidade</a> · -->
                    <a href="politica.html">Política de privacidade</a> ·
                    <!--<a href="#">Anúncios</a> ·
                    <a href="#">Opções de anúncio</a> ·
                    <a href="#">Cookies</a> · -->
                    Doção © <?= date('Y'); ?>
                </div>
            </div>
        </div>

        <style>
            div.botC{
                display: none;
            }
            @media screen and (max-width: 990px){
                div.botC{
                    display: block;
                    margin-left: 100px;
                }
                div.botB,div.nomeD{
                    display: none;
                }
            }
            @media screen and (max-width: 760px){
                div.row{
                    left: 0px;
                    right: 0px;
	    
                    padding: 0px;
                    margin: 70px 10px 0px 10px;
                    min-width: 300px;
                }
                div.row>div{
                    float: none;
                    min-width: 0px;
	    		
                    width: 100%;
                    margin: 0px;
                    padding: 0px;
                }
                div.row>div.col-3{
                    display: none;
                }
            }


            @media screen and (max-width: 590px){
                .ft_animal{
                    float: none;
                    width: 100%;
                    height: auto;
                }
                .ft_animal>img{
                    width: 100%;
                    height: auto;
                }
                .desc_animal{
                    padding: 10px 0px 0px 0px;
                }
            }
	</style>
        
        <script>
            
            jQuery('input[name=categoria_animal]').click(function(){
                var n = jQuery(this).val();

                if(n == 'perdido'){
                    jQuery('div#perdido').animate({'backgroundColor':'#127BA3','opacity':1},0);
                    jQuery('div#doacao').animate({'backgroundColor':'#158CBA','opacity':0.8},0);
                    jQuery('div#encontrado').animate({'backgroundColor':'#158CBA','opacity':0.8},0);
                    jQuery('div#perdido>span').show();
                    jQuery('div#doacao>span').hide();
                    jQuery('div#encontrado>span').hide();
                }else if(n == 'encontrado'){
                    jQuery('div#encontrado').animate({'backgroundColor':'#127BA3','opacity':1},0);
                    jQuery('div#perdido').animate({'backgroundColor':'#158CBA','opacity':0.8},0);
                    jQuery('div#doacao').animate({'backgroundColor':'#158CBA','opacity':0.8},0);
                    jQuery('div#perdido>span').hide();
                    jQuery('div#doacao>span').hide();
                    jQuery('div#encontrado>span').show();
                }else{
                    jQuery('div#doacao').animate({'backgroundColor':'#127BA3','opacity':1},0);
                    jQuery('div#perdido').animate({'backgroundColor':'#158CBA','opacity':0.8},0);
                    jQuery('div#encontrado').animate({'backgroundColor':'#158CBA','opacity':0.8},0);
                    jQuery('div#doacao>span').show();
                    jQuery('div#perdido>span').hide();
                    jQuery('div#encontrado>span').hide();
                }
            });
        </script>
    </body>
</html>