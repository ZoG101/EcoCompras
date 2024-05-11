<?php session_start(); ?>
<?php
  if (!isset($_SESSION['cliente'])) {

    echo "<script>window.location.replace('indexLogin.php');</script>";

  } else if (!isset($_SESSION['produtos'])) {

    echo "<script>window.location.replace('indexProdutos.php');</script>";

  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Dados Pessoais</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/cadastro.css">
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
        <div class="produto-envio-container">
        <?php
          if ($_SESSION['pedidoRes']) {

            echo "<img src='imagens-pti/iconSucess.png' alt='Imagem de sucesso verde.'>
            <h2>Pedido realizado com sucesso!</h2>
            <p><a href='indexConta.php'>Veja seus pedidos</a></p>" ;

          } else {

            echo "<img src='imagens-pti/iconUnsuccess.png' alt='Imagem de insucesso vermelho.'>
            <h2>Erro no Pedido!</h2><p><a href='indexCarrinho.php'>Tente Novamente</a></p>";

          }

          $_SESSION['pedidoRes'] = false;
        ?>
    </div>
    <footer class="green-background">
        <div class="page-inner-content footer-content">
            <div class="logo-footer">
                <h1 class="logo">Eco<span>Compras</span></h1>
                <p>100% de produtos sustentáveis!</p>
                <p>copyright 2024 ©</p>
            </div>
        </div>
    </footer>
</body>
</html>
