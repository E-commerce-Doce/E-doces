<?php
#Nome do arquivo: pedido/pagamento.php
#Objetivo: interface para realizar o pagamento do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>


<div class="container mt-5">
    <div class="row" style="margin-top: 10px; font-family:montserrat;">

    <div class="info-pagamento">

    </div>
        <div class="col-8 mx-auto">
            <form id="frmPagamento" method="POST"
                action="<?= BASEURL ?>/controller/PedidoController.php?action=realizarPagamento" enctype="multipart/form-data">

                
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

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>
</div>
<?php
require_once(__DIR__ . "/../include/footer2.php");
?>