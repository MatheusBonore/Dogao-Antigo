<?php
    class dados_animal{
        private $id_login;
        private $nome_animal;
        private $raca_animal;
        private $idade_animal;
        private $pelagem_animal;
        private $cor_animal;
        private $tamanho_animal;
        private $descricao_animal;
        private $foto_animal;

        function getId_login() {
            return $this->id_login;
        }

        function getNome_animal() {
            return $this->nome_animal;
        }

        function getRaca_animal() {
            return $this->raca_animal;
        }

        function getIdade_animal() {
            return $this->idade_animal;
        }

        function getPelagem_animal() {
            return $this->pelagem_animal;
        }

        function getCor_animal() {
            return $this->cor_animal;
        }

        function getTamanho_animal() {
            return $this->tamanho_animal;
        }

        function getDescricao_animal() {
            return $this->descricao_animal;
        }

        function getFoto_animal() {
            return $this->foto_animal;
        }

        function setId_login($id_login) {
            $this->id_login = $id_login;
        }

        function setNome_animal($nome_animal) {
            $this->nome_animal = $nome_animal;
        }

        function setRaca_animal($raca_animal) {
            $this->raca_animal = $raca_animal;
        }

        function setIdade_animal($idade_animal) {
            $this->idade_animal = $idade_animal;
        }

        function setPelagem_animal($pelagem_animal) {
            $this->pelagem_animal = $pelagem_animal;
        }

        function setCor_animal($cor_animal) {
            $this->cor_animal = $cor_animal;
        }

        function setTamanho_animal($tamanho_animal) {
            $this->tamanho_animal = $tamanho_animal;
        }

        function setDescricao_animal($descricao_animal) {
            $this->descricao_animal = $descricao_animal;
        }

        function setFoto_animal($foto_animal) {
            $this->foto_animal = $foto_animal;
        }


    }
?>