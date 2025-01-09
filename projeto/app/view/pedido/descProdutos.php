<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
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

                <!-- Formulário para adicionar ao carrinho -->
                <form method="POST" action="<?= BASEURL ?>/controller/CarrinhoController.php?action=addCarrinho">
                    <input type="hidden" name="idDoce" value="<?= $dados["doce"]->getIdDoces(); ?>">
                    <input type="hidden" name="nomeDoce" value="<?= $dados["doce"]->getNomeDoce(); ?>">
                    <input type="hidden" name="valorDoce" value="<?= $dados["doce"]->getValor(); ?>">
                    <input type="hidden" name="imgDoce" value="<?= $dados["doce"]->getCaminhoImagem() ?>">
                    <input type="hidden" name="idConfeiteiro" value="<?= $dados["doce"]->getConfeiteiro()->getIdConfeiteiro() ?>">
                    <!-- <input type="hidden" name="quantidade" value="<?= $quantidadeCarrinho ?>"> -->
                    <button type="submit" class="btn" style="width: 100%; margin-top: 50px; font-size:large;">
                        Adicionar ao carrinho
                    </button>
                </form>
            </div>

            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>
