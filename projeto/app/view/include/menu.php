<?php
# Nome do arquivo: view/include/menu.php
# Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME])) {
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
}
$usuarioPapel = isset($_SESSION[SESSAO_USUARIO_PAPEL]) ? $_SESSION[SESSAO_USUARIO_PAPEL] : '';
?>
<nav class="navbar navbar-expand-lg" style="background-color:#C30E59;">
    <a class="navbar-brand" style="color: #fff;" href="#">&nbsp; A'MEIs &nbsp;</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav ml-auto" style="font-family: montserrat; font-weight:320;">
            <li class="nav-item active">
                <?php if (isset($_SESSION['usuarioLogadoId'])): ?>
                    <a class="nav-link" style="color: #fff;" href="<?= HOME_PAGE ?>">Home &nbsp;</a>
                <?php else: ?>
                    <a class="nav-link" style="color: #fff;" href="<?= LOGIN_PAGE ?>">Login &nbsp;</a>
                <?php endif; ?>
            </li>


            <?php if ($usuarioPapel === UsuarioPapel::ADMINISTRADOR): ?>
                <li class="nav-item">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários&nbsp;</a>
                </li>

            <?php elseif ($usuarioPapel === UsuarioPapel::CONFEITEIRO): ?>
                <li class="nav-item">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/DoceController.php?action=list' ?>">Doces&nbsp;</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/ConfeiteiroController.php?action=listPedidos' ?>">Pedidos&nbsp;</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" style="color: #fff;" href='<?= BASEURL ?>/controller/AvaliacaoController.php?action=listAvaliacoes&idConfeiteiro=<?= $_SESSION[SESSAO_USUARIO_CONFEITEIRO_ID] ?>'>Avaliação&nbsp;</a>
                </li>

            <?php elseif ($usuarioPapel === UsuarioPapel::CLIENTE): ?>
                <li class="nav-item active">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/ConfeiteiroController.php?action=listLojas' ?>"> Lojas &nbsp;</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/EnderecoController.php?action=list' ?>"> Endereços &nbsp;</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/PedidoController.php?action=listPedidos' ?>"> Pedidos &nbsp;</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/CarrinhoController.php?action=listCarrinho' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($nome !== "(Sessão expirada)"): ?>
                <li class="nav-item active">
                    <a class="nav-link" style="color: #fff;" href="<?= BASEURL . '/controller/UsuarioController.php?action=editProfile' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                    </a>
                </li>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="btn nav-link" style="background-color: #FFE2E2; color:#C30E59;" href="<?= LOGOUT_PAGE ?>">Sair</a>
                    </li>
                </ul>
            <?php endif; ?>
        </ul>
    </div>

</nav>