<?php

    require_once './classes/models/Cliente.php';
    require_once './classes/models/Endereco.php';
    require_once './classes/crud/ClienteDAO.php';

    use models\Endereco;
    use models\Cliente;
    use crud\ClienteDAO;

    $endereco = new Endereco('00000000', 'nowhere', 'nowhere', 'nowhere', 'nowhere', 'nowhere', 'nowhere');
    $cliente = new Cliente('ecompras2', '11111111111', 'eco@gmail.com', 'eco2023', '11111111111', $endereco);

    $clienteDAO = new ClienteDAO();
    $clienteDAO->cadastraCliente($cliente);

?>