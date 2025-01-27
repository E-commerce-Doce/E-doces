<?php require_once(__DIR__ . '/../include/header.php'); ?>
<?php require_once(__DIR__ . '/../include/menu.php'); ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/avaliacao.css">


<div class="row mb-0 mr-0">
    <div class="col-2">
        <a href="<?= BASEURL ?>/controller/PedidoController.php?action=listProdutos&idConfeiteiro=<?= $dados['lista'][0]->getConfeiteiro()->getIdConfeiteiro(); ?>" class="btn ml-5 mt-5" style="font-weight: 800; color:#C30E59; background-color:transparent; ">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
            </svg>
        </a>
    </div>
    <div class="col-8 mt-4">
        <?php if (!empty($dados['lista'])): ?>
            <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">
                <?= $dados['lista'][0]->getConfeiteiro()->getNomeLoja(); ?>
            </h3>
        <?php else: ?>
            <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem avaliações disponíveis</h3>
        <?php endif; ?>
    </div>
</div>


<div class="tudo">

    <!-- Container para os cartões -->
    <div class="row">
        <?php foreach ($dados['lista'] as $avaliacao): ?>
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5><?= $avaliacao->getUsuario()->getNome(); ?></h5>
                        <p class="card-text">
                            <strong>Nota:</strong>
                            <?php
                            $nota = $avaliacao->getNota();
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $nota) {
                                    echo '<i class="fas fa-star text-warning"></i>';
                                } else {
                                    echo '<i class="far fa-star text-warning"></i>';
                                }
                            }
                            ?>
                        </p>
                        <p class="card-text">
                            <strong>Comentário:</strong> <?= htmlspecialchars($avaliacao->getComentario()); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once(__DIR__ . '/../include/footer2.php'); ?>