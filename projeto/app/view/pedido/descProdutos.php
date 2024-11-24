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
                <p style="font-size:medium;"><?= $dados["doce"]->getConfeiteiro()->getNomeLoja(); ?></p>
                <h5 class="mt-1 mb-5" style="font-family: caveat; font-weight: bold; font-size:40px;">
                    <?= $dados["doce"]->getNomeDoce(); ?>
                </h5>
                <!--<p>Cat.: <?= $dados["doce"]->getTipoDoce()->getIdTipoDoce(); ?></p>-->
                <p style="color:brown; font-weight: bold;">R$ <?= $dados["doce"]->getValorFormatado(); ?></p>
                <p><span style="font-weight: bold;">Descrição:</span><br> <?= $dados["doce"]->getDescricao(); ?></p>
                <p><span style="font-weight: bold;">Alergicos:</span><br> <?= $dados["doce"]->getIngredientes(); ?></p>



                <!-- Formulário para adicionar ao carrinho -->
                <form method="POST" action="<?= BASEURL ?>/controller/CarrinhoController.php?action=addCarrinho">
                    <input type="hidden" name="idProduto" value="<?= $dados["doce"]->getIdDoces(); ?>">
                    <input type="hidden" name="nomeProduto" value="<?= $dados["doce"]->getNomeDoce(); ?>">
                    <input type="hidden" name="valorProduto" value="<?= $dados["doce"]->getValor(); ?>">
                    <input type="hidden" name="imgProduto" value="<?= $dados["doce"]->getCaminhoImagem() ?>">
                    <button type="submit" class="btn" style="width: 100%; margin-top: 175px; font-size:large;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg>
                        Adicionar ao carrinho</button>
                </form>
            </div>
        </div>
    </div>