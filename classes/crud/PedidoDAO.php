<?php

    namespace crud;

    require_once 'classes\domain\ConnectionFactory.php';
    require_once 'classes\models\Cliente.php';
    require_once 'classes\crud\ClienteDAO.php';
    require_once 'classes\models\Pedido.php';
    require_once 'classes\models\ItensPedido.php';

    use domain\ConnectionFactory;
    use models\Cliente;
    use crud\ClienteDAO;
    use models\Pedido;
    use models\ItensPedido;

    use PDO;
    use PDOException;

    use DateTime;

    use InvalidArgumentException;

    /**
     * Classe de acesso a um pedido de cliente no sistema.
     * Esta classe deve ser usada como objeto de acesso aos
     * pedidos e recuperação de dados de pedidos já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class PedidoDAO {

        /**
         * Variável que representa a conexão com o SGBD
         * através da classe PDO
         * @var PDO
         */
        private PDO $con;

        /**
         * Construtor da classe EnderecoDAO que inicializa uma conexão PDO.
         */
        public function __construct() {

            $this->con = ConnectionFactory::getConexao();

        }

        /**
         * Método que retorna a instância inicializada de um PDO
         * @return PDO
         */
        private function getCon(): PDO {

            return $this->con;

        }

        /**
         * Método que busca os pedidos e seus itens no banco de dados
         * @param string $email
         * @return array
         * @throws InvalidArgumentException
         * @throws PDOException
         */
        public function buscaPedido(string $email): array {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($email)) return throw new InvalidArgumentException("Cliente não existe!");
            if (!$this->verificaSeExistePedio($email)) return throw new PDOException("Não há pedidos!");

            $sql = "SELECT * FROM PEDIDO WHERE PEDIDO.cliente_email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);

            try {

                $stmt->execute();
                $fetchPedidos = $stmt->fetchAll();

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            $sql = "SELECT PEDIDO.id, ITEM_PEDIDO.nome_produto, ITEM_PEDIDO.quantidade, ITEM_PEDIDO.valor_unitario FROM PEDIDO JOIN ITEM_PEDIDO ON PEDIDO.id = ITEM_PEDIDO.pedido_id AND PEDIDO.cliente_email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);

            try {

                $stmt->execute();
                $fetchItensPedido = $stmt->fetchAll();

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            foreach ($fetchPedidos as $key => $value) {
                
                $pedidos [$key] = new Pedido($fetchPedidos[$key]["id"], $fetchPedidos[$key]["valor_total"], new DateTime($fetchPedidos[$key]["data"]), $fetchPedidos[$key]["estado"]);

                foreach ($fetchItensPedido as $key2 => $value2) {

                    if ($pedidos[$key]->getNumero() == $fetchItensPedido[$key2]["id"]) $pedidos[$key]->addItensPedido(new ItensPedido($fetchItensPedido[$key2]["nome_produto"], $fetchItensPedido[$key2]["quantidade"], $fetchItensPedido[$key2]["valor_unitario"]));


                }

            }

            return $pedidos;

        }

        /**
         * Método que cadastra um pedido no banco de dados
         * @param \models\Cliente $cliente
         * @param \models\Pedido $endereco
         * @return bool
         */
        public function cadastraPedido(Cliente $cliente, Pedido $pedido): bool {

            //implementação real pendente...

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($cliente->getEmail())) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "INSERT INTO endereco (cliente_email, cep, cidade, estado, rua, numero, bairro, complemento) VALUES (:email, :cep, :cidade, :estado, :rua, :numero, :bairro, :complemento);";
            $this->con->beginTransaction();
            $stmt = $this->getCon()->prepare($sql);

            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":cep", $cep);
            $stmt->bindParam(":cidade", $cidade);
            $stmt->bindParam(":estado", $estado);
            $stmt->bindParam(":rua", $rua);
            $stmt->bindParam(":numero", $numero);
            $stmt->bindParam(":bairro", $bairro);
            $stmt->bindParam(":complemento", $complemento);

            $result = false;

            try {

                $result = $stmt->execute();
                $this->con->commit();

            } catch (\Throwable $th) {
                
                $this->con->rollBack();
                print($th->getMessage());
                exit;
                
            }

            return $result;

        }

        public function verificaSeExistePedio(string $email): bool {

            $sql = "SELECT COUNT(*) FROM PEDIDO WHERE PEDIDO.cliente_email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;

        }

    }

?>