<?php
#Nome do arquivo: doce/listEndereco.php
#Objetivo: interface para listagem dos enderecos do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-5">
    <h3 class="text-center" style="font-family:caveat;">
        <?php if ($dados['id'] == 0) echo "Cadastro de Endereço";
        else echo "Editar Endereço"; ?>
    </h3>

    <div class="row" style="margin-top: 10px; font-family:montserrat;">
        <div class="col-8 mx-auto"> <!-- Aumentei a largura da coluna -->
            <form id="frmendereco" method="POST" action="<?= BASEURL ?>/controller/EnderecoController.php?action=save">

                <div class="form-group">
                    <label for="txtNomeLogradouro" class="font-weight-bold">Nome da Rua:</label> <!-- Negrito -->
                    <input class="form-control form-control-lg" type="text" id="txtNomeLogradouro" name="nomeLogradouro"
                        maxlength="70" placeholder="Informe o nome do logradouro"
                        value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getNomeLogradouro() : ''); ?>" />
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtCep" class="font-weight-bold">Cep:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtCep" name="cep"
                            maxlength="70" placeholder="Informe seu Cep"
                            value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getCep() : ''); ?>" />
                    </div>
                    <div class="form-group col-2" style="margin: auto; margin-top:35px;">
                        <button class=" btn btn-primary " type="submit">Procurar</button>

                    </div>
                    <div class="form-group col-4">
                        <label for="txtNumero" class="font-weight-bold">Numero:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtNumero" name="numero"
                            maxlength="70" placeholder="Numero"
                            value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getNumero() : ''); ?>" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtBairro" class="font-weight-bold">Bairro:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtBairro" name="bairro" placeholder="Informe o bairro"
                            value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getBairro() : ''); ?>" />
                    </div>

                    <div class="form-group col-6">
                        <label for="txtEstado" class="font-weight-bold">Estado:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtEstado" name="estado"
                            maxlength="200" placeholder="UF"
                            value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getEstado() : ''); ?>" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtCidade" class="font-weight-bold">Cidade:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtCidade" name="cidade"
                            maxlength="200" placeholder="Informe a Cidade"
                            value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getCidade() : ''); ?>" />
                    </div>

                    <div class="form-group col-6">
                        <label for="txtComplemento" class="font-weight-bold">Complemento</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtComplemento" name="complemento"
                            maxlength="200" placeholder="Confirme o complemento"
                            value="<?php echo (isset($dados['endereco']) ? $dados['endereco']->getComplemento() : ''); ?>" />.
                    </div>
                </div>


                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>