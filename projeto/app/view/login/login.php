<?php
# Nome do arquivo: login/login.php
# Objetivo: interface para login com visual moderno e amigável
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require_once(__DIR__ . "/../include/header.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/login/login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container" style="margin-top: 5%; font-family: 'Poppins', sans-serif;">
    <!-- Barra Superior -->
    <div class="d-flex justify-content-between align-items-center">
        <a class="navbar-brand" style="color: #C30E59; font-size: 1.8rem; font-weight: bold;" href="#">
            <img src="<?= BASEURL ?>/view/img/logo.png" alt="" style="width: 50px; margin-right: 10px;"> A'MEIs
        </a>
        <a class="btn" style="background-color: #C30E59; color: #fff; padding: 10px 20px; border-radius: 25px;" href="<?= BASEURL . '/controller/UsuarioController.php?action=create' ?>">Cadastre-se</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="row mt-5">
        <!-- Formulário de Login -->
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h2 style="color: #333; font-weight: bold;">Bem-vindo de volta!</h2>
            <p style="color: #777;">Entre na sua conta e descubra os melhores doces da sua região!</p>

            <div class="col-8">
                <?php include_once(__DIR__ . "/../include/msg.php") ?>
            </div>

            <form id="frmLogin" action="./LoginController.php?action=logon" method="POST" class="mt-4">
                <div class="form-group mb-4">
                    <label for="txtLogin" style="font-weight: bold; color: #333;">E-mail </label>
                    <input type="text" class="form-control" name="login" id="txtLogin" maxlength="200"
                        placeholder="Digite seu e-mail ou usuário"
                        value="<?php echo isset($dados['login']) ? $dados['login'] : '' ?>"
                        style="padding: 15px; border-radius: 10px; border: 1px solid #ddd;" required />
                </div>

                <div class="form-group mb-4">
                    <label for="txtSenha" style="font-weight: bold; color: #333;">Senha</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="senha" id="txtSenha" maxlength="200"
                            placeholder="Digite sua senha"
                            style="padding: 15px; border-radius: 10px; border: 1px solid #ddd;" required />
                        <div class="input-group-append">
                            <span class="input-group-text bg-light" id="togglePassword" style="cursor: pointer; border-radius: 10px;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                  
                </div>

                <button type="submit" class="btn w-100 mt-3"
                    style="background-color: #C30E59; color: white; padding: 15px; border-radius: 25px; font-weight: bold;">
                    Entrar
                </button>
            </form>
        </div>

        <!-- Imagem Ilustrativa -->
        <div class="col-md-6 text-center d-none d-md-block">
            <img src="<?= BASEURL ?>/view/img/imgLogin.jpg" alt="Doces deliciosos" class="img-fluid"
                style="max-width: 100%; height: auto; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); 
               width: 85%; max-height: 700px;">
        </div>

    </div>
</div>


<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('txtSenha');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>