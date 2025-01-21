<?php
# Nome do arquivo: pedido/listPedidos.php
# Objetivo: Interface para listagem dos pedidos do confeiteiro

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/pedido/historico.css">

<div class="container mt-5" style="font-family: montserrat;">
    <?php if (!empty($dados['lista'])): ?>
        <h2 class="text-center mb-4" style="font-family:caveat; color:#C30E59;">Meus Pedidos</h2>
    <?php else: ?>
        <h3 class="text-center font-weight-bold" style="font-family: 'Caveat', cursive;">
            <p class="card-text mb-2"> <a href="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=listLojas" class="text-decoration-none; font-weight: normal;">Faça seu primeiro pedido!</a>
        </h3>
    <?php endif; ?>
    <div class="row">
        <?php foreach ($dados['lista'] as $pedido): ?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header ">
                        <strong style="font-family:caveat; font-size:25px">
                            Pedido #<?= $pedido->getIdPedido(); ?> : <?php
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
                        <p class="card-text mb-2"> <a href="<?= BASEURL ?>/controller/PedidoController.php?action=acompanharStatus&idPedido=<?= $pedido->getIdPedido(); ?>" class="text-decoration-none; font-weight: normal;">Andamento do Pedido</a>
                        <p class="card-text mb-2"><strong>Status:</strong> <?= $pedido->getStatus(); ?>
                        </p>

                        <p class="card-text">
                            <strong>Forma de Pagamento:</strong> <?= $pedido->getFormaPagamento(); ?>
                        </p>
                        <p class="card-text">
                            <strong>Endereço:</strong>
                            <?php
                            if ($pedido->getEndereco()) {
                                echo $pedido->getEndereco()->getEnderecoCompleto();
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
                            <?php if ($pedido->getAvaliacaoObj()): ?>
                                <p><strong>Avaliação:</strong>
                                    <?php
                                    $nota = $pedido->getAvaliacaoObj()->getNota();
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $nota) {
                                            echo '<i class="fas fa-star text-warning "></i>';
                                        } else {
                                            echo '<i class="far fa-star text-warning"></i>';
                                        }
                                    }
                                    ?>
                                </p>
                                <p><strong>Comentário:</strong> <?= htmlspecialchars($pedido->getAvaliacaoObj()->getComentario()); ?></p>

                            <?php else: ?>
                                <?php if ($pedido->getStatus() == 'ENTREGUE'): ?>
                                    <button class="btn btn-info" onclick="toggleAvaliacao(this, <?= $pedido->getIdPedido() ?>)">Avaliar</button>
                                <?php endif; ?>
                                <div id="msgErro<?= $pedido->getIdPedido() ?>" class="alert alert-danger" style="display: none;"></div>
                            <?php endif; ?>
                        </div>

                        <?php if (! $pedido->getAvaliacaoObj()): ?>
                            <div class="avaliacao mt-3" style="display: none;">
                                <form action="<?= BASEURL ?>/controller/AvaliacaoController.php?action=save" method="POST"
                                    onsubmit="return validarAvaliacao(<?= $pedido->getIdPedido() ?>);">
                                    <input type="hidden" name="idPedido" value="<?= htmlspecialchars($pedido->getIdPedido()); ?>">

                                    <div class="mb-3">
                                        <label for="avaliacao" class="font-weight-bold">Avaliação (1 a 5 estrelas):</label>
                                        <div class="rating">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" id="star-<?= $i; ?>-<?= $pedido->getIdPedido() ?>" name="avaliacao" value="<?= $i; ?>">
                                                <label for="star-<?= $i; ?>-<?= $pedido->getIdPedido() ?>" title="<?= $i; ?> estrelas">★</label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="comentario-<?= $pedido->getIdPedido() ?>" class="font-weight-bold">Comentário:</label>
                                        <textarea class="form-control form-control-lg" id="comentario<?= $pedido->getIdPedido() ?>" name="comentario" rows="3"
                                            placeholder="Adicione seu comentário aqui..."><?= isset($dados['avaliacao']) ? htmlspecialchars($dados['avaliacao']->getComentario()) : ''; ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                                </form>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



<script>
    function toggleAvaliacao(button, idPedido) {
        const avaliacaoDiv = button.parentElement.nextElementSibling;

        if (avaliacaoDiv.style.display === "none") {
            avaliacaoDiv.style.display = "block";
            button.textContent = "Cancelar Avaliação";
        } else {
            avaliacaoDiv.style.display = "none";
            button.textContent = "Avaliar";

            var divMsgErro = document.getElementById("msgErro" + idPedido);
            divMsgErro.style.display = "none";
        }
    }

    function validarAvaliacao(idPedido) {
        var msgErro = "";

        if (!notaPreenchida(idPedido))
            msgErro += "<br>Informe uma nota de 1 a 5!";

        var comentario = document.getElementById("comentario" + idPedido).value;
        if (comentario.trim() == '')
            msgErro += "<br>Informe o comentário!";

        if (msgErro) {
            var divMsgErro = document.getElementById("msgErro" + idPedido);
            divMsgErro.innerHTML = msgErro.replace("<br>", "");
            divMsgErro.style.display = "block";
            return false;
        } else
            return true;
    }

    function notaPreenchida(idPedido) {
        for (var i = 1; i <= 5; i++) {
            var estrela = document.getElementById("star-" + i + "-" + idPedido);
            if (estrela.checked)
                return true;
        }

        return false;
    }
</script>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>