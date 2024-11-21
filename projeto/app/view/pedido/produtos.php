<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#Nome do arquivo: doce/listDoce.php
#Objetivo: interface para listagem dos doces do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container my-5">
    <?php if (!empty($dados['lista'])): ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">
            <?= $dados['lista'][0]->getConfeiteiro()->getNomeLoja(); ?>
        </h3>
     <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem doces disponíveis</h3>
    <?php endif; ?> 

    <div class="row">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

    <div class="row">
        <?php foreach ($dados['lista'] as $d): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="border: none; background-color: transparent;">
                    <?php if ($d->getCaminhoImagem()): ?>
                        <a href="<?= BASEURL?> /controller/PedidoController.php?action=descProduto&idDoces=<?= $d->getIdDoces() ?>">
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