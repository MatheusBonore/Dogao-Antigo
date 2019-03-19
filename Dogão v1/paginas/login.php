<?php
if(isset($_SESSION['Login']) and isset($_SESSION['Senha'])){
    $email_login = $_SESSION['Login'];
    $senha_login = $_SESSION['Senha'];
    $dados_login->setEmail_login($email_login);
    $dados_login->setSenha_login($senha_login);
    
    $loginUsuarioDAO->login($dados_login);
    header('Location:index.php');
}

if(isset($_POST['entrar'])){
    if( !empty($_POST['email_entrar']) and !empty($_POST['senha_entrar'])){
        $email_entrar = $_POST['email_entrar'];
        $senha_entrar = md5($_POST['senha_entrar']);
        
        $dados_login->setEmail_login($email_entrar);
        $dados_login->setSenha_login($senha_entrar);
        
        $return = $loginUsuarioDAO->login($dados_login);
        
        if($return == 0){
            $_SESSION['Login'] = $email_entrar;
            $_SESSION['Senha'] = $senha_entrar;
            header('Location:index.php');
        }
        if($return == 1){
            $nullSenhaErro = TRUE;
        }
        if($return == 2){
            $nullEmailErro = TRUE;
        }
    }
}

if(isset($_POST['cadastrar'])){
    $nome_cadastro = $_POST['nome_cadastro'];
    $sobrenome_cadastro = $_POST['sobrenome_cadastro'];
    $email_cadastro = $_POST['email_cadastro'];
    $senha_cadastro = md5($_POST['senha_cadastro']);
    $dia_cadastro = $_POST['dia_cadastro'];
    $mes_cadastro = $_POST['mes_cadastro'];
    $ano_cadastro = $_POST['ano_cadastro'];
    $genero_cadastro = $_POST['genero_cadastro'];
    
    $dados_cadastro->setEmail_cadastro($email_cadastro);
    
    $return = $cadastroUsuarioDAO->email_registrado($dados_cadastro);
    if($return == 1){
        $email_registrado = 1;
    }else{
        $email_registrado = 0;
        
        $_SESSION['DADOS']['NOME'] = ($nome_cadastro);
        $_SESSION['DADOS']['SOBRENOME'] = ($sobrenome_cadastro);
        $_SESSION['DADOS']['EMAIL'] = ($email_cadastro);
        $_SESSION['DADOS']['SENHA'] = ($senha_cadastro);
        $_SESSION['DADOS']['DIA'] = ($dia_cadastro);
        $_SESSION['DADOS']['MES'] = ($mes_cadastro);
        $_SESSION['DADOS']['ANO'] = ($ano_cadastro);
        $_SESSION['DADOS']['GENERO'] = ($genero_cadastro);
    }
}

if(isset($_POST['registrar'])){
   $nome_cadastro = $_SESSION['DADOS']['NOME'];
   $sobrenome_cadastro = $_SESSION['DADOS']['SOBRENOME'];
   $email_cadastro = $_SESSION['DADOS']['EMAIL'];
   $senha_cadastro = $_SESSION['DADOS']['SENHA'];
   $dia_cadastro = $_SESSION['DADOS']['DIA'];
   $mes_cadastro = $_SESSION['DADOS']['MES'];
   $ano_cadastro = $_SESSION['DADOS']['ANO'];
   $genero_cadastro = $_SESSION['DADOS']['GENERO'];
   $telefonefixo_cadastro = $_POST['telefonefixo_cadastro'];
   $celular_cadastro = $_POST['celular_cadastro'];
   $cep_cadastro = $_POST['cep_cadastro'];
   $pais_cadastro = $_POST['pais_cadastro'];
   $estado_cadastro = $_POST['estado_cadastro'];
   $cidade_cadastro = $_POST['cidade_cadastro'];
   $bairro_cadastro = $_POST['bairro_cadastro'];
   $rua_cadastro = $_POST['rua_cadastro'];
   $numero_cadastro = $_POST['numero_cadastro'];
   
   if(isset($_SESSION['DADOS'])): unset($_SESSION['DADOS']);  endif;
   
   $dados_cadastro->setNome_cadastro($nome_cadastro);
   $dados_cadastro->setSobrenome_cadastro($sobrenome_cadastro);
   $dados_cadastro->setEmail_cadastro($email_cadastro);
   $dados_cadastro->setSenha_cadastro($senha_cadastro);
   $dados_cadastro->setDia_cadastro($dia_cadastro);
   $dados_cadastro->setMes_cadastro($mes_cadastro);
   $dados_cadastro->setAno_cadastro($ano_cadastro);
   $dados_cadastro->setGenero_cadastro($genero_cadastro);
   $dados_cadastro->setTelefone1_cadastro($telefonefixo_cadastro);
   $dados_cadastro->setTelefone2_cadastro($celular_cadastro);
   $dados_cadastro->setCep_cadastro($cep_cadastro);
   $dados_cadastro->setPais_cadastro($pais_cadastro);
   $dados_cadastro->setEstado_cadastro($estado_cadastro);
   $dados_cadastro->setCidade_cadastro($cidade_cadastro);
   $dados_cadastro->setBairro_cadastro($bairro_cadastro);
   $dados_cadastro->setRua_cadastro($rua_cadastro);
   $dados_cadastro->setNumero_cadastro($numero_cadastro);
   
   $cadastroUsuarioDAO->cadastrar($dados_cadastro);
   $_SESSION['Login'] = $email_cadastro;
   $_SESSION['Senha'] = $senha_cadastro;
   
   header('Location:index.php');
    
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width-device, initial-scale=1">
        
        <script src="js/jquery/jquery-3.1.1.min.js"></script>
        <script src="js/jquery/jquery.maskedinput.js"></script>
        <script src="js/cep.js"></script>
        
        <link rel="stylesheet" type="text/css" href="paginas/TODOS.css">
        <link rel="stylesheet" type="text/css" href="css/default.css">
        <link rel="stylesheet" type="text/css" href="fonts/icomoon.css">
        
        <link rel="icon" type="image/x-icon" href="layout/lg.png"/>
        <link rel="shortcut icon" type="image/x-icon" href="layout/lg.png"/>

        <title>Dogão – entre ou cadastre-se</title>
        
        <style type="text/css">
            body{
                background-image: url('layout/Hero-Recuperado.jpg');
                background-color: #86CBEC;
                background-repeat: repeat-x;
                background-size: 600px;

                position: fixed;
                overflow: hidden;
                width: 100%;
                height: 100%;
            }
        </style>
        
    </head>
    <body>
        <style>
            div.boxregister{
                background-color: #EEF1F1;
                margin: 0 auto;
                width: 60%;
                min-width: 670px;
                padding: 15px 20px 15px 20px;
                border: solid 1px;
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
                border-color: rgb(187, 187, 187);
                z-index: 2;
                position: absolute;
                top: 0px;
                bottom: 0px;
                right: 0px;
            }
            
            div.row-col-1{
                width: 49%;
                height: 100%;
                
                float: left;
            }
            div.row-col-2{
                width: 45%;
                height: 100%;
                
                float: right;
                overflow-y: auto;
                
            }
        </style>
        <script>
            function add_boxregister(){
                var boxregister ='<div id="boxBlack">';
                        boxregister +='<div class="boxregister">';
                            boxregister +='<div class="row-col-1">';
                                boxregister +='<div style="border-radius: 5px; border-color: white; background-color: rgb(187, 187, 187); padding: 10px; margin-top: 20px;">';
                                    boxregister +='Ola, '; 
                                    boxregister +='<?php if(isset($_SESSION["DADOS"])): echo($_SESSION["DADOS"]["NOME"]); endif; ?> ';
                                    boxregister +='<?php if(isset($_SESSION["DADOS"])): echo($_SESSION["DADOS"]["SOBRENOME"]); endif; ?>';
                                boxregister +='</div>';
                                boxregister +='<center>';
                                    boxregister +='<p>Muitas pessoas perdem seus cachorros ou qualquer outro tipo de animal de estimação</p>';
                                    boxregister +='<p>O uso pretendido deste sistema é voltada para auxiliar donos de animais perdidos a entrar em contato com pessoas que, potencialmente, podem os ter encontrado, e ainda permitir que Ongs e Canis possam expor animais para a doção.</p>';
                                    boxregister +='<p>Além disso, com esta ferramenta, os usuários poderão cadastrar seus animais de estimação, em especial cachorros.</p>';
                                    boxregister +='<p>Estas informações estarão disponíveis para as pessoas acessar o formulário on-line.</p>';  
                                    boxregister +='<span class="marcaNome" style="font-size:50px;"><span class="marcaPrimeiro">D</span><span class="marcaSegundo">ogão</span></span>';
                                boxregister +='</center>';
                                
                            boxregister +='</div>';
                            
                            boxregister +='<div class="row-col-2">';
                                boxregister +='<form method="POST">';
                                    boxregister +='<label for="telefonefixo_cadastro">Telefone Fixo</label>';
                                    boxregister +='<input type="text" class="large formRequired" id="telefonefixo_cadastro" name="telefonefixo_cadastro" value="" required>';
                                    boxregister +='<label for="celular_cadastro">Celular</label>';
                                    boxregister +='<input type="text" class="large formRequired" id="celular_cadastro" name="celular_cadastro" value="" required>';
                                    boxregister +='<label for="cep">CEP</label>';
                                    boxregister +='<input type="text" class="large formRequired" id="cep" name="cep_cadastro" value="" onblur="pesquisacep(this.value);" required>';
                                    boxregister +='<label id="pais_label" for="pais_cadastro">Endereço*</label>';
                                    boxregister +='<center><select style="margin-bottom:5px;" class="large" name="pais_cadastro" id="pais_cadastro" required>';
                                    boxregister +='<option value="" id="">Pais</option>';
                                    boxregister +='<option value="br">Brasil</option>';
                                    boxregister +='</select>';
                                    boxregister +='<input style="margin-bottom:5px;" type="text" class="large formRequired" id="uf" maxlength="15" name="estado_cadastro" placeholder="Estado" value="" readonly required>';
                                    boxregister +='<input type="text" class="large formRequired" id="cidade" maxlength="15" name="cidade_cadastro" placeholder="Cidade" value="" readonly required>';
                                    boxregister +='</center>';
                                    boxregister +='<label for="bairro">Bairro</label>';
                                    boxregister +='<input maxlength="52" type="text" class="large formRequired" id="bairro" name="bairro_cadastro" placeholder="Bairro" value="" readonly required>';
                                    boxregister +='<label for="rua">Rua</label>';
                                    boxregister +='<style> #rua_cadastro{width: 100%;} </style>';
                                    boxregister +='<input maxlength="52" type="text" class="formRequired" id="rua" name="rua_cadastro" placeholder="Rua" value="" style="padding-right: 35px;" readonly required>';
                                    boxregister +='<input maxlength="6" type="text" class="formRequired" id="numero_cadastro" style="margin-top:5px;width: 40%;" name="numero_cadastro" placeholder="Número" value="" required>';
                                    boxregister +='<div class="erroBox" id="erroEmptyRegister"></div>';
                                    boxregister +='<input type="submit" name="registrar" value="Registrar" style="display:block; margin-top:5px; float:right;">';
                                    
                                boxregister +='</form>';
                                
                            boxregister +='</div>';
                        boxregister +='</div>';
                    boxregister +='</div>';
                
                jQuery('div#entrar').append(boxregister);
            }
            function add_boxgetin(){
                var boxgetin ='<div class="boxgetin" id="boxBlack">';
                boxgetin +='<div class="getIn">';
                boxgetin +='<div style="display:block; height: 40px;">';
                boxgetin +='<div style="float:left; height:100%; width:430px;">';
                boxgetin +='<span class="marcaNome">';
                boxgetin +='<span class="marcaPrimeiro">D</span><span class="marcaSegundo">ogão</span> - Entrar';
                boxgetin +='</span>';
                boxgetin +='</div>';
                boxgetin +='<div class="boxgetinClose">';
                boxgetin +='<button onClick="remove_boxgetin();" style="border:none;background-color: transparent;"><span class="icon-cross" style="font-size:24px; opacity:0.7;"></span></button>';
                boxgetin +='</div>';
                boxgetin +='</div>';
                boxgetin +='<div class="alertBox">';
                boxgetin +='Obtenha o Dogão para seu dispositivo mobile e navegue mais rápido.';
                boxgetin +='</div>';    
                boxgetin +='<h4>Faça o login para continuar</h4>';
                boxgetin +='<hr style="height:1px;border-width:0;background-color:rgb(187, 187, 187); opacity:0.5;">';
                boxgetin +='<form method="POST">';
                boxgetin +='<label for="email_entrar">Seu Email</label>';
                boxgetin +='<input maxlength="40" placeholder="Email" type="text" class="large formRequired" id="email_entrar" name="email_entrar" value="<?php if(isset($_POST["email_entrar"])){echo $_POST["email_entrar"];} ?>"/>';
                boxgetin +='<label for="senha_entrar">Sua senha</label>';
                boxgetin +='<input maxlength="40" style="margin-bottom:10px;" placeholder="Senha" type="password" class="large formRequired" id="senha_entrar" name="senha_entrar"/>';
                boxgetin +='<div class="erroBox" id="erroEntrarEmpty">';
                boxgetin +='</div>';
                boxgetin +='<input type="submit" value="Login" name="entrar"/>';
                boxgetin +=' <button type="reset" onClick="remove_boxgetin();">Criar nova conta</button>';
                boxgetin +=' <!--<a href="#" style="font-size:14px;">Esqueci minha senha</a>-->';
                boxgetin +='</form>';
                boxgetin +='</div>';
                boxgetin +='</div>';
                
                jQuery('div#entrar').append(boxgetin);
            }
            
            function remove_boxgetin(){
                jQuery('div#entrar>div').remove();
            }
            jQuery(document).ready(function(){
                
                <?php 
                    if(isset($_POST['cadastrar'])){
                        if( !empty($_POST['nome_cadastro']) and
                            !empty($_POST['sobrenome_cadastro']) and
                            !empty($_POST['email_cadastro']) and
                            !empty($_POST['senha_cadastro']) and
                            !empty($_POST['dia_cadastro']) and
                            !empty($_POST['mes_cadastro']) and
                            !empty($_POST['ano_cadastro']) and
                            !empty($_POST['genero_cadastro']) and $email_registrado != 1){
                            
                            echo'add_boxregister();';
                            
                            
                        }else{
                            if(isset($email_registrado) and $email_registrado == 1){
                                echo'jQuery("#emailErro").append("Não foi possível usar este e-mail.");';
                                echo'jQuery("#emailErro").show();';
                                echo'jQuery("input#email_cadastro").removeClass("formRequired");';
                                echo'jQuery("input#email_cadastro").addClass("formErro");';
                                echo'jQuery("input#email_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); jQuery("#emailErro").remove(); });';
                            }
                            /*if(empty($_POST['nome_cadastro']) or
                            empty($_POST['sobrenome_cadastro']) or
                            empty($_POST['email_cadastro']) or 
                            empty($_POST['senha_cadastro']) or
                            empty($_POST['dia_cadastro']) or
                            empty($_POST['mes_cadastro']) or
                            empty($_POST['ano_cadastro']) or
                            empty($_POST['genero_cadastro'])){ 
                                echo'jQuery("#erroEmpty").append("Existem campos vazios");'; 
                                echo'jQuery("#erroEmpty").show();';
                            }
                                
                            if(empty($_POST['nome_cadastro'])){
                                echo'jQuery("input#nome_cadastro").addClass("formErro");';
                                echo'jQuery("input#nome_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            if(empty($_POST['sobrenome_cadastro'])){
                                echo'jQuery("input#sobrenome_cadastro").addClass("formErro");';
                                echo'jQuery("input#sobrenome_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            if(empty($_POST['email_cadastro'])){
                                echo'jQuery("input#email_cadastro").addClass("formErro");';
                                echo'jQuery("input#email_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            if(empty($_POST['senha_cadastro'])){
                                echo'jQuery("input#senha_cadastro").addClass("formErro");';
                                echo'jQuery("input#senha_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            if(empty($_POST['dia_cadastro'])){
                                echo'jQuery("#date_cadastro").addClass("erro");';
                                echo'jQuery("input#dia_cadastro").addClass("erroBorder");';
                                echo'jQuery("input#dia_cadastro").focus(function(){ jQuery("#date_cadastro").removeClass("erro"); jQuery(this).removeClass("erroBorder"); });';
                            }
                            if(empty($_POST['mes_cadastro'])){
                                echo'jQuery("#date_cadastro").addClass("erro");';
                                echo'jQuery("select#mes_cadastro").addClass("erroBorder");';
                                echo'jQuery("select#mes_cadastro").focus(function(){ jQuery("#date_cadastro").removeClass("erro"); jQuery(this).removeClass("erroBorder"); });';
                            }
                            if(empty($_POST['ano_cadastro'])){
                                echo'jQuery("#date_cadastro").addClass("erro");';
                                echo'jQuery("input#ano_cadastro").addClass("erroBorder");';
                                echo'jQuery("input#ano_cadastro").focus(function(){ jQuery("#date_cadastro").removeClass("erro"); jQuery(this).removeClass("erroBorder"); });';
                            }
                            if(empty($_POST['genero_cadastro'])){
                                echo'jQuery("#genero_cadastro").addClass("erro");';
                                echo'jQuery("select#input_genero_cadastro").addClass("erroBorder");';
                                echo'jQuery("select#input_genero_cadastro").focus(function(){ jQuery("#genero_cadastro").removeClass("erro"); jQuery(this).removeClass("erroBorder"); });';
                            }-*/
                        }
                    }elseif(isset($_POST['registrar'])){
                        echo'add_boxregister();';
                        
                        if(empty($_POST['telefonefixo_cadastro']) or
                           empty($_POST['celular_cadastro']) or
                           empty($_POST['cep_cadastro']) or
                           empty($_POST['pais_cadastro']) or
                           empty($_POST['estado_cadastro']) or
                           empty($_POST['cidade_cadastro']) or
                           empty($_POST['bairro_cadastro']) or
                           empty($_POST['rua_cadastro']) or
                           empty($_POST['numero_cadastro'])){
                                echo'jQuery("#erroEmptyRegister").append("Existem campos vazios");'; 
                                echo'jQuery("#erroEmptyRegister").show();';
                           }
                        
                            if(empty($_POST['telefonefixo_cadastro'])){
                                echo'jQuery("input#telefonefixo_cadastro").addClass("formErro");';
                                echo'jQuery("input#telefonefixo_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            
                            if(empty($_POST['celular_cadastro'])){
                                echo'jQuery("input#celular_cadastro").addClass("formErro");';
                                echo'jQuery("input#celular_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                        
                            if(empty($_POST['cep_cadastro'])){
                                echo'jQuery("input#cep_cadastro").addClass("formErro");';
                                echo'jQuery("input#cep_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            
                            if(empty($_POST['pais_cadastro'])){
                                echo'jQuery("#pais_label").addClass("erro");';
                                echo'jQuery("select#pais_cadastro").addClass("erroBorder");';
                                echo'jQuery("select#pais_cadastro").focus(function(){ jQuery("#pais_label").removeClass("erro"); jQuery(this).removeClass("erroBorder"); });';
                            }
                            
                            if(empty($_POST['estado_cadastro'])){
                                echo'jQuery("#pais_label").addClass("erro");';
                                echo'jQuery("input#estado_cadastro").addClass("formErro");';
                                echo'jQuery("input#estado_cadastro").focus(function(){ jQuery("#pais_label").removeClass("erro"); jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            
                            if(empty($_POST['cidade_cadastro'])){
                                echo'jQuery("#pais_label").addClass("erro");';
                                echo'jQuery("input#cidade_cadastro").addClass("formErro");';
                                echo'jQuery("input#cidade_cadastro").focus(function(){ jQuery("#pais_label").removeClass("erro"); jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            
                            if(empty($_POST['bairro_cadastro'])){
                                echo'jQuery("input#bairro_cadastro").addClass("formErro");';
                                echo'jQuery("input#bairro_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            
                            if(empty($_POST['rua_cadastro'])){
                                echo'jQuery("input#rua_cadastro").addClass("formErro");';
                                echo'jQuery("input#rua_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                            
                            if(empty($_POST['numero_cadastro'])){
                                echo'jQuery("input#numero_cadastro").addClass("formErro");';
                                echo'jQuery("input#numero_cadastro").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            }
                    }else{
                        echo'add_boxgetin();';
                    }
                    if(isset($_POST['entrar'])){
                        if(empty($_POST['email_entrar']) or empty($_POST['senha_entrar'])){
                            echo'jQuery("#erroEntrarEmpty").append("Existem campos vazios");';
                            echo'jQuery("#erroEntrarEmpty").show();';
                        }
                        if(empty($_POST['email_entrar'])){
                            echo'jQuery("input#email_entrar").addClass("formErro");';
                            echo'jQuery("input#email_entrar").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                        }
                        if(empty($_POST['senha_entrar'])){
                            echo'jQuery("input#senha_entrar").addClass("formErro");';
                            echo'jQuery("input#senha_entrar").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                        }
                        if(isset($nullEmailErro) or isset($nullSenhaErro)){
                            echo'jQuery("#erroEntrarEmpty").append("E-mail ou senha inserido não corresponde a nenhuma conta.");';
                            echo'jQuery("#erroEntrarEmpty").show();';
                            echo'jQuery("input#email_entrar").addClass("formErro");';
                            echo'jQuery("input#senha_entrar").addClass("formErro");';
                            echo'jQuery("input#email_entrar").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                            echo'jQuery("input#senha_entrar").focus(function(){ jQuery(this).removeClass("formErro"); jQuery(this).addClass("formRequired"); });';
                        }
                    }
                ?>
            });
        </script>
        
        <div id="entrar"></div>          
                
        <div id="background_banding_container" class="ie_legacy">
            
            <div class="lo">
                <img style="float:left;" src="layout/mobile.png" width="250" />
                <div style="float:right; color:white; font-size: 40px; margin-left:10px; font-weight: bold; width: 370px;">
                    <span style="text-shadow: 1px 0px 5px rgba(0, 0, 0, 0.4);">
                        Facilite sua busca baixando nosso aplicativo.
                    </span>
                    <a>
                        <img src="layout/pt-br_play_store.png" width="200px" />
                    </a>
                </div>
            </div>
            
            <div class="form">
                <div class="div-form-register" style="padding-top:20px;">
                    <span class="marcaNome">
                        <span class="marcaPrimeiro">D</span><span class="marcaSegundo">ogão</span> - Registro
                    </span>
                    
                    <form action="" method="POST">
                        <label for="nome_cadastro">Nome</label>
                        <input style="margin-right:5px;" maxlength="20" type="text" class="large formRequired" id="nome_cadastro" name="nome_cadastro" placeholder="Primeiro nome" value="<?php if(isset($_POST['nome_cadastro'])){echo $_POST['nome_cadastro'];} ?>" required autocomplete="off">
                        
                        <label for="sobrenome_cadastro">Sobrenome</label>
                        <input maxlength="20" type="text" class="large formRequired" id="sobrenome_cadastro" name="sobrenome_cadastro" placeholder="Sobrenome" value="<?php if(isset($_POST['sobrenome_cadastro'])){echo $_POST['sobrenome_cadastro'];} ?>" required autocomplete="off">
                        
                        <label for="email_cadastrar">Cadastre seu Email</label>
                        <input maxlength="40" type="text" class="large formRequired" placeholder="exemplo@email.com" id="email_cadastro" name="email_cadastro" value="<?php if(isset($_POST['email_cadastro'])){echo $_POST['email_cadastro'];} ?>" required autocomplete="off">
                        <div class="erroBox" id="emailErro"></div>
                        
                        <label for="senha_cadastro">Criar senha</label>
                        <input maxlength="30" type="password" class="large formRequired" id="senha_cadastro" name="senha_cadastro" placeholder="Nova senha" required autocomplete="off">

                        <label for="dia_cadastro" id="date_cadastro">Data de nascimento*</label>
                        <center>
                            <input type="text" style="margin-right: 5px;" class="small" id="dia_cadastro" maxlength="2" name="dia_cadastro" placeholder="Dia" value="<?php if(isset($_POST['dia_cadastro'])){echo $_POST['dia_cadastro'];} ?>" required autocomplete="off">
                            <select name="mes_cadastro" id="mes_cadastro" style="margin-right: 5px;" class="small" required>
                                <option value="1">Janeiro</option>
                                <option value="2">Fevereiro</option>
                                <option value="3">Março</option>
                                <option value="4">Abril</option>
                                <option value="5">Maio</option>
                                <option value="6">Junho</option>
                                <option value="7">Julho</option>
                                <option value="8">Agosto</option>
                                <option value="9">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                                    
                            </select>
                            <input type="text" class="small" id="ano_cadastro" maxlength="4" name="ano_cadastro" placeholder="Ano" value="<?php if(isset($_POST['ano_cadastro'])){echo $_POST['ano_cadastro'];} ?>" required autocomplete="off">
                        </center>

                        <label for="genero_cadastro" id="genero_cadastro">Sexo*</label>
                        <select name="genero_cadastro" style="margin-bottom:10px;" id="input_genero_cadastro" class="large" style="margin:0px; height: 30px; width:100%;" required>
                            <option value="">Eu sou..</option>
                            <option value="homem">Homem</option>
                            <option value="mulher">Mulher</option>
                            <option value="outro">Outro</option>
                        </select>
                        
                        <div class="erroBox" id="erroEmpty"></div>
                        <input type="submit" value="Registrar" name="cadastrar">

                        <button type="reset" onclick="add_boxgetin();">Já tenho uma conta</button>
                        <p style="color: #767676; font-size: 13px;">Ao clicar em registrar você estará aceitando os termos de uso e nossas politicas de privacidade.</p>
                    </form>
                </div>
                <style>
                
                </style>
                <div class="footer_links_container">
                    <div>
                        <span>© <?= date("Y") ?> Sistema Dogão</span>
                    </div>
                    <div>
                        <span style="">
                            <a href="politica.html">Política de privacidade</a>
                        </span>
                        <!--<span style="margin-left:10px;">
                            <a href="#">Privacidade e Cookies</a>
                        </span>-->
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            @media screen and (max-width: 670px){
                div.boxregister{
                    position: absolute;
                    border-radius: 0;
                    border:none;
                    
                    overflow: auto;
                    
                    margin: 0px 0px 0px 0px;
                    padding: 0px ;
                    
                    right: 0px;
                    left: 0px;
                    top: 0px;
                    bottom: 0px;
                    
                    width: auto;
                    height: auto;
                    min-width: 320px;
                }
                div.row-col-1, div.row-col-2{
                    float: none;
                    padding: 0px 20px 20px 20px;
                    margin: 0px;
                    
                    width: auto;
                    height: auto;
                }
                div.row-col-2>form{
                    width: 100%;
                }
                
                /* ------------------------ */
                div.form{
                    position: absolute;
                    border-radius: 0;
                    border:none;
                    
                    overflow: auto;
                    
                    margin: 0px 0px 0px 0px;
                    padding: 0px 0px 0px 0px;
                    
                    right: 0px;
                    left: 0px;
                    top: 0px;
                    bottom: 0px;
                    
                    width: auto;
                    height: auto;
                    min-width: 320px;
                }
                .div-form-register{
                    padding: 0px 20px 0px 20px;
                    margin: 0px;
                }
                .footer_links_container{
                    margin: 0px;
                    padding: 0px 0px 10px 0px;
                }
                .footer_links_container>div{
                    margin:0px;
                    padding: 0px 0px 0px 20px;
                }
                input,select,#dia_cadastro,#mes_cadastro,#ano_cadastro,.input-dual{
                    width: 100%;
                    float: none;
                    margin: 0px 0px 5px 0px;
                }
                input[type=submit]{
                    margin-bottom: 10px;
                }
                div.getIn {
                    margin: 0px;
                    width: auto;
                    height: auto;
                    border: none;
                    border-radius: 0px;
                    position: absolute;
                    top:0px;
                    left:0px;
                    bottom:0px;
                    right:0px;
                }
                div.boxgetin{
                    display: block;
                    min-width: 320px;
                }
                div.boxgetin>div>form>label{
                    display: none;
                }
                div.boxgetin>div>form>input[type=text], div.boxgetin>div>form>input[type=password]{
                    margin: 0px;
                    border:none;
                    border-radius: 0px 0px 3px 3px;
                    border:solid #D5D6D6 1px;
                }
                div.boxgetin>div>form>input[name=email_entrar]{
                    border-bottom:none;
                    border-radius: 3px 3px 0px 0px;
                }
                div.boxgetinClose{
                    display: none;
                }
                div.alertBox{
                    display: block;
                }
            }
        </style>
        <!--<script>
        $("#cep_cadastro").blur(function(){
            var cep = this.value.replace(/[^0-9]/, "");
            
            if(cep.length!=8){
                return false;
            }
            
            var url = "http://viacep.com.br/ws/"+cep+"/json/";
             $.getJSON(url, function(dadosRetorno){
                try{
                    $("#rua_cadastro").val(dadosRetorno.logradouro);
                    $("#bairro_cadastro").val(dadosRetorno.bairro);
                    $("#cidade_cadastro").val(dadosRetorno.localidade);
                    $("#estado_cadastro").val(dadosRetorno.uf);
                }catch(ex){}
            });
        });</script>-->

        <script>
            jQuery(document).ready(function(){
                jQuery("input#cep").mask("99999-999");
                jQuery("input#telefonefixo_cadastro").mask("(99) 9999-9999");
                jQuery("input#celular_cadastro").mask("(99) 99999-9999");
            });
        </script>
    </body>
</html>