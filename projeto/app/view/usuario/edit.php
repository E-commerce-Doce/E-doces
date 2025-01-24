<?php
# Nome do arquivo: usuario/editar_perfil.php
# Objetivo: interface para edição do perfil do usuário logado

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/usuario/edit.css">

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="header">
                    <p class="alert">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        Detalhes do Perfil
                    </p>
                </div>

                <div class="message">
                    <dl class="row">
                        <dt class="col-sm-3">Nome:</dt>
                        <dd class="col-sm-9"><?= $dados['usuario']->getNome(); ?></dd>

                        <dt class="col-sm-3">CPF:</dt>
                        <dd class="col-sm-9"><?= $dados['usuario']->getCpf(); ?></dd>

                        <dt class="col-sm-3">Telefone:</dt>
                        <dd class="col-sm-9"><?= $dados['usuario']->getTelefone(); ?></dd>

                        <dt class="col-sm-3">Login:</dt>
                        <dd class="col-sm-9"><?= $dados['usuario']->getLogin(); ?></dd>

                        <dt class="col-sm-3">Data de Nascimento:</dt>
                        <dd class="col-sm-9"><?= $dados['usuario']->getDataNascimentoFormatada(); ?></dd>

                        <dt class="col-sm-3">Papel:</dt>
                        <dd class="col-sm-9"><?= $dados['usuario']->getPapel(); ?></dd>
                    </dl>
                </div>

                <div class="actions">
                    <a class="read" href="<?= BASEURL ?>/controller/UsuarioController.php?action=edit&id=<?= $dados['usuario']->getId(); ?>">
                        Editar Perfil
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer2.php");
?>