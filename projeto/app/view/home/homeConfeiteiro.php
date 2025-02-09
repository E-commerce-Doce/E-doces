<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/homeConfeiteiro.css">


<div class="conf">

    <div class="texto">
        <h1 class="mt-5">Bem vindo confeiteiro!</h1>
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

<div class="lembrete mt-5">
    <div class="container">
        <div class="row suporte">
            <div class="col-lg-6 info">
                <h1><strong>Suporte</strong></h1>
                <h3><strong>Suporte via e-mail</strong></h3>
                <p>Estamos aqui para facilitar sua jornada!</p>
                <p>E-mail: <a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox?compose=CllgCJZdkFwKxBXzxWCpfwXgWBwmSFRfkDStgKvVQjHFVfrgPkFJXzvtVlFLGQKfvtPJWFzQdPg">ameis.contato@gmail.com</a></p>
                <p><strong>Suporte apenas pelo e-mail</strong></p>
                <p>Resolva todas as suas dúvidas e comece a <br> vender suas delícias de forma simples e prática!</p>
                <p><strong>Entre em contato conosco e simplifique <br> suas vendas online agora mesmo!"</strong></p>
            </div>

            <div class="col-lg-5">
                <img src="<?= BASEURL ?>/view/img/suporte.png" alt="">
            </div>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>