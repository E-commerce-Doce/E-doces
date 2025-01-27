<?php
#Nome do arquivo: pedido/pagamento.php
#Objetivo: interface para realizar o pagamento do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
    .tudo{
        background-color: #fff;
        border-radius: 20px;
    }

    .row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .col-lg-6 {
        display: flex;
        flex-direction: column;
        align-items: center; 
        text-align: center;
    }

    .col-lg-6 img {
        max-width: 80%;
        height: auto;
        margin-bottom: 20px; 
    }

    .formulario {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .form-group label {
        display: block;
        text-align: left; 
        margin-bottom: 5px;
    }

    .bot{
        width: 49%;
    }

    h3, h5 {
        text-align: left;
    }

    /* Ajustes para telas menores */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }

        .col-lg-6 {
            width: 100%;
            margin-bottom: 20px; /* Espaçamento entre as colunas na versão mobile */
        }
    }
</style>

<div class="container mt-5 tudo">
    <div class="row">
        <!-- Info Pagamento -->
        <div class="col-lg-6 mb-4 mt-5" style="font-family: montserrat;">
            <?php if (isset($dados["pagamento"])) : ?>
                <?php $pedido = $dados["pagamento"]; ?>
                <h2 style="font-family: Caveat;">QR Code para Pagamento</h2><br>
                <h5><strong>Valor Total:</strong> R$
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
                </h5>
                
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
        <div class="col-lg-6 formulario" style="font-family: 'Montserrat', sans-serif;">
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

                <div class="botão">
                <button type="submit" class="btn btn-primary bot">Salvar</button>
                <a class="btn btn-secondary bot" href="<?= BASEURL ?>/controller/PedidoController.php?action=acompanharStatus&idPedido=<?=$dados['pagamento']->getIdPedido();?>">Cancelar</a>
                </div>
                
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
