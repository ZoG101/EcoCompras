<?php session_start(); ?>
<?php
    require_once 'classes\helper\Contador.php';

    use helper\Contador;

    if (!isset($_SESSION['prodCont'])) {

        $prodCont = new Contador();
        $_SESSION['prodCont'] = $prodCont->getCont();

    } else {

        $prodCont = new Contador();
        $prodCont->setCont($_SESSION['prodCont']);

    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produtos</title>
    <link rel="stylesheet" href="/styles/global.css" />
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="produtos.js"></script>
    <script>
        function marcaSelecionado(id){
            $(document).ready(function() {
                $("#"+id).addClass("selected");
                $("#"+id).siblings().removeClass("selected");
            });
        }
    </script>
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
            <h3>Camiseta Unisex Cinza</h3>
            <p>Cor: Cinza</p>
            <form method="POST" action="">
                <p><strong>Tamanhos:</strong>
                    <div class="tamanho-box">
                        <input type="radio" id="Camiseta-Unisex-Cinza-P" name="produto" value="Camiseta Unisex Cinza - P" checked hidden>
                        <label class="selected" id="produtoLabel1P" for="Camiseta-Unisex-Cinza-P" onclick="marcaSelecionado('produtoLabel1P')">P</label>
                        <input type="radio" id="Camiseta-Unisex-Cinza-M" name="produto" value="Camiseta Unisex Cinza - M" hidden>
                        <label id="produtoLabel1M" for="Camiseta-Unisex-Cinza-M" onclick="marcaSelecionado('produtoLabel1M')">M</label>
                        <input type="radio" id="Camiseta-Unisex-Cinza-G" name="produto" value="Camiseta Unisex Cinza - G" hidden>
                        <label id="produtoLabel1G" for="Camiseta-Unisex-Cinza-G" onclick="marcaSelecionado('produtoLabel1G')">G</label>
                    </div>
                </p>
                <p class="price">R$ 50.00</p>
                <input type="hidden" name="preco" value="50">
                <button type="submit" class="addToCartBtn">Adicionar ao Carrinho</button>
            </form>
        </div>

        <div class="product" id="produto2">
            <img src="imagens-pti/CamisetaPreta.png" alt="Camisetas Básica" />
            <h3>Camiseta Unisex Preta</h3>
            <p>Cor: Preta</p>
                <form method="POST" action="">
                <p><strong>Tamanhos:</strong>
                    <div class="tamanho-box">
                        <input type="radio" id="Camiseta-Unisex-Preto-P" name="produto" value="Camiseta Unisex Preto - P" checked hidden>
                        <label class="selected" id="produtoLabel2P" for="Camiseta-Unisex-Preto-P" onclick="marcaSelecionado('produtoLabel2P')">P</label>
                        <input type="radio" id="Camiseta-Unisex-Preto-M" name="produto" value="Camiseta Unisex Preto - M" hidden>
                        <label id="produtoLabel2M" for="Camiseta-Unisex-Preto-M" onclick="marcaSelecionado('produtoLabel2M')">M</label>
                        <input type="radio" id="Camiseta-Unisex-Preto-G" name="produto" value="Camiseta Unisex Preto - G" hidden>
                        <label id="produtoLabel2G" for="Camiseta-Unisex-Preto-G" onclick="marcaSelecionado('produtoLabel2G')">G</label>
                    </div>
                </p>
                <p class="price">R$ 50.00</p>
                <input type="hidden" name="preco" value="50">
                <button type="submit" class="addToCartBtn">Adicionar ao Carrinho</button>
            </form>
        </div>

        <div class="product" id="produto3">
            <img src="imagens-pti/CamistaBranca.png" alt="Camisetas Básica" />
            <h3>Camiseta Unisex Branca</h3>
            <p>Cor: Branca</p>
            <form method="POST" action="">
                <p><strong>Tamanhos:</strong>
                    <div class="tamanho-box">
                        <input type="radio" id="Camiseta-Unisex-Branca-P" name="produto" value="Camiseta Unisex Branca - P" checked hidden>
                        <label class="selected" id="produtoLabel3P" for="Camiseta-Unisex-Branca-P" onclick="marcaSelecionado('produtoLabel3P')">P</label>
                        <input type="radio" id="Camiseta-Unisex-Branca-M" name="produto" value="Camiseta Unisex Branca - M" hidden>
                        <label id="produtoLabel3M" for="Camiseta-Unisex-Branca-M" onclick="marcaSelecionado('produtoLabel3M')">M</label>
                        <input type="radio" id="Camiseta-Unisex-Branca-G" name="produto" value="Camiseta Unisex Branca - G" hidden>
                        <label id="produtoLabel3G" for="Camiseta-Unisex-Branca-G" onclick="marcaSelecionado('produtoLabel3G')">G</label>
                    </div>
                </p>
                <p class="price">R$ 50.00</p>
                <input type="hidden" name="preco" value="50">
                <button type="submit" class="addToCartBtn">Adicionar ao Carrinho</button>
            </form>
        </div>

        <div class="product" id="produto4">
            <img src="imagens-pti/bagSust.png" alt="Sacola Sustentável" />
            <h3>Sacola Sustentável</h3>
            <p>Sacola sustentável feita de material 100% reciclável</p>
            <p class="price">R$ 30.00</p>
            <form method="POST" action="">
                <input type="hidden" name="produto" value="Sacola Sustentável">
                <input type="hidden" name="preco" value="30">
                <button type="submit" class="addToCartBtn">Adicionar ao Carrinho</button>
            </form>
        </div>

        <div class="product" id="produto5">
            <img src="imagens-pti/escovSust.png" alt="Escova de Dente Sustentável" />
            <h3>Escova de Dente Sustentável</h3>
            <p>Escova de Dente material feito de bambu 100% reciclável</p>
            <p class="price">R$ 35.00</p>
            <form method="POST" action="">
                <input type="hidden" name="produto" value="Escova de Dente Sustentável">
                <input type="hidden" name="preco" value="35">
                <button type="submit" class="addToCartBtn">Adicionar ao Carrinho</button>
            </form>
        </div>

        <div class="product" id="produto6">
            <img src="imagens-pti/mochilaSust.png" alt="Mochila Reciclável" />
            <h3>Mochila Reciclável</h3>
            <p>Mochila produzida com material 100% reciclável. Remenda-se carregar até 8kg</p>
            <p class="price">R$ 250.00</p>
            <form method="POST" action="">
                <input type="hidden" name="produto" value="Mochila Reciclável">
                <input type="hidden" name="preco" value="250">
                <button type="submit" class="addToCartBtn">Adicionar ao Carrinho</button>
            </form>
        </div>
    </div>
    <?php
        //recebe requisição POST
        if (isset($_POST['produto'])) {
            $jaExiste = false;

            //verifica se o produto já está presente no carriho da sessão
            for ($i = 0; $i < $prodCont->getCont(); $i++) {
                
                if ($_SESSION['produtos'][$i]['nome'] == $_POST['produto']) {

                    $jaExiste = true;

                }

            }

            //se não existir, adiciona ao carrinho e exibe a mensagem de confirmação. se já existir, exibe o erro
            if (!$jaExiste) {

                $_SESSION['produtos'][$prodCont->getCont()] = [
                    'nome' => $_POST['produto'],
                    'preco' => $_POST['preco'],
                    'quantidade' => 1
                ];

                $prodCont->adicionar();
                $_SESSION['prodCont'] = $prodCont->getCont();

                echo "<script>
                Swal.fire({
                title: 'Produto adicionado ao carrinho!',
                text: 'Deseja ir para o carrinho?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Redireciona para a página de carrinho após adicionar o produto
                    window.location.href = 'indexCarrinho.php';
                } else {
                    // Continua na página atual
                    window.location.href = 'indexProdutos.php';
                }
                });
                </script>";

            } else {

                echo "<script>
                Swal.fire({
                title: 'Produto já adicionado ao carrinho!',
                text: 'Deseja ir para o carrinho?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Redireciona para a página de carrinho após adicionar o produto
                    window.location.href = 'indexCarrinho.php';
                } else {
                    // Continua na página atual
                    window.location.href = 'indexProdutos.php';
                }
                });
                </script>";

            }

        }
    ?>
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
