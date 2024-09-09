<?php
#Nome do arquivo: confeiteiro/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    Usuário
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmConfeiteiro" method="POST" 
                action="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=save" >

                <div class="form-group">
                    <label for="txtNomeLoja">Nome da Loja:</label>
                    <input class="form-control" type="text" id="txtNomeLoja" name="nomeLoja" 
                        maxlength="70" placeholder="Informe o nome da loja:"
                        value="<?php echo (isset($dados[""]) ? $dados["confeiteiro"]->getNomeLoja() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtMei">MEI:</label>
                    <input class="form-control" type="text" id="txtMei" name="mei" 
                        maxlength="70" placeholder="Digite seu MEI"
                        value="<?php echo (isset($dados["confeiteiro"]) ? $dados["confeiteiro"]->getMei() : ''); ?>" />
                </div>

                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />

                <button type="submit" class="btn">Gravar</button>
                <button type="reset" class="btn">Limpar</button>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
        <a class="btn" 
                href="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>