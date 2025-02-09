<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<div class="container mt-5">
    <h3 class="text-center" style="font-family:caveat;">
        <?php if ($dados['id'] == 0) echo "Cadastre-se aqui";
        else echo "Editar Perfil"; ?>
    </h3>

    <div class="row" style="margin-top: 10px; font-family:montserrat;">
        <div class="col-8 mx-auto"> <!-- Aumentei a largura da coluna -->
            <form id="frmUsuario" method="POST" action="<?= BASEURL ?>/controller/UsuarioController.php?action=save"><br>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtNome" class="font-weight-bold">Nome:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtNome" name="nome"
                            maxlength="70" placeholder="Informe seu nome"
                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                    </div>


                    <div class="form-group col-6">
                        <label for="txtCpf" class="font-weight-bold">CPF:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtCpf" name="cpf"
                            maxlength="14" placeholder="Informe seu CPF"
                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtTelefone" class="font-weight-bold">Telefone:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtTelefone" name="telefone"
                            maxlength="15" placeholder="Informe seu telefone"
                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getTelefone() : ''); ?>" />
                    </div>

                    <div class="form-group col-6">
                        <label for="txtDataNascimento" class="font-weight-bold">Data de Nascimento:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="date" id="txtDataNascimento" name="dataNascimento"
                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getDataNascimento() : ''); ?>" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtLogin" class="font-weight-bold">Login:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="text" id="txtLogin" name="login"
                            maxlength="200" placeholder="Informe seu e-mail"
                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getLogin() : ''); ?>" />
                    </div>
            
                    <div class="form-group col-6">
                        <label for="txtSenha" class="font-weight-bold">Senha:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="password" id="txtPassword" name="senha"
                            maxlength="200" placeholder="Informe a senha"
                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="txtConfSenha" class="font-weight-bold">Confirmação da senha:</label> <!-- Negrito -->
                        <input class="form-control form-control-lg" type="password" id="txtConfSenha" name="conf_senha"
                            maxlength="200" placeholder="Confirme a senha"
                            value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : ''; ?>" />
                    </div>
              
                    <div class="form-group col-6" style="margin:auto; margin-top:35px;" >
                        <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />
                        <button style="width: 360px; background-color:#C30E59; color:aliceblue; font-weight:bolder;" type="submit" class="btn btn-dark">Cadastrar</button>&nbsp;
                    </div>
                </div>

                <div>
                    <img class="imgCadastro"  src="<?= BASEURL ?>/view/img/imgCadastro.png" alt="Imagem aqui">
                </div>

            </form>
        </div><br>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script src="<?= BASEURL ?>/view/usuario/form.js"></script>


    <!-- <div class="row" style="margin-top: 30px;">
        <div class="col-12">
            <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/HomeController.php?action=home">Voltar</a>
        </div>
    </div> -->
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>