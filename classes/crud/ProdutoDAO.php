<?php

    namespace crud;

    require_once 'classes\domain\ConnectionFactory.php';
    require_once 'classes\models\Cliente.php';
    require_once 'classes\models\Produto.php';
    require_once 'classes\crud\ClienteDAO.php';

    use models\Cliente;
    use models\Produto;
    use crud\ClienteDAO;
    use domain\ConnectionFactory;

    use PDO;

    use InvalidArgumentException;

    /**
     * Classe de acesso a um produto no sistema.
     * Esta classe deve ser usada como objeto de acesso ao
     * produto e recuperação de dados de produtos já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class ProdutoDAO {

         /**
         * Variável que representa a conexão com o SGBD
         * através da classe PDO
         * @var PDO
         */
        private PDO $con;

        /**
         * Construtor da classe ProdutoDAO que inicializa uma conexão PDO.
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
         * Método para cadastrar um produto no SGBD.
         * Caso o produto já exista, joga exceção.
         * @param Produto $cliente
         * @return bool
         */
        public function cadastraProduto(Produto $produto): bool {

            $sql = "INSERT INTO `PRODUTO_PARCEIRO` (nome, descricao, img, preco, tamanhos, parceiro_email) VALUES (:nome, :descricao, :img, :preco, :tamanhos, :parceiro_email);";
            $this->con->beginTransaction();
            $stmt = $this->getCon()->prepare($sql);

            $nome = $produto->getNome();
            $descricao = $produto->getDescricao();
            $img = $produto->getImagem();
            $preco = $produto->getPreco();
            $tamanhos = $produto->getTamanhos();
            $parceiroEmail = $produto->getCliente()->getEmail();

            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":preco", $preco);
            $stmt->bindParam(":tamanhos", $tamanhos);
            $stmt->bindParam(":parceiro_email", $parceiroEmail);

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
         * Método que verifica a existência de um produto relacionado com cliente.
         * Retorn `true` se existe e `false` se não existe.
         * @param Cliente $cliente
         * @throws InvalidArgumentException
         * @return bool
         */
        public function verificaSeExisteProduto(Cliente $cliente): bool {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($cliente->getEmail())) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "SELECT * FROM `PRODUTO_PARCEIRO` WHERE parceiro_email = :email limit 1;";
            $stmt = $this->getCon()->prepare($sql);
            $email = $cliente->getEmail();
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {

                return true;

            } else {

                return false;
                
            }

        }

        /**
         * Método que verifica a existência de um produto parceiro.
         * Retorn `true` se existe e `false` se não existe.
         * @return bool
         */
        public function verificaSeExisteAlgumProduto(): bool {

            $sql = "SELECT nome FROM `PRODUTO_PARCEIRO` limit 1;";
            $stmt = $this->getCon()->prepare($sql);

            $result = array();

            try {

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (\Throwable $th) {
                echo($th->getMessage());
                exit;
            }

            if (count($result) > 0) {

                return true;

            } else {

                return false;
                
            }

        }

        /**
         * Método que busca os produtos de um cliente no banco de dados
         * @param Cliente $cliente
         * @return array
         * @throws InvalidArgumentException
         */
        public function buscaProdutos(Cliente $cliente): array {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($cliente->getEmail())) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "SELECT * FROM `PRODUTO_PARCEIRO` WHERE parceiro_email = :email;";
            $stmt = $this->getCon()->prepare($sql);
            $email = $cliente->getEmail();
            $stmt->bindParam(":email", $email);

            $fetchProdutos = null;

            try {

                $stmt->execute();
                $fetchProdutos = $stmt->fetchAll();

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            $produtos = array();

            foreach ($fetchProdutos as $key => $value) {
                
                $produtos [$key] = new Produto($fetchProdutos[$key]['nome'], $fetchProdutos[$key]['preco'], $fetchProdutos[$key]['descricao'], $fetchProdutos[$key]['img'], $fetchProdutos[$key]['tamanhos'], $cliente);
                $produtos [$key] -> setId($fetchProdutos[$key]['id']);

            }

            return $produtos;

        }

        /**
         * Método que busca os produtos no banco de dados
         * @param Cliente $cliente
         * @return array
         * @throws InvalidArgumentException
         */
        public function puxaProdutos(Cliente $cliente): array {

            $sql = "SELECT * FROM `PRODUTO_PARCEIRO`";
            $stmt = $this->getCon()->prepare($sql);

            $fetchProdutos = null;

            try {

                $stmt->execute();
                $fetchProdutos = $stmt->fetchAll();

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            $produtos = array();

            foreach ($fetchProdutos as $key => $value) {
                
                $produtos [$key] = new Produto($fetchProdutos[$key]['nome'], $fetchProdutos[$key]['preco'], $fetchProdutos[$key]['descricao'], $fetchProdutos[$key]['img'], $fetchProdutos[$key]['tamanhos'], $cliente);
                $produtos [$key] -> setId($fetchProdutos[$key]['id']);

                try {

                    $sql = "SELECT nome_lojinha FROM `CLIENTE` WHERE email = :email;";
                    $stmt = $this->getCon()->prepare($sql);
                    $email = $fetchProdutos[$key]['parceiro_email'];
                    $produtos [$key] -> setEmail($email);
                    $stmt->bindParam(":email", $email);
                    $stmt->execute();
                    $fetchNomeLojinha = $stmt->fetchAll();
                    $produtos [$key] -> setNomeLojinha($fetchNomeLojinha[0]['nome_lojinha']);

                } catch (\Throwable $th) {

                    print($th->getMessage());
                    exit;

                }

            }

            return $produtos;

        }

        /**
         * Método que atualiza os dados de um produto no banco de dados
         * @param string $id
         * @param string $email
         * @param string $diretorioUser
         * @return bool
         * @throws InvalidArgumentException
        */
        public function deletaProduto(string $id, string $email, string $diretorioUser): bool {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($email)) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "SELECT parceiro_email FROM `PRODUTO_PARCEIRO` WHERE id = :id;";

            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":id", $id);

            $result = array();

            try {

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            if ($result[0]['parceiro_email'] != $email) return throw new InvalidArgumentException("Produto não pertence a esse cliente!");

            $this->con->beginTransaction();

            if (!is_dir($diretorioUser)) {

                $this->con->rollBack();
                return throw new InvalidArgumentException("Diretório não existe!");

            }

            $sql = "SELECT img FROM `PRODUTO_PARCEIRO` WHERE id = :id;";

            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":id", $id);

            $img = array();

            try {

                $stmt->execute();
                $img = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            $file = $diretorioUser . "/" . $img[0]['img'];

            if (file_exists($file)) {
    
                try {

                    unlink($file);

                } catch (\Throwable $th) {

                    $this->con->rollBack();
                    print($th->getMessage());
                    exit;

                }

            }

            $sql = "DELETE FROM `PRODUTO_PARCEIRO` WHERE id = :id;";
            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":id", $id);

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
         * Método que atualiza os dados de um produto no banco de dados
         * @param string $id
         * @param string $email
         * @param Produto $produto
         * @param string $diretorioUser
         * @return bool
         * @throws InvalidArgumentException
         */
        public function atualizaProduto(string $id, string $email, Produto $produto, string $diretorioUser): bool {

            $CDAO = new ClienteDAO();

            if (!$CDAO->verificaSeExisteCliente($email)) return throw new InvalidArgumentException("Cliente não existe!");

            $sql = "SELECT parceiro_email FROM `PRODUTO_PARCEIRO` WHERE id = :id;";

            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":id", $id);

            $result = array();

            try {

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            if ($result[0]['parceiro_email'] != $email) return throw new InvalidArgumentException("Produto não pertence a esse cliente!");

            $this->con->beginTransaction();

            if (!is_dir($diretorioUser)) {

                $this->con->rollBack();
                return throw new InvalidArgumentException("Diretório não existe!");

            }

            $sql = "SELECT img FROM `PRODUTO_PARCEIRO` WHERE id = :id;";

            $stmt = $this->getCon()->prepare($sql);
            $stmt->bindParam(":id", $id);

            $img = array();

            try {

                $stmt->execute();
                $img = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (\Throwable $th) {

                print($th->getMessage());
                exit;

            }

            $file = $diretorioUser . "/" . $img[0]['img'];

            if (file_exists($file)) {
    
                try {

                    unlink($file);

                } catch (\Throwable $th) {

                    $this->con->rollBack();
                    print($th->getMessage());
                    exit;

                }

            }

            $sql = "UPDATE `PRODUTO_PARCEIRO` SET nome = :nome, descricao = :descricao, img = :img, preco = :preco, tamanhos = :tamanhos  WHERE id = :id;";
            $stmt = $this->getCon()->prepare($sql);

            $nome = $produto->getNome();
            $descricao = $produto->getDescricao();
            $img = $produto->getImagem();
            $preco = $produto->getPreco();
            $tamanhos = $produto->getTamanhos();
            $parceiroEmail = $produto->getCliente()->getEmail();

            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":preco", $preco);
            $stmt->bindParam(":tamanhos", $tamanhos);
            $stmt->bindParam(":id", $id);

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

    }

?>