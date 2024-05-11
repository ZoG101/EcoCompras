<?php session_start(); ?>
<?php
  require_once 'classes\crud\PedidoDAO.php';
  require_once 'classes\models\Pedido.php';
  require_once 'classes\models\ItensPedido.php';

  use crud\PedidoDAO;
  use models\Pedido;
  use models\ItensPedido;

  if (!isset($_SESSION['cliente'])) {

    echo "<script>window.location.replace('indexLogin.php');</script>";

  }

  $cliente = $_SESSION['cliente'];
  $endereco = $_SESSION['endereco'];

  if (isset($_SESSION['produtos'])) {

    $carrinho = $_SESSION['produtos'];
    $cont = 0;

  }

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrinho</title>
    <link rel="stylesheet" href="/styles/global.css" />
    <link rel="stylesheet" href="styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
      jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
      jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });
    });
    </script>
  </head>
  <body>
    <div class="navBar">
      <div>
        <h1 class="logo">Eco<span>Compras</span></h1>
        <nav>
          <ul>
            <li>
              <a href="index.php" onclick="markClicked(this)">HOME</a>
            </li>
            <li>
              <a href="indexProdutos.php" onclick="markClicked(this)"
                >PRODUTOS</a
              >
            </li>
            <li>
              <a href="indexLogin.php" onclick="markClicked(this)"
                >MINHA CONTA</a
              >
            </li>
            <li>
              <a href="indexCarrinho.php" onclick="markClicked(this)"
                >CARRINHO</a
              >
            </li>
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
    <div <?php
    
      if (isset($_SESSION['produtos'])) {
        if (sizeof($_SESSION['produtos']) > 0) {

          echo "class='nota-fiscal'";

        } else {

          echo "class='nota-fiscal-sem-produto '";

        }

      } else {

        echo "class='nota-fiscal-sem-produto '";

      }

    ?>>
      <h3>Sua compra!</h3>
      <p>Obrigado por comprar conosco!</p>
      <p class="small-text">Entrega grátis, receba em até 10 dias úteis.</p>
      <p>Nome do Cliente: <?php echo $cliente['nome']; ?></p>
      <p>Email: <?php echo $cliente['email']; ?></p>
      <p>Telefone: <?php 
            if (strlen($cliente['telefone']) == 11){

               echo '('.substr($cliente['telefone'], 1, 2).')'.' '.substr($cliente['telefone'], 3, 4).'-'.substr($cliente['telefone'], 7);

            } else {

                echo '('.substr($cliente['telefone'], 1, 2).')'.' '.substr($cliente['telefone'], 3, 5).'-'.substr($cliente['telefone'], 8);

            } ?></p>
      <!-- Informações de Endereço -->
      <h4 class="endereco-fim-titulo">Endereço de Entrega</h4>
      <p>CEP: <?php echo substr($endereco['cep'], 0, 5).'-'.substr($endereco['cep'], 5, 3); ?></p>
      <p>Cidade: <?php echo $endereco['cidade']; ?></p>
      <p>Estado: <?php echo $endereco['estado']; ?></p>
      <p>Rua: <?php echo $endereco['rua']; ?> Nº<?php echo $endereco['numero']; ?></p>
      <p>Bairro: <?php echo $endereco['bairro']; ?></p>
      <?php
        if (isset($_SESSION['produtos'])) {
          if (sizeof($_SESSION['produtos']) > 0) {

            echo "<h3 class='carrinho-titulo'>Carrinho:</h3>
            <form action='' method='POST'>
              <table>
                <thead>
                    <tr>
                      <th class='th-corpo'>Itens</th>
                      <th class='th-corpo'>Valor unitário</th>
                      <th class='th-corpo'>Quantidade</th>
                    </tr>
                </thead>
                <tbody>";

          } else {

            echo "<h3 class='carrinho-titulo'>Ainda não há nada no carrinho...</h3>";
  
          }

        } else {

          echo "<h3 class='carrinho-titulo'>Ainda não há nada no carrinho...</h3>";

        }
      ?>
      <?php
        if (isset($_SESSION['produtos'])) {
          if (sizeof($_SESSION['produtos']) > 0) {
            foreach ($carrinho as $key => $value) {
            
              echo 
              "<tr class='produto-".str_replace(" ", "", $value['nome'])."'>
                <form action='' method='POST'>
                  <td><p class='nome'>".$value['nome']."<input name='nome' type='text' value='".$value['nome']."' hidden></p></td>
                  <td>"."R$ ".$value['preco']."<input name='preco' type='text' value='".$value['preco']."' hidden></td>
                  <td>
                  <input name='qtn' class='qtn' type='number' min='1' max='9' step='1' value='".$value['quantidade']."'>
                  <input name='atualiza' type='text' value='".$value['nome']."' hidden>
                  <button type='submit' class='excluir'><img src='imagens-pti/trashIcon.png' alt=''></button>
                  </td>
                </form>
              </tr>";

          }

          

            echo "</tbody>
            </table>";

          }
        }
      ?>
      <?php
        if (isset($_POST['atualiza'])) {

          $controle = false;
          $novo = [];

          foreach ($carrinho as $key => $value) {

            if ($value['nome'] == $_POST['atualiza']) {

              $controle = true;
              continue;

            }

            $chave = $key;

            if ($controle) $chave--;

            $novo[$chave] = [
              'nome' => $value['nome'],
              'preco' => $value['preco'],
              'quantidade' => $value['quantidade'],
            ];

            echo $novo[$chave]['nome'];

          }

          $_SESSION['produtos'] = $novo;
          $_POST = array();
          echo "<script>window.location.replace('indexCarrinho.php');</script>";

        }
      ?>
      <?php
        if (isset($_SESSION['produtos'])) {
          if (sizeof($_SESSION['produtos']) > 0) {

            echo "<h4>Valor Total:</h4>";

            echo "<p class='total'>";

            $total = 0.0;

            foreach ($carrinho as $key => $value) {
              
              $total += $value['preco'] * $value['quantidade'];

            }

            echo "R$ ".$total;

            echo "</p>";

            echo "</form>
            <form action='' method='POST'>";

            foreach ($carrinho as $key => $value) {
            
              echo 
                "<input name='nomes[]' type='text' value='".$value['nome']."' hidden>
                <input name='precos[]' type='text' value='".$value['preco']."' hidden>
                <input name='qtnd[]' class='qtn' type='number' min='1' max='9' step='1' value='".$value['quantidade']."' hidden>";
            }

            echo "<input name='enviar' type='text' hidden>
              <div class='btn-finalizar-box'>
                <button class='btn-finalizar' type='submit'>Finalizar</button>
              </div>
              </form>";

          }
        }
      ?>
      <?php
        if (isset($_POST['enviar'])) {

          $nomes = $_POST['nomes'];
          $precos = $_POST['precos'];
          $qtn = $_POST['qtnd'];
          $valorTotal = 0.0;

          try {

            $PDAO = new PedidoDAO();
            $pedido = new Pedido('', 0.0, new DateTime(Date('Y-m-d H:i:i')), '0');

            foreach ($nomes as $key => $value) {
             
              $valorTotal += $precos[$key]*$qtn[$key];
              $pedido->addItensPedido(new ItensPedido($nomes[$key], $qtn[$key], $precos[$key]));
              
            }

            $pedido->setValorTotal($valorTotal);

            $_SESSION['pedidoRes'] = $PDAO->cadastraPedido($cliente['email'], $pedido);

            $carrinho = array();
            $_SESSION['produtos'] = array();
            $_POST = array();

            echo "<script>window.location.replace('pedidoResultado.php');</script>";
          
          } catch (\Throwable $th) {
            
            print $th->getMessage();
            
          }
          
        }
      ?>
    </div>
    <footer class="footer; position: fixed; bottom: 0;">
      <div class="page-inner-content footer-content">
        <div class="logo-footer">
          <h1 class="logo">Eco<span>Compras</span></h1>
          <p>100% de produtos sustentáveis!</p>
          <p>copyright 2024 ©</p>
        </div>
      </div>
    </footer>
    <script type="module" src="public/js/carrinho.js"></script>
  </body>
</html>
