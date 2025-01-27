<?php require_once(__DIR__ . '/../include/header.php'); ?>
<?php require_once(__DIR__ . '/../include/menu.php'); ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/avaliacao.css">

<div class="tudo">
    <?php if (!empty($dados['lista'])): ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">
            <?= $dados['lista'][0]->getConfeiteiro()->getNomeLoja(); ?>
        </h3>
    <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem avaliações disponíveis</h3>
    <?php endif; ?>

    <!-- Container para os cartões -->
    <div class="row">
        <?php foreach ($dados['lista'] as $avaliacao): ?>
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5><?=$avaliacao->getUsuario()->getNome();?></h5>
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