document.addEventListener("DOMContentLoaded", function () {
    const carrinhoItens = JSON.parse(localStorage.getItem("carrinho")) || [];

    exibirItensDoCarrinho(carrinhoItens);
    exibirNotaFiscal(carrinhoItens);
});

function exibirItensDoCarrinho(carrinhoItens) {
    const carrinhoContainer = document.getElementById("carrinhoItens");

    carrinhoItens.forEach(item => {
        const itemDiv = document.createElement("div");
        itemDiv.innerHTML = `<p>${item.idProduto} - Tamanhos: ${item.tamanhos.join(', ')}</p>`;
        carrinhoContainer.appendChild(itemDiv);
    });
}

function exibirNotaFiscal(carrinhoItens) {
    const notaFiscalContainer = document.getElementById("notaFiscal");

    let total = 0;

    // Lógica para calcular o total (substitua isso com a lógica real da sua aplicação)
    carrinhoItens.forEach(item => {
        // Adicione aqui a lógica para calcular o preço com base no produto e nos tamanhos selecionados
        // Atualmente, assumimos um preço fixo de R$ 50.00 para todos os produtos
        total += 50.00 * item.tamanhos.length;
    });

    // Aqui, estamos apenas exibindo uma mensagem simples
    notaFiscalContainer.innerHTML = `<h3>Nota Fiscal</h3><p>Total a pagar: R$ ${total.toFixed(2)}</p>`;
}
