<?php
    class dados_post{
        private $id_login;
        private $id_animal;
        private $data_post;
        private $data_expira_post;
        private $titulo_post;
        private $categoria_post;
        private $local_post;
        
        function getId_login() {
            return $this->id_login;
        }

        function getId_animal() {
            return $this->id_animal;
        }

        function getData_post() {
            return $this->data_post;
        }

        function getData_expira_post() {
            return $this->data_expira_post;
        }

        function getTitulo_post() {
            return $this->titulo_post;
        }

        function getCategoria_post() {
            return $this->categoria_post;
        }

        function getLocal_post() {
            return $this->local_post;
        }

        function setId_login($id_login) {
            $this->id_login = $id_login;
        }

        function setId_animal($id_animal) {
            $this->id_animal = $id_animal;
        }

        function setData_post($data_post) {
            $this->data_post = $data_post;
        }

        function setData_expira_post($data_expira_post) {
            $this->data_expira_post = $data_expira_post;
        }

        function setTitulo_post($titulo_post) {
            $this->titulo_post = $titulo_post;
        }

        function setCategoria_post($categoria_post) {
            $this->categoria_post = $categoria_post;
        }

        function setLocal_post($local_post) {
            $this->local_post = $local_post;
        }


    }
?>