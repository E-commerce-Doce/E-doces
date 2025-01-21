function detalhesPedido(idDescricao, idPedido) {
    // Seleciona a div com base no id recebido
    var divDescricao = document.getElementById("divDescricao" + idPedido);
    
    // Alterna a visibilidade da div
    if (divDescricao.style.display === "none") {
        divDescricao.style.display = "block"; // Torna a div visível
    } else {
        divDescricao.style.display = "none"; // Torna a div invisível
    }
}

