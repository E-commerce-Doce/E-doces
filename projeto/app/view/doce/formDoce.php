<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if ($dados['id'] == 0) echo "Inserir";
    else echo "Alterar"; ?>
    Doces
</h3>

<div class="container">

    <div class="row" style="margin-top: 10px;">

        <div class="col-6">
            <form id="frmDoce" method="POST"
                action="<?= BASEURL ?>/controller/DoceController.php?action=save" enctype="multipart/form-data">


                <div class="form-group">
                    <label for="txtNome">Nome:</label>
                    <input class="form-control" type="text" id="txtNome" name="nomeDoce"
                        maxlength="70" placeholder="Informe seu nome:"
                        value="<?php echo (isset($dados["doce"]) ? $dados["doce"]->getNomeDoce() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtDescricao">Descrição:</label>
                    <input class="form-control" type="text" id="txtDescricao" name="descricao"
                        maxlength="255" placeholder="Informe a descrição:"
                        value="<?php echo (isset($dados['doce']) ? $dados['doce']->getDescricao() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtCaminhoImagem">Foto:</label>
                    <input type="file" class="form-control"
                        id="txtCaminhoImagem" name="caminhoImagem"
                        accept="image/*" />
                </div>

                <?php if (isset($dados['doce']) && $dados['doce']->getCaminhoImagem()): ?>
                     <img src="<?php echo URL_ARQUIVOS . '/' . $dados['doce']->getCaminhoImagem(); ?>"
                            alt="Imagem do Doce" style="max-height: 180px; max-width: 100%;" />

                    <input type="hidden" name="caminhoImagemAtual" value="<?= $dados['doce']->getCaminhoImagem() ?>" />
                <?php endif; ?>

                <div class="form-group mt-2">
                    <label for="txtValor">Valor:</label>
                    <input class="form-control" type="number" id="txtValor" name="valor"
                        step="0.01" placeholder="Informe o valor:"
                        value="<?php echo (isset($dados['doce']) ? $dados['doce']->getValor() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtIngredientes">Ingredientes:</label>
                    <input class="form-control" type="text" id="txtIngredientes" name="ingredientes"
                        maxlength="255" placeholder="Informe os ingredientes:"
                        value="<?php echo (isset($dados['doce']) ? $dados['doce']->getIngredientes() : ''); ?>" />
                </div>


                <div class="form-group">
                    <label>Tipo Doce:</label>
                    <select class="form-control" name="idTipoDoce" id="selTipoDoce">
                        <option value="">Selecione o tipo do doce:</option>
                        <?php foreach ($dados["tiposDoces"] as $tipo): ?>
                            <option value="<?= $tipo->getIdTipoDoce() ?>"
                                <?php
                                if (isset($dados["doce"]) && $dados["doce"]->getTipoDoce()->getIdTipoDoce() == $tipo->getIdTipoDoce())
                                    echo "selected";
                                ?>>
                                <?= $tipo->getDescricao() ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
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
                href="<?= BASEURL ?>/controller/DoceController.php?action=list">Voltar</a>
        </div>
    </div>

</div>

</div>


</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>