<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/confeiteiro.css">


<div class="conf">

    <div class="texto">
        <h1>Bem vindo confeiteiro!</h1>
        <h2>Aqui, seu talento transforma sonhos em realidade. <br> Compartilhe suas criações! </h2>
        <a class="btn" href="<?= BASEURL . '/controller/DoceController.php?action=list' ?>"> Cadastrar doces</a>
    </div>

</div>

<div class="dica">
    <div class="info">
        <h1>Quer chamar a atenção dos clientes?</h1>
        <h2>Invista em fotos de alta qualidade que despertem o apetite, encantem os olhos e deixem seus clientes com água na boca!</h2>
    </div>
    <div class="row fotos">
        <div class="col-lg-3">
            <img src="https://i.pinimg.com/736x/56/46/c6/5646c6ba5eb29f1bf0e205103aae2c61.jpg">
        </div>
        <div class="col-lg-3">
            <img src="https://i.pinimg.com/736x/a9/9d/ed/a99ded685fd6dccc2f16c0a39770d96f.jpg">
        </div>
        <div class="col-lg-3">
            <img src="https://i.pinimg.com/736x/4f/8f/7d/4f8f7d6a15f43211a417d60226871c3f.jpg">
        </div>

    </div>
</div>


<?php
require_once(__DIR__ . "/../include/footer.php");
?>