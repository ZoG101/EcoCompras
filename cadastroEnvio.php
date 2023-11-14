<?php session_start(); ?>
<?php
  if (isset($_SESSION['cliente'])) {

    echo "<script>window.location.replace('indexConta.php');</script>";

  }
?>
<?php
  require_once 'classes\models\Cliente.php';
  require_once 'classes\models\Endereco.php';
  require_once 'classes\crud\ClienteDAO.php';
  require_once 'classes\crud\EnderecoDAO.php';

  use crud\ClienteDAO;
  use crud\EnderecoDAO;
  use models\Cliente;
  use models\Endereco;
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
              </ul>
            </nav>
            <div class="nav-icon-container"></div>
          </div>
        </div>
        <div class="cadastro-container">
        <?php
          $clienteTest = false;
          $enderecoTest = false;
          $erroMsg = '';

          try {

            $endereco = new Endereco($_POST['cep'], $_POST['cidade'], $_POST['estado'], $_POST['logradouro'], $_POST['numero'], $_POST['bairro'], $_POST['complemento']);
            $cliente = new Cliente($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['telefone'], $_POST['senha'], $endereco);
            $CDAO = new ClienteDAO();
            $EDAO = new EnderecoDAO();
            $clienteTest = $CDAO->cadastraCliente($cliente);
            $enderecoTest = $EDAO->cadastraEndereco($cliente, $endereco);

          } catch (\Throwable $th) {

            echo "<img src='imagens-pti/iconUnsuccess.png' alt='Imagem de insucesso vermelho.'>
            <h2>Erro no cadastro!</h2><p>". $th->getMessage() .
            "</p><p><a href='indexCadastro.php'>Tente Novamente</a></p>";

          }
        ?>
        <?php
          if (($clienteTest) && ($enderecoTest)) echo "<img src='imagens-pti/iconSucess.png' alt='Imagem de sucesso verde.'>
            <h2>Cadastro realizado com sucesso!</h2>
            <p><a href='indexLogin.php'>Faça Login</a></p>" ;
        ?>
    </div>
    <footer class="green-background">
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
