<?php
#Nome do arquivo: doce/listDoce.php
#Objetivo: interface para listagem dos doces do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center font-weight-bold" style="font-family:caveat; margin-top: 20px;">Sodie</h3>

<div class="container">
    <div class="row">
        <div class="col-3">
            <?php if (isset($dados['usuario']) && $dados['usuario']->getPapel() === UsuarioPapel::CONFEITEIRO): ?>
                <a class="btn btn-primary" href="<?= BASEURL ?>/controller/DoceController.php?action=create">
                    Inserir
                </a>
            <?php endif; ?>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <?php foreach ($dados['lista'] as $d): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 18rem;">
                    <?php if ($d->getCaminhoImagem()): ?>
                        <img src="<?= URL_ARQUIVOS . "/" . $d->getCaminhoImagem() ?>" class="card-img-top" alt="Imagem do doce" style="height: 180px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $d->getNomeDoce(); ?></h5>
                        <p class="card-text"><?= $d->getDescricao(); ?></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item fs-5">Valor: R$ <?= $d->getValorFormatado(); ?></li>
                            <li class="list-group-item fs-5 fw-bold">Ingredientes: <?= $d->getIngredientes(); ?></li>
                            <li class="list-group-item fs-5">Nome da Loja: <?= $d->getConfeiteiro()->getNomeLoja(); ?></li>
                            <li class="list-group-item fs-5">Tipo de Doce: <?= $d->getTipoDoce()->getDescricao(); ?></li>
                        </ul>

                    </div>
                    <div class="card-body">
                        <?php if (isset($dados['usuario']) && $dados['usuario']->getPapel() === UsuarioPapel::CONFEITEIRO): ?>
                            <a href="<?= BASEURL ?>/controller/DoceController.php?action=edit&id=<?= $d->getIdDoces() ?>" class="card-link btn btn-primary">Alterar</a>
                            <a href="<?= BASEURL ?>/controller/DoceController.php?action=delete&id=<?= $d->getIdDoces() ?>" onclick="return confirm('Confirma a exclusão do doce?');" class="card-link btn btn-danger">Excluir</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>