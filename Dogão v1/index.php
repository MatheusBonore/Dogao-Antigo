<?php
session_start();
require_once('classes/DAO/connect.php');
$connect = new Connect();

require_once('classes/DAO/cadastroUsuarioDAO.php');
$cadastroUsuarioDAO = new cadastroUsuarioDAO($connect);

require_once('classes/Entidade/cadastroUsuario.php');
$dados_cadastro = new dados_cadastro();

require_once('classes/DAO/loginUsuarioDAO.php');
$loginUsuarioDAO = new loginUsuarioDAO($connect);

require_once('classes/Entidade/loginUsuario.php');
$dados_login = new dados_login();

require_once('classes/DAO/consultaUsuarioDAO.php');
$consultaUsuarioDAO = new consultaUsuarioDAO($connect);

require_once('classes/DAO/postDAO.php');
$postDAO = new postDAO($connect);

require_once('classes/DAO/cadastroAnimalPostDAO.php');
$cadastroAnimalPostDAO = new cadastroAnimalPostDAO($connect);

require_once('classes/DAO/excluirDAO.php');
$excluirDAO = new excluirDAO($connect);

require_once('classes/DAO/notificacaoDAO.php');
$notificacaoDAO = new notificacaoDAO($connect);

require_once('classes/DAO/editarUsuarioDAO.php');
$editarUsuarioDAO = new editarUsuarioDAO($connect);

require_once('classes/Entidade/cadastroAnimal.php');
$dados_animal = new dados_animal();

require_once('classes/Entidade/cadastroPost.php');
$dados_post = new dados_post();

require_once('classes/Entidade/cadastroNotificacao.php');
$dados_notificacao = new dados_notificacao();

require_once('classes/Entidade/editarUsuario.php');
$dados_editarUsuario = new dados_editarUsuario();

if(isset($_SESSION['Login']) and isset($_SESSION['Senha'])){
   include('paginas/inicial.php');
 
}else{
   include('paginas/login.php');
}
?>