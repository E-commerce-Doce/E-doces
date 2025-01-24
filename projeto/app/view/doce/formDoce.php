<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-5">
    <h2 class="text-center" style="font-family: 'Caveat', cursive; font-size: 2.5rem; color: black;">
        <?php if ($dados['id'] == 0) echo "Inserir";
        else echo "Alterar"; ?> Doces
    </h2>

    <div class="row" style="margin-top: 10px; font-family: 'Montserrat', sans-serif;">
        <div class="col-md-8 mx-auto">
            <form id="frmDoce" method="POST" action="<?= BASEURL ?>/controller/DoceController.php?action=save" enctype="multipart/form-data" style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                <div class="form-group">
                    <label for="txtNome" class="font-weight-bold">Nome:</label>
                    <input class="form-control form-control-lg" type="text" id="txtNome" name="nomeDoce"
                        maxlength="70" placeholder="Informe seu nome:"
                        value="<?php echo (isset($dados["doce"]) ? $dados["doce"]->getNomeDoce() : ''); ?>" required />
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txtDescricao" class="font-weight-bold">Descrição:</label>
                        <textarea class="form-control form-control-lg" id="txtDescricao" name="descricao"
                            maxlength="255" placeholder="Informe a descrição:" rows="5" required><?php echo (isset($dados['doce']) ? $dados['doce']->getDescricao() : ''); ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="txtIngredientes" class="font-weight-bold">Ingredientes:</label>
                        <textarea class="form-control form-control-lg" id="txtIngredientes" name="ingredientes"
                            maxlength="255" placeholder="Informe os ingredientes:" rows="5" required><?php echo (isset($dados['doce']) ? $dados['doce']->getIngredientes() : ''); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="txtCaminhoImagem" class="font-weight-bold">Foto:</label>
                    <input type="file" class="form-control form-control-lg"
                        id="txtCaminhoImagem" name="caminhoImagem" accept="image/*" />
                </div>

                <?php if (isset($dados['doce']) && $dados['doce']->getCaminhoImagem()): ?>
                    <div class="mb-3 text-center">
                        <img src="<?php echo URL_ARQUIVOS . '/' . $dados['doce']->getCaminhoImagem(); ?>"
                            alt="Imagem do Doce" style="max-height: 180px; max-width: 100%; border-radius: 5px;"/>
                        <input type="hidden" name="caminhoImagemAtual" value="<?= $dados['doce']->getCaminhoImagem() ?>" />
                    </div>
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group col-md-6 ">
                        <label for="txtValor" class="font-weight-bold">Valor:</label>
                        <input class="form-control form-control-lg" type="number" id="txtValor" name="valor"
                            step="0.01" placeholder="Informe o valor:"
                            value="<?php echo (isset($dados['doce']) ? $dados['doce']->getValor() : ''); ?>" required />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="selTipoDoce" class="font-weight-bold">Tipo Doce:</label>
                        <select class="form-control form-control-lg" name="idTipoDoce" id="selTipoDoce" required>
                            <option value="">Selecione o tipo do doce:</option>
                            <?php foreach ($dados["tiposDoces"] as $tipo): ?>
                                <option value="<?= $tipo->getIdTipoDoce() ?>"
                                    <?php if (isset($dados["doce"]) && $dados["doce"]->getTipoDoce()->getIdTipoDoce() == $tipo->getIdTipoDoce()) echo "selected"; ?>>
                                    <?= $tipo->getDescricao() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <div class="d-flex justify-content-between mt-4 ">
                    <button type="submit" class="btn btn-primary btn-lg ml-2" style="background-color: #C30E59; border: none;">Salvar</button>
                    <a class="btn btn-secondary btn-lg ml-2" href="<?= BASEURL ?>/controller/DoceController.php?action=list">Cancelar</a>
                </div>

                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />
            </form>
        </div>
    </div>

</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>























