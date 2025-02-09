<?php
#Nome do arquivo: doce/listEndereco.php
#Objetivo: interface para listagem dos enderecos do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-5">
    <h2 class="text-center" style="font-family:caveat;">
        <?php if ($dados['id'] == 0) echo "Cadastro de Endereço";
        else echo "Editar Endereço"; ?>
    </h2>

    <div class="row" style="margin-top: 10px; font-family:montserrat;">
        <div class="col-8 mx-auto"> <!-- Aumentei a largura da coluna -->
            <form id="frmendereco" method="POST" action="<?= BASEURL ?>/controller/EnderecoController.php?action=save" enctype="multipart/form-data" style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        

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
                            maxlength="9" placeholder="Informe seu Cep"
                            value="<?php echo (isset($dados["endereco"]) ? $dados["endereco"]->getCep() : ''); ?>" />
                    </div>
                
                    <div class="form-group col-6">
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
                <a class="btn btn-secondary ml-2" href="<?= BASEURL ?>/controller/EnderecoController.php?action=list">Cancelar</a>
                </form>
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

<script>
    document.getElementById('txtCep').addEventListener('input', function (e) {
    let cep = e.target.value;
    cep = cep.replace(/\D/g, ""); // Remove tudo que não for dígito
    cep = cep.replace(/(\d{4})(\d{1,3})$/, "$1-$2"); // Adiciona o traço
    e.target.value = cep; // Atualiza o valor do campo
});
</script>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>