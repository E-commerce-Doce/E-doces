<?php
#Nome do arquivo: confeiteiro/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-5">
    <h3 class="text-center font-weight-bold" style="font-family:caveat; margin-top: 20px;">
        Alterar usuário para Confeiteiro
    </h3>


    <div class="row" style="margin-top: 10px; font-family:montserrat;">
        <div class="col-8 mx-auto"> <!-- Aumentei a largura da coluna e centralizei -->
            <form id="frmConfeiteiro" method="POST"
                action="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=save" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtNomeLoja" class="font-weight-bold">Nome da Loja:</label>
                    <input class="form-control form-control-lg" type="text" id="txtNomeLoja" name="nomeLoja"
                        maxlength="70" placeholder="Informe o nome da loja:"
                        value="<?php echo (isset($dados["confeiteiro"]) ? $dados["confeiteiro"]->getNomeLoja() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtMei" class="font-weight-bold">MEI:</label>
                    <input class="form-control form-control-lg" type="text" id="txtMei" name="mei"
                        maxlength="18" placeholder="Digite seu MEI"
                        value="<?php echo (isset($dados["confeiteiro"]) ? $dados["confeiteiro"]->getMei() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtQrCode" class="font-weight-bold">QrCode do PIX:</label>
                    <input type="file" class="form-control form-control-lg" id="txtQrCode" name="qrCodeImagem" accept="image/*" />
                </div>

                <?php if (isset($dados['confeiteiro']) && $dados['confeiteiro']->getQrCode()): ?>
                    <img src="<?php echo URL_ARQUIVOS . '/' . $dados['confeiteiro']->getQrCode(); ?>"
                        alt="Imagem do qrcode" style="max-height: 180px; max-width: 100%;" />
                    <input type="hidden" name="qrCodeImagemAtual" value="<?= $dados['confeiteiro']->getQrCode() ?>" />
                <?php endif; ?>

                <div class="form-group">
                    <label for="txtLogo" class="font-weight-bold">Logo da Loja:</label>
                    <input type="file" class="form-control form-control-lg" id="txtLogo" name="logoImagem" accept="image/*" />
                </div>

                <?php if (isset($dados['confeiteiro']) && $dados['confeiteiro']->getLogo()): ?>
                    <img src="<?php echo URL_ARQUIVOS . '/' . $dados['confeiteiro']->getLogo(); ?>"
                        alt="Imagem do Confeiteiro" style="max-height: 180px; max-width: 100%;" />
                    <input type="hidden" name="logoImagemAtual" value="<?= $dados['confeiteiro']->getLogo() ?>" />
                <?php endif; ?>




                <input type="hidden" id="hddId" name="idUsuario"
                    value="<?= $dados['idUsuario']; ?>" />

                <button type="submit" class="btn btn-primary">Alterar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <script>
        document.getElementById('txtMei').addEventListener('input', function(e) {
            let mei = e.target.value;
            // Aplica a formatação MEI (CNPJ)
            mei = mei.replace(/^(\d{2})(\d)/, "$1.$2"); // Adiciona o primeiro ponto
            mei = mei.replace(/^(\d{2}\.\d{3})(\d)/, "$1.$2"); // Adiciona o segundo ponto
            mei = mei.replace(/^(\d{2}\.\d{3}\.\d{3})(\d)/, "$1/$2"); // Adiciona a barra
            mei = mei.replace(/^(\d{2}\.\d{3}\.\d{3}\/\d{4})(\d)/, "$1-$2"); // Adiciona o traço

            e.target.value = mei; // Atualiza o valor do campo
        });
    </script>

    <?php
    require_once(__DIR__ . "/../include/footer2.php");
    ?>