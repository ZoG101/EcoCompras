<?php

    namespace models;

    require_once 'classes\models\Endereco.php';

    use models\Endereco;

    /**
     * Classe que representa um cliente no sistema.
     * Esta classe deve ser usada para a criação de um
     * cliente novo ou para molde de recuperação de dados
     * de clientes já persistidos.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class Cliente {

        /**
         * Nome do cliente
         * @var string
         */
        private string $nome;
        /**
         * CPF do cliente
         * @var string
         */
        private string $cpf;
        /**
         * E-mail do cliente
         * @var string
         */
        private string $email;
        /**
         * Telefone do cliente
         * @var string
         */
        private string $telefone;
        /**
         * Senha do cliente
         * @var string
         */
        private string $senha;

        /**
         * Endereço do cliente
         * @var Endereco
         */
        private Endereco $endereco;

        /**
         * Construtor do cliente que já recebe por padrão
         * todos os parâmetros requisitados para representá-lo.
         * @param string $nome
         * @param string $cpf
         * @param string $email
         * @param string $telefone
         */
        public function __construct (string $nome, string $cpf, string $email, string $telefone, string $senha, Endereco $endereco) {

            $this->nome = $nome;
            $this->cpf = $cpf;
            $this->email = $email;
            $this->telefone = $telefone;
            $this->senha = $senha;
            $this->senha = $this->hashPassword($senha);
            $this->endereco = $endereco;

        }

        /**
         * Retorna o nome do cliente
         * @return string
         */
        public function getNome(): string {

            return $this->nome;

        }

        /**
         * Retorna o CPF do cliente
         * @return string
         */
        public function getCpf(): string {

            return $this->cpf;

        }

        /**
         * Retirna o E-mail do cliente
         * @return string
         */
        public function getEmail(): string {

            return $this->email;

        }

        /**
         * Retorna o telefone do cliente
         * @return string
         */
        public function getTelefone(): string {

            return $this->telefone;

        }

        /**
         * Retorna a senha do cliente
         * @return string
         */
        public function getSenha(): string {

            return $this->senha;

        }

        /**
         * Retorna um objeto de classe que representa o
         * endereço do cliente
         * @return Endereco
         */
        public function getEndereco(): Endereco {

            return $this->endereco;

        }

        public function hashPassword(string $password): string {

            $options = ['cost' => 12,];
            return password_hash($this->senha, PASSWORD_BCRYPT, $options);

        }

    }

?>