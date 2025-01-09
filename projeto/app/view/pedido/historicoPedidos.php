<?php
# Nome do arquivo: pedido/listPedidos.php
# Objetivo: Interface para listagem dos pedidos do confeiteiro

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<div class="container mt-5" style="font-family: montserrat;">
    <h2 class="text-center mb-4" style="font-family:caveat">Meus Pedidos</h2>
    <div class="row">
        <?php foreach ($dados['lista'] as $pedido): ?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header ">
                        <strong style="font-family:caveat; font-size:25px">
                            Pedido : <?php
                                        $horario = $pedido->getHorario();
                                        if ($horario instanceof DateTime) {
                                            echo $horario->format('d/m/Y - H:i:s');
                                        } else {
                                            echo date('d/m/Y - H:i:s', strtotime($horario));
                                        }
                                        ?></strong>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">Loja: <?= $pedido->getConfeiteiro()->getNomeLoja(); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Status: <a href="<?= BASEURL ?>/controller/PedidoController.php?action=acompanharStatus&idPedido=<?= $pedido->getIdPedido(); ?>" class="text-decoration-none">Andamento do Pedido</a>
                        </h6>
                        <p class="card-text">
                            <strong>Avaliação:</strong> <?= $pedido->getAvaliacao(); ?>
                        </p>
                        <p class="card-text">
                            <strong>Forma de Pagamento:</strong> <?= $pedido->getFormaPagamento(); ?>
                        </p>
                        <p class="card-text">
                            <strong>Endereço:</strong>
                            <?php
                            if ($pedido->getEndereco()) {
                                echo $pedido->getEndereco()->getNomeLogradouro() . ", ";
                                echo $pedido->getEndereco()->getNumero() . " - ";
                                echo $pedido->getEndereco()->getBairro();
                            } else {
                                echo "Não informado";
                            }
                            ?>
                        </p>

                        <div class="mb-3">
                            <h6><strong>Itens do Pedido:</strong></h6>
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
                                        <p><strong><?php echo $doce->getNomeDoce(); ?></strong> - <?php echo $pedidoDoce->getQuantidade(); ?> unidades (R$ <?php echo number_format($pedidoDoce->getValorUnitario(), 2, ',', '.'); ?> cada)</p>
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
                            <h5 class="text-right">Total: <strong>R$ <?php echo number_format($valorTotalPedido, 2, ',', '.'); ?></strong></h5>
                        </div>

                        <div class="text-center">
                            <a href="#" class="btn btn-info">Avaliar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>