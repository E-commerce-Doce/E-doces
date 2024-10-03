<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">

<div class="row justify-content-between">

    <div class="col-5 ml-5">
        <h2 class="estilo2">Bem vindo à A'MEIs</h2>
        <h2 class="estilo" style="font-size:larger;">Onde cada doce é uma oportunidade!</h2>
        <p>Confeiteiros apaixonados criam delícias inesquecíveis para encantar seus clientes. Encontre, experimente e sinta o sabor, em um lugar só!</p>
        <button class="btn">Faça seu pedido</button>
    </div>

    <div class="col-5">
        <img class="rounded-circle imgCupCake" style="width: 450px; height:510px" src="https://i.pinimg.com/564x/ae/68/2f/ae682f4b595cb11223340de42295cbf1.jpg" alt="cupcake rosa">
    </div>

</div>

<div class="row"  style="background-color: #9BB899; margin: 20px 0px 20px 20px; border-radius: 10px 0 0 10px; ">
    <br>
    <div class="col-6 ml-5" style=" text-align: justify;">
        <h2 class="estilo2 pt-2">Como se tornar um confeiteiro</h2>
        <h2 class="estilo pb-2" style="font-size:larger;">Quer transformar sua paixão por confeitaria em um negócio de sucesso?</h2>
        <br>
        <p class="estilo">Aqui no A'MEIs, você tem a oportunidade de se tornar um confeiteiro e compartilhar seus doces com o Barsil! Para começar essa jornada deliciosa, basta entrar em contato.</p>
        <p class="estilo">Envie um e-mail para <a style="font-family:Montserrat;color:#FCCEAA; font-weight: bolder;" href="ameis.contato@gmail.com">ameis.contato@gmail.com</a>, e nossa equipe irá orientá-lo em cada passo para cadastrar seus produtos em nossa plataforma.</p>
    </div>
    <div class="col">
        <img class="imgC rounded float-end" src="../../../projeto/arquivos/SonhoDoce.png" alt="">
    </div>
   
</div>

<script src="<?= BASEURL ?>/view/home/home.js"></script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>