<?php
# Nome do arquivo: doce/listEndereco.php
# Objetivo: interface para listagem dos endereços do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container my-5">

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-center" style="font-family: 'Caveat', cursive;">
                    <h3 class="font-weight-bold">
                        <i class="fas fa-map-marker-alt"></i> Meus Endereços
                    </h3>
                </div>
                <div class="card-body">

                    <?php if (empty($dados['lista'])): ?>
                        <h5 class="text-center">Sem endereços cadastrados</h5>
                        <div class="row mb-4">
                            <div class="col-12 text-end">
                            <a class="btn btn-primary" style="border-radius: 100%;  hight:3%; width:6%; font-size: 23px; " href="<?= BASEURL ?>/controller/EnderecoController.php?action=create">+</a>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="col-5 mb-3">
                            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 text-end">
                            <a class="btn btn-primary" style="border-radius: 100%; hight:3%; width:6%; font-size: 15px; " href="<?= BASEURL ?>/controller/EnderecoController.php?action=create">+</a>
                            </div>
                        </div>

                        <div class="list-group"style="font-family: 'Montserrat', sans-serif; ">
                            <?php foreach ($dados['lista'] as $end): ?>
                                <div class="list-group-item">
                                    <h5 class="mb-1" ><?= $end->getNomeLogradouro(); ?>, <?= $end->getNumero(); ?></h5>
                                    <p class="mb-1">
                                        <strong>CEP:</strong> <?= $end->getCep(); ?><br>
                                        <strong>Bairro:</strong> <?= $end->getBairro(); ?><br>
                                        <strong>Cidade:</strong> <?= $end->getCidade(); ?>, <strong>Estado:</strong> <?= $end->getEstado(); ?><br>
                                        <strong>Complemento:</strong> <?= $end->getComplemento(); ?>
                                    </p>
                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-warning btn-sm me-2"
                                           href="<?= BASEURL ?>/controller/EnderecoController.php?action=edit&id=<?= $end->getIdEndereco(); ?>">
                                           Editar</a>
                                           &nbsp;
                                        <a class="btn btn-danger btn-sm"
                                           onclick="return confirm('Confirma a exclusão do endereço?');"
                                           href="<?= BASEURL ?>/controller/EnderecoController.php?action=delete&id=<?= $end->getIdEndereco() ?>">
                                           Excluir</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
// require_once(__DIR__ . "/../include/footer.php");
?>
