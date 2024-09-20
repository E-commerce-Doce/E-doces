<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once(__DIR__ . "/../include/header.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">


<div class="container "  style="margin-top: 6%;">
<div class="d-flex justify-content-between align-items-center">
        <a class="navbar-brand" style="color: #EA4961;" href="#">&nbsp; A'MEIs &nbsp;</a>

        <a class="btn" style="background-color: #9BB899; color: #fff;" href="<?= BASEURL . '/controller/UsuarioController.php?action=create' ?>">Cadastra-se</a>
    </div>
   
    <div class="row" style="margin-top: 5%;">
        <div class="col-6">
            <h3 style="margin-left:10%;" class="estilo2">Login</h3>
           

            <h4 style="margin-left:5%; margin-top: 10%; font-family:caveat" class="estilo">Entre e encontre os melhores doces!</h4>
            <br>


            <!-- Formulário de login -->
            <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                <div class="form-group estilo2">
                    <label for="txtLogin">Login:</label>
                    <input type="text" class="form-control" name="login" id="txtLogin"
                        maxlength="15" placeholder="Informe o login"
                        value="<?php echo isset($dados['login']) ? $dados['login'] : '' ?>" />
                </div>

                <div class="form-group estilo2">
                    <label for="txtSenha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="txtSenha"
                        maxlength="15" placeholder="Informe a senha"
                        value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />
                </div>

                <button type="submit" style="background-color:#9BB899; color:aliceblue; " class="btn estilo2">Logar</button>
            </form>

      
               
        </div>

        <div class="col-4">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>