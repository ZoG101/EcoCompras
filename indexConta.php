<?php session_start(); ?>
<?php
    require_once 'classes\models\Cliente.php';
    require_once 'classes\models\Endereco.php';
    require_once 'classes\crud\ClienteDAO.php';
    require_once 'classes\crud\EnderecoDAO.php';

    use models\Cliente;
    use models\Endereco;

    $cliente = $_SESSION['cliente'];
    $endereco = $_SESSION['endereco'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/global.css" />
    <title>Minha Conta</title>
</head>
<body>
    <div class="navBar">
        <div class="">
        <h1 class="logo">Eco<span>Compras</span></h1>
        <nav>
            <ul>
            <li><a href="index.php" onclick="markClicked(this)">HOME</a></li>
            <li><a href="indexProdutos.php" onclick="markClicked(this)">PRODUTOS</a></li>
            <li><a href="indexLogin.php" onclick="markClicked(this)">MINHA CONTA</a></li>
            <li><a href="indexCarrinho.php" onclick="markClicked(this)">CARRINHO</a></li>
            </ul>
        </nav>
        <div class="nav-icon-container"></div>
        </div>
    </div>
    <div class="conta-container">
        <h2>Dados pessoais</h2>
        <p><label>Nome:</label></p>
        <p><label>CPF:</label></p>
        <p><label>E-mail:</label><p></p>
        <p><label>Telefone:</label></p>
        
        <h2>Endereço de entrega</h2>
        <p><label>CEP:</label></p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>

        <h2>Pedidos</h2>
        <table>
            <thead>
                <th><h2>Pedido n</h2></th>
                <th><h2>x</h2></th>
                <th><h2>x</h2></th>
                <th><h2>x</h2></th>
            </thead>
            <tbody>
                <tr>
                    <td>Itens</td>
                    <td>Quantidade</td>
                    <td>Valor unitário</td>
                </tr>
            </tbody>
        </table>
    </div>
    <footer class="green-background" style="position: fixed; bottom: 0; width: 100%; padding: 10px;">      
    <div class="page-inner-content footer-content">
          <div class="logo-footer">
              <h1 class="logo">Eco<span>Compras</span></h1>
              <p>100% de produtos sustentáveis!</p>
              <p>copyright 2023 ©</p>
          </div>
      </div>
  </footer>
</body>
</html>