<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrinho</title>
    <link rel="stylesheet" href="/styles/global.css" />
    <link rel="stylesheet" href="styles.css" />
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
          </ul>
        </nav>
        <div class="nav-icon-container"></div>
      </div>
    </div>
    <div class="nota-fiscal">
      <h3>Sua compra!</h3>
      <p>Obrigado por comprar conosco!</p>
      <p class="small-text">Entrega grátis, receba em até 10 dias úteis.</p>

      <p>Nome do Cliente: <span id="nomeCliente"></span></p>
      <p>Email: <span id="emailCliente"></span></p>
      <p>Telefone: <span id="telefoneCliente"></span></p>
      <p>Quantidade de Produtos: <span id="quantidadeProdutos"></span></p>
      <!-- Informações de Endereço -->
      <h4>Endereço de Entrega</h4>
      <p>CEP: <span id="cepCliente"></span></p>
      <p>Cidade: <span id="cidadeCliente"></span></p>
      <p>Estado: <span id="estadoCliente"></span></p>
      <p>Rua: <span id="ruaCliente"></span></p>
      <p>Bairro: <span id="bairroCliente"></span></p>

      <!-- Total do Valor -->
      <h4>Total do Valor</h4>
      <p id="totalValor"></p>
    </div>

    <footer class="footer; position: fixed; bottom: 0;">
      <div class="page-inner-content footer-content">
        <div class="logo-footer">
          <h1 class="logo">Eco<span>Compras</span></h1>
          <p>100% de produtos sustentáveis!</p>
          <p>copyright 2023 ©</p>
        </div>
      </div>
    </footer>

    <script src="carrinho.js"></script>

    <script>
      // Exemplo básico de valores fictícios
      const cliente = {
        nome: cliente.nome,
        email: cliente.email,
        telefone: cliente.telefone,
        cep: cliente.cep,
        cidade: cliente.cidade,
        estado: cliente.estado,
        rua: cliente.rua,
        bairro: cliente.bairro,
      };

      const carrinho = [
        { nome: "Produto 1", preco: 50.0, quantidade: 2 },
        { nome: "Produto 2", preco: 30.0, quantidade: 1 },
        // Adicione mais produtos conforme necessário
      ];

      // Função para calcular o total do valor no carrinho
      function calcularTotalValor(carrinho) {
        return carrinho.reduce(
          (total, produto) => total + produto.preco * produto.quantidade,
          0
        );
      }

      // Atualizar valores na nota fiscal
      document.getElementById("nomeCliente").innerText = cliente.nome;
      document.getElementById("emailCliente").innerText = cliente.email;
      document.getElementById("telefoneCliente").innerText = cliente.telefone;
      document.getElementById("quantidadeProdutos").innerText = carrinho.length;
      document.getElementById("cepCliente").innerText = cliente.cep;
      document.getElementById("cidadeCliente").innerText = cliente.cidade;
      document.getElementById("estadoCliente").innerText = cliente.estado;
      document.getElementById("ruaCliente").innerText = cliente.rua;
      document.getElementById("bairroCliente").innerText = cliente.bairro;
      document.getElementById(
        "totalValor"
      ).innerText = `R$ ${calcularTotalValor(carrinho).toFixed(2)}`;
    </script>
  </body>
</html>
