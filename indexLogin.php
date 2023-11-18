<?php
  session_start();

  require_once 'classes\models\Cliente.php';
  require_once 'classes\models\Endereco.php';
  require_once 'classes\crud\ClienteDAO.php';
  require_once 'classes\crud\EnderecoDAO.php';

  use crud\ClienteDAO;
  use crud\EnderecoDAO;
  use models\Cliente;
  use models\Endereco;

  $fail = false;
  $CDAO = new ClienteDAO();
  $EDAO = new EnderecoDAO();
?>
<?php
  if (isset($_SESSION['cliente'])) {

    echo "<script>window.location.replace('indexConta.php');</script>";

  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EcoCompras | Produtos sustentáveis</title>
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
            </ul>
          </nav>
          <div class="nav-icon-container"></div>
        </div>
      </div>
    <div class="login-container">
      <h2>Login</h2>
      <p>Caso já tenha usuário, faça seu login.</p>
      <form method="POST" action="">
        <label for="username">Usuário:</label>
        <input
          type="text"
          id="username"
          name="username"
          placeholder="Seu e-mail"
          required
        />

        <label for="password">Senha:</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Sua senha"
          required
        />
        <button type="submit">Acessar</button>
        <a href="indexCadastro.php" class="button-scroll"
          >É novo? Cadastre-se</a
        >
      </form>
      <?php
        if ((isset($_POST['username'])) && isset($_POST['password'])) {

          if (!$CDAO->verificaSeExisteCliente($_POST['username'])) {

            echo "<p class='fail erro'>Usuário ou senha estão incorretos</p>";
            $fail = true;

          }

          try {

            $cliente = $CDAO->buscaCliente($_POST['username'],);

          } catch (\Throwable $th) {
            
            $fail = true;

          }

          if (!$fail) {

            if ($_POST['password'] != $cliente->getSenha()) {

              $fail = true;
              echo "<p class='fail'>Usuário ou senha estão incorretos</p>";

            }

          }

          if (!$fail) {

            try {

              $endereco = $EDAO->buscaEndereco($cliente);
              $cliente->setEndereco($endereco);

            } catch (\Throwable $th) {

              $fail = true;

            }

          }

          if (!$fail) {

            $_SESSION['cliente'] = [
              'nome'=> $cliente->getNome(),
              'cpf'=> $cliente->getCpf(),
              'email'=> $cliente->getEmail(),
              'telefone'=> $cliente->getTelefone()
            ];
            $_SESSION['endereco'] = [
              'cep'=> $endereco->getCep(),
              'cidade'=> $endereco->getCidade(),
              'estado'=> $endereco->getEstado(),
              'rua'=> $endereco->getRua(),
              'numero'=> $endereco->getNumero(),
              'bairro'=> $endereco->getBairro(),
              'complemento'=> $endereco->getComplemento()
            ];

            echo "<script>window.location.replace('indexConta.php');</script>";

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
