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

function exibirTabelaPedidos($statusArray, $dados)
{
?>
    <table class="table table-bordered m-3">
        <thead>
            <tr>
                <th scope="col">Numero do Pedido</th>
                <th>Nome do Cliente</th>
                <th>Data</th>
                <th>Forma de Pagamento</th>
                <th>Status</th>
                <th>Endereço</th>
                <th>Doces</th>
                <th>Valor Total</th>
                <th>Nome do Comprovante</th>
                <th>Comprovante</th>
                <th>Avaliação</th>
                <th>Alterar Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($dados['listaPedidos'] as $pedido) {
                if (in_array($pedido->getStatus(), $statusArray)) {
            ?>
                    <tr>
                        <td><?php echo $pedido->getIdPedido(); ?></td>
                        <td><?php echo $pedido->getUsuario()->getNome(); ?></td>
                        <td>
                            <?php
                            $horario = $pedido->getHorario();
                            if ($horario instanceof DateTime) {
                                echo $horario->format('d/m/Y H:i:s');
                            } else {
                                echo date('d/m/Y H:i:s', strtotime($horario));
                            }
                            ?>
                        </td>
                        <td><?php echo $pedido->getFormaPagamento(); ?></td>
                        <td><?php echo $pedido->getStatus(); ?></td>
                        <td>
                            <?php
                            if ($pedido->getEndereco()) {
                                echo $pedido->getEndereco()->getNomeLogradouro() . ", ";
                                echo $pedido->getEndereco()->getNumero() ;
                                echo $pedido->getEndereco()->getBairro();
                            } else {
                                echo "Não informado";
                            }
                            ?>
                        </td>
                        <td>
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
                        </td>
                        <td>R$ <?php echo number_format($valorTotalPedido, 2, ',', '.'); ?></td>
                        <td><?php echo $pedidoDoce->getNomeComprovante(); ?></td>
                        <td>
                            <img src="<?php echo URL_ARQUIVOS . "/" . $pedidoDoce->getComprovante(); ?>" class="card-img-top" alt="Imagem do comprovante" style="height: 300px; width:100%; object-fit: cover;">
                        </td>
                        <td><?php echo $pedido->getAvaliacao(); ?></td>
                        <td>
                            <form method='POST' action='<?php echo BASEURL . "/controller/PedidoController.php?action=alterarStatus"; ?> '>
                                <input type='hidden' name='idPedido' value='<?php echo $pedido->getIdPedido(); ?>'>
                                <div class='form-group'>
                                    <select class='form-control form-control-lg' style='width:190px;' name='novoStatus' required>
                                        <?php
                                        $statusOptions = [
                                            Status::RECEBIDO,
                                            Status::PREPARANDO,
                                            Status::PRONTO,
                                            Status::PAGO,
                                            Status::ENTREGUE,
                                            Status::CANCELADO
                                        ];
                                        $statusAtual = $pedido->getStatus();
                                        foreach ($statusOptions as $status) {
                                            $selected = ($status === $statusAtual) ? 'selected' : '';
                                            echo "<option value='$status' $selected>$status</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button class='btn btn-primary m-2' onclick="return confirm('Você tem certeza que deseja alterar o status deste pedido?');" type='submit'>Alterar Status</button>
                            </form>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
<?php
}

?>

<h3 class="text-center font-weight-light" style="font-family:caveat; margin-top: 20px;">Pedidos do Confeiteiro</h3>

<div style="margin: 0 auto; width: 80%; display: flex; justify-content: center; align-items: center; flex-direction: column; ">
    <div class="row" style="margin-top: 20px; font-family: montserrat;">

        <h4 class="mb-3 text-success">Pedidos Recebidos</h4>
        <?php exibirTabelaPedidos([Status::RECEBIDO], $dados); ?>

        <h4 class="mb-3 text-danger">Pedidos em Andamento</h4>
        <?php exibirTabelaPedidos([Status::PREPARANDO, Status::PRONTO, Status::PAGO], $dados); ?>

        <h4 class="mb-3 text-muted">Pedidos Finalizados e Cancelados</h4>
        <?php exibirTabelaPedidos([Status::ENTREGUE, Status::CANCELADO], $dados); ?>

    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>