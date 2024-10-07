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
                action="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=save">

                <div class="form-group">
                    <label for="txtNomeLoja" class="font-weight-bold">Nome da Loja:</label> 
                    <input class="form-control form-control-lg" type="text" id="txtNomeLoja" name="nomeLoja" 
                        maxlength="70" placeholder="Informe o nome da loja:"
                        value="<?php echo (isset($dados["confeiteiro"]) ? $dados["confeiteiro"]->getNomeLoja() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtMei" class="font-weight-bold">MEI:</label> 
                    <input class="form-control form-control-lg" type="text" id="txtMei" name="mei" 
                        maxlength="70" placeholder="Digite seu MEI"
                        value="<?php echo (isset($dados["confeiteiro"]) ? $dados["confeiteiro"]->getMei() : ''); ?>" />
                </div>

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



