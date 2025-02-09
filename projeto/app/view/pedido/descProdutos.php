<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="voltar">
    <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $dados["doce"]->getConfeiteiro()->getIdConfeiteiro() ?> " class="btn ml-5 mt-5" style="font-weight: 800; color:#C30E59; background-color:transparent; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg>
    </a>
</div>

<div class="container mt-1 p-3" style="border-radius: 15px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">



    <div class="col-6">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

    <div class="row align-items-stretch">
        <!-- Imagem do produto -->
        <div class="col">
            <div style="overflow: hidden; position: relative; max-width: 100%; max-height: 550px;">
                <?php if ($dados["doce"]->getCaminhoImagem()): ?>
                    <img class="zoom" style="width: 100%; height: 600px; object-fit: cover;" src="<?= URL_ARQUIVOS . "/" . $dados["doce"]->getCaminhoImagem() ?>" alt="Imagem do doce">
                <?php endif; ?>
            </div>
        </div>

        <!-- Informações do produto -->
        <div class="col d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <?php if ($dados["doce"]->getConfeiteiro()->getLogo()): ?>
                            <img src="<?= URL_ARQUIVOS . '/' . $dados["doce"]->getConfeiteiro()->getLogo(); ?>"
                                alt="Imagem da loja"
                                style="width: 50px; height: 50px; object-fit: cover; border: none; border-radius:50%">
                        <?php else: ?>
                            <img src="<?= BASEURL . '/view/img/Logo_chapeu.png'; ?>"
                                alt="Imagem padrão da loja"
                                style="width: 50px; height:50px; object-fit: cover; border: none;">
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold ml-2" style="font-size: 2rem; font-family: 'Caveat', cursive;">
                            <?= $dados["doce"]->getConfeiteiro()->getNomeLoja(); ?>
                        </p>
                    </div>
                </div>

                <div style="font-family: 'Montserrat', sans-serif; color: black;" class="mb-3 mt-5">
                    <h2 style="font-family: 'Caveat', cursive; font-weight: bold; font-size: 2.5rem;">
                        <?= $dados["doce"]->getNomeDoce(); ?>
                    </h2>
                    <p style="color: brown; font-size: 1.2rem; font-weight: bold;">
                        R$ <?= $dados["doce"]->getValorFormatado(); ?>
                    </p>
                    <p style="font-size: 1rem; font-weight: bold; color: #333;">Descrição:</p>
                    <p><?= $dados["doce"]->getDescricao(); ?></p>
                    <p><span style="font-weight: bold;">Alérgicos:</span><br> <?= $dados["doce"]->getIngredientes(); ?></p>

                    <div class="mt-4">
                        <a href="<?= BASEURL ?>/controller/AvaliacaoController.php?action=listAvaliacoes&idConfeiteiro=<?= $dados["doce"]->getConfeiteiro()->getIdConfeiteiro() ?> " class="text-muted" style="font-size: medium;">Ver avaliações da loja</a>
                    </div>
                </div>
            </div>

            <!-- Formulário para adicionar ao carrinho -->
            <form method="POST" action="<?= BASEURL ?>/controller/CarrinhoController.php?action=addCarrinho">
                <input type="hidden" name="idDoce" value="<?= $dados["doce"]->getIdDoces(); ?>">
                <input type="hidden" name="nomeDoce" value="<?= $dados["doce"]->getNomeDoce(); ?>">
                <input type="hidden" name="valorDoce" value="<?= $dados["doce"]->getValor(); ?>">
                <input type="hidden" name="imgDoce" value="<?= $dados["doce"]->getCaminhoImagem() ?>">
                <input type="hidden" name="idConfeiteiro" value="<?= $dados["doce"]->getConfeiteiro()->getIdConfeiteiro() ?>">
                <button type="submit" class="btn btn-primary btn-lg mt-2"
                    style="width: 100%; font-size: large; background-color: #C30E59; color:#FFE2E2; border: none;">
                    Adicionar ao carrinho
                </button>
            </form>
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