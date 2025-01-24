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
    <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem doces disponíveis</h3>
    <?php endif; ?>

    <div class="row m-5">
        <div class="col-6">
            <?php if (isset($dados['usuario']) && $dados['usuario']->getPapel() === UsuarioPapel::CONFEITEIRO): ?>
                <a class="btn btn-primary" style="border-radius: 50%;" href="<?= BASEURL ?>/controller/DoceController.php?action=create">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="col-6 d-flex">
    </div>

    </div>

    <div class="row">
        <?php require_once(__DIR__ . "/../include/msg.php"); ?>
    </div>

    <div class="row">
        <?php foreach ($dados['lista'] as $d): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="border: none; background-color: transparent;">
                    <?php if ($d->getCaminhoImagem()): ?>
                        <img src="<?= URL_ARQUIVOS . "/" . $d->getCaminhoImagem() ?>" class="card-img-top" alt="Imagem do doce" style="height: 300px; width:100%; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body" style="font-family: 'Montserrat', sans-serif; color: black; text-align:center;">
                        <p style="color:brown; font-weight: bold;" class="fw-bold">Valor: R$ <?= $d->getValorFormatado(); ?></p>
                        <h5 class="card-title" style="font-family: caveat; font-weight: bold; font-size:40px "><?= $d->getNomeDoce(); ?></h5>
                        <p class="card-text"><?= $d->getDescricao(); ?></p>
                        
                    </div>
                    <div class="mb-2 d-flex justify-content-center" style="align-items: center;">
                        <?php if (isset($dados['usuario']) && $dados['usuario']->getPapel() === UsuarioPapel::CONFEITEIRO): ?>
                            <a href="<?= BASEURL ?>/controller/DoceController.php?action=edit&id=<?= $d->getIdDoces() ?>" class="btn btn-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                </svg>
                            </a>&nbsp;
                            <a href="<?= BASEURL ?>/controller/DoceController.php?action=delete&id=<?= $d->getIdDoces() ?>" onclick="return confirm('Confirma a exclusão do doce?');" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>