<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">

<div class="row justify-content-between m-0 capa" style="max-width: 100%; ">

    <div class="col-5 ml-5 info" id="pedido">
        <div>
            <h2 class="estilo2"> Bem vindo à A'MEIs</h2>
            <p class="estilo" style="font-size:larger;">Onde cada doce é uma oportunidade!</p>
            <p class="extra" >Confeiteiros apaixonados criam delícias inesquecíveis para encantar seus clientes. Encontre, experimente e sinta o sabor, em um lugar só!</p>
            <a class="btn" href="<?= BASEURL . '/controller/ConfeiteiroController.php?action=listLojas' ?>">Faça seu pedido</a>
        </div>
    </div>

    <div class="col-5">
        <img class="imgCupCake" src="https://i.pinimg.com/564x/ae/68/2f/ae682f4b595cb11223340de42295cbf1.jpg" alt="cupcake rosa">

    </div>

</div>

<div class="sobre" id="sobre">

    <div class="row hist" style=" width: 100%;display: flex; justify-content: space-between;">
        <div class="col" style=" flex: 1;">
            <img class="cupSobre" src="<?= BASEURL ?>/view/img/confeiteira.jpg" alt="">
        </div>
    
        <div class="col-7" style="text-align: right;" >
            <h1 class="estiloSob2" >Sobre</h1>
            <p class="estiloSob">Aqui é o lugar onde a paixão pela confeitaria encontra o comércio digital! Se você é um confeiteiro MEI ou simplesmente adora um docinho de qualidade, chegou ao lugar certo. Nossa plataforma é a vitrine perfeita para quem quer mostrar suas delícias, com um atendimento personalizado e sem aquela dor de cabeça das taxas altas.<br>Aqui, os confeiteiros ganham destaque e os clientes encontram tudo o que precisam para adoçar o dia. Pronto para descobrir a magia da confeitaria digital? Vem com a gente!</p>
        </div>

    </div>

</div>

<div class="conf" id="confeiteiro">

    <div class="row">
        <div class="col-lg-4">
            <h2 class="estilo2 pt-2" id="confeiteiro">Torne-se um confeiteiro!</h2>
        </div>

        <div class="col-lg-4">
            <div class="icone">
                <svg class="texIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                    <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                </svg>
            </div>
            <h2 class="estilo pb-2" style="font-size:larger;">Após o cadastro. Envie um e-mail para nosso adm em ameis.contato@gmail.com.</h2>
        </div>

        <div class="col-lg-4">
            <div class="icone">
                <svg class="texIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                    <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                </svg>
            </div>
            <h2 class="estilo pb-2" style="font-size:larger;">Nesse e-mail deve conter algumas outras informações como: Nome da loja, Mei, a logo da sua loja e tambem um QR Code para pagamentos no pix.</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4"></div>

        <div class="col-lg-4">
            <div class="icone">
                <svg class="texIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                </svg>
            </div>
            <h2 class="estilo pb-2" style="font-size:larger;">Aguarde a confirmação do seu cadastro. Em breve, você receberá um retorno da nossa equipe com algumas orientações. </h2>
        </div>

        <div class="col-lg-4">
            <div class="icone">
                <svg class="texIcon" style="color: whitesmoke; margin:5px;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                </svg>
            </div>
            <h2 class="estilo pb-2" style="font-size:larger;">Após a confirmação, comece a cadastrar seus produtos em nossa plataforma e mostre ao mundo suas criações! </h2>
        </div>
    </div>

</div>

</div>

<script src="<?= BASEURL ?>/view/home/home.js"></script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>