<?php

    namespace models;

    /**
     * Classe que representa um endereço de cliente no sistema.
     * Esta classe deve ser usada para a criação de um
     * endereço novo ou para molde de recuperação de dados
     * de endereços já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class Endereco {

        /**
         * Representa o CEP do cliente
         * @var string
         */
        private string $cep;
        /**
         * Representa a cidade do cliente
         * @var string
         */
        private string $cidade;
        /**
         * Representa o Estado do cliente
         * @var string
         */
        private string $estado;
        /**
         * Representa a rua do cliente
         * @var string
         */
        private string $rua;
        /**
         * Representa o número da casa do cliente
         * @var string
         */
        private string $numero;
        /**
         * Representa o bairro do cliente
         * @var string
         */
        private string $bairro;
        /**
         * Representa o complemento do endereço
         * @var string
         */
        private string $complemento;

        /**
         * Construtor da classe "Endereco" que já recebe por padrão
         * todos os dados necessários.
         * @param mixed $cep
         * @param mixed $cidade
         * @param mixed $estado
         * @param mixed $rua
         * @param mixed $numero
         * @param mixed $bairro
         * @param mixed $complemento
         */
        public function __construct($cep, $cidade, $estado, $rua, $numero, $bairro, $complemento) {

            $this->cep = $cep;
            $this->cidade = $cidade;
            $this->estado = $estado;
            $this->rua = $rua;
            $this->numero = $numero;
            $this->bairro = $bairro;
            $this->complemento = $complemento;

        }

        /**
         * Retorna o CEP do cliente
         * @return string
         */
        public function getCep(): string {
            return $this->cep;
        }

        /**
         * Retorna a cidade do cliente
         * @return string
         */
        public function getCidade(): string {

            return $this->cidade;

        }

        /**
         * Retorna o Estado do cliente
         * @return string
         */
        public function getEstado(): string {

            return $this->estado;

        }

        /**
         * Retorna a rua do cliente
         * @return string
         */
        public function getRua(): string {

            return $this->rua;

        }

        /**
         * Retorna o número da residência do cliente
         * @return string
         */
        public function getNumero(): string {

            return $this->numero;

        }

        /**
         * Retorna o bairro do cliente
         * @return string
         */
        public function getBairro(): string {

            return $this->bairro;

        }

        /**
         * retorna o complemento do endereço do cliente
         * @return string
         */
        public function getComplemento(): string {

            return $this->complemento;

        }

    }

?>