<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-5">
    <h3 class="text-center" style="font-family:caveat;">
        <?php if ($dados['id'] == 0) echo "Inserir";
        else echo "Alterar"; ?> Doces
    </h3>

    <div class="row" style="margin-top: 10px; font-family:montserrat;">
        <div class="col-8 mx-auto"> <!-- Increased the width of the column -->
            <form id="frmDoce" method="POST" action="<?= BASEURL ?>/controller/DoceController.php?action=save" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtNome" class="font-weight-bold">Nome:</label>
                    <input class="form-control form-control-lg" type="text" id="txtNome" name="nomeDoce"
                        maxlength="70" placeholder="Informe seu nome:"
                        value="<?php echo (isset($dados["doce"]) ? $dados["doce"]->getNomeDoce() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtDescricao" class="font-weight-bold">Descrição:</label>
                    <input class="form-control form-control-lg" type="text" id="txtDescricao" name="descricao"
                        maxlength="255" placeholder="Informe a descrição:"
                        value="<?php echo (isset($dados['doce']) ? $dados['doce']->getDescricao() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtCaminhoImagem" class="font-weight-bold">Foto:</label>
                    <input type="file" class="form-control form-control-lg"
                        id="txtCaminhoImagem" name="caminhoImagem" accept="image/*" />
                </div>

                <?php if (isset($dados['doce']) && $dados['doce']->getCaminhoImagem()): ?>
                    <img src="<?php echo URL_ARQUIVOS . '/' . $dados['doce']->getCaminhoImagem(); ?>"
                        alt="Imagem do Doce" style="max-height: 180px; max-width: 100%;" />
                    <input type="hidden" name="caminhoImagemAtual" value="<?= $dados['doce']->getCaminhoImagem() ?>" />
                <?php endif; ?>

                <div class="form-group mt-2">
                    <label for="txtValor" class="font-weight-bold">Valor:</label>
                    <input class="form-control form-control-lg" type="number" id="txtValor" name="valor"
                        step="0.01" placeholder="Informe o valor:"
                        value="<?php echo (isset($dados['doce']) ? $dados['doce']->getValor() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label for="txtIngredientes" class="font-weight-bold">Ingredientes:</label>
                    <input class="form-control form-control-lg" type="text" id="txtIngredientes" name="ingredientes"
                        maxlength="255" placeholder="Informe os ingredientes:"
                        value="<?php echo (isset($dados['doce']) ? $dados['doce']->getIngredientes() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tipo Doce:</label>
                    <select class="form-control form-control-lg" name="idTipoDoce" id="selTipoDoce">
                        <option value="">Selecione o tipo do doce:</option>
                        <?php foreach ($dados["tiposDoces"] as $tipo): ?>
                            <option value="<?= $tipo->getIdTipoDoce() ?>"
                                <?php if (isset($dados["doce"]) && $dados["doce"]->getTipoDoce()->getIdTipoDoce() == $tipo->getIdTipoDoce()) echo "selected"; ?>>
                                <?= $tipo->getDescricao() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

                <button type="submit" class="btn btn-primary">Gravar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-12">
                        <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/DoceController.php?action=list">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

</div>

<!-- <?php
// require_once(__DIR__ . "/../include/footer.php");
?> -->