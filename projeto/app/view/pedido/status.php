<?php require_once(__DIR__ . "/../include/header.php"); ?>
<?php require_once(__DIR__ . "/../include/menu.php"); ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/status.css">

<div class="container my-5">
    <h2 class="ml-5 mb-5" style="font-family: caveat; color: #C30E59;">Andamento do Pedido</h2>

    <div class="row">

        <div class="col-md-6">
            <div class="info">
                <ul>

                    <div class="info-item mb-3">
                        <p>
                            <svg class="m-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                            <strong>Pedido nº <?= $pedido->getIdPedido(); ?></strong>

                        </p>

                        <p>
                            <strong>Forma de Pagamento:</strong> <?= htmlspecialchars($pedido->getFormaPagamento()) ?><br>
                             <?php if ($formaPagamento === 'PIX'): ?>
                                <?php if ($pedido->getComprovante()): ?>
                                    <span class="text-success">Pagamento Confirmado</span>
                                <?php else: ?>
                                    <span class="text-danger">Pagamento Não Realizado</span>
                                <?php endif; ?>
                            <?php elseif ($formaPagamento === 'DINHEIRO'): ?>
                                <span class="text-info">Pagamento na Entrega</span>
                            <?php endif; ?>
                        </p>

                        <?php
                        $valorTotalPedido = 0;
                        $pedidoDoces = $pedido->getPedidosDoces();

                        if (!empty($pedidoDoces)) {
                            foreach ($pedidoDoces as $pedidoDoce) {
                                $doce = $pedidoDoce->getDoce();
                                if ($doce) {
                                    $valorItem = $pedidoDoce->getQuantidade() * $pedidoDoce->getValorUnitario();
                                    $valorTotalPedido += $valorItem;
                        ?>
                                    <p>
                                        <strong><?= htmlspecialchars($doce->getNomeDoce()) ?></strong> -
                                        <?= $pedidoDoce->getQuantidade() ?> unidades
                                        (R$ <?= number_format($pedidoDoce->getValorUnitario(), 2, ',', '.') ?> cada)
                                    </p>
                        <?php
                                } else {
                                    echo "<p>Doce não encontrado</p>";
                                }
                            }
                        } else {
                            echo "<p>Sem doces associados</p>";
                        }
                        ?>
                        <hr>
                        <h5 class="text-right">
                            Total: <strong>R$ <?= number_format($valorTotalPedido, 2, ',', '.') ?></strong>
                        </h5>
                    </div>

                    <?php if ($status == Status::CANCELADO): ?>

                        <p class="info-item">
                            <svg class="m-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                            <strong>Cancelado?</strong> Se seu pedido foi cancelado e você escolheu o PIX, entre em contato com a loja <strong><?= $pedido->getConfeiteiro()->getNomeLoja(); ?> </strong>pelo telefone <strong><?= htmlspecialchars($telefoneConfeiteiro) ?></strong> para reembolso.
                        </p>

                    <?php elseif ($status !== Status::ENTREGUE): ?>

                        <?php if ($pedido->getComprovante() === null && isset($formaPagamento) && $formaPagamento == 'PIX'): ?>
                            <p class="info-item">
                                <i class="bi bi-credit-card"></i> <strong>Escolheu Pix?</strong>
                                <a href="<?= BASEURL . '/controller/PedidoController.php?action=createPagamento&idPedido=' . $pedidoId ?>"
                                    class="text-decoration-none text-success">Clique aqui para realizar seu pagamento</a>.
                            </p>
                        <?php endif; ?>


                        <p class="info-item">
                            <svg class="m-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.5 3.5 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.5 4.5 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                            </svg>
                            <strong>Deseja cancelar seu pedido?</strong>
                            <a class="text-success" onclick="return confirm('Você tem certeza de que deseja cancelar o seu pedido?');"
                                href="<?= BASEURL ?>/controller/PedidoController.php?action=cancelarPedido&idPedido=<?= $pedidoId; ?>">Clique aqui!</a>
                        </p>


                    <?php endif; ?>
                    <?php if ($status == Status::ENTREGUE): ?>

                        <p class="info-item">
                            <svg class="m-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                            </svg>
                            <strong>Finalizado?</strong> Quando seu pedido for finalizado, não se esqueça de <a href="<?= BASEURL . '/controller/PedidoController.php?action=listPedidos' ?>"
                                class="text-decoration-none text-success">avaliar</a> nossos confeiteiros! Isso ajuda a melhorar sempre a qualidade dos nossos serviços. 💖
                        </p>
                    <?php endif; ?>

                </ul>

            </div>
        </div>

        <div class="col-md-6">
            <ul class="timeline">
                <?php if ($status == Status::CANCELADO): ?>
                    <!-- Caso o status seja cancelado, exibe o item cancelado isoladamente -->
                    <li class="timeline-item">
                        <div class="timeline-icon bg-cancelado">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h5>Cancelado</h5>
                            <p>O pedido foi cancelado.</p>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Exibe os status apenas se não for cancelado -->
                    <?php if ($status == Status::RECEBIDO || $status == Status::PREPARANDO || $status == Status::PRONTO || $status == Status::ENTREGUE): ?>
                        <li class="timeline-item">
                            <div class="timeline-icon bg-recebido">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Recebido</h5>
                                <p>O pedido foi recebido e está pronto para ser preparado.</p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($status == Status::PREPARANDO || $status == Status::PRONTO || $status == Status::ENTREGUE): ?>
                        <li class="timeline-item">
                            <div class="timeline-icon bg-preparando">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Preparando</h5>
                                <p>O pedido está sendo preparado.</p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($status == Status::PRONTO || $status == Status::ENTREGUE): ?>
                        <li class="timeline-item">
                            <div class="timeline-icon bg-pronto">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Pronto</h5>
                                <p>O pedido está pronto para ser entregue.</p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($status == Status::ENTREGUE): ?>
                        <li class="timeline-item">
                            <div class="timeline-icon bg-entregue">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Entregue</h5>
                                <p>O pedido foi entregue com sucesso.</p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer2.php"); ?>