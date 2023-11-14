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
        <h2>Cadastro de Dados Pessoais</h2>
        <form>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
            
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Seu CPF" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Seu email" required>
            
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="Seu telefone" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
            
            <label for="confirm-senha">Confirmação de Senha:</label>
            <input type="password" id="confirm-senha" name="confirm-senha" placeholder="Confirme sua senha" required>

        
            <h2>Cadastro do Endereço</h2>

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" placeholder="CEP" required>
            
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" placeholder="Estado" required>
            
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" placeholder="Cidade" required>
            
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro" required>
            
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" placeholder="Logradouro" required>
            
            <label for="numero">Nº:</label>
            <input type="text" id="numero" name="numero" placeholder="Número" required>
            
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
                <p>copyright 2023 ©</p>
            </div>
        </div>
    </footer>
</body>
</html>
