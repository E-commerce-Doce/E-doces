<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-5">

    <div class="row">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

    <div class="row">

        <div class="col">
            <?php if ($dados["doce"]->getCaminhoImagem()): ?>
                <img style="width:100%; height:520px;" src="<?= URL_ARQUIVOS . "/" . $dados["doce"]->getCaminhoImagem() ?>" alt="Imagem do doce">
            <?php endif; ?>
        </div>


        <div class="col">
            <div style="font-family: 'Montserrat', sans-serif; color: black;">
                <h5 class="mt-5 mb-5" style="font-family: caveat; font-weight: bold; font-size:40px;">
                    <?= $dados["doce"]->getNomeDoce(); ?>
                </h5>
                <p>Descrição: <?= $dados["doce"]->getDescricao(); ?></p>
                <p>Valor: R$ <?= $dados["doce"]->getValorFormatado(); ?></p>
                <p>Ingredientes: <?= $dados["doce"]->getIngredientes(); ?></p>
                <p>Nome da Loja: <?= $dados["doce"]->getConfeiteiro()->getNomeLoja(); ?></p>


                <!-- Formulário para adicionar ao carrinho -->
                <form method="POST" action="<?= BASEURL?>/controller/CarrinhoController.php?action=addCarrinho">
                    <input type="hidden" name="idProduto" value="<?= $dados["doce"]->getIdDoces(); ?>">
                    <input type="hidden" name="nomeProduto" value="<?= $dados["doce"]->getNomeDoce(); ?>">
                    <input type="hidden" name="valorProduto" value="<?= $dados["doce"]->getValor(); ?>">
                    <input type="hidden" name="imgProduto" value="<?= $dados["doce"]->getCaminhoImagem()?>">
                    <button type="submit" class="btn" style="width: 100%; margin-top: 175px;">Comprar</button>
                </form>
            </div>
        </div>
    </div>

</div>