<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produtos</title>
    <link rel="stylesheet" href="/styles/global.css" />
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="navBar">
        <div>
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

    <div class="catalog" style="margin-bottom: 100px;">
        <!-- Seus produtos aqui -->
        <div class="product" id="produto1">
            <img src="imagens-pti/camisetaCinza.png" alt="Camisetas Básica" />
            <h3>Camiseta Unisex</h3>
            <p>Cor: Cinza</p>
            <p><strong>Tamanhos:</strong>
                <div class="tamanho-box">
                    <span id="tamanhos1" onclick="selecionarTamanhos('tamanhos1')">P</span>
                    <span id="tamanhos2" onclick="selecionarTamanhos('tamanhos2')">M</span>
                    <span id="tamanhos3" onclick="selecionarTamanhos('tamanhos3')">G</span>
                </div>
            </p>
            <p class="price">R$ 50.00</p>
            <button class="addToCartBtn" onclick="adicionarAoCarrinho('produto1')">Adicionar ao Carrinho</button>
        </div>

        <div class="product" id="produto2">
            <img src="imagens-pti/CamisetaPreta.png" alt="Camisetas Básica" />
            <h3>Camiseta Unisex </h3>
            <p>Cor: Preta</p>
            <p><strong>Tamanhos:</strong>
                <div class="tamanho-box">
                    <span id="tamanhos4" onclick="selecionarTamanhos('tamanhos4')">P</span>
                    <span id="tamanhos5" onclick="selecionarTamanhos('tamanhos5')">M</span>
                    <span id="tamanhos6" onclick="selecionarTamanhos('tamanhos6')">G</span>
                </div>
            </p>
            <p class="price">R$ 50.00</p>
            <button class="addToCartBtn" onclick="adicionarAoCarrinho('produto2')">Adicionar ao Carrinho</button>
        </div>

        <div class="product" id="produto3">
            <img src="imagens-pti/CamistaBranca.png" alt="Camisetas Básica" />
            <h3>Camiseta Unisex </h3>
            <p>Cor: Branca</p>
            <p><strong>Tamanhos:</strong>
                <div class="tamanho-box">
                    <span id="tamanhos7" onclick="selecionarTamanhos('tamanhos7')">P</span>
                    <span id="tamanhos8" onclick="selecionarTamanhos('tamanhos8')">M</span>
                    <span id="tamanhos9" onclick="selecionarTamanhos('tamanhos9')">G</span>
                </div>
            </p>
            <p class="price">R$ 50.00</p>
            <button class="addToCartBtn" onclick="adicionarAoCarrinho('produto3')">Adicionar ao Carrinho</button>
        </div>

        <div class="product" id="produto4">
            <img src="imagens-pti/bagSust.png" alt="Sacola Sustentável" />
            <h3>Sacola Sustentável</h3>
            <p>Sacola sustentável feita de material 100% reciclável</p>
            <p class="price">R$ 30.00</p>
            <button class="addToCartBtn" onclick="adicionarAoCarrinho('produto4')">Adicionar ao Carrinho</button>
        </div>

        <div class="product" id="produto5">
            <img src="imagens-pti/escovSust.png" alt="Escova de Dente Sustentável" />
            <h3>Escova de Dente Sustentável</h3>
            <p>Escova de Dente material feito de bambu 100% reciclável</p>
            <p class="price">R$ 35.00</p>
            <button class="addToCartBtn" onclick="adicionarAoCarrinho('produto5')">Adicionar ao Carrinho</button>
        </div>

        <div class="product" id="produto6">
            <img src="imagens-pti/mochilaSust.png" alt="Mochila Reciclável" />
            <h3>Mochila Reciclável</h3>
            <p>Mochila produzida com material 100% reciclável. Remenda-se carregar até 8kg</p>
            <p class="price">R$ 250.00</p>
            <button class="addToCartBtn" onclick="adicionarAoCarrinho('produto6')">Adicionar ao Carrinho</button>
        </div>
    </div>
    <footer class="footer; position: fixed;">
        <div class="page-inner-content footer-content">
            <div class="logo-footer">
                <h1 class="logo">Eco<span>Compras</span></h1>
                <p>100% de produtos sustentáveis!</p>
                <p>copyright 2023 ©</p>
            </div>
        </div>
    </footer>
    <script src="produtos.js"></script>
</body>
</html>