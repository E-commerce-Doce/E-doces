<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if(isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= HOME_PAGE ?>">Home</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                role="button" data-toggle="dropdown" aria-haspopup="true" 
                aria-expanded="false"> Cadastros </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" 
                        href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários</a>
                    <a class="dropdown-item" href="#">Outro cadastro</a>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="<?= LOGOUT_PAGE ?>">Sair</a>
            </li>
        </ul>

        <ul class="navbar-nav mr-left">
            <li class="nav-item active"><?= $nome?></li>
        </ul>
    </div>
</nav>
