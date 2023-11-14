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

        public static function getConexao(): PDO {

            try {

                return new PDO('mysql:host=localhost:3307;dbname=Eco_Compras;charset=utf8', 'root', 'root12345D');

            } catch (\Throwable $th) {

                throw new PDOException($th->getMessage());

            }

        }

    }

?>