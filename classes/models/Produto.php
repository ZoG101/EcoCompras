<?php

    namespace models;

    /**
     * Classe que representa um produto no sistema.
     * Esta classe deve ser usada para a criação de um
     * produto novo ou para molde de recuperação de dados
     * de produtos já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class Produto {
        
        /**
         * ID do produto no banco de dados
         * @var int
         */
        private int $id;
        /**
         * Nome do produto
         * @var string
         */
        private string $nome;
        /**
         * Preço do produto
         * @var string
         */
        private string $preco;
        /**
         * Descrição do produto
         * @var string
         */
        private string $descricao;
        /**
         * Nome da imagem dentro da pasta
         * @var string
         */
        private string $imagem;
        /**
         * Tamanhos disponíveis do produto
         * @var string
         * @example `P - M - G`
         */
        private string $tamanhos;
        /**
         * Cliente que cadastrou o produto
         * @var string
         */
        private Cliente $cliente;
        /**
         * Nome da lojinha que postou o produto.
         * @var string
         */
        private string $nomeLojinha;
        /**
         * Email da loja
         * @var string
         */
        private string $emailLoja;

        /**
         * Construtor de Produto que já recebe por padrão
         * todos os parâmetros requisitados para representá-lo.
         * @param string $nome Nome do produto;
         * @param string $preco Preço do produto;
         * @param string $descricao Descrição do produto;
         * @param string $imagem Nome da imagem dentro da pasta;
         * @param string $tamanhos Tamanhos disponíveis do produto;
         * @param Cliente $cliente Cliente que cadastrou o produto;
         */
        public function __construct (string $nome, string $preco, string $descricao, string $imagem, string $tamanhos, Cliente $cliente) {

            $this->nome = $nome;
            $this->preco = $preco;
            $this->descricao = $descricao;
            $this->imagem = $imagem;
            $this->tamanhos = $tamanhos;
            $this->cliente = $cliente;

        }

        /**
         * Define o ID recebido pelo SGBD
         * @return void
         * @param int $id ID do produto no banco de dados
         */
        public function setId (int $id): void {
            $this->id = $id;
        }

        /**
         * Define o nome da lojinha dona do produto.
         * @return void
         * @param string $nomeLojinha Nome da lojinha do produto
         */
        public function setNomeLojinha (string $nomeLojinha): void {
            $this->nomeLojinha = $nomeLojinha;
        }

        /**
         * Define o email da lojinha dona do produto.
         * @return void
         * @param string $email Email da lojinha do produto
         */
        public function setEmail (string $email): void {
            $this->emailLoja = $email;
        }

        /**
         * Retorna o email da lojinha dona do produto.
         * @return string
         */
        public function getEmail (): string {
            return $this->emailLoja;
        }

        /**
         * Retorna o nome da lojinha dona do produto.
         * @return string
         */
        public function getNomeLojinha (): string {
            return $this->nomeLojinha;
        }

        /**
         * Retorna o id do produto
         * @return int
         */
        public function getId (): int {
            return $this->id;
        }

        /**
         * Retorna o nome do produto
         * @return string
         */
        public function getNome (): string {
            return $this->nome;
        }

        /**
         * Retorna o preço do produto
         * @return string
         */
        public function getPreco (): string  {
            return $this->preco;
        }

        /**
         * Retorna o descricao do produto
         * @return string
         */
        public function getDescricao (): string  {
            return $this->descricao;
        }

        /**
         * Retorna o nome da imagem do produto
         * @return string
         */
        public function getImagem (): string  {
            return $this->imagem;
        }

        /**
         * Retorna os tamanhos disponíveis do produto
         * @return string
         * @example `P - M - G`
         */
        public function getTamanhos (): string  {
            return $this->tamanhos;
        }

        /**
         * Retorna o cliente que cadastrou o produto
         * @return Cliente
         */
        public function getCliente (): Cliente  {
            return $this->cliente;
        }

    }
    
?>