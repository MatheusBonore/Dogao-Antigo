<?php
    class dados_editarUsuario{
    	private $id_login;
    	private $telefone01;
    	private $telefone02;
    	private $cep;
    	private $pais;
    	private $estado;
    	private $cidade;
    	private $bairro;
    	private $rua;
    	private $numero;
        
        function getId_login() {
            return $this->id_login;
        }

        function getTelefone01() {
            return $this->telefone01;
        }

        function getTelefone02() {
            return $this->telefone02;
        }

        function getCep() {
            return $this->cep;
        }

        function getPais() {
            return $this->pais;
        }

        function getEstado() {
            return $this->estado;
        }

        function getCidade() {
            return $this->cidade;
        }

        function getBairro() {
            return $this->bairro;
        }

        function getRua() {
            return $this->rua;
        }

        function getNumero() {
            return $this->numero;
        }

        function setId_login($id_login) {
            $this->id_login = $id_login;
        }

        function setTelefone01($telefone01) {
            $this->telefone01 = $telefone01;
        }

        function setTelefone02($telefone02) {
            $this->telefone02 = $telefone02;
        }

        function setCep($cep) {
            $this->cep = $cep;
        }

        function setPais($pais) {
            $this->pais = $pais;
        }

        function setEstado($estado) {
            $this->estado = $estado;
        }

        function setCidade($cidade) {
            $this->cidade = $cidade;
        }

        function setBairro($bairro) {
            $this->bairro = $bairro;
        }

        function setRua($rua) {
            $this->rua = $rua;
        }

        function setNumero($numero) {
            $this->numero = $numero;
        }
    }