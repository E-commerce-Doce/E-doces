<?php require_once(__DIR__ . '/../include/header.php'); ?>
<?php require_once(__DIR__ . '/../include/menu.php'); ?>


<div class="container m-5">
<?php if (!empty($dados['lista'])): ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">
            <?= $dados['lista'][0]->getConfeiteiro()->getNomeLoja(); ?>
        </h3>
    <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">Sem avaliacoes disponíveis</h3>
    <?php endif; ?>
    <div class="row">

        <?php foreach ($dados['lista'] as $avaliacao): ?>
            <div class="col-md-4 mb-4">
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
