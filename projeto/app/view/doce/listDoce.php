<?php
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
    <!-- <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem doces disponíveis</h3>
    <?php endif; ?> -->

    <div class="row mb-4">
        <div class="col-12 text-end ">
            <?php if (isset($dados['usuario']) && $dados['usuario']->getPapel() === UsuarioPapel::CONFEITEIRO): ?>
                <a class="btn btn-primary" style="border-radius: 100%; hight:5%; width:5%; font-size: 25px; " href="<?= BASEURL ?>/controller/DoceController.php?action=create">+</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

    <div class="row">
        <?php foreach ($dados['lista'] as $d): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                    <?php if ($d->getCaminhoImagem()): ?>
                        <img src="<?= URL_ARQUIVOS . "/" . $d->getCaminhoImagem() ?>" class="card-img-top" alt="Imagem do doce" style="height: 180px; object-fit: cover; border-radius: 15px 15px 0 0;">
                    <?php endif; ?>
                    <div class="card-body" style="font-family: 'Montserrat', sans-serif; color: black;">
                        <h5 class="card-title"><?= $d->getNomeDoce(); ?></h5>
                        <p class="card-text"><?= $d->getDescricao(); ?></p>
                        <p class="fw-bold">Valor: R$ <?= $d->getValorFormatado(); ?></p>
                        <p>Ingredientes: <?= $d->getIngredientes(); ?></p>
                        <p>Nome da Loja: <?= $d->getConfeiteiro()->getNomeLoja(); ?></p>
                        <p>Tipo de Doce: <?= $d->getTipoDoce()->getDescricao(); ?></p>
                    </div>
                    <div  class="mb-2 ml-2">
                        <?php if (isset($dados['usuario']) && $dados['usuario']->getPapel() === UsuarioPapel::CONFEITEIRO): ?>
                            <a href="<?= BASEURL ?>/controller/DoceController.php?action=edit&id=<?= $d->getIdDoces() ?>" class="btn btn-light">Alterar</a>
                            <a href="<?= BASEURL ?>/controller/DoceController.php?action=delete&id=<?= $d->getIdDoces() ?>" onclick="return confirm('Confirma a exclusão do doce?');" class="btn btn-danger">Excluir</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
// require_once(__DIR__ . "/../include/footer.php");
?>
