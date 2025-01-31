<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#Nome do arquivo: doce/listDoce.php
#Objetivo: interface para listagem dos doces do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="row mb-0 mr-0">
    <div class="col-2">
    <a href="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=listLojas" class="btn ml-5 mt-5" style="font-weight: 800; color:#C30E59; background-color:transparent; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
        </svg>
    </a>
    </div>
    <div class="col-8 mt-5">
    <?php if (!empty($dados['lista'])): ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">
            <?= $dados['lista'][0]->getConfeiteiro()->getNomeLoja(); ?>
        </h3>
    <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem doces disponíveis</h3>
    <?php endif; ?>

    </div>
</div>

<div class="container my-5">


    <div class="row">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

    <div class="m-5">
        <button class="btn btn-secondary" onclick="window.location.href='<?= BASEURL ?>/controller/AvaliacaoController.php?action=listAvaliacoes&idConfeiteiro=<?= urlencode($dados['lista'][0]->getConfeiteiro()->getIdConfeiteiro()); ?>'">
            Ver Avaliações
        </button>
    </div>

    <div class="row">

        <?php foreach ($dados['lista'] as $d): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="border: none; background-color: transparent;">
                    <?php if ($d->getCaminhoImagem()): ?>
                        <a href="<?= BASEURL ?>/controller/PedidoController.php?action=descProduto&idDoces=<?= $d->getIdDoces() ?>">
                            <img src="<?= URL_ARQUIVOS . "/" . $d->getCaminhoImagem() ?>" class="card-img-top" alt="Imagem do doce" style="height: 300px; width:100%; object-fit: cover;">
                        </a>
                    <?php endif; ?>
                    <div class="card-body" style="font-family: 'Montserrat', sans-serif; color: black; text-align:center;">
                        <h5 class="card-title" style="font-family: caveat; font-weight: bold; font-size:40px "><?= $d->getNomeDoce(); ?></h5>
                        <p class="card-text"><?= $d->getDescricao(); ?></p>
                        <p style="color:brown; font-weight: bold;" class="fw-bold">Valor: R$ <?= $d->getValorFormatado(); ?></p>
                        <!--<p>Ingredientes: <?= $d->getIngredientes(); ?></p>
                        <p>Nome da Loja: <?= $d->getConfeiteiro()->getNomeLoja(); ?></p>
                        <p>Tipo de Doce: <?= $d->getTipoDoce()->getDescricao(); ?></p>-->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>