<?php 
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once(__DIR__ . "/../include/header.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container" style="margin-top: 3%;">
    <div class="d-flex justify-content-between align-items-center">
        <a class="navbar-brand" style="color: #EA4961;" href="#">&nbsp; A'MEIs &nbsp;</a>
        <a class="btn" style="background-color: #9BB899; color: #fff;" href="<?= BASEURL . '/controller/UsuarioController.php?action=create' ?>">Cadastra-se</a>
    </div>

    <div class="row" style="margin-top: 3%;">
        <div class="col-6">
            <h3 style="margin-left:4%;" class="estilo2"> Login </h3>
            <div class="col-7">
                <?php include_once(__DIR__ . "/../include/msg.php") ?>
            </div>

            <h4 style="margin-left:5%; margin-top: 5%; font-family:caveat" class="estilo">Entre e encontre os melhores doces!</h4>
            <br><br>
            <!-- Formulário de login -->
            <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                <div class="form-group estilo2">
                    <label for="txtLogin" class="fw-bold"><b>Login</b></label>
                    <br>
                    <input type="text" class="form-control" name="login" id="txtLogin"
                        maxlength="15" placeholder="Informe o login"
                        value="<?php echo isset($dados['login']) ? $dados['login'] : '' ?>" />
                </div>

                <div>
                    <img class="imgLogin" src="\ProjetoIntegrador\E-doces\projeto\arquivos\imgLogin.png" alt="Descricao img">
                </div>

                <div class="form-group estilo2">
                    <label for="txtSenha" class="fw-bold"><b>Senha</b></label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="senha" id="txtSenha"
                            maxlength="15" placeholder="Informe a senha"
                            value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <script>
                    const togglePassword = document.getElementById('togglePassword');
                    const password = document.getElementById('txtSenha');

                    togglePassword.addEventListener('click', function (e) {
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                        this.querySelector('i').classList.toggle('fa-eye');
                        this.querySelector('i').classList.toggle('fa-eye-slash');
                    });
                </script>

                <br>
                <button type="submit" style="background-color:#9BB899; color:aliceblue;" class="btn estilo2">Logar</button>
            </form>
        </div>
    </div>
</div>
