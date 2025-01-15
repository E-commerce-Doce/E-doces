<?php
# Nome do arquivo: pedido/listPedidos.php
# Objetivo: Interface para listagem dos pedidos do confeiteiro

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/historico.css">

<div class="container mt-5" style="font-family: montserrat;">
    <h2 class="text-center mb-4" style="font-family:caveat; color:#C30E59;">Meus Pedidos</h2>
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
                        <h5 class="card-title text-dark"><strong>Loja: </strong><?= $pedido->getConfeiteiro()->getNomeLoja(); ?></h5>
                        <p class="card-text mb-2"><strong>Status:</strong> <a href="<?= BASEURL ?>/controller/PedidoController.php?action=acompanharStatus&idPedido=<?= $pedido->getIdPedido(); ?>" class="text-decoration-none; font-weight: normal;">Andamento do Pedido</a>
                        </p>
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
                            <button class="btn btn-info" onclick="toggleAvaliacao(this)">Avaliar</button>
                        </div>

                        <div class="avaliacao mt-3" style="display: none;">
    <form action="AvaliacaoController.php?action=inserirAvaliacao" method="POST">
        <input type="hidden" name="idPedido" value="<?= $pedido->getIdPedido(); ?>">

        <div class="mb-3">
            <label for="avaliacao-<?= $pedido->getIdPedido(); ?>" class="form-label">Avaliação (1 a 5 estrelas):</label>
            <div class="rating">
                <input type="radio" id="star-5-<?= $pedido->getIdPedido(); ?>" name="avaliacao" value="5">
                <label for="star-5-<?= $pedido->getIdPedido(); ?>" title="5 estrelas">★</label>

                <input type="radio" id="star-4-<?= $pedido->getIdPedido(); ?>" name="avaliacao" value="4">
                <label for="star-4-<?= $pedido->getIdPedido(); ?>" title="4 estrelas">★</label>

                <input type="radio" id="star-3-<?= $pedido->getIdPedido(); ?>" name="avaliacao" value="3">
                <label for="star-3-<?= $pedido->getIdPedido(); ?>" title="3 estrelas">★</label>

                <input type="radio" id="star-2-<?= $pedido->getIdPedido(); ?>" name="avaliacao" value="2">
                <label for="star-2-<?= $pedido->getIdPedido(); ?>" title="2 estrelas">★</label>

                <input type="radio" id="star-1-<?= $pedido->getIdPedido(); ?>" name="avaliacao" value="1">
                <label for="star-1-<?= $pedido->getIdPedido(); ?>" title="1 estrela">★</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="comentario-<?= $pedido->getIdPedido(); ?>" class="form-label">Comentário:</label>
            <textarea class="form-control" id="comentario-<?= $pedido->getIdPedido(); ?>" name="comentario" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
    </form>
</div>




                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
    function toggleAvaliacao(button) {
        const avaliacaoDiv = button.parentElement.nextElementSibling;
        if (avaliacaoDiv.style.display === "none") {
            avaliacaoDiv.style.display = "block";
            button.textContent = "Cancelar Avaliação";
        } else {
            avaliacaoDiv.style.display = "none";
            button.textContent = "Avaliar";
        }
    }
</script>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>