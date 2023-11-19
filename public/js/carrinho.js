const inputs = document.querySelectorAll("input[name='qtn']")
var precos = document.querySelectorAll("input[name='preco']")
var nomes = document.querySelectorAll("input[name='nome']")
const qtn = document.querySelectorAll("input[name='qtnd[]']")

inputs.forEach(input => {
    input.addEventListener('blur', (evento) => {
        atualiza(evento.target)
    })
})

function atualiza(target) {
    var total = 0.0;
    for (let index = 0; index < inputs.length; index++) {
        console.log(precos[index].value)
        if (isNaN(parseFloat(inputs[index].value)) || parseFloat(inputs[index].value) == 0) target.value = 1; 
        total = total+(parseFloat(precos[index].value)*parseFloat(inputs[index].value))
        qtn[index].value = parseFloat(inputs[index].value)
    }
    console.log(total)
    document.querySelector('.total').innerHTML = "R$ "+total;
}
