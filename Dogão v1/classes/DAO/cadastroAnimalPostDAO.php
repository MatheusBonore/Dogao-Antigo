<?php
    class cadastroAnimalPostDAO{
        private $pdo;
        function __construct($Conexao) {
            $this->pdo =  $Conexao->getPdo();             
        }
        function cadastrarAnimal($dados_animal){
            try{
                $stmt = $this->pdo->prepare('INSERT INTO animal (id_login,nome_animal,raca_animal,idade_animal,pelagem_animal,cor_animal,tamanho_animal,descricao_animal,foto_animal) VALUES (:ID_LOGIN,:NOME_ANIMAL,:RACA_ANIMAL,:IDADE_ANIMAL,:PELAGEM_ANIMAL,:COR_ANIMAL,:TAMANHO_ANIMAL,:DESCRICAO_ANIMAL,:FOTO_ANIMAL)');
                $param = array(
                    ':ID_LOGIN'=>$dados_animal->getId_login(),
                    ':NOME_ANIMAL'=>$dados_animal->getNome_animal(),
                    ':RACA_ANIMAL'=>$dados_animal->getRaca_animal(),
                    ':IDADE_ANIMAL'=>$dados_animal->getIdade_animal(),
                    ':PELAGEM_ANIMAL'=>$dados_animal->getPelagem_animal(),
                    ':COR_ANIMAL'=>$dados_animal->getCor_animal(),
                    ':TAMANHO_ANIMAL'=>$dados_animal->getTamanho_animal(),
                    ':DESCRICAO_ANIMAL'=>$dados_animal->getDescricao_animal(),
                    ':FOTO_ANIMAL'=>$dados_animal->getFoto_animal()
                );

                

                $stmt->execute($param);
            } catch (PDOException $ex) {
                echo 'ERRO[cadastrarAnimal]: {'. $ex->getMessage() . '}';
            }
        }
        
        function cadastrarPost($dados_post){
            try{
                $stmt = $this->pdo->prepare('INSERT INTO post (id_login,id_animal,data_post,data_expira_post,titulo_post,categoria_post,local_post) VALUES (:ID_LOGIN,:ID_ANIMAL,:DATA_POST,:DATA_EXPIRA_POST,:TITULO_POST,:CATEGORIA_POST,:LOCAL_POST)');
                $param = array(
                    ':ID_LOGIN'=>$dados_post->getId_login(),
                    ':ID_ANIMAL'=>$dados_post->getId_animal(),
                    ':DATA_POST'=>$dados_post->getData_post(),
                    ':DATA_EXPIRA_POST'=>$dados_post->getData_expira_post(),
                    ':TITULO_POST'=>$dados_post->getTitulo_post(),
                    ':CATEGORIA_POST'=>$dados_post->getCategoria_post(),
                    ':LOCAL_POST'=>$dados_post->getLocal_post()
                );
                $stmt->execute($param);
            } catch (PDOException $ex) {
                echo 'ERRO[cadastrarPost]: {'. $ex->getMessage() . '}';
            }
        }
    }
?>