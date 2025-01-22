<?php

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/home/homeAdm.css">

<div class="adm">

    <div class="texto">
        <h1>Olá, administrador!</h1>
        <h2>Aqui, você impulsiona talentos e transforma possibilidades em realidade!</h2>
        <a class="btn" href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários</a>
    </div>

</div>

<div class="lembrete">
    <div class="container">
        <div class="row suporte">
            <div class="col-lg-7 info">
                <h1 class="mb-4 ml-4"><strong>Lembretes</strong></h1>
                <h3><strong>Tornar Clientes Confeiteiros</strong></h3>
                <li>Verificar diariamente os e-mails recebidos.</li>
                <li>Conferir se os dados enviados pelos clientes estão completos.</li>
                <li>Atualizar o status do cliente no sistema para "Confeiteiro".</li>
                <li>Responder ao cliente confirmando a ativação do perfil como confeiteiro.</li>
                <h3><strong>Monitoramento de Suporte</strong></h3>
                <li>Responder a dúvidas e solicitações enviadas pelos usuários com agilidade.</li>
                <li>Acompanhar reclamações ou sugestões para melhorar o sistema.</li>
            </div>

            <div class="col-lg-4 ml-5">
                <img src="<?= BASEURL ?>/view/img/lembrete.png" alt="">
            </div>
        </div>
    </div>
</div>


<?php
require_once(__DIR__ . "/../include/footer.php");
?>
