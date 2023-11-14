<?php

    namespace crud;

    require_once 'classes\domain\ConnectionFactory.php';
    require_once 'classes\models\Cliente.php';

    use models\Cliente;
    use domain\ConnectionFactory;

    use models\Endereco;
    use PDO;

    use InvalidArgumentException;
    
    /**
     * Classe de acesso a um cliente no sistema.
     * Esta classe deve ser usada como objeto de acesso ao
     * cliente e recuperação de dados de clientes já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class ClienteDAO {

        /**
         * Variável que representa a conexão com o SGBD
         * através da classe PDO
         * @var PDO
         */
        private PDO $con;

        /**
         * Construtor da classe ClienteDAO que inicializa uma conexão PDO.
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
         * Busca um cliente no banco e o retorna como um objeto do tipo Cliente.
         * Caso não esxita, joga uma exceção.
         * @param string $email
         * @throws \InvalidArgumentException
         * @return Cliente
         */
        public function buscaCliente(string $email): Cliente {

            if (!$this->verificaSeExisteCliente($email)) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "SELECT * FROM cliente WHERE email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);
            $fetch = null;

            try {
                
                $stmt->execute();
                $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
                $endereco = new Endereco("N/D", "N/D", "N/D", "N/D", "N/D", "N/D", "N/D");
                $cliente = new Cliente($fetch["nome"], $fetch["cpf"], $fetch["email"], $fetch["telefone"], $fetch["senha"], $endereco);
                return $cliente;

            } catch (\Throwable $th) {
                
                print($th->getMessage());
                exit;
                
            }

        }

        /**
         * Método para cadastrar um cliente no SGBD.
         * Caso o clinete já exista, joga exceção.
         * @param Cliente $cliente
         * @throws \InvalidArgumentException
         * @return bool
         */
        public function cadastraCliente(Cliente $cliente): bool {

            if ($this->verificaSeExisteCliente($cliente->getEmail())) throw new InvalidArgumentException("Cliente já existe!");

            $sql = "INSERT INTO cliente (nome, cpf, email, senha, telefone) VALUES (:nome, :cpf, :email, :senha, :telefone);";
            $this->con->beginTransaction();
            $stmt = $this->getCon()->prepare($sql);

            $clienteNome = $cliente->getNome();
            $clienteCpf = $cliente->getCpf();
            $clienteEmail = $cliente->getEmail();
            $clienteSenha = $cliente->getSenha();
            $clienteTelefone = $cliente->getTelefone();

            $stmt->bindParam(":nome", $clienteNome);
            $stmt->bindParam(":cpf", $clienteCpf);
            $stmt->bindParam(":email", $clienteEmail);
            $stmt->bindParam(":senha", $clienteSenha);
            $stmt->bindParam(":telefone", $clienteTelefone);

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

        /**
         * Método que verifica a existencia de um cliente através do E-mail.
         * Retorn `true` se existe e `false` se não existe.
         * @param string $email
         * @return bool
         */
        public function verificaSeExisteCliente(string $email): bool {

            $sql = "SELECT * FROM cliente WHERE email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {

                return true;

            } else {

                return false;
                
            }

        }

    }

?>