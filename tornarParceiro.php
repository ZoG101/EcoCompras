<?php
  session_start();

  require_once 'classes\models\Cliente.php';
  require_once 'classes\models\Endereco.php';
  require_once 'classes\crud\ClienteDAO.php';
  require_once 'classes\crud\EnderecoDAO.php';

  use crud\ClienteDAO;
  use crud\EnderecoDAO;
  use models\Cliente;

  $fail = false;
  $CDAO = new ClienteDAO();
?>
<?php
  if (!isset($_SESSION['cliente'])) {

    echo "<script>window.location.replace('indexLogin.php');</script>";

  } else if ($_SESSION['cliente']['parceiro'] == 1) {

    echo "<script>window.location.replace('produtosCliente.php');</script>";

  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EcoCompras | Seja Parceiro</title>
    <link rel="stylesheet" href="/styles/global.css" />
    <link rel="stylesheet" href="/styles/login.css" />
    <style>
      .navBar a {
        color: black !important;
      }
      .navBar a.clicked {
        color: black;
      }
      </style>
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
    <div class="login-container">
      <h2>Parceria</h2>
      <p>Cadastre-se como parceiro e comece a vender agora mesmo!</p>
      <form method="POST" action="">
        <label for="nomeLoja">Nome da Lojinha:</label>
        <input
          type="text"
          id="nomeLoja"
          name="nomeLoja"
          placeholder="Nome da sua lojinha"
          required
        />
        <button type="submit">Começar a vender!</button>
        <p class="button-scroll"
          >Toda venda tem uma taxa de 5%</p
        >
      </form>
      <?php
        if (isset($_POST['nomeLoja'])) {
            $_POST['nomeLoja'] = strtoupper($_POST['nomeLoja']);

          if ($CDAO->verificaSeExisteLoja($_POST['nomeLoja'])) {

            echo "<spam class='fail erro'>Nome de loja já está em uso</spam>";
            $fail = true;

          }

          if (!$fail) {

            try {

                $cliente = $CDAO->mudaStatusClienteParaParceiro($_SESSION['cliente']['email'], $_POST['nomeLoja']);
    
            } catch (\Throwable $th) {
                
                $fail = true;
                if ($fail) echo "<p class='fail erro'>".$th->getMessage()."</p>";
    
            }

          }

          if (!$fail) {

            $_SESSION['cliente']['parceiro'] = 1; 
            $_SESSION['cliente']['nomeLojinha'] = $_POST['nomeLoja'];
              
            echo "<script>window.location.replace('produtosCliente.php');</script>";

          }

        }
      ?>
    </div>
    <footer class="green-background" style="position: fixed; bottom: 0; width: 100%; padding: 10px;">      <div class="page-inner-content footer-content">
          <div class="logo-footer">
              <h1 class="logo">Eco<span>Compras</span></h1>
              <p>100% de produtos sustentáveis!</p>
              <p>copyright 2023 ©</p>
          </div>
      </div>
  </footer>
  </body>
</html>
