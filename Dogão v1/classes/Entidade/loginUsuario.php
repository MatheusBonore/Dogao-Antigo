<?php
    class dados_login{
        private $email_login;
        private $senha_login;
        
        function getEmail_login() {
            return $this->email_login;
        }

        function getSenha_login() {
            return $this->senha_login;
        }

        function setEmail_login($email_login) {
            $this->email_login = $email_login;
        }

        function setSenha_login($senha_login) {
            $this->senha_login = $senha_login;
        }
    }
    
?>