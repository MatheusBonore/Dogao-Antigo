<?php
session_start();
require_once('classes/DAO/connect.php');
$con = new Connect();

require_once('classes/DAO/cadastroUsuarioDAO.php');
$cadastroUsuarioDAO = new cadastroUsuarioDAO();

require_once('classes/Entidade/cadastroUsuario.php');
$dados_cadastro = new dados_cadastro();

require_once('classes/DAO/loginUsuarioDAO.php');
$loginUsuarioDAO = new loginUsuarioDAO();

require_once('classes/Entidade/loginUsuario.php');
$dados_login = new dados_login();

if(isset($_SESSION['Login']) and isset($_SESSION['Senha'])){
   include('paginas/inicial.php');
 
}else{
   include('paginas/login.php');
}
?>