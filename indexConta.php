<?php session_start(); ?>
<?php
    require_once 'classes\models\Pedido.php';
    require_once 'classes\crud\PedidoDAO.php';

    use models\Pedido;
    use crud\PedidoDAO;

    $cliente = $_SESSION['cliente'];
    $endereco = $_SESSION['endereco'];

    if (!isset($_SESSION['cliente'])) {

        echo "<script>window.location.replace('indexLogin.php');</script>";
    
    }
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
                <?php 
                    if ((isset($_SESSION['cliente'])) && ($_SESSION['cliente']['parceiro'] == 1)) {

                        echo '<li><a href="produtosCliente.php" onclick="markClicked(this)">MINHA LOJA</a></li>';
                    
                    } else if ((isset($_SESSION['cliente'])) && ($_SESSION['cliente']['parceiro'] == 0)) {

                        echo '<li><a href="tornarParceiro.php" onclick="markClicked(this)">SEJA PARCEIRO</a></li>';

                    }
                ?>
            </ul>
        </nav>
        <div class="nav-icon-container"></div>
        </div>
    </div>
    <div class="conta-container">
        <h2>Dados pessoais</h2>
        <p><label>Nome:</label> <?php echo $cliente['nome']; ?></p>
        <p><label>CPF:</label> <?php echo substr($cliente['cpf'], 0, 3).'.'.substr($cliente['cpf'], 3, 3).'.'.substr($cliente['cpf'], 6, 3).'-'.substr($cliente['cpf'], 9, 2); ?></p>
        <p><label>E-mail:</label> <?php echo $cliente['email']; ?></p>
        <p><label>Telefone:</label> <?php 
            if (strlen($cliente['telefone']) == 11){

               echo '('.substr($cliente['telefone'], 1, 2).')'.' '.substr($cliente['telefone'], 3, 4).'-'.substr($cliente['telefone'], 7);

            } else {

                echo '('.substr($cliente['telefone'], 1, 2).')'.' '.substr($cliente['telefone'], 3, 5).'-'.substr($cliente['telefone'], 8);

            } ?>
        </p>
        <p><label>Tipo:</label><?php if ($cliente['parceiro'] == 0) {

            echo ' '.'Sem parceria';

        } else {

            echo ' '.'Parceiro';
            echo '</p><p><label>Nome da lojinha:</label>' .' '. $cliente['nomeLojinha'];

        } ?></p>
        
        <h2>Endereço de entrega</h2>
        <p><label>CEP:</label> <?php echo substr($endereco['cep'], 0, 5).'-'.substr($endereco['cep'], 5, 3); ?></p>
        <p><?php echo $endereco['cidade']; ?> - <?php echo $endereco['estado']; ?></p>
        <p><?php echo $endereco['rua']; ?> Nº<?php echo $endereco['numero']; ?></p>
        <p><?php echo $endereco['bairro']; ?></p>
        <?php if ($endereco['complemento'] != 'N/D') echo '<p>'.$endereco['complemento'].'</p>'; ?>
        <?php
            $PDAO = new PedidoDAO();

            if ($PDAO->verificaSeExistePedio($cliente['email'])) {

                try {

                    $pedidos = $PDAO->buscaPedido($cliente['email']);

                } catch (\Throwable $th) {

                    print($th->getMessage());

                }

                echo"<h2>Pedidos</h2>";

                foreach ($pedidos as $value) {

                    echo "<table>
                    <thead class='"; 
                        if ($value->getEstado() == 0){
                            echo "PENDENTE";
                        } else {
                            echo "APROVADO";
                        }
                    echo "'>
                        <th colspan='2'><h3>".$value->getNumero()."</h3></th>
                        <th><h3>R$".$value->getValorTotal()."</h3></th>
                        <th><h3>".$value->getData()->format('d/m/Y H:i')."</h3></th>
                        <th><h3>";
                        if ($value->getEstado() == 0){
                            echo "PENDENTE";
                        } else {
                            echo "APROVADO";
                        }
                        echo "</h3></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan='2' class='th-corpo'>Itens</th>
                            <th colspan='2' class='th-corpo'>Quantidade</th>
                            <th colspan='2' class='th-corpo'>Valor unitário</th>
                        </tr>";

                        foreach ($value->getItensPedido() as $value2) {
                            
                            echo 
                            "<tr>
                                <td colspan='2'>".$value2->getNome()."</td>
                                <td colspan='2'>".$value2->getQtn()."</td>
                                <td colspan='2'>".$value2->getValorUnitario()."</td>
                            </tr>";

                        }
                        
                    echo "</tbody>
                </table>";
                    
                }

                $PDAO->valida($cliente['email']);
                
            }
        ?>
    </div>
    <footer class="green-background" style=" width: 100%; padding: 10px;">      
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