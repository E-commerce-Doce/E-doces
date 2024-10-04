<?php
# Nome do arquivo: usuario/editar_perfil.php
# Objetivo: interface para edição do perfil do usuário logado

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-header" style="font-family: caveat; font-size:25px">
                    Detalhes do Perfil
                </div>
                <div class="card-body" style="font-family: montserrat; width:1000px;">
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
                    <div class="text-center mt-4">
                        <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=edit&id=<?= $dados['usuario']->getId(); ?>" class="btn btn-primary">Editar Perfil</a>
                        <!-- <a class="btn"onclick="return confirm('Confirma a exclusão do usuário?');"href="<?= BASEURL ?>/controller/UsuarioController.php?action=delete&id=<?= $dados['usuario']->getId(); ?>">Excluir</a>  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

