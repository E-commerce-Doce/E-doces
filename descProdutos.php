<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<?php
// A quantidade padrão do doce no carrinho (1 por padrão)
$quantidadeCarrinho = 1;

if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $doce) {
        if ($doce['id'] == $dados["doce"]->getIdDoces()) {
            $quantidadeCarrinho = $doce['quantidade'];  // Carrega a quantidade atualizada
            break;
        }
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <?php if ($dados["doce"]->getCaminhoImagem()): ?>
                <img style="width:100%; height:520px;" src="<?= URL_ARQUIVOS . "/" . $dados["doce"]->getCaminhoImagem() ?>" alt="Imagem do doce">
            <?php endif; ?>
        </div>

        <div class="col">
            <div style="font-family: 'Montserrat', sans-serif; color: black;" class="mb-3">
                <p><?= $dados["doce"]->getTipoDoce()->getDescricao(); ?></p>
                <p style="font-size:medium;"><?= $dados["doce"]->getConfeiteiro()->getNomeLoja(); ?></p>
                <h5 class="mt-1 mb-5" style="font-family: caveat; font-weight: bold; font-size:40px;">
                    <?= $dados["doce"]->getNomeDoce(); ?>
                </h5>
                <p style="color:brown; font-weight: bold;">R$ <?= $dados["doce"]->getValorFormatado(); ?></p>
                <p><span style="font-weight: bold;">Descrição:</span><br> <?= $dados["doce"]->getDescricao(); ?></p>
                <p><span style="font-weight: bold;">Alergicos:</span><br> <?= $dados["doce"]->getIngredientes(); ?></p>

                <!-- Quantidade -->
                <p  style="font-weight: bold;" for="quantidade">Quantidade:</p>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-sm" onclick="alterarQuantidade('menos', <?= $dados['doce']->getIdDoces() ?>)">-</button>
                    <input type="text" class="form-control text-center m-1" name="quantidade" id="quantidade" value="<?= $quantidadeCarrinho ?>" readonly style="width:40px;" >
                    <button type="button" class="btn btn-sm" onclick="alterarQuantidade('mais', <?= $dados['doce']->getIdDoces() ?>)">+</button>
                </div>

                <!-- Formulário para adicionar ao carrinho -->
                <form method="POST" action="<?= BASEURL ?>/controller/CarrinhoController.php?action=addCarrinho">
                    <input type="hidden" name="idDoce" value="<?= $dados["doce"]->getIdDoces(); ?>">
                    <input type="hidden" name="nomeDoce" value="<?= $dados["doce"]->getNomeDoce(); ?>">
                    <input type="hidden" name="valorDoce" value="<?= $dados["doce"]->getValor(); ?>">
                    <input type="hidden" name="imgDoce" value="<?= $dados["doce"]->getCaminhoImagem() ?>">
                    <input type="hidden" name="idConfeiteiro" value="<?= $dados["doce"]->getConfeiteiro()->getIdConfeiteiro() ?>">
                    <input type="hidden" name="quantidade" id="input-quantidade" value="<?= $quantidadeCarrinho ?>">
                    <button type="submit" class="btn" style="width: 100%; margin-top: 50px; font-size:large;">
                        Adicionar ao carrinho
                    </button>
                </form>
            </div>

            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>
</div>

<script>
// Função para alterar a quantidade
function alterarQuantidade(acao, idDoce) {
    let quantidade = parseInt(document.getElementById('quantidade').value);

    // Atualiza a quantidade conforme o botão pressionado
    if (acao === 'mais') {
        quantidade++;  // Aumenta a quantidade
    } else if (acao === 'menos' && quantidade > 1) {
        quantidade--;  // Diminui a quantidade, mas não permite valores menores que 1
    }

    // Atualiza o valor da quantidade no campo de entrada (visível)
    document.getElementById('quantidade').value = quantidade;

    // Atualiza o valor do campo oculto para envio no formulário
    document.getElementById('input-quantidade').value = quantidade;

    // Envia a nova quantidade para o servidor via AJAX
    atualizarCarrinho(idDoce, quantidade);
}



// Função para atualizar a quantidade no carrinho via AJAX
function atualizarCarrinho(idDoce, quantidade) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= BASEURL ?>/controller/CarrinhoController.php?action=updateQuantidade', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    // Função que será executada quando a resposta da requisição chegar
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Carrinho atualizado');
        } else {
            console.log('Erro ao atualizar carrinho');
        }
    };

    // Enviar os dados (idDoce e quantidade) para o servidor
    xhr.send('idDoce=' + idDoce + '&quantidade=' + quantidade);
}
</script>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>
