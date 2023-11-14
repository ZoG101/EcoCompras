<?php

    namespace models;

    /**
     * Classe que representa itens de um pedido do cliente no sistema.
     * Esta classe deve ser usada para a criação de um
     * item de pedido inividual novo ou para molde de recuperação de dados
     * de um item de pedido já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class ItensPedido {

        /**
         * Representa o nome do produto
         * @var string
         */
        private string $nomeProduto;
        /**
         * representa a quantidade do produto
         * @var int
         */
        private int $qtn;
        /**
         * Representa o valor unitário do produto
         * @var float
         */
        private float $valorUnitario;

        /**
         * Construtor padrão do item de pedido que já recebe todos os
         * itens para sua construção
         * @param string $nomeProduto
         * @param int $qtn
         * @param float $valorUnitario
         */
        public function __construct(string $nomeProduto, int $qtn, float $valorUnitario) {

            $this->nomeProduto = $nomeProduto;
            $this->qtn = $qtn;
            $this->valorUnitario = $valorUnitario;

        }

        /**
         * Retorna o nome do produto
         * @return string
         */
        public function getNome(): string {

            return $this->nomeProduto;

        }

        /**
         * Retorna a quantidade do produto
         * @return string
         */
        public function getQtn(): string {

            return $this->qtn;

        }

        /**
         * Retorna o valor unitário do produto
         * @return float
         */
        public function getValorUnitario(): float {

            return $this->valorUnitario;

        }

        /**
         * Retorna o valor total considerando a quantidade do produto
         * selecionado
         * @return float
         */
        public function getValorTotalProduto(): float {

            return $this->valorUnitario * $this->qtn;

        }

    }

?>