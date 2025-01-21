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


<?php
require_once(__DIR__ . "/../include/footer.php");
?>