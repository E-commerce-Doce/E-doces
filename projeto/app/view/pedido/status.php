<?php require_once(__DIR__ . "/../include/header.php"); ?>
<?php require_once(__DIR__ . "/../include/menu.php"); ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/status.css">

<div class="container my-5">
    <h2 class="mb-4" style="font-family: caveat;">Status do Pedido</h2>

    <div class="row">

        <div class="col-md-6">
            <div class="info">
                <ul>
                    <p class="info-item">
                        <i class="bi bi-sad"></i> <strong>Cancelado?</strong> Se seu pedido foi cancelado e você escolheu o PIX, entre em contato com nosso e-mail <strong>ameis.contato@gmail.com</strong> para reembolso.
                    </p>

                    <?php if (isset($formaPagamento) && $formaPagamento == 'PIX'): ?>
                        <p class="info-item">
                            <i class="bi bi-credit-card"></i> <strong>Escolheu Pix?</strong>
                            <a href="<?= BASEURL . '/controller/PedidoController.php?action=createPagamento&idPedido=' . $pedidoId ?>"
                                class="text-decoration-none text-success">Clique aqui para realizar seu pagamento</a>.
                        </p>
                    <?php endif; ?>

                    <p class="info-item">
                        <i class="bi bi-sad"></i> <strong>Deseja cancelar seu pedido?</strong>                  
                        <a class="text-success" onclick="return confirm('Você tem certeza de que deseja cancelar o seu pedido?'); "href="<?= BASEURL ?>/controller/PedidoController.php?action=cancelarPedido&idPedido=<?=  $pedidoId; ?>">Clique aqui!</a> 

                    </p>

                    <p class="info-item">
                        <i class="bi bi-star"></i> <strong>Finalizado?</strong> Quando seu pedido for finalizado, não se esqueça de avaliar nossos confeiteiros! Isso ajuda a melhorar sempre a qualidade dos nossos serviços. 💖
                    </p>
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
                    <?php if ($status == Status::RECEBIDO || $status == Status::PREPARANDO || $status == Status::PRONTO || $status == Status::PAGO || $status == Status::ENTREGUE): ?>
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

                    <?php if ($status == Status::PREPARANDO || $status == Status::PRONTO || $status == Status::PAGO || $status == Status::ENTREGUE): ?>
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

                    <?php if ($status == Status::PRONTO || $status == Status::PAGO || $status == Status::ENTREGUE): ?>
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

                    <?php if ($status == Status::PAGO || $status == Status::ENTREGUE): ?>
                        <li class="timeline-item">
                            <div class="timeline-icon bg-pagamento">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Pago</h5>
                                <p>O pagamento foi realizado com sucesso.</p>
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