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
  if ((!isset($_SESSION['cliente'])) || (!$_SESSION['cliente']['parceiro'] == 1)) echo "<script>window.location.replace('indexLogin.php');</script>";
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EcoCompras | Produtos Parceiro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function marcaSelecionado(id){
            $(document).ready(function() {
                if($("#"+id).hasClass("selected")){
                    $("#"+id).removeClass("selected");
                    var b = document.querySelector("#"+id+"-checkbox");
                    b.removeAttribute("checked", "checked");
                } else {
                    $("#"+id).addClass("selected");
                    $("#"+id+"-checkbox").remove("selected");
                    var b = document.querySelector("#"+id+"-checkbox");
                    b.setAttribute("checked", "checked");
                }
                
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            var textarea = document.querySelector("#"+"descricaoProduto");
            textarea.addEventListener("input", function(e) {
                var inputLength = parseInt(textarea.value.length);
                if (inputLength === 255) {
                    e.preventDefault();
                }
                var diferenca = 255 - parseInt(inputLength);
                document.querySelector("#"+"textarea-span").innerHTML = parseInt(diferenca);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var textarea = document.querySelector("#"+"nomeProduto");
            textarea.addEventListener("input", function(e) {
                var inputLength = parseInt(textarea.value.length);
                if (inputLength >= 255) {
                    e.preventDefault();
                    document.querySelector("#"+"textarea-nome-span").innerHTML = "O máximo de caracteres para o nome é 255!";
                } else {
                    document.querySelector("#"+"textarea-nome-span").innerHTML = "";
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var textarea = document.querySelector("#"+"precoProduto");
            textarea.addEventListener("input", function(e) {
                formatCurrency($(textarea));
            });
            textarea.addEventListener("blur", function(e) {
                formatCurrency($(textarea), "blur");
            });
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.
            
            // get input value
            var input_val = input.val();
            
            // don't validate empty input
            if (input_val === "") { return; }
            
            // original length
            var original_len = input_val.length;

            // initial caret position 
            var caret_pos = input.prop("selectionStart");
                
            // check for decimal
            if (input_val.indexOf(",") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(",");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);
                
                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                right_side += "00";
                }
                
                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "R$" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "R$" + input_val;
                
                // final formatting
                if (blur === "blur") {
                    input_val += ",00";
                }
            }
            
            // send updated string to input
            input.val(input_val);
            input.value = input_val;

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
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
    <div class="conta-container">
      <h2>Cadastrar Produtos</h2>
      <p style="margin-bottom:1.5%;">Cadastre um produto para vender!</p>
      <form enctype="multipart/form-data" method="POST" action="">
        <label for="nomeProduto">Nome do produto:</label>
        <input
          type="text"
          id="nomeProduto"
          name="nomeProduto"
          placeholder="Ex.Relógio"
          maxlength="255"
          required
        />
        <span id="textarea-nome-span" class="fail erro" style="font-size:1.0em;"></span>
        <label for="descricaoProduto">Descrição do produto:</label>
        <textarea
            type="text"
            id="descricaoProduto"
            name="descricaoProduto"
            placeholder="Ex.Relógio de parede" 
            size="50"
            rows="5" 
            cols="60"
            style="padding: 10px;
                    max-width: 100%;
                    line-height: 1.5;
                    border-radius: 5px;
                    border: 1px solid #ccc;
                    box-shadow: 1px 1px 1px #999;
                    margin-top:5px;"
                
            required
            autocomplete
            wrap
            maxlength="255"
        ></textarea>
        <span id="textarea-span" style="position:relative; top:-10px; left:-10%; font-size:0.8em; color:#999">255</span>
        <h3>Selecione os tamanhos (opcional):</h3>
        <div class="tamanho-box">
            <label id="P" for="P" onclick="marcaSelecionado('P')">P</label>
            <input type="checkbox" name="tamanhos[]" id="P-checkbox" value="P" hidden>
            <label id="M" for="M" onclick="marcaSelecionado('M')">M</label>
            <input type="checkbox" name="tamanhos[]" id="M-checkbox" value="M" hidden>
            <label id="G" for="G" onclick="marcaSelecionado('G')">G</label>
            <input type="checkbox" name="tamanhos[]" id="G-checkbox" value="G" hidden>
        </div>
        <label for="imagem">Imagem do produto:</label>
        <input name="imagem" id="imagem" type="file" required/>
        <label for="precoProduto">Preço do produto:</label>
        <input type="text" name="precoProduto" id="precoProduto" pattern="^\R\$\d{1,3}(.\d{3})*(\,\d+)?$" value="" data-type="currency" placeholder="R$1.000,00" maxlength="100" required>
        <button type="submit">Cadastrar Produto</button>
        <p class="button-scroll"
          >Toda venda tem uma taxa de 5%</p
        >
      </form>
      <?php
        if ((isset($_POST['nomeProduto'])) && (isset($_FILES['imagem']))) {

            $type = substr($_FILES['imagem']['type'], 0, 5);

            if (!($type === 'image')) {
                echo "<spam class='fail erro' style='font-size:1.0em;'>Só é permitido o envio de imagens!</spam>";
                $fail = true;
            }

            if (!$fail) {

                $nomeProduto = $_POST['nomeProduto'];
                $descricaoProduto = $_POST['descricaoProduto'];
                $tamanhos = $_POST['tamanhos'];
                $preco = $_POST['precoProduto'];
                $imagem = $_FILES['imagem'];

                $diretorio = 'D:/documentos/UniformServer/UniServerZ/www/imagens-parceiro/'. $_SESSION['cliente']['email'];

                if(!is_dir($diretorio)){
                    mkdir($diretorio);
                }

                $concertado = str_replace(' ', '', date('Y-m-d H:i:i') . date('U') . $nomeProduto . $imagem['name']);
                $concertado = str_replace('-', '', $concertado);
                $concertado = str_replace(':', '', $concertado);
                $concertado = str_replace('_', '', $concertado);

                $diretorio = $diretorio . '/' . $concertado;

                if (file_exists($diretorio)) {
                    echo "<spam class='fail erro' style='font-size:1.0em;'>Já existe um produto com esse nome!</spam>";
                    $fail = true;
                }

            }

            if (!$fail) {

                $resultado = rename($imagem['tmp_name'], $diretorio);

                //$produto = new Produto($nomeProduto, $descricaoProduto, $tamanhos, $diretorio, $_SESSION['cliente']['id']);

                //$produto->cadastrarProduto();

                if ($resultado) {
                    
                    echo "<script>
                    Swal.fire({
                    title: 'Produto cadastrado!',
                    text: 'Você já pode ver seus produtos em MEUS PRODUTOS!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Continuar',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        // Redireciona para a página de carrinho após adicionar o produto
                        window.location.href = 'produtosCliente.php';
                    } else {
                        // Continua na página atual
                        window.location.href = 'produtosCliente.php';
                    }
                    });
                    </script>";
                
                } else {

                    echo "<script>
                    Swal.fire({
                    title: 'Erro ao cadastrar produto! :(',
                    text: 'Tente novamente!',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'Continuar',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        // Redireciona para a página de carrinho após adicionar o produto
                        window.location.href = 'produtosCliente.php';
                    } else {
                        // Continua na página atual
                        window.location.href = 'produtosCliente.php';
                    }
                    });
                    </script>";

                }

            }

        }
      ?>
    </div>
    <footer class="green-background" style="bottom: 0; width: 100%; padding: 10px;">      <div class="page-inner-content footer-content">
          <div class="logo-footer">
              <h1 class="logo">Eco<span>Compras</span></h1>
              <p>100% de produtos sustentáveis!</p>
              <p>copyright 2023 ©</p>
          </div>
      </div>
  </footer>
  </body>
</html>
