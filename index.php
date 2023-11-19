<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EcoCompras | Produtos sustentáveis</title>
    <link rel="stylesheet" href="/styles/global.css" />
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
    <header>
      <div class="header--inner-content">
        <div class="header-bottom-side">
          <div class="header-bottom-side-left">
            <h2>Bem-vindo à EcoCompras!</h2>
            <p>
              Descubra produtos sustentáveis, de qualidade excepcional e entrega
              rápida.
            </p>
            <buttonInicio onclick="window.location.href='indexProdutos.php'">Explore agora!</buttonInicio>          </div>
          <div class="header-bottom-side-right">
            <img src="/imagens-pti/arvoreSust.jpg" />
          </div>
        </div>
      </div>
    </header>
    <!---- aqui começa o main ----->
    <main>
      <div class="main-content">
        <h2>Produtos Recomendados!</h2>
        <div class="main">
          <img src="/imagens-pti/bagSust.png" />
          <img src="/imagens-pti/mochilaSust.png" />
          <img src="/imagens-pti/escovSust.png" />
          <img src="/imagens-pti/camisetas.png" />
        </div>
      </div>
      <div class="page-inner-content">
        <div class="testemunhas">
          <div class="comentario">
            <p>
              "Adoro a variedade de produtos sustentáveis deste site! Comprei
              uma mochila ecológica e fiquei impressionado com a qualidade e o
              compromisso com o meio ambiente. Definitivamente, vou continuar
              comprando aqui."
            </p>
            <div class="avaliacao">
              <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
              <p>Ana Luiza</p>
            </div>
          </div>

          <div class="comentario">
            <p>
              "Os produtos deste site realmente fazem a diferença. Comprei uma
              escova de dentes de bambu e estou muito feliz em contribuir para a
              redução do plástico. Além disso, a entrega foi super rápida e o
              atendimento ao cliente é excelente."
            </p>
            <div class="avaliacao">
              <p class="rate">&#9733;&#9733;&#9733;&#9734;&#9734;</p>
              <p>Federick Martins</p>
            </div>
          </div>
          <div class="comentario">
            <p>
              "Encontrei o lugar perfeito para comprar presentes eco-friendly.
              Comprei uma camiseta feita de algodão orgânico e não só estou
              ajudando o planeta, mas também estou vestindo algo confortável e
              de alta qualidade. Recomendo este site a todos que se preocupam
              com o meio ambiente."
            </p>
            <div class="avaliacao">
              <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9734;</p>
              <p>João Pedro</p>
            </div>
          </div>
        </div>
      </div>
    </main>
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
