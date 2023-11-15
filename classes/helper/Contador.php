<?php

    namespace helper;

    /**
     * Classe reponsável por auxiliar a aplicação na contagem de itens.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class Contador{

        /**
         * Variável contador
         * @var int
         */
        private int $cont = 0;

        /**
         * Função reponsável por adicionar mais 1 ao contador
         * @return void
         */
        public function adicionar(): void {

            $this->cont++;

        }

        /**
         * Função que retorna o valor contido no contador do obj.
         * @return int
         */
        public function getCont(): int {

            return $this->cont;

        }

        /**
         * Função para definir um valor específico para `cont`.
         * @param int $cont
         * @return void
         */
        public function setCont(int $cont): void {

            $this->cont = $cont;

        }

    }

?>