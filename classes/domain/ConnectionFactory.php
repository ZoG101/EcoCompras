<?php

    namespace domain;
    
    use PDO;
    use PDOException;

    /**
     * Classe reponsável por recuperar uma conexão com o 
     * banco de dados.
     * @author Davi Campolina Leite Morato
     * @version ${1:1.0.0}
     */
    class ConnectionFactory {

        /**
         * Função que retorna uma nova conxão através de um `PDO`
         * @return PDO
         * @throws PDOException
         */
        public static function getConexao(): PDO {

            try {

                return new PDO('mysql:host=localhost:3307;dbname=Eco_Compras;charset=utf8', 'root', 'root1234D');

            } catch (\Throwable $th) {

                throw new PDOException($th->getMessage());

            }

        }

    }

?>