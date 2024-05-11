<?php session_start(); ?>
<?php
  if (isset($_SESSION['cliente'])) {

    echo "<script>window.location.replace('indexConta.php');</script>";

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
    <link rel="stylesheet" href="styles/_variaveis.css">
    <link rel="stylesheet" href="styles/inputs.css">
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
    <div class="cadastro-container">
        <h2>Cadastro de Dados Pessoais</h2>
        <form method="POST" action="cadastroEnvio.php" onsubmit="validaPassword();">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Seu nome" data-tipo="nome" required>
            <span class="input-mensagem-erro-nome erro"></span>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Seu CPF" data-tipo="cpf" required>
            <span class="input-mensagem-erro-cpf erro"></span>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Seu email" data-tipo="email" required>
            <span class="input-mensagem-erro-email erro"></span>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="Seu telefone" data-tipo="telefone" pattern="^(?=.*[0-9])(?!.*[a-z])(?!.*[A-Z])(?!.*[!@#$%^&*_=+.]).{11,15}$" required>
            <span class="input-mensagem-erro-telefone erro"></span>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Sua senha" data-tipo="senha" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?!.*[ ])(?=\S+$).{6,}$" title="A senha deve conter, pelo menos, 6 caracteres, deve conter no mínimo uma letra maiúscula e uma minúscula, um número e não deve conter espaços." required>
            <span class="input-mensagem-erro-senha erro"></span>

            <label for="confirm-senha">Confirmação de Senha:</label>
            <input type="password" id="confirm-senha" name="confirm-senha" placeholder="Confirme sua senha" data-tipo="senhaConf" required>
            <span class="input-mensagem-erro-senhaConf erro"></span>
        
            <h2>Cadastro do Endereço</h2>

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" placeholder="CEP" pattern="[\d]{5}-?[\d]{3}" data-tipo="cep" required>
            <span class="input-mensagem-erro-cep erro"></span>

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" placeholder="Estado" data-tipo="estado" required>
            <span class="input-mensagem-erro-estado erro"></span>

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" placeholder="Cidade" data-tipo="cidade" required>
            <span class="input-mensagem-erro-cidade erro"></span>

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro" data-tipo="bairro" required>
            <span class="input-mensagem-erro-bairro erro"></span>
            
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" placeholder="Logradouro" data-tipo="logradouro" required>
            <span class="input-mensagem-erro-logradouro erro"></span>

            <label for="numero">Nº:</label>
            <input type="text" id="numero" name="numero" placeholder="Número" data-tipo="numero" required>
            <span class="input-mensagem-erro-numero erro"></span>

            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento" placeholder="Complemento (opcional)">
            
            <button type="submit">Salvar</button>
        </form>
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
    <script src="public/js/app.js" type="module"></script>
</body>
</html>
