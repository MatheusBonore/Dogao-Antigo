<?php
    class dados_notificacao{
        private $id_remetente;
        private $id_destinatario;
        private $id_animal;
        private $id_post;
        private $data;
        
        function getId_remetente() {
            return $this->id_remetente;
        }

        function getId_destinatario() {
            return $this->id_destinatario;
        }

        function getId_animal() {
            return $this->id_animal;
        }

        function getId_post() {
            return $this->id_post;
        }

        function getData() {
            return $this->data;
        }

        function setId_remetente($id_remetente) {
            $this->id_remetente = $id_remetente;
        }

        function setId_destinatario($id_destinatario) {
            $this->id_destinatario = $id_destinatario;
        }

        function setId_animal($id_animal) {
            $this->id_animal = $id_animal;
        }

        function setId_post($id_post) {
            $this->id_post = $id_post;
        }

        function setData($data) {
            $this->data = $data;
        }
    }
?>