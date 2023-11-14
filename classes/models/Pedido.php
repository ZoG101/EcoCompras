<?php

    namespace models;

    require_once 'classes\models\ItensPedido.php';

    use models\ItensPedido;

    use DateTime;

    /**
     * Classe que representa um pedido do cliente no sistema.
     * Esta classe deve ser usada para a criação de um
     * pedido novo ou para molde de recuperação de dados
     * de pedidos já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class Pedido {

        /**
         * Representa o número do pedido
         * @var int
         */
        private int $numero;
        /**
         * Representa o valor total do pedido
         * @var float
         */
        private float $valorTotal;
        /**
         * Representa a data de realização do pedido
         * @var DateTime
         */
        private DateTime $data;
        /**
         * Representa o estado do pedido
         * @var string
         */
        private string $estado;
        /**
         * Representa os itens do pedido
         * @var array
         */
        private $itensPedido = [];

        /**
         * Construtor da classe "Pedido" que já recebe todos os parâmetros 
         * para sua criação por padrão.
         * @param int $numero
         * @param float $valorTotal
         * @param DateTime $date
         * @param string $estado
         * @param array $itensPedido
         */
        public function __construct(int $numero, float $valorTotal, DateTime $date, string $estado, array $itensPedido) {

            $this->numero = $numero;
            $this->valorTotal = $valorTotal;
            $this->date = $date;
            $this->estado = $estado;
            $this->itensPedido = $itensPedido;

        }

        /**
         * Retorna o número do pedido
         * @return int
         */
        public function getNumero(): int {

            return $this->numero;

        }

        /**
         * Retorna o valor total do pedido
         * @return float
         */
        public function getValorTotal(): float {

            return $this->valorTotal;

        }

        /**
         * Retorn a data do pedido
         * @return DateTime
         */
        public function getDate(): DateTime {

            return $this->data;

        }

        /**
         * Retorna o estado atual do pedido
         * @return string
         */
        public function getEstado(): string {

            return $this->estado;

        }

        /**
         * Retorna um array com os itens deste pedido
         * @return array
         */
        public function getItensPedido(): array {

            return $this->itensPedido;

        }

        /**
         * Adiciona um novo item de pedido ao pedido
         * @param ItensPedido $itemPedido
         * @return void
         */
        public function addItensPedido(ItensPedido $itemPedido): void {

            $this->itensPedido[] = $itemPedido;

        }

    }

?>