<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>


<div class="container mt-5 p-3" style="border-radius: 15px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <div class="col-6">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>
    <div class="row">
        <!-- Imagem do produto -->
        <div class="col">
            <div style="overflow: hidden; position: relative; max-width: 100%; max-height: 550px;">
                <?php if ($dados["doce"]->getCaminhoImagem()): ?>
                    <img class="zoom" style="width: 100%; height: 100%; object-fit: cover;" src="<?= URL_ARQUIVOS . "/" . $dados["doce"]->getCaminhoImagem() ?>" alt="Imagem do doce">
                <?php endif; ?>
            </div>
        </div>

        <!-- Informações do produto -->
        <div class="col">

            <div class="d-flex align-items-center">
                <div class="me-5">
                    <?php if ($dados["doce"]->getConfeiteiro()->getLogo()): ?>
                        <img src="<?= URL_ARQUIVOS . '/' . $dados["doce"]->getConfeiteiro()->getLogo(); ?>"
                            alt="Imagem da loja"
                            style="width: 150px; height: 150px; object-fit: cover; border: none;">
                    <?php else: ?>
                        <img src="<?= BASEURL . '/view/img/Logo_chapeu.png'; ?>"
                            alt="Imagem padrão da loja"
                            style="width: 150px; height: 150px; object-fit: cover; border: none;">
                    <?php endif; ?>
                </div>
                <div class="m-5">
                    <p class="mb-0 fw-bold " style="font-size: 2rem; font-family: 'Caveat', cursive;">
                        <?= $dados["doce"]->getConfeiteiro()->getNomeLoja(); ?>
                    </p>
                </div>
            </div>
            <div style="font-family: 'Montserrat', sans-serif; color: black;" class="mb-3">
                <h2 style="font-family: 'Caveat', cursive; font-weight: bold; font-size: 2.5rem;"><?= $dados["doce"]->getNomeDoce(); ?></h2>
                <p style="color:brown; font-size: 1.2rem; font-weight: bold;">R$ <?= $dados["doce"]->getValorFormatado(); ?></p>
                <p style="font-size: 1rem; font-weight: bold; color: #333;">Descrição:</p>
                <p><?= $dados["doce"]->getDescricao(); ?></p>
                <p><span style="font-weight: bold;">Alérgicos:</span><br> <?= $dados["doce"]->getIngredientes(); ?></p>

                <!-- Informações de entrega
                <div class="mt-3">
                    <h6>Informações de entrega:</h6>
                    <p>Prazo de entrega: <strong>2 a 5 dias úteis</strong></p>
                    <p>Frete: <strong>Grátis</strong> para pedidos acima de R$ 150,00.</p>
                </div>

                 Avaliações 
                <div class="mt-4">
                    <h6>Avaliações:</h6>
                    <div class="d-flex align-items-center">
                        <span class="me-2">⭐⭐⭐⭐☆</span>
                        <span>(12 avaliações)</span>
                    </div>
                    <a href="#reviews" class="text-muted" style="font-size: small;">Ver todas as avaliações</a>
                </div> -->

                <!-- Formulário para adicionar ao carrinho -->
                <form method="POST" action="<?= BASEURL ?>/controller/CarrinhoController.php?action=addCarrinho">
                    <input type="hidden" name="idDoce" value="<?= $dados["doce"]->getIdDoces(); ?>">
                    <input type="hidden" name="nomeDoce" value="<?= $dados["doce"]->getNomeDoce(); ?>">
                    <input type="hidden" name="valorDoce" value="<?= $dados["doce"]->getValor(); ?>">
                    <input type="hidden" name="imgDoce" value="<?= $dados["doce"]->getCaminhoImagem() ?>">
                    <input type="hidden" name="idConfeiteiro" value="<?= $dados["doce"]->getConfeiteiro()->getIdConfeiteiro() ?>">
                    <button type="submit" class="btn btn-primary btn-lg"
                        style="width: 100%; margin-top: 30px; font-size: large; background-color: #ff4081; border: none;">
                        Adicionar ao carrinho
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Estilo adicional -->
    <style>
        img.zoom:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }
    </style>

    <?php
    require_once(__DIR__ . "/../include/footer2.php");
    ?>