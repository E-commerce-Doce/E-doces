document.getElementById('txtCpf').addEventListener('input', function (e) {
    let cpf = e.target.value;
    cpf = cpf.replace(/\D/g, ""); // Remove tudo que não for dígito
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona o primeiro ponto
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona o segundo ponto
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Adiciona o traço
    e.target.value = cpf; // Atualiza o valor do campo
});

document.getElementById('txtTelefone').addEventListener('input', function (e) {
    let telefone = e.target.value;
    telefone = telefone.replace(/\D/g, ""); // Remove tudo que não for dígito
    telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2"); // Adiciona parênteses em torno do DDD
    telefone = telefone.replace(/(\d{5})(\d)/, "$1-$2"); // Adiciona o traço depois dos 5 primeiros dígitos
    e.target.value = telefone; // Atualiza o valor do campo
});

document.getElementById('txtDataNascimento').addEventListener('change', function() {
    const input = this;
    const dataNascimento = new Date(input.value);
    const dataAtual = new Date();

    // Cálculo da idade
    let idade = dataAtual.getFullYear() - dataNascimento.getFullYear();
    const mes = dataAtual.getMonth() - dataNascimento.getMonth();
    if (mes < 0 || (mes === 0 && dataAtual.getDate() < dataNascimento.getDate())) {
        idade--;
    }

    // Definir os limites de idade (18 a 100 anos)
    const idadeMinima = 18;
    const idadeMaxima = 100;
    const erroMensagem = document.getElementById('dataNascimentoErro');

    // Validação da idade
    if (idade < idadeMinima || idade > idadeMaxima) {
        erroMensagem.style.display = 'block';  // Mostra a mensagem de erro
        input.value = '';  // Limpa o campo se a idade for inválida
    } else {
        erroMensagem.style.display = 'none';  // Esconde a mensagem de erro se a idade for válida
    }
});