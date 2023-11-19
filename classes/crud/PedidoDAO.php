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
        public function cadastraPedido(string $email, Pedido $pedido): bool {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($email)) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "INSERT INTO pedido (valor_total, data, estado, cliente_email) VALUES (:valor_total, :data, :estado, :cliente_email);";
            $this->con->beginTransaction();
            $stmt = $this->getCon()->prepare($sql);

            $valorTotal = $pedido->getValorTotal();
            $data = $pedido->getData()->format('Y-m-d H:i:i');
            $estado = $pedido->getEstado();
            $cliente_email = $email;

            $stmt->bindParam(":valor_total", $valorTotal);
            $stmt->bindParam(":data", $data);
            $stmt->bindParam(":estado", $estado);
            $stmt->bindParam(":cliente_email", $cliente_email);

            $result = false;

            try {

                $stmt->execute();

            } catch (\Throwable $th) {
                
                $this->con->rollBack();
                print($th->getMessage());
                exit;
                
            }

            $sql = "SELECT id FROM pedido WHERE cliente_email = :email ORDER BY id DESC LIMIT 1;";
            $stmt = $this->getCon()->prepare($sql);
            
            $stmt->bindParam(":email", $cliente_email);

            try {

                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (\Throwable $th) {
                
                $this->con->rollBack();
                print($th->getMessage());
                exit;
                
            }

            $sql = "INSERT INTO item_pedido (nome_produto, quantidade, valor_unitario, pedido_id) VALUES (:nome_produto, :quantidade, :valor_unitario, :pedido_id);";
            $stmt = $this->getCon()->prepare($sql);

            $id = $res['id'];

            try {

                foreach ($pedido->getItensPedido() as $value) {
                            
                    $nome = $value->getNome();
                    $qtn = $value->getQtn();
                    $valor = $value->getValorUnitario();

                    $stmt->bindParam(":nome_produto", $nome);
                    $stmt->bindParam(":quantidade", $qtn);
                    $stmt->bindParam(":valor_unitario", $valor);
                    $stmt->bindParam(":pedido_id", $id);

                    $stmt->execute();

                }

                $this->con->commit();
                $result = true;

            } catch (\Throwable $th) {

                $this->con->rollBack();
                print($th->getMessage());
                exit;

            }

            return $result;

        }

        public function valida(string $email): bool {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($email)) return throw new InvalidArgumentException("Cliente não existe!");
            if (!$this->verificaSeExistePedio($email)) return throw new PDOException("Não há pedidos!");

            $this->con->beginTransaction();

            $sql = "UPDATE pedido SET estado = 1 WHERE cliente_email = :email";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);

            try {

                $stmt->execute();
                $this->con->commit();
                return true;

            } catch (\Throwable $th) {

                $this->con->rollBack();
                print($th->getMessage());
                exit;

            }

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