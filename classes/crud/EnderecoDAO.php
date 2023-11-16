<?php

    namespace crud;

    require_once 'classes\domain\ConnectionFactory.php';
    require_once 'classes\models\Endereco.php';
    require_once 'classes\models\Cliente.php';

    use domain\ConnectionFactory;
    use models\Endereco;
    use models\Cliente;

    use PDO;

    use InvalidArgumentException;

    /**
     * Classe de acesso a um endereço de cliente no sistema.
     * Esta classe deve ser usada como objeto de acesso ao
     * endereço e recuperação de dados de endereços já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class EnderecoDAO {

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
         * Método que busca um endereço no banco de dados
         * @param \models\Cliente $cliente
         * @return \models\Endereco
         */
        public function buscaEndereco(Cliente $cliente): Endereco {

            if (!$this->verificaSeExisteEndereco($cliente->getEmail())) return throw new InvalidArgumentException("Endereco não existe!");

            $sql = "SELECT endereco.cep, endereco.cidade, endereco.estado, endereco.rua, endereco.numero, endereco.bairro, endereco.complemento FROM cliente JOIN endereco ON endereco.cliente_email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $email = $cliente->getEmail();
            $stmt->bindParam(":email", $email);

            try {

                $stmt->execute();
                $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
                $endereco = new Endereco($fetch["cep"], $fetch["cidade"], $fetch["estado"], $fetch["rua"], $fetch["numero"], $fetch["bairro"], $fetch["complemento"]);
                return $endereco;

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

        }

        /**
         * Método que cadastra um endereço no banco de dados
         * @param \models\Cliente $cliente
         * @param \models\Endereco $endereco
         * @return bool
         */
        public function cadastraEndereco(Cliente $cliente, Endereco $endereco): bool {

            if ($this->verificaSeExisteEndereco($cliente->getEmail())) return throw new InvalidArgumentException("Endereco já existe!");

            $sql = "INSERT INTO endereco (cliente_email, cep, cidade, estado, rua, numero, bairro, complemento) VALUES (:email, :cep, :cidade, :estado, :rua, :numero, :bairro, :complemento);";
            $this->con->beginTransaction();
            $stmt = $this->getCon()->prepare($sql);

            $email = $cliente->getEmail();
            $cep = $endereco->getCep();
            $cidade = $endereco->getCidade();
            $estado = $endereco->getEstado();
            $rua = $endereco->getRua();
            $numero = $endereco->getNumero();
            $bairro = $endereco->getBairro();
            $complemento = $endereco->getComplemento();

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

        /**
         * Método que verifica se um endereço já existe na base de dados
         * Retorna `true` caso exista e `false` caso não exista
         * @param string $email
         * @return bool
         */
        public function verificaSeExisteEndereco(string $email): bool {

            $sql = "SELECT COUNT(*) FROM cliente JOIN endereco ON endereco.cliente_email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;

        }

    }

?>