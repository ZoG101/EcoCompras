<?php
  session_start();

  require_once 'classes\models\Cliente.php';
  require_once 'classes\models\Endereco.php';
  require_once 'classes\models\Produto.php';
  require_once 'classes\crud\ProdutoDAO.php';

  use crud\ProdutoDAO;
  use models\Produto;
  use models\Cliente;
  use models\Endereco;

  $fail = false;
?>
<?php
  if ((!isset($_SESSION['cliente'])) || (!$_SESSION['cliente']['parceiro'] == 1)) echo "<script>window.location.replace('indexLogin.php');</script>";

  $cliente = null;
  $produto = null;
  $endereco = null;
  $produtoDAO = null;

  try {

    $endereco = new Endereco('N/D', 'N/D', 'N/D', 'N/D', 'N/D', 'N/D', 'N/D',);
    $cliente = new Cliente($_SESSION['cliente']['nome'], $_SESSION['cliente']['cpf'], $_SESSION['cliente']['email'], $_SESSION['cliente']['telefone'], 'N/D', $endereco);
    $produtoDAO = new produtoDAO();

  } catch (\Throwable $th) {
    
    echo $th->getMessage();
    
  }
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

        function marcaSelecionadoAtualizacao(id){
          console.log(id);
            $(document).ready(function() {
              if($("#"+id).hasClass("selected")){
                $("#"+id).removeClass("selected");
              } else {
                $("#"+id).addClass("selected");
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
      function atualizaDescricao(id) {
        $(document).ready(function() {
            var textarea = document.querySelector("#"+"descricaoProdutoAtualizacao"+id);
            textarea.addEventListener("input", function(e) {
                var inputLength = parseInt(textarea.value.length);
                if (inputLength === 255) {
                    e.preventDefault();
                }
                var diferenca = 255 - parseInt(inputLength);
                document.querySelector("#"+"textarea-spanAtualizacao"+id).innerHTML = parseInt(diferenca);
            });
        });
      }
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
      function atualizaNome(id) {
        $(document).ready(function() {
            var textarea = document.querySelector("#"+"nomeProdutoAtualizacao"+id);
            textarea.addEventListener("input", function(e) {
                var inputLength = parseInt(textarea.value.length);
                if (inputLength >= 255) {
                    e.preventDefault();
                    document.querySelector("#"+"textarea-nome-spanAtualizacao"+id).innerHTML = "O máximo de caracteres para o nome é 255!";
                } else {
                    document.querySelector("#"+"textarea-nome-spanAtualizacao"+id).innerHTML = "";
                }
            });
        });
      }
    </script>
    <script>
      var textarea = null
      function atualizaCurrency(id) {
        $(document).ready(function() {
          textarea = document.querySelector("#"+id);
            
          formatCurrency($(textarea));
             
        });
      }

      function atualizaCurrencyBlur(id){

        textarea = document.querySelector("#"+id);

        formatCurrency($(textarea), "blur");
        

      }
      

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

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
    <script>
        function deleteApertado(id){
            $(document).ready(function() {
                
              var btnExluir = document.querySelector("#btn-exluir-"+id);
              btnExluir.setAttribute("hidden", "hidden");

              var btnAtualiza = document.querySelector("#btn-atualizar-"+id);
              btnAtualiza.setAttribute("hidden", "hidden");
        
              var btnSim = document.querySelector("#btn-sim-"+id);
              btnSim.removeAttribute("hidden", "hidden");

              var btnNao = document.querySelector("#btn-nao-"+id);
              btnNao.removeAttribute("hidden", "hidden");

              var spam = document.querySelector("#spam-"+id);
              spam.removeAttribute("hidden", "hidden");
              
            });
        }

        function naoApertado(id){
            $(document).ready(function() {
              
              var btnAtualiza = document.querySelector("#btn-atualizar-"+id);
              btnAtualiza.removeAttribute("hidden", "hidden");

              var btnExluir = document.querySelector("#btn-exluir-"+id);
              btnExluir.removeAttribute("hidden", "hidden");
        
              var btnSim = document.querySelector("#btn-sim-"+id);
              btnSim.setAttribute("hidden", "hidden");

              var btnNao = document.querySelector("#btn-nao-"+id);
              btnNao.setAttribute("hidden", "hidden");

              var spam = document.querySelector("#spam-"+id);
              spam.setAttribute("hidden", "hidden");
              
            });
        }

        function atualizaApertado(id){
            $(document).ready(function() {
              
              var formAtualiza = document.querySelector("#formAtualizacao"+id);
              formAtualiza.removeAttribute("hidden", "hidden");

              var btnAtualiza = document.querySelector("#btn-atualizar-"+id);
              btnAtualiza.setAttribute("hidden", "hidden");

              var btnExluir = document.querySelector("#btn-exluir-"+id);
              btnExluir.setAttribute("hidden", "hidden");
        
              var btnSim = document.querySelector("#btn-sim-"+id);
              btnSim.setAttribute("hidden", "hidden");

              var btnNao = document.querySelector("#btn-nao-"+id);
              btnNao.setAttribute("hidden", "hidden");

              var spam = document.querySelector("#spam-"+id);
              spam.setAttribute("hidden", "hidden");
              
            });
        }

        function atualizaCancelaApertado(id){
            $(document).ready(function() {
              
              var formAtualiza = document.querySelector("#formAtualizacao"+id);
              formAtualiza.setAttribute("hidden", "hidden");

              var btnAtualiza = document.querySelector("#btn-atualizar-"+id);
              btnAtualiza.removeAttribute("hidden", "hidden");

              var btnExluir = document.querySelector("#btn-exluir-"+id);
              btnExluir.removeAttribute("hidden", "hidden");
        
              var btnSim = document.querySelector("#btn-sim-"+id);
              btnSim.setAttribute("hidden", "hidden");

              var btnNao = document.querySelector("#btn-nao-"+id);
              btnNao.setAttribute("hidden", "hidden");

              var spam = document.querySelector("#spam-"+id);
              spam.setAttribute("hidden", "hidden");
              
            });
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
      <h2 style="font-size:1.8em;">Cadastrar Produtos</h2>
      <h3>LOJA: <?php echo $_SESSION['cliente']['nomeLojinha']; ?></h3>
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
        <input type="text" name="precoProduto" id="precoProduto" pattern="^\R\$\d{1,3}(.\d{3})*(\,\d+)?$" value="" data-type="currency" placeholder="R$1.000,00" maxlength="100" oninput="atualizaCurrency('precoProduto')" onblur="atualizaCurrencyBlur('precoProduto')"" required>
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
              $tamanhos = $_POST['tamanhos'][0] . $_POST['tamanhos'][1] . $_POST['tamanhos'][2];
              $preco = $_POST['precoProduto'];
              $imagem = $_FILES['imagem'];

              $diretorio = './imagens-parceiro/'. $_SESSION['cliente']['email'];

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

                try {
                  
                  $produto = new Produto($nomeProduto, $preco, $descricaoProduto, $concertado, $tamanhos, $cliente);

                } catch (\Throwable $th) {

                  echo $th->getMessage();

                }

                try {
                  
                  $produtoDAO->cadastraProduto($produto);

                } catch (\Throwable $th) {
                  
                  echo $th->getMessage();
                  $fail = true;

                }

                if (($resultado) && (!$fail)) {
                    
                  echo "<script>
                  Swal.fire({
                  title: 'Produto cadastrado!',
                  text: 'Você já pode ver seus produtos em MEUS PRODUTOS!',
                  icon: 'success',
                  showCancelButton: false,
                  confirmButtonText: 'Continuar',
                  }).then((result) => {
                  if (result.isConfirmed) {
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                  } else {
                      // Recarrega a página atual
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
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                  } else {
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                  }
                  });
                  </script>";

                }

            }

        }
      ?>
      <h2 style="font-size:1.8em;">Meus produtos</h2>
      <?php
        if (!$produtoDAO->verificaSeExisteProduto($cliente)) {

          echo "<spam style='font-size:1.0em;'>Você ainda não cadastrou nenhum produto!</spam>";

        } else {

          $produtos = null;

          try {

            $produtos = $produtoDAO->buscaProdutos($cliente);

            foreach ($produtos as $produto) {

              $tamanhos = "";

              if (strlen($produto->getTamanhos()) > 0) {

                for ($i=0; $i <= (strlen($produto->getTamanhos()) - 1); $i++) {
  
                  if ($i === 0) {
  
                    $tamanhos = $tamanhos . substr($produto->getTamanhos(), $i, $i+1);
                    continue;
                    
                  } else {

                    $tamanhos = $tamanhos . '-' . substr($produto->getTamanhos(), $i, $i);

                  }
                  
                }
  
              } else {

                $tamanhos = "Tamanho único";

              }

              echo "<div class='product' style='height: 20%; width:100%; max-width:550px;'>
                      <img src='./imagens-parceiro/". $_SESSION['cliente']['email'] ."/". $produto->getImagem() . "' alt='" . $produto->getNome() . "'>
                      <div class='produto-info'>
                        <h3 style='text-align:center; align-self: center; font-size:1.6em; text-color: red;'>" . $produto->getNome() . "</h3>
                        <p>Preço: " . $produto->getPreco() . "</p>
                        <p>Descrição: " . $produto->getDescricao() . "</p>
                        <p>Tamanhos: " . $tamanhos . "</p>
                      </div>
                      <div class='produto-buttons'>
                        <spam id='spam-".$produto->getId()."' style='font-size:1.0em; margin-bottom: 10px;' hidden>Tem certeza que deseja excluir?</spam>
                        <form action='' method='post'>
                          <input name='excluirProdutoParceiro' value='" . $produto->getId() . "' hidden>
                          <button type='button' style='background-color:red;' id='btn-exluir-".$produto->getId()."' onclick='deleteApertado(".$produto->getId().")'>Exluir</button>
                          <button type='button' id='btn-atualizar-".$produto->getId()."' onclick='atualizaApertado(".$produto->getId().")'>Atualizar</button>
                          <button type='submit' style='background-color:red;' id='btn-sim-".$produto->getId()."' hidden>Sim</button>
                          <button type='button' id='btn-nao-".$produto->getId()."' onclick='naoApertado(".$produto->getId().")' hidden>Não</button hidden>
                        </form>

                        <form id='formAtualizacao".$produto->getId()."' enctype='multipart/form-data' method='POST' action='' hidden>

                          <label for='nomeProdutoAtualizacao".$produto->getId()."'>Nome do produto:</label>
                          <input
                            type='text'
                            id='nomeProdutoAtualizacao".$produto->getId()."'
                            name='nomeProdutoAtualizacao'
                            placeholder='Ex.Relógio'
                            maxlength='255'
                            oninput='atualizaNome(".$produto->getId().")'
                            required
                          />
                          <span id='textarea-nome-spanAtualizacao".$produto->getId()."' class='fail erro' style='font-size:1.0em;'></span>

                          <label for='descricaoProdutoAtualizacao".$produto->getId()."'>Descrição do produto:</label>
                          <textarea
                              type='text'
                              id='descricaoProdutoAtualizacao".$produto->getId()."'
                              name='descricaoProdutoAtualizacao'
                              placeholder='Ex.Relógio de parede' 
                              size='50'
                              rows='5' 
                              cols='60'
                              style='padding: 10px;
                                      max-width: 100%;
                                      line-height: 1.5;
                                      border-radius: 5px;
                                      border: 1px solid #ccc;
                                      box-shadow: 1px 1px 1px #999;
                                      margin-top:5px;'
                                  
                              required
                              autocomplete
                              wrap
                              maxlength='255'
                              oninput='atualizaDescricao(".$produto->getId().")'
                          ></textarea>
                          <span id='textarea-spanAtualizacao".$produto->getId()."' style='position:relative; top:-10px; left:-10%; font-size:0.8em; color:#999'>255</span>

                          <h3>Selecione os tamanhos (opcional):</h3>
                          <div class='tamanho-box'>
                              <label id='P".$produto->getId()."' for='P".$produto->getId()."-checkbox' onclick=marcaSelecionadoAtualizacao('P".$produto->getId()."')>P</label>
                              <input type='checkbox' name='tamanhosAtt[]' id='P".$produto->getId()."-checkbox' value='P' hidden>
                              <label id='M".$produto->getId()."' for='M".$produto->getId()."-checkbox' onclick=marcaSelecionadoAtualizacao('M".$produto->getId()."')>M</label>
                              <input type='checkbox' name='tamanhosAtt[]' id='M".$produto->getId()."-checkbox' value='M' hidden>
                              <label id='G".$produto->getId()."' for='G".$produto->getId()."-checkbox' onclick=marcaSelecionadoAtualizacao('G".$produto->getId()."')>G</label>
                              <input type='checkbox' name='tamanhosAtt[]' id='G".$produto->getId()."-checkbox' value='G' hidden>
                          </div>

                          <label for='imagemAtualizacao'>Imagem do produto:</label>
                          <input name='imagemAtualizacao' id='imagemAtualizacao' type='file' required/>

                          <label for='precoProduto".$produto->getId()."'>Preço do produto:</label>
                          <input type='text' name='precoProdutoAtualiza' id='precoProduto".$produto->getId()."' pattern='^\R\\$\d{1,3}(.\d{3})*(\,\d+)?$' value='' data-type='currency' placeholder='R$1.000,00' maxlength='100' oninput=atualizaCurrency('precoProduto".$produto->getId()."') onblur=atualizaCurrencyBlur('precoProduto".$produto->getId()."') required>
                          
                          <input name='atualizaProdutoParceiro' value='" . $produto->getId() . "' hidden>
                          <button type='button' style='background-color:red;' id='cancelaAtt-btn".$produto->getId()."' onclick='atualizaCancelaApertado(".$produto->getId().")'>Cancelar</button>
                          <button type='submit'>Atualizar Produto</button>
                      </form>

                      </div>
                    </div>";
            }

          } catch (\Throwable $th) {

            echo $th-> getMessage();

          }

        }
      ?>
      <?php
        if (isset($_POST['excluirProdutoParceiro'])) {

          $falha = false;

          try {

            $diretorioUser = './imagens-parceiro/'. $_SESSION['cliente']['email'];
            $produtoDAO->deletaProduto($_POST['excluirProdutoParceiro'], $_SESSION['cliente']['email'], $diretorioUser);

          } catch (\Throwable $th) {

            echo "<script>
                    Swal.fire({
                    title: 'Erro ao deletar o produto!',
                    text: '".$th->getMessage()."',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'Continuar',
                    }).then((result) => {
                    if (result.isConfirmed) {
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                    } else {
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                    }
                    });
                    </script>";
            $falha = true;

          }

          if (!$falha) {

            echo "<script>
                    Swal.fire({
                    title: 'Produto deletado com sucesso!',
                    text: 'Você ainda pode ver seus produtos em MEUS PRODUTOS!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Continuar',
                    }).then((result) => {
                    if (result.isConfirmed) {
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                    } else {
                      // Recarrega a página atual
                      window.location.href = 'produtosCliente.php';
                    }
                    });
                    </script>";

          }

        }

        $falha = false;

      ?>
      <?php

        if ((isset($_POST['atualizaProdutoParceiro'])) && (isset($_FILES['imagemAtualizacao']))) {

          $type = substr($_FILES['imagemAtualizacao']['type'], 0, 5);

          if (!($type === 'image')) {

            echo "<script>
            Swal.fire({
            title: 'Erro ao atualizar a imagem do produto!',
            text: 'ERRO: Só é permitido o envio de imagens!',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'Continuar',
            }).then((result) => {
            if (result.isConfirmed) {
              // Recarrega a página atual
              window.location.href = 'produtosCliente.php';
            } else {
              // Recarrega a página atual
              window.location.href = 'produtosCliente.php';
            }
            });
            </script>";
    
            $fail = true;

          }

          if (!$fail) {

            $nomeProduto = $_POST['nomeProdutoAtualizacao'];
            $descricaoProduto = $_POST['descricaoProdutoAtualizacao'];
            $tamanhos = $_POST['tamanhosAtt'][0] . $_POST['tamanhosAtt'][1] . $_POST['tamanhosAtt'][2];
            $preco = $_POST['precoProdutoAtualiza'];
            $imagem = $_FILES['imagemAtualizacao'];

            $diretorio = './imagens-parceiro/'. $_SESSION['cliente']['email'];

            if (!is_dir($diretorio)) {

              echo "<script>
              Swal.fire({
              title: 'Erro interno do servidor!',
              text: 'ERRO: 500',
              icon: 'error',
              showCancelButton: false,
              confirmButtonText: 'Continuar',
              }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              } else {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              }
              });
              </script>";
      
              $fail = true;

            }

            $concertado = str_replace(' ', '', date('Y-m-d H:i:i') . date('U') . $nomeProduto . $imagem['name']);
            $concertado = str_replace('-', '', $concertado);
            $concertado = str_replace(':', '', $concertado);
            $concertado = str_replace('_', '', $concertado);

            $diretorio = $diretorio . '/' . $concertado;

            $resultado = false;

            if ((file_exists($diretorio)) && (!$fail)) {

              echo "<script>
              Swal.fire({
              title: 'Erro no envio da imagem!',
              text: 'ERRO: Arquivo de imagem já existe!',
              icon: 'error',
              showCancelButton: false,
              confirmButtonText: 'Continuar',
              }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              } else {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              }
              });
              </script>";

              $fail = true;

            } else {

              $resultado = rename($imagem['tmp_name'], $diretorio);

            }

            if ((!$resultado) && (!$fail)) {

              echo "<script>
              Swal.fire({
              title: 'Erro interno do servidor!',
              text: 'ERRO: 500',
              icon: 'error',
              showCancelButton: false,
              confirmButtonText: 'Continuar',
              }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              } else {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              }
              });
              </script>";

              $fail = true;

            }

          }

          if (!$fail) {

            try {
                  
              $produto = new Produto($nomeProduto, $preco, $descricaoProduto, $concertado, $tamanhos, $cliente);

            } catch (\Throwable $th) {

              echo $th->getMessage();

            }

            try {
              
              $produtoDAO->atualizaProduto($_POST['atualizaProdutoParceiro'], $_SESSION['cliente']['email'], $produto, './imagens-parceiro/'. $_SESSION['cliente']['email']);
              
            } catch (\Throwable $th) {
              
              echo $th->getMessage();
              $fail = true;

            }

            if (($resultado) && (!$fail)) {
                
              echo "<script>
              Swal.fire({
              title: 'Produto atualizado!',
              text: 'Você já pode ver seu produto atualizado em MEUS PRODUTOS!',
              icon: 'success',
              showCancelButton: false,
              confirmButtonText: 'Continuar',
              }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              } else {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              }
              });
              </script>";
            
            } else {

              echo "<script>
              Swal.fire({
              title: 'Erro ao atualizar produto! :(',
              text: 'Tente novamente!',
              icon: 'error',
              showCancelButton: false,
              confirmButtonText: 'Continuar',
              }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página atual
                window.location.href = 'produtosCliente.php';
              } else {
                // Recarrega a página atual
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
