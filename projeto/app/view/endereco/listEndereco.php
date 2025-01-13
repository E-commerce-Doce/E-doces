<?php
# Nome do arquivo: doce/listEndereco.php
# Objetivo: interface para listagem dos endereços do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow" style="border-radius: 10px;">
                <div class="card-header t-white text-center py-3" style="border-radius: 10px 10px 0 0; color: #C30E59;" >
                    <h3 class="font-weight-bold mb-0" style="font-family: Caveat;">
                        <i class="fas fa-map-marker-alt me-2"></i> Meus Endereços
                    </h3>
                </div>
                <div class="card-body p-4" style="font-family: Montserrat;">
                    <div class="text-end mb-3">
                        <a class="btn btn-primary rounded-circle btn-lg" style="width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;" href="<?= BASEURL ?>/controller/EnderecoController.php?action=create">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                            </svg>
                        </a>
                    </div>

                    <?php if (empty($dados['lista'])): ?>
                        <div class="text-center py-3">
                            <h5 class="text-muted">Sem endereços cadastrados</h5>
                        </div>
                    <?php else: ?>

                        <div class="col-12 mb-3">
                            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                        </div>

                        <div class="list-group">
                            <?php foreach ($dados['lista'] as $end): ?>
                                <div class="list-group-item list-group-item-action rounded mb-2 shadow-sm" style="border: 1px solid #ddd;">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5 class="mb-1"><?= $end->getNomeLogradouro(); ?>, <?= $end->getNumero(); ?></h5>
                                            <p class="mb-1">
                                                <strong>CEP:</strong> <?= $end->getCep(); ?><br>
                                                <strong>Bairro:</strong> <?= $end->getBairro(); ?><br>
                                                <strong>Cidade:</strong> <?= $end->getCidade(); ?>, <strong>Estado:</strong> <?= $end->getEstado(); ?><br>
                                                <strong>Complemento:</strong> <?= $end->getComplemento(); ?>
                                            </p>
                                        </div>
                                        <div class="col-md-3 d-flex flex-column justify-content-center align-items-end">
                                            <a class="btn btn-warning btn-sm mb-2" style="border-radius: 50%;"
                                                href="<?= BASEURL ?>/controller/EnderecoController.php?action=edit&id=<?= $end->getIdEndereco(); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                </svg>
                                            </a>
                                            <a class="btn btn-danger btn-sm" style="border-radius: 50%;"
                                                onclick="return confirm('Confirma a exclusão do endereço?');"
                                                href="<?= BASEURL ?>/controller/EnderecoController.php?action=delete&id=<?= $end->getIdEndereco() ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </div>
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
require_once(__DIR__ . "/../include/footer2.php");
?>