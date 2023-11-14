
function arraysIguais(arr1, arr2) {
  if (arr1.length !== arr2.length) {
      return false;
  }

  for (let i = 0; i < arr1.length; i++) {
      if (arr1[i] !== arr2[i]) {
          return false;
      }
  }

  return true;
}

function selecionarTamanhos(id) {
  const tamanhosSpan = document.getElementById(id);

  // Obtém o texto dentro da tag span
  const tamanhosTexto = tamanhosSpan.textContent;

  // Separa os tamanhos utilizando a barra como delimitador
  const tamanhosSeparados = tamanhosTexto.split(' / ');

  // Exibe cada tamanho em uma janela de alerta
  for (const tamanho of tamanhosSeparados) {
      alert(`Tamanho selecionado: ${tamanho}`);
  }
}

function adicionarAoCarrinho(idProduto, tamanhosSelecionados) {
  const carrinho = [];

  // Verifica se o produto já está no carrinho
  const produtoJaNoCarrinho = carrinho.find(item => {
      return item.idProduto === idProduto && arraysIguais(item.tamanhos, tamanhosSelecionados);
  });

  if (produtoJaNoCarrinho) {
      alert("Este produto já está no carrinho!");
  } else {
      carrinho.push({
          idProduto: idProduto,
          tamanhos: tamanhosSelecionados
      });

      // Utilizando o SweetAlert para a mensagem de confirmação
      Swal.fire({
          title: "Produto adicionado ao carrinho!",
          text: "Deseja ir para o carrinho?",
          icon: "success",
          showCancelButton: true,
          confirmButtonText: "Sim",
          cancelButtonText: "Não"
      }).then((result) => {
          if (result.isConfirmed) {
              // Redireciona para a página de carrinho após adicionar o produto
              window.location.href = "indexCarrinho.html";
          } else {
              // Continua na página atual
              console.log("Continuar na página atual");
          }
      });
  }
}

function arraysIguais(arr1, arr2) {
  if (arr1.length !== arr2.length) {
      return false;
  }

  for (let i = 0; i < arr1.length; i++) {
      if (arr1[i] !== arr2[i]) {
          return false;
      }
  }

  return true;
}




