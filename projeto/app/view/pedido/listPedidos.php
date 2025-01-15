<?php
# Nome do arquivo: pedido/listPedidos.php
# Objetivo: Interface para listagem dos pedidos do confeiteiro

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['msgErro'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['msgErro'] . "</div>";
    unset($_SESSION['msgErro']);
}

if (isset($_SESSION['msgSucesso'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['msgSucesso'] . "</div>";
    unset($_SESSION['msgSucesso']);
}

function exibirListaPedidos($statusArray, $dados)
{
?>
    <ul class="list-group m-3">
        <?php
        foreach ($dados['listaPedidos'] as $pedido) {
            if (in_array($pedido->getStatus(), $statusArray)) {
                $valorTotalPedido = 0;
                $pedidoDoces = $pedido->getPedidosDoces();
        ?>
                <li class="list-group-item mb-3">
                    <p><strong>Pedido nº:</strong> <?php echo $pedido->getIdPedido(); ?></p>
                    <p><strong>Cliente:</strong> <?php echo $pedido->getUsuario()->getNome(); ?></p>
                    <p><strong>Data:</strong>
                        <?php
                        $horario = $pedido->getHorario();
                        if ($horario instanceof DateTime) {
                            echo $horario->format('d/m/Y H:i:s');
                        } else {
                            echo date('d/m/Y H:i:s', strtotime($horario));
                        }
                        ?>
                    </p>
                    <p><strong>Status:</strong> <?php echo $pedido->getStatus(); ?></p>

                    <form method='POST' action='<?php echo BASEURL . "/controller/PedidoController.php?action=alterarStatus"; ?> '>
                        <input type='hidden' name='idPedido' value='<?php echo $pedido->getIdPedido(); ?>'>
                        <div class='form-group'>
                            <select class='form-control form-control-lg' name='novoStatus' required>
                                <?php
                                $statusOptions = [
                                    Status::RECEBIDO, Status::PREPARANDO, Status::PRONTO,
                                    Status::PAGO, Status::ENTREGUE, Status::CANCELADO
                                ];
                                $statusAtual = $pedido->getStatus();
                                foreach ($statusOptions as $status) {
                                    $selected = ($status === $statusAtual) ? 'selected' : '';
                                    echo "<option value='$status' $selected>$status</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button class='btn btn-primary m-1 w-100' onclick="return confirm('Você tem certeza que deseja alterar o status deste pedido?');" type='submit'>Alterar Status</button>
                    
                    </form>
                        <button class="btn btn-info m-1 w-100 detalhes-btn" data-target="#divDescricao<?= $pedido->getIdPedido() ?>">Ver Detalhes</button>
                    
                    <div id="divDescricao<?= $pedido->getIdPedido() ?>" class="detalhes" style="display: none;">
                        <div class="divAva">
                            <p class="mt-4"><strong>Doces:</strong>
                            <?php
                            $valorTotalPedido = 0;
                            if (!empty($pedidoDoces)) {
                                foreach ($pedidoDoces as $pedidoDoce) {
                                    $doce = $pedidoDoce->getDoce();
                                    if ($doce) {
                                        $valorItem = $pedidoDoce->getQuantidade() * $pedidoDoce->getValorUnitario();
                                        $valorTotalPedido += $valorItem;
                            ?>
                                        <?= $doce->getNomeDoce(); ?> - <?= $pedidoDoce->getQuantidade(); ?> unidades
                                            (R$ <?= number_format($pedidoDoce->getValorUnitario(), 2, ',', '.'); ?> cada)</p>
                                    <?php
                                    } else {
                                        echo "<p>Doce não encontrado</p>";
                                    }
                                }
                            } else {
                                echo "<p>Sem doces associados</p>";
                            }
                            ?>
                            <p><strong>Valor Total:</strong> R$ <?php echo number_format($valorTotalPedido, 2, ',', '.'); ?></p>
                            <p><strong>Forma de Pagamento:</strong> <span><?= $pedido->getFormaPagamento(); ?></span></p>
                            <p><strong>Endereço:</strong> <span>
                                    <?php
                                    if ($pedido->getEndereco()) {
                                        echo $pedido->getEndereco()->getNomeLogradouro() . ", ";
                                        echo $pedido->getEndereco()->getNumero() . " - ";
                                        echo $pedido->getEndereco()->getBairro();
                                    } else {
                                        echo "Não informado";
                                    }
                                    ?>
                                </span></p>
                            <p><strong>Nome do Comprovante:</strong> <span><?= $pedidoDoce->getNomeComprovante(); ?></span></p>
                            <p><strong>Comprovante:</strong><br>
                                <img src="<?= URL_ARQUIVOS . "/" . $pedidoDoce->getComprovante(); ?>" class="card-img-top" alt="Imagem do comprovante" style="height: 300px; width:100%; object-fit: cover;">
                            </p>
                           
                        </div>
                    </div>
                </li>
        <?php
            }
        }
        ?>
    </ul>
<?php
}
?>

<div class="container">
    <h1 class="text-center font-weight-light m-3" style="font-family:caveat; margin-top: 20px; color:#C30E59;"><strong>Pedidos</strong></h1>
    <div class="row" style="margin-top: 20px; font-family: montserrat;">
        <div class="col-md-4 mb-4">
            <h4 class="mb-3 ml-4 text-black">Pedidos Recebidos</h4>
            <?php exibirListaPedidos([Status::RECEBIDO], $dados); ?>
        </div>
        <div class="col-md-4 mb-4">
            <h4 class="mb-3 ml-4 text-black">Pedidos em Andamento</h4>
            <?php exibirListaPedidos([Status::PREPARANDO, Status::PRONTO, Status::PAGO], $dados); ?>
        </div>
        <div class="col-md-4 mb-4">
            <h4 class="mb-3 ml-4 text-black">Pedidos Final. e Cancel.</h4>
            <?php exibirListaPedidos([Status::ENTREGUE, Status::CANCELADO], $dados); ?>
        </div>
    </div>
</div>

<script>
    const detalhesBotoes = document.querySelectorAll('.detalhes-btn');

    detalhesBotoes.forEach(botao => {
        botao.addEventListener('click', () => {
            const targetId = botao.dataset.target;
            const targetDiv = document.querySelector(targetId);
            if (targetDiv) {
                targetDiv.style.display = targetDiv.style.display === 'none' ? 'block' : 'none';
            }
        });
    });
</script>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>