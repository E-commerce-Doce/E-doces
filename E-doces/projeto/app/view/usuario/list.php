<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center font-weight-light" style="font-family:caveat; margin-top: 20px;">
    Usuários Cadastrados</h3>
<div style="margin:0% auto ; width:80;  display: flex; justify-content: center; 
    align-items: center;">
    <div class="row" >
        <!-- <div class="col-3">
            <a class="btn "
                href="<?= BASEURL ?>/controller/UsuarioController.php?action=create">
                Inserir</a>
        </div> -->

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 13px; font-family:montserrat">
        <div >
            <table id="tabUsuarios" class='table table-striped table-bordered'>
                <thead >
                    <tr >
                        <!-- <th>ID</th> -->
                        <th class="custom-width">Cpf</th>
                        <th>Nome</th>
                        <th class="custom-width">Telefone</th>
                        <th class="custom-width">Login</th>
                        <th>Data de Nascimento</th>
                        <th>Papel</th>
                        <th >Loja</th>
                        <th class="custom-width">Mei</th>
                        <th>Alterar Papel</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['lista'] as $usu): ?>
                        <tr>
                            <!-- <td><?php echo $usu->getId(); ?></td> -->
                            <td><?php echo $usu->getCpf(); ?></td>
                            <td><?= $usu->getNome(); ?></td>
                            <td><?= $usu->getTelefone(); ?></td>
                            <td><?= $usu->getLogin(); ?></td>
                            <td><?= $usu->getDataNascimentoFormatada(); ?></td>
                            <td><?= $usu->getPapel(); ?></td>
                            <td><?= $usu->getConfeiteiro() ? $usu->getConfeiteiro()->getNomeLoja() : 'N/A'?></td>
                            <td><?= $usu->getConfeiteiro() ? $usu->getConfeiteiro()->getMei() : 'N/A'?></td>
                            <td>
                                <?php if($usu->getPapel() == UsuarioPapel::CLIENTE): ?>
                                    <a class="btn"
                                        href="<?= BASEURL ?>/controller/ConfeiteiroController.php?action=create&idUsuario=<?= $usu->getId(); ?>">
                                        Confeiteiro</a>
                                <?php endif; ?>
                            </td>
                            <td><a class="btn"
                                    onclick="return confirm('Confirma a exclusão do usuário?');"
                                    href="<?= BASEURL ?>/controller/UsuarioController.php?action=delete&id=<?= $usu->getId() ?>">
                                    Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <?php
// require_once(__DIR__ . "/../include/footer.php");
?> -->