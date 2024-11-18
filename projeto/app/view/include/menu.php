<?php
# Nome do arquivo: view/include/menu.php
# Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME])) {
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
}
$usuarioPapel = isset($_SESSION[SESSAO_USUARIO_PAPEL]) ? $_SESSION[SESSAO_USUARIO_PAPEL] : '';
?>

<nav class="navbar navbar-expand-lg">
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <a class="navbar-brand" style="color: #EA4961;" href="#">&nbsp; A'MEIs &nbsp;</a>

        <ul class="navbar-nav ml-auto" style="font-family: montserrat; font-weight:320; ">
            <li class="nav-item active">
                <a class="nav-link" href="<?= HOME_PAGE ?>">Home &nbsp;</a>
            </li>


            <?php if ($usuarioPapel === UsuarioPapel::ADMINISTRADOR): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários&nbsp;</a>
                </li>

            <?php elseif ($usuarioPapel === UsuarioPapel::CONFEITEIRO): ?>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL . '/controller/DoceController.php?action=create' ?>">Cadastro (Doce)&nbsp;</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL . '/controller/DoceController.php?action=list' ?>">Doces Cadastrados&nbsp;</a>
                </li>

            <?php elseif ($usuarioPapel === UsuarioPapel::CLIENTE): ?>

                <li class="nav-item active">
                    <a class="nav-link" href="<?= BASEURL . '/controller/ConfeiteiroController.php?action=listLojas' ?>"> Lojas &nbsp;</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="<?= BASEURL . '/controller/EnderecoController.php?action=list' ?>"> Meus Endereços &nbsp;</a>
                </li>

            <?php endif; ?>


            <?php if ($nome !== "(Sessão expirada)"): ?> <!-- Verifica se o usuário está logado -->

                <li class="nav-item active">
                    <a class="nav-link" href="<?= BASEURL . '/controller/UsuarioController.php?action=editProfile' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL . '/controller/CarrinhoController.php?action=addCarrinho' ?>">
                            <i class="fas fa-shopping-cart"></i> 
                        </a>
                    </li>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="btn nav-link" href="<?= LOGOUT_PAGE ?>">Sair</a>
                    </li>

                    


                <?php endif; ?>



                </ul>
        </ul>





    </div>
</nav>