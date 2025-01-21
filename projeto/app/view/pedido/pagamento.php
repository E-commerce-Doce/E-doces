<?php
#Nome do arquivo: pedido/pagamento.php
#Objetivo: interface para realizar o pagamento do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

     h3 {
        font-family: 'Caveat', cursive;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
    }
</style>

<div class="container mt-5">
    <div class="row" style="margin-top: 10px;">
        <!-- Info Pagamento -->
        <div class="col-lg-6 mb-4" style="font-family: 'Caveat', cursive;">
            <?php if (isset($dados["pagamento"])) : ?>
                <?php $pedido = $dados["pagamento"]; ?>
                <h3>Informações do Pedido: #<?php echo $pedido->getIdPedido(); ?></h3>
                <h2><strong>Valor Total:</strong> R$
                    <?php
                    $valorTotalPedido = 0; 
                    $pedidoDoces = $pedido->getPedidosDoces();// Inicializa o total
                    if (!empty($pedidoDoces)) {
                        foreach ($pedidoDoces as $pedidoDoce) {
                            $valorItem = $pedidoDoce->getQuantidade() * $pedidoDoce->getValorUnitario();
                            $valorTotalPedido += $valorItem; // Soma o valor total
                        }
                        echo number_format($valorTotalPedido, 2, ',', '.'); // Formata e exibe o valor total
                    } else {
                        echo "0,00"; // Caso não haja doces no pedido
                    }
                    ?>
                </h2>
                <h3>QR Code para Pagamento</h3>
                <?php if ($pedido->getConfeiteiro()->getQrCode()) : ?>
                    <img src="<?php echo URL_ARQUIVOS . "/" . $pedido->getConfeiteiro()->getQrCode(); ?>" alt="QR Code do Confeiteiro" class="img-fluid">
                <?php else : ?>
                    <p>QR Code não disponível.</p>
                <?php endif; ?>
            <?php else : ?>
                <p>Dados do pagamento não encontrados.</p>
            <?php endif; ?>
        </div>

        <!-- Formulário -->
        <div class="col-lg-6" style="font-family: 'Montserrat', sans-serif;">
            <form id="frmPagamento" method="POST" action="<?= BASEURL ?>/controller/PedidoController.php?action=realizarPagamento" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtNomeComprovante" class="font-weight-bold">Nome do Comprovante:</label>
                    <input class="form-control form-control-lg" type="text" id="txtNomeComprovante" name="nomeComprovante"
                        maxlength="70" placeholder="Informe o nome do Comprovante:"
                        value="<?php echo (isset($dados["pagamento"]) ? $dados["pagamento"]->getNomeComprovante() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtComprovante" class="font-weight-bold">Comprovante do PIX:</label>
                    <input type="file" class="form-control form-control-lg" id="txtComprovante" name="comprovanteImagem" accept="image/*" />
                </div>

                <?php if (isset($dados['pagamento']) && $dados['pagamento']->getComprovante()): ?>
                    <img src="<?php echo URL_ARQUIVOS . '/' . $dados['pagamento']->getComprovante(); ?>"
                        alt="Imagem do Comprovante" style="max-height: 180px; max-width: 100%;" />
                    <input type="hidden" name="comprovanteImagemAtual" value="<?= $dados['pagamento']->getComprovante() ?>" />
                <?php endif; ?>

                <input type="hidden" id="hddId" name="idPedido" value="<?= $dados['idPedido']; ?>">

                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>
        </div>

        <div class="col-12 mt-4">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>
